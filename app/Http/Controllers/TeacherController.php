<?php

namespace App\Http\Controllers;

use App\User;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TeachersImport;
use App\Exports\TeachersTemplateExport;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Charger les enseignants avec leurs relations
        $teachers = Teacher::with(['user', 'subjects'])->latest()->paginate(10);

        return view('backend.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.teachers.create');
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
            'gender'            => 'required|string',
            'phone'             => 'required|string|max:255',
            'dateofbirth'       => 'required|date',
            'current_address'   => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255'
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
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

        $user->teacher()->create([
            'gender'            => $request->gender,
            'phone'             => $request->phone,
            'dateofbirth'       => $request->dateofbirth,
            'current_address'   => $request->current_address,
            'permanent_address' => $request->permanent_address
        ]);

        $user->assignRole('Teacher');

        return redirect()->route('teacher.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        $teacher = Teacher::with('user')->findOrFail($teacher->id);

        return view('backend.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users,email,'.$teacher->user_id,
            'gender'            => 'required|string',
            'phone'             => 'required|string|max:255',
            'dateofbirth'       => 'required|date',
            'current_address'   => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255'
        ]);

        $user = User::findOrFail($teacher->user_id);

        if ($request->hasFile('profile_picture')) {
            $profile = Str::slug($user->name).'-'.$user->id.'.'.$request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('images/profile'), $profile);
        } else {
            $profile = $user->profile_picture;
        }

        $user->update([
            'name'              => $request->name,
            'email'             => $request->email,
            'profile_picture'   => $profile
        ]);

        $user->teacher()->update([
            'gender'            => $request->gender,
            'phone'             => $request->phone,
            'dateofbirth'       => $request->dateofbirth,
            'current_address'   => $request->current_address,
            'permanent_address' => $request->permanent_address
        ]);

        return redirect()->route('teacher.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        $user = User::findOrFail($teacher->user_id);

        $user->teacher()->delete();
        
        $user->removeRole('Teacher');

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
 * Télécharger le modèle de fichier d'import pour les enseignants
 */
public function downloadTemplate($type = 'excel')
{
    try {
        if ($type === 'csv') {
            $filename = 'modele_import_enseignants.csv';
            $headers = [
                'nom',
                'email',
                'mot_de_passe',
                'genre',
                'telephone',
                'date_naissance',
                'adresse_actuelle',
                'adresse_permanente'
            ];

            // Créer le contenu CSV
            $csvContent = implode(',', $headers) . "\n";
            
            // Ajouter des exemples de données
            $examples = [
                [
                    'Ahmed Bennani',
                    'ahmed.bennani@enseignant.ma',
                    'motdepasse123',
                    'male',
                    '+212612345678',
                    '1985-03-15',
                    '123 Avenue Hassan II, Casablanca',
                    '456 Rue Mohamed V, Rabat'
                ],
                [
                    'Fatima El Amrani',
                    'fatima.elamrani@enseignant.ma',
                    'password456',
                    'female',
                    '+212687654321',
                    '1990-07-22',
                    '789 Boulevard Zerktouni, Casablanca',
                    '321 Avenue des FAR, Casablanca'
                ],
                [
                    'Mohammed Tazi',
                    'mohammed.tazi@enseignant.ma',
                    'securepwd789',
                    'male',
                    '+212698765432',
                    '1982-11-10',
                    '45 Rue Allal Ben Abdellah, Rabat',
                    '67 Avenue Ibn Sina, Rabat'
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
            // Pour Excel - Utiliser la classe TeachersTemplateExport
            return Excel::download(new \App\Exports\TeachersTemplateExport(), 'modele_import_enseignants.xlsx');
        }
        
    } catch (\Exception $e) {
        \Log::error('Erreur téléchargement template enseignants: ' . $e->getMessage());
        
        return redirect()->back()->with('error', 'Erreur lors du téléchargement du modèle: ' . $e->getMessage());
    }
}

    /**
     * Importer les enseignants en lot
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
            $import = new TeachersImport();
            
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