<?php

namespace App\Http\Controllers;

use App\User;
use App\Grade;
use App\Parents;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;
use App\Exports\StudentsTemplateExport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with('class')->latest()->paginate(10);

        return view('backend.students.index', compact('students'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = Grade::latest()->get();
        $parents = Parents::with('user')->latest()->get();
        
        return view('backend.students.create', compact('classes','parents'));
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
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users',
            'password'          => 'required|string|min:8',
            'parent_id'         => 'required|numeric',
            'class_id'          => 'required|numeric',
            'roll_number'       => [
                'required',
                'numeric',
                Rule::unique('students')->where(function ($query) use ($request) {
                    return $query->where('class_id', $request->class_id);
                })
            ],
            'gender'            => 'required|string',
            'phone'             => 'required|string|max:255',
            'dateofbirth'       => 'required|date',
            'current_address'   => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255'
        ]);

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password)
        ]);

        if ($request->hasFile('profile_picture')) {
            $profile = Str::slug($user->name).'-'.$user->id.'.'.$request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('images/profile'), $profile);
        } else {
            $profile = 'avatar.png';
        }
        $user->update([
            'profile_picture' => $profile
        ]);

        $user->student()->create([
            'parent_id'         => $request->parent_id,
            'class_id'          => $request->class_id,
            'roll_number'       => $request->roll_number,
            'gender'            => $request->gender,
            'phone'             => $request->phone,
            'dateofbirth'       => $request->dateofbirth,
            'current_address'   => $request->current_address,
            'permanent_address' => $request->permanent_address
        ]);

        $user->assignRole('Student');

        return redirect()->route('student.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $class = Grade::with('subjects')->where('id', $student->class_id)->first();
        
        return view('backend.students.show', compact('class','student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $classes = Grade::latest()->get();
        $parents = Parents::with('user')->latest()->get();

        return view('backend.students.edit', compact('classes','parents','student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users,email,'.$student->user_id,
            'parent_id'         => 'required|numeric',
            'class_id'          => 'required|numeric',
            'roll_number'       => [
                'required',
                'numeric',
                Rule::unique('students')->ignore($student->id)->where(function ($query) use ($request) {
                    return $query->where('class_id', $request->class_id);
                })
            ],
            'gender'            => 'required|string',
            'phone'             => 'required|string|max:255',
            'dateofbirth'       => 'required|date',
            'current_address'   => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255'
        ]);

        if ($request->hasFile('profile_picture')) {
            $profile = Str::slug($student->user->name).'-'.$student->user->id.'.'.$request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('images/profile'), $profile);
        } else {
            $profile = $student->user->profile_picture;
        }

        $student->user()->update([
            'name'              => $request->name,
            'email'             => $request->email,
            'profile_picture'   => $profile
        ]);

        $student->update([
            'parent_id'         => $request->parent_id,
            'class_id'          => $request->class_id,
            'roll_number'       => $request->roll_number,
            'gender'            => $request->gender,
            'phone'             => $request->phone,
            'dateofbirth'       => $request->dateofbirth,
            'current_address'   => $request->current_address,
            'permanent_address' => $request->permanent_address
        ]);

        return redirect()->route('student.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $user = User::findOrFail($student->user_id);
        $user->student()->delete();
        $user->removeRole('Student');

        if ($user->delete()) {
            if($user->profile_picture != 'avatar.png') {
                $image_path = public_path() . '/images/profile/' . $user->profile_picture;
                if (is_file($image_path) && file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }

        return back();
    }

    /**
 * Télécharger le modèle de fichier d'import
 */
public function downloadTemplate($type = 'excel')
{
    try {
        if ($type === 'csv') {
            $filename = 'modele_import_etudiants.csv';
            $headers = [
                'nom',
                'email', 
                'mot_de_passe',
                'numero_matricule',
                'telephone',
                'genre',
                'date_naissance',
                'adresse_actuelle',
                'adresse_permanente',
                'nom_classe',
                'email_parent',
                'nom_parent'
            ];

            $handle = fopen('php://temp', 'w+');
            
            // Ajouter les en-têtes
            fputcsv($handle, $headers);
            
            // Ajouter des exemples de données
            fputcsv($handle, [
                'Jean Dupont',
                'jean.dupont22@email.com',
                'motdepasse123',
                '2024001',
                '+212612345678',
                'male',
                '2000-01-15',
                '123 Rue de la Paix, Casablanca',
                '456 Avenue Hassan II, Rabat',
                'One',
                'mouad@gmail.com',
                'Monsieur Dupont'
            ]);
            
            fputcsv($handle, [
                'Marie Martin',
                'marie.martin22@email.com',
                'password456',
                '2024002',
                '+212687654321',
                'female',
                '1999-06-22',
                '789 Boulevard Zerktouni, Casablanca',
                '321 Rue Allal Ben Abdellah, Rabat',
                'One',
                'mouad@gmail.com',
                'Madame Martin'
            ]);

            fputcsv($handle, [
                'Ahmed Alami',
                'ahmed.alami@email.com',
                'password789',
                '2024003',
                '+212698765432',
                'male',
                '2001-03-10',
                '45 Rue Mohamed V, Rabat',
                '67 Avenue Hassan II, Casablanca',
                'One',
                'mouad@gmail.com',
                'Monsieur Alami'
            ]);

            rewind($handle);
            $csv = stream_get_contents($handle);
            fclose($handle);
            
            return response($csv)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        } else {
            // Pour Excel
            return Excel::download(new StudentsTemplateExport(), 'modele_import_etudiants.xlsx');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erreur lors du téléchargement du modèle: ' . $e->getMessage());
    }
}

/**
 * Importer les étudiants en lot
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
        $import = new StudentsImport();
        
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
                ]]);
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

