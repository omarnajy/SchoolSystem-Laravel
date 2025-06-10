<?php
// app/Http/Controllers/ScheduleController.php

namespace App\Http\Controllers;

use App\Schedule;
use App\Grade;
use App\Subject;
use App\Teacher;
use App\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Liste des emplois du temps (Admin)
    public function index(Request $request)
    {
        $this->authorize('viewAny', Schedule::class);

        $academicYear = $request->get('academic_year', date('Y'));
        $semester = $request->get('semester', '1');
        $classId = $request->get('class_id');

        $query = Schedule::with(['class', 'subject', 'teacher'])
                        ->forAcademicYear($academicYear)
                        ->forSemester($semester)
                        ->active()
                        ->orderBy('day_of_week')
                        ->orderBy('start_time');

        if ($classId) {
            $query->forClass($classId);
        }

        $schedules = $query->get();
        $classes = Grade::all();
        
        // Organiser par classe et jour
        $schedulesByClass = $schedules->groupBy('class_id');
        $organizedSchedules = collect();
        
        foreach ($schedulesByClass as $classId => $classSchedules) {
            $organizedSchedules[$classId] = $classSchedules->groupBy('day_of_week');
        }

        return view('backend.schedules.index', compact(
            'organizedSchedules', 
            'classes', 
            'academicYear', 
            'semester'
        ));
    }

    // Création d'un emploi du temps
    public function create()
    {
        $this->authorize('create', Schedule::class);

        $classes = Grade::all();
        $subjects = Subject::all();
        $teachers = Teacher::with('user')->get();
        $days = Schedule::getDaysOfWeek();
        $timeSlots = Schedule::getTimeSlots();

        return view('backend.schedules.create', compact(
            'classes', 
            'subjects', 
            'teachers', 
            'days', 
            'timeSlots'
        ));
    }

    // Sauvegarde d'un emploi du temps
    public function store(Request $request)
    {
        $this->authorize('create', Schedule::class);

        $request->validate([
            'class_id' => 'required|exists:grades,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:255',
            'academic_year' => 'required|string|max:10',
            'semester' => 'required|in:1,2',
            'notes' => 'nullable|string'
        ]);

        $schedule = new Schedule($request->all());

        // Vérifier les conflits
        if ($schedule->hasConflict()) {
            return back()->withErrors(['conflict' => 'Il y a un conflit d\'horaire pour cette classe à ce créneau.'])->withInput();
        }

        if ($schedule->hasTeacherConflict()) {
            return back()->withErrors(['teacher_conflict' => 'L\'enseignant a déjà un cours à ce créneau.'])->withInput();
        }

        $schedule->save();

        return redirect()->route('schedules.index')
                        ->with('success', 'Emploi du temps créé avec succès.');
    }

    // Affichage d'un emploi du temps - CORRIGÉ POUR INCLURE LES PARENTS
    public function show(Request $request, $id = null)
    {
        $user = Auth::user();
        
        // If no ID specified, show current user's schedule
        if (!$id) {
            if ($user->hasRole('Student') && $user->student) {
                return $this->showStudentSchedule($request, $user->student->class_id);
            } elseif ($user->hasRole('Teacher') && $user->teacher) {
                return $this->showTeacherSchedule($request, $user->teacher->id);
            } elseif ($user->hasRole('Parent') && $user->parent) {
                // Pour les parents, afficher l'emploi du temps du premier enfant
                return $this->showParentSchedule($request);
            } elseif ($user->hasRole('Admin')) {
                // Admin can see general schedule index
                return redirect()->route('schedules.index');
            }
        }

        // For specific ID access, check permissions
        if ($user->hasRole('Admin')) {
            $this->authorize('view', Schedule::class);
            return $this->showClassSchedule($request, $id);
        } elseif ($user->hasRole('Teacher') && $user->teacher) {
            // Allow teacher to view their own schedule even with ID
            return $this->showTeacherSchedule($request, $user->teacher->id);
        } elseif ($user->hasRole('Parent') && $user->parent) {
            // Parent can view their child's schedule
            return $this->showParentSchedule($request);
        }
        
        // If none of the above, deny access
        abort(403, 'Unauthorized access');
    }

    // NOUVELLE MÉTHODE pour les parents
    public function showParentSchedule(Request $request)
{
    $user = Auth::user();
    
    if (!$user->hasRole('Parent') || !$user->parent) {
        abort(403, 'Unauthorized access');
    }

    $academicYear = $request->get('academic_year', date('Y'));
    $semester = $request->get('semester', '1');

    // Récupérer tous les enfants du parent avec leurs classes
    $children = $user->parent->children()->with(['user', 'class'])->get();
    
    if ($children->isEmpty()) {
        return view('frontend.schedules.parent-no-child')->with([
            'message' => 'Aucun enfant trouvé associé à votre compte.',
            'parent' => $user->parent
        ]);
    }

    // Utiliser la vue spécifique pour les parents
    return view('frontend.schedules.parent', compact(
        'children', 
        'academicYear', 
        'semester'
    ));
}

    // Emploi du temps pour une classe
    public function showClassSchedule(Request $request, $classId)
    {
        $academicYear = $request->get('academic_year', date('Y'));
        $semester = $request->get('semester', '1');

        $class = Grade::findOrFail($classId);
        $schedules = Schedule::with(['subject', 'teacher.user'])
                           ->forClass($classId)
                           ->forAcademicYear($academicYear)
                           ->forSemester($semester)
                           ->active()
                           ->orderBy('day_of_week')
                           ->orderBy('start_time')
                           ->get();

        $schedulesByDay = $schedules->groupBy('day_of_week');
        $days = Schedule::getDaysOfWeek();

        return view('backend.schedules.show', compact(
            'class', 
            'schedulesByDay', 
            'days', 
            'academicYear', 
            'semester'
        ));
    }

    // Emploi du temps pour un étudiant
    public function showStudentSchedule(Request $request, $classId)
    {
        $academicYear = $request->get('academic_year', date('Y'));
        $semester = $request->get('semester', '1');

        $class = Grade::findOrFail($classId);
        $schedules = Schedule::with(['subject', 'teacher.user'])
                           ->forClass($classId)
                           ->forAcademicYear($academicYear)
                           ->forSemester($semester)
                           ->active()
                           ->orderBy('day_of_week')
                           ->orderBy('start_time')
                           ->get();

        $schedulesByDay = $schedules->groupBy('day_of_week');
        $days = Schedule::getDaysOfWeek();

        return view('frontend.schedules.student', compact(
            'class', 
            'schedulesByDay', 
            'days', 
            'academicYear', 
            'semester'
        ));
    }

    // Emploi du temps pour un enseignant
    public function showTeacherSchedule(Request $request, $teacherId = null)
    {
        $user = Auth::user();
        
        // If no teacher ID provided and user is a teacher, use their ID
        if (!$teacherId && $user->hasRole('Teacher') && $user->teacher) {
            $teacherId = $user->teacher->id;
        }
        
        // Check if admin or the teacher viewing their own schedule
        if (!$user->hasRole('Admin') && (!$user->teacher || $user->teacher->id != $teacherId)) {
            abort(403, 'Unauthorized access');
        }
        
        $academicYear = $request->get('academic_year', date('Y'));
        $semester = $request->get('semester', '1');

        $teacher = Teacher::with('user')->findOrFail($teacherId);
        $schedules = Schedule::with(['class', 'subject'])
                           ->forTeacher($teacherId)
                           ->forAcademicYear($academicYear)
                           ->forSemester($semester)
                           ->active()
                           ->orderBy('day_of_week')
                           ->orderBy('start_time')
                           ->get();

        $schedulesByDay = $schedules->groupBy('day_of_week');
        $days = Schedule::getDaysOfWeek();

        return view('frontend.schedules.teacher', compact(
            'teacher', 
            'schedulesByDay', 
            'days', 
            'academicYear', 
            'semester'
        ));
    }

    // Édition d'un emploi du temps
    public function edit(Schedule $schedule)
    {
        $this->authorize('update', $schedule);

        $classes = Grade::all();
        $subjects = Subject::all();
        $teachers = Teacher::with('user')->get();
        $days = Schedule::getDaysOfWeek();
        $timeSlots = Schedule::getTimeSlots();

        return view('backend.schedules.edit', compact(
            'schedule', 
            'classes', 
            'subjects', 
            'teachers', 
            'days', 
            'timeSlots'
        ));
    }

    // Mise à jour d'un emploi du temps
    public function update(Request $request, Schedule $schedule)
    {
        $this->authorize('update', $schedule);

        $request->validate([
            'class_id' => 'required|exists:grades,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:255',
            'academic_year' => 'required|string|max:10',
            'semester' => 'required|in:1,2',
            'notes' => 'nullable|string'
        ]);

        $schedule->fill($request->all());

        // Vérifier les conflits
        if ($schedule->hasConflict()) {
            return back()->withErrors(['conflict' => 'Il y a un conflit d\'horaire pour cette classe à ce créneau.'])->withInput();
        }

        if ($schedule->hasTeacherConflict()) {
            return back()->withErrors(['teacher_conflict' => 'L\'enseignant a déjà un cours à ce créneau.'])->withInput();
        }

        $schedule->save();

        return redirect()->route('schedules.index')
                        ->with('success', 'Emploi du temps mis à jour avec succès.');
    }

    // Suppression d'un emploi du temps
    public function destroy(Schedule $schedule)
    {
        $this->authorize('delete', $schedule);

        $schedule->delete();

        return redirect()->route('schedules.index')
                        ->with('success', 'Emploi du temps supprimé avec succès.');
    }

    // API pour obtenir les créneaux disponibles
    public function getAvailableSlots(Request $request)
    {
        $classId = $request->get('class_id');
        $teacherId = $request->get('teacher_id');
        $dayOfWeek = $request->get('day_of_week');
        $academicYear = $request->get('academic_year', date('Y'));
        $semester = $request->get('semester', '1');

        $bookedSlots = Schedule::where(function($query) use ($classId, $teacherId) {
                                $query->where('class_id', $classId)
                                      ->orWhere('teacher_id', $teacherId);
                            })
                            ->where('day_of_week', $dayOfWeek)
                            ->where('academic_year', $academicYear)
                            ->where('semester', $semester)
                            ->active()
                            ->select('start_time', 'end_time')
                            ->get();

        return response()->json([
            'booked_slots' => $bookedSlots
        ]);
    }

    // Génération d'emploi du temps en masse
    public function bulkCreate()
    {
        $this->authorize('create', Schedule::class);

        $classes = Grade::all();
        $subjects = Subject::all();
        $teachers = Teacher::with('user')->get();

        return view('backend.schedules.bulk-create', compact('classes', 'subjects', 'teachers'));
    }

    public function bulkStore(Request $request)
    {
        $this->authorize('create', Schedule::class);

        $request->validate([
            'schedules' => 'required|array',
            'schedules.*.class_id' => 'required|exists:grades,id',
            'schedules.*.subject_id' => 'required|exists:subjects,id',
            'schedules.*.teacher_id' => 'required|exists:teachers,id',
            'schedules.*.day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday',
            'schedules.*.start_time' => 'required|date_format:H:i',
            'schedules.*.end_time' => 'required|date_format:H:i',
            'academic_year' => 'required|string',
            'semester' => 'required|in:1,2'
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->schedules as $scheduleData) {
                $scheduleData['academic_year'] = $request->academic_year;
                $scheduleData['semester'] = $request->semester;
                
                $schedule = new Schedule($scheduleData);
                
                if (!$schedule->hasConflict() && !$schedule->hasTeacherConflict()) {
                    $schedule->save();
                }
            }
            
            DB::commit();
            return redirect()->route('schedules.index')
                           ->with('success', 'Emplois du temps créés avec succès.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Erreur lors de la création des emplois du temps.']);
        }
    }
}