<?php

namespace App\Http\Controllers;

use App\Grade;
use App\Subject;
use App\Teacher;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Grade::with(['teachers', 'students','subjects.teacher.user','subjects.teachers.user'])
                       ->withCount('students')
                       ->latest()
                       ->paginate(10);

        return view('backend.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teachers = Teacher::with('user')->latest()->get();
        
        return view('backend.classes.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_name'        => 'required|string|max:255|unique:grades',
            'class_numeric'     => 'required|numeric',
            'teacher_ids'       => 'array', // Enseignants de la classe
            'teacher_ids.*'     => 'exists:teachers,id',
            'class_description' => 'required|string|max:255'
        ]);

        $class = Grade::create([
            'class_name'        => $request->class_name,
            'class_numeric'     => $request->class_numeric,
            'class_description' => $request->class_description
        ]);

        // Attacher les enseignants sélectionnés à la classe (sans la colonne is_main_teacher)
        if ($request->teacher_ids) {
            $class->teachers()->attach($request->teacher_ids);
        }

        return redirect()->route('classes.index')->with('success', 'Classe créée avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Grade $grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teachers = Teacher::with('user')->latest()->get();
        $class = Grade::with('teachers')->findOrFail($id);

        return view('backend.classes.edit', compact('class','teachers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'class_name'        => 'required|string|max:255|unique:grades,class_name,'.$id,
            'class_numeric'     => 'required|numeric',
            'teacher_ids'       => 'array',
            'teacher_ids.*'     => 'exists:teachers,id',
            'class_description' => 'required|string|max:255'
        ]);

        $class = Grade::findOrFail($id);

        $class->update([
            'class_name'        => $request->class_name,
            'class_numeric'     => $request->class_numeric,
            'class_description' => $request->class_description
        ]);

        // Synchroniser les enseignants (sans la colonne is_main_teacher)
        if ($request->teacher_ids) {
            $class->teachers()->sync($request->teacher_ids);
        } else {
            $class->teachers()->detach();
        }

        return redirect()->route('classes.index')->with('success', 'Classe mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = Grade::findOrFail($id);
        
        $class->subjects()->detach();
        $class->teachers()->detach();
        $class->delete();

        return back();
    }

    /*
     * Assign Subjects to Grade 
     * 
     * @return \Illuminate\Http\Response
     */
    public function assignSubject($classid)
    {
        $subjects   = Subject::with(['teacher.user', 'teachers.user'])->latest()->get();
        // Charger la classe avec ses matières assignées et les enseignants de ces matières
        $assigned = Grade::with([
            'subjects' => function($query) {
                $query->with(['teacher.user', 'teachers.user']);
        },
        'students', 
        'teachers.user'
    ])->findOrFail($classid);

        return view('backend.classes.assign-subject', compact('classid','subjects','assigned'));
    }

    /*
     * Add Assigned Subjects to Grade 
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAssignedSubject(Request $request, $id)
    {
        // Debug: Voir ce qui est reçu
        \Log::info('Data received:', $request->all());

        $class = Grade::findOrFail($id);

        // Validation des données reçues
        $request->validate([
            'selectedsubjects' => 'required|array',
            'selectedsubjects.*' => 'exists:subjects,id',
            'subject_teachers' => 'array',
            'subject_teachers.*' => 'array',
            'subject_teachers.*.*' => 'exists:teachers,id'
        ]);

        try {
        \DB::beginTransaction();

        // 1. Détacher toutes les matières existantes de la classe
        $class->subjects()->detach();

        // 2. Collecter tous les enseignants qui vont enseigner dans cette classe
        $allTeachersInClass = collect();

        // 3. Pour chaque matière sélectionnée
        foreach ($request->selectedsubjects as $subjectId) {
            // Attacher la matière à la classe
            $class->subjects()->attach($subjectId);

            // Gérer les enseignants pour cette matière
            if (isset($request->subject_teachers[$subjectId]) && !empty($request->subject_teachers[$subjectId])) {
                $subject = Subject::findOrFail($subjectId);
                $teacherIds = $request->subject_teachers[$subjectId];
                
                // Synchroniser les enseignants pour cette matière spécifique
                // Utiliser sync au lieu de syncWithoutDetaching pour une assignation propre
                $subject->teachers()->sync($teacherIds);
                
                // Ajouter ces enseignants à la collection des enseignants de la classe
                foreach ($teacherIds as $teacherId) {
                    $allTeachersInClass->push($teacherId);
                }
            } else {
                // Si aucun enseignant n'est sélectionné pour cette matière, 
                // détacher tous les enseignants de cette matière
                $subject = Subject::findOrFail($subjectId);
                $subject->teachers()->detach();
            }
        }

        // 4. Obtenir les enseignants uniques
        $uniqueTeachers = $allTeachersInClass->unique()->values()->toArray();
        
        // 5. Synchroniser les enseignants de la classe
        // Garder les enseignants déjà directement assignés + ajouter ceux des matières
        $existingDirectTeachers = $class->teachers->pluck('id')->toArray();
        $finalTeachers = array_unique(array_merge($existingDirectTeachers, $uniqueTeachers));
        
        $class->teachers()->syncWithoutDetaching($finalTeachers);

        \DB::commit();

        return redirect()->route('classes.index')->with('success', 'Matières et enseignants assignés avec succès.');

    } catch (\Exception $e) {
        \DB::rollback();
        \Log::error('Error in storeAssignedSubject: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return redirect()->back()
                       ->withErrors(['error' => 'Erreur lors de l\'assignation: ' . $e->getMessage()])
                       ->withInput();
    }
    }
}