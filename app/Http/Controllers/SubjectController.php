<?php

namespace App\Http\Controllers;

use App\Subject;
use App\Teacher;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SubjectsImport;
use App\Exports\SubjectsTemplateExport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::with(['teacher.user', 'teachers.user'])->latest()->paginate(10);
        
        return view('backend.subjects.index', compact('subjects'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teachers = Teacher::latest()->get();

        return view('backend.subjects.create', compact('teachers'));
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
            'name'          => 'required|string|max:255|unique:subjects',
            'subject_code'  => 'required|numeric',
            'teacher_id'    => 'required|numeric',
            'description'   => 'required|string|max:255',
            'additional_teachers' => 'array', // Pour les enseignants additionnels
            'additional_teachers.*' => 'exists:teachers,id'
        ]);

        Subject::create([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'subject_code'  => $request->subject_code,
            'teacher_id'    => $request->teacher_id,
            'description'   => $request->description
        ]);
        // Attacher les enseignants additionnels si présents
        if ($request->has('additional_teachers')) {
            $additionalTeachers = array_filter($request->additional_teachers, function($teacherId) use ($request) {
                return $teacherId != $request->teacher_id; // Éviter les doublons
            });
            
            if (!empty($additionalTeachers)) {
                $subject->teachers()->attach($additionalTeachers);
            }
        }

        return redirect()->route('subject.index')->with('success', 'Matière créée avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
        $subject->load(['teacher.user', 'teachers.user']);
        
        return view('backend.subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    { 
        $teachers = Teacher::with('user')->latest()->get();
        $subject->load(['teacher.user', 'teachers.user']);

        return view('backend.subjects.edit', compact('subject','teachers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name'          => 'required|string|max:255|unique:subjects,name,'.$subject->id,
            'subject_code'  => 'required|numeric',
            'teacher_id'    => 'required|numeric',
            'description'   => 'required|string|max:255',
            'additional_teachers' => 'array',
            'additional_teachers.*' => 'exists:teachers,id'
        ]);

        $subject->update([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'subject_code'  => $request->subject_code,
            'teacher_id'    => $request->teacher_id,
            'description'   => $request->description
        ]);

        // Synchroniser les enseignants additionnels
        if ($request->has('additional_teachers')) {
            $additionalTeachers = array_filter($request->additional_teachers, function($teacherId) use ($request) {
                return $teacherId != $request->teacher_id; // Éviter les doublons
            });
            
            $subject->teachers()->sync($additionalTeachers);
        } else {
            $subject->teachers()->detach();
        }

        return redirect()->route('subject.index')->with('success', 'Matière mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        // Détacher tous les enseignants additionnels
        $subject->teachers()->detach();

        $subject->delete();

        return redirect()->route('subject.index')->with('success', 'Matière supprimée avec succès.');
    }

    /**
 * Télécharger le modèle de fichier d'import pour les matières
 */
public function downloadTemplate($type = 'excel')
{
    try {
        if ($type === 'csv') {
            $filename = 'modele_import_matieres.csv';
            $headers = [
                'nom',
                'code_matiere',
                'description',
                'email_enseignant',
                'emails_enseignants_additionnels'
            ];

            // Créer le contenu CSV
            $csvContent = implode(',', $headers) . "\n";
            
            // Ajouter des exemples de données
            $examples = [
                [
                    'Mathématiques',
                    '101',
                    'Cours de mathématiques générales couvrant l\'algèbre, la géométrie et les statistiques de base',
                    'ahmed.bennani@enseignant.ma',
                    'fatima.elamrani@enseignant.ma,mohammed.tazi@enseignant.ma'
                ],
                [
                    'Physique',
                    '102',
                    'Cours de physique fondamentale incluant la mécanique, l\'électricité et l\'optique',
                    'fatima.elamrani@enseignant.ma',
                    'ahmed.bennani@enseignant.ma'
                ],
                [
                    'Français',
                    '201',
                    'Cours de français : grammaire, littérature, expression écrite et orale',
                    'mohammed.tazi@enseignant.ma',
                    ''
                ]
            ];

            foreach ($examples as $example) {
                $csvContent .= '"' . implode('","', $example) . '"' . "\n";
            }
            
            return response($csvContent)
                ->header('Content-Type', 'text/csv; charset=UTF-8')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Content-Length', strlen($csvContent));
                
        } else {
            // Pour Excel
            return Excel::download(new SubjectsTemplateExport(), 'modele_import_matieres.xlsx');
        }
        
    } catch (\Exception $e) {
        \Log::error('Erreur téléchargement template matières: ' . $e->getMessage());
        
        return redirect()->back()->with('error', 'Erreur lors du téléchargement du modèle: ' . $e->getMessage());
    }
}

/**
 * Importer les matières en lot
 */
public function bulkImport(Request $request)
{
    try {
        // Validation du fichier
        $validator = Validator::make($request->all(), [
            'import_file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Fichier invalide. Veuillez vérifier le format et la taille.',
                'errors' => $validator->errors()
            ], 422);
        }

        $file = $request->file('import_file');
        
        // Créer une instance d'import personnalisée
        $import = new SubjectsImport();
        
        // Importer le fichier
        Excel::import($import, $file);
        
        // Récupérer les résultats
        $results = $import->getResults();
        
        return response()->json([
            'success' => true,
            'message' => 'Import terminé avec succès',
            'total' => $results['total'],
            'success' => $results['success'],
            'errors' => $results['errors'],
            'errorDetails' => $results['errorDetails']
        ]);

    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        $failures = $e->failures();
        $errorDetails = [];
        
        foreach ($failures as $failure) {
            $errorDetails[] = [
                'ligne' => $failure->row(),
                'erreur' => implode(', ', $failure->errors())
            ];
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Erreurs de validation dans le fichier',
            'total' => count($failures),
            'success' => 0,
            'errors' => count($failures),
            'errorDetails' => $errorDetails
        ], 422);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de l\'importation: ' . $e->getMessage(),
            'total' => 0,
            'success' => 0,
            'errors' => 1,
            'errorDetails' => [
                [
                    'ligne' => 'Système',
                    'erreur' => $e->getMessage()
                ]
            ]
        ], 500);
    }
}

    
}
