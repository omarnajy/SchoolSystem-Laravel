<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Teacher;
use App\Student;
use App\Parents;
use Carbon\Carbon;
use App\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // Pour les parents : afficher les présences de leurs enfants
        if ($user->hasRole('Parent')) {
            return $this->parentAttendanceIndex();
        }
        
        // Pour les étudiants : afficher leurs propres présences
        if ($user->hasRole('Student')) {
            return $this->studentAttendanceIndex();
        }

        // Pour les admins et enseignants : vue complète
        $months = Attendance::select('attendence_date')
                            ->orderBy('attendence_date')
                            ->get()
                            ->groupBy(function ($val) {
                                return Carbon::parse($val->attendence_date)->format('m');
                            });

        if( request()->has(['type', 'month']) ) {
            $type = request()->input('type');
            $month = request()->input('month');

            if($type == 'class') {
                $attendances = Attendance::whereMonth('attendence_date', $month)
                                     ->select('attendence_date','student_id','attendence_status','class_id')
                                     ->orderBy('class_id','asc')
                                     ->get()
                                     ->groupBy(['class_id','attendence_date']);

                return view('backend.attendance.index', compact('attendances','months'));
            }
        }
        
        $attendances = [];
        return view('backend.attendance.index', compact('attendances','months'));
    }

    /**
     * Vue des présences pour les parents
     */
    private function parentAttendanceIndex()
    {
        $user = Auth::user();
        $parent = $user->parent;

        if (!$parent) {
            return redirect()->route('home')->with('error', 'Profil parent introuvable.');
        }

        // Récupérer tous les enfants du parent
        $children = $parent->children()->with(['user', 'class'])->get();

        if ($children->isEmpty()) {
            return view('frontend.attendance.parent-no-child')->with([
                'message' => 'Aucun enfant trouvé pour consulter les présences.',
                'parent' => $parent
            ]);
        }

        // Récupérer les présences des 30 derniers jours pour tous les enfants
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        $attendances = collect();
        
        foreach ($children as $child) {
            $childAttendances = Attendance::where('student_id', $child->id)
                                        ->whereBetween('attendence_date', [$startDate, $endDate])
                                        ->orderBy('attendence_date', 'desc')
                                        ->get();
            
            foreach ($childAttendances as $attendance) {
                $attendance->child = $child;
                $attendances->push($attendance);
            }
        }

        // Grouper par enfant et par date
        $attendancesByChild = $attendances->groupBy('student_id');
        $attendancesByDate = $attendances->groupBy(function ($attendance) {
            return Carbon::parse($attendance->attendence_date)->format('Y-m-d');
        });

        // Calculer les statistiques
        $statistics = [];
        foreach ($children as $child) {
            $childAttendances = $attendances->where('student_id', $child->id);
            $totalDays = $childAttendances->count();
            $presentDays = $childAttendances->where('attendence_status', 1)->count();
            $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;

            $statistics[$child->id] = [
                'child' => $child,
                'total_days' => $totalDays,
                'present_days' => $presentDays,
                'absent_days' => $totalDays - $presentDays,
                'attendance_rate' => $attendanceRate
            ];
        }

        return view('frontend.attendance.parent', compact(
            'children',
            'attendancesByChild',
            'attendancesByDate',
            'statistics',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Vue des présences pour les étudiants
     */
    private function studentAttendanceIndex()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('home')->with('error', 'Profil étudiant introuvable.');
        }

        // Récupérer les présences des 30 derniers jours
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        $attendances = Attendance::where('student_id', $student->id)
                                ->whereBetween('attendence_date', [$startDate, $endDate])
                                ->orderBy('attendence_date', 'desc')
                                ->get();

        // Calculer les statistiques
        $totalDays = $attendances->count();
        $presentDays = $attendances->where('attendence_status', 1)->count();
        $absentDays = $totalDays - $presentDays;
        $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;

        // Grouper par date
        $attendancesByDate = $attendances->groupBy(function ($attendance) {
            return Carbon::parse($attendance->attendence_date)->format('Y-m-d');
        });

        return view('frontend.attendance.student', compact(
            'student',
            'attendances',
            'attendancesByDate',
            'totalDays',
            'presentDays',
            'absentDays',
            'attendanceRate',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    public function createByTeacher($classid)
    {
        $class = Grade::with(['students','subjects','teacher'])->findOrFail($classid);

        return view('backend.attendance.create', compact('class'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $classid    = $request->class_id;
        $attenddate = date('Y-m-d');

        $teacher = Teacher::findOrFail(auth()->user()->teacher->id);
        $class   = Grade::find($classid);

        if($teacher->id !== $class->teacher_id) {
            return redirect()->route('teacher.attendance.create',$classid)
                             ->with('status', 'You are not assign for this class attendence!');
        }

        $dataexist = Attendance::whereDate('attendence_date',$attenddate)
                                ->where('class_id',$classid)
                                ->get();

        if (count($dataexist) !== 0 ) {
            return redirect()->route('teacher.attendance.create',$classid)
                             ->with('status', 'Attendance already taken!');
        }

        $request->validate([
            'class_id'      => 'required|numeric',
            'teacher_id'    => 'required|numeric',
            'attendences'   => 'required'
        ]);

        foreach ($request->attendences as $studentid => $attendence) {

            if( $attendence == 'present' ) {
                $attendence_status = true;
            } else if( $attendence == 'absent' ){
                $attendence_status = false;
            }

            Attendance::create([
                'class_id'          => $request->class_id,
                'teacher_id'        => $request->teacher_id,
                'student_id'        => $studentid,
                'attendence_date'   => $attenddate,
                'attendence_status' => $attendence_status
            ]);
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        $attendances = Attendance::where('student_id',$attendance->id)->get();

        return view('backend.attendance.show', compact('attendances'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}