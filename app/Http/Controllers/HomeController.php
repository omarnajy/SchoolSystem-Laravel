<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Parents;
use App\Student;
use App\Teacher;
use App\Subject;
use App\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasRole('Admin')) {

            $parents = Parents::latest()->get();
            $teachers = Teacher::latest()->get();
            $students = Student::latest()->get();
            $subjects = Subject::latest()->get();
            $classes = Grade::latest()->get();

            return view('home', compact('parents','teachers','students','subjects','classes'));

        } elseif ($user->hasRole('Teacher')) {

            $teacher = Teacher::with(['user','subjects','classes','students'])->withCount('subjects','classes')->findOrFail($user->teacher->id);

            return view('home', compact('teacher'));

        } elseif ($user->hasRole('Parent')) {
            
            $parent = Parents::with(['children.user', 'children.class'])->findOrFail($user->parent->id);
            
            // Préparer les données pour la vue
            $children = $parent->children->map(function ($child) {
                return (object) [
                    'id' => $child->id,
                    'name' => $child->user->name,
                    'email' => $child->user->email,
                    'class_name' => $child->class ? $child->class->class_name : 'Non assignée',
                    'profile_picture' => $child->user->profile_picture ?? 'avatar.png'
                ];
            });
            
            $childrenCount = $children->count();
            
            // Calculer les présences d'aujourd'hui
            $today = Carbon::today();
            $presentToday = 0;
            
            foreach ($parent->children as $child) {
                $attendance = Attendance::where('student_id', $child->id)
                                      ->whereDate('attendence_date', $today)
                                      ->where('attendence_status', 1)
                                      ->exists();
                if ($attendance) {
                    $presentToday++;
                }
            }
            
            // Calculer le taux de présence (30 derniers jours)
            $attendanceRate = 0;
            if ($childrenCount > 0) {
                $totalAttendances = 0;
                $totalExpected = 0;
                
                $last30Days = Carbon::now()->subDays(30);
                
                foreach ($parent->children as $child) {
                    $attendances = Attendance::where('student_id', $child->id)
                                           ->where('attendence_date', '>=', $last30Days)
                                           ->get();
                    
                    $present = $attendances->where('attendence_status', 1)->count();
                    $total = $attendances->count();
                    
                    $totalAttendances += $present;
                    $totalExpected += $total;
                }
                
                if ($totalExpected > 0) {
                    $attendanceRate = round(($totalAttendances / $totalExpected) * 100);
                } else {
                    $attendanceRate = 95; // Valeur par défaut si pas de données
                }
            }

            return view('home', compact('children', 'childrenCount', 'presentToday', 'attendanceRate'));

        } elseif ($user->hasRole('Student')) {
            
            $student = Student::with(['user','parent','class','attendances'])->findOrFail($user->student->id); 

            return view('home', compact('student'));

        } else {
            return 'NO ROLE ASSIGNED YET!';
        }
        
    }

    /**
     * PROFILE
     */
    public function profile() 
    {
        return view('profile.index');
    }

    public function profileEdit() 
    {
        return view('profile.edit');
    }

    public function profileUpdate(Request $request) 
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.auth()->id()
        ]);

        if ($request->hasFile('profile_picture')) {
            $profile = Str::slug(auth()->user()->name).'-'.auth()->id().'.'.$request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('images/profile'), $profile);
        } else {
            $profile = 'avatar.png';
        }

        $user = auth()->user();

        $user->update([
            'name'              => $request->name,
            'email'             => $request->email,
            'profile_picture'   => $profile
        ]);

        return redirect()->route('profile');
    }

    /**
     * CHANGE PASSWORD
     */
    public function changePasswordForm()
    {  
        return view('profile.changepassword');
    }

    public function changePassword(Request $request)
    {     
        if (!(Hash::check($request->get('currentpassword'), Auth::user()->password))) {
            return back()->with([
                'msg_currentpassword' => 'Your current password does not matches with the password you provided! Please try again.'
            ]);
        }
        if(strcmp($request->get('currentpassword'), $request->get('newpassword')) == 0){
            return back()->with([
                'msg_currentpassword' => 'New Password cannot be same as your current password! Please choose a different password.'
            ]);
        }

        $this->validate($request, [
            'currentpassword' => 'required',
            'newpassword'     => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        $user->password = bcrypt($request->get('newpassword'));
        $user->save();

        Auth::logout();
        return redirect()->route('login');
    }
}