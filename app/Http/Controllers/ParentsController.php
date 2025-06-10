<?php

namespace App\Http\Controllers;

use App\User;
use App\Parents;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ParentsImport;
use App\Exports\ParentsTemplateExport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ParentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parents = Parents::with(['user','children'])->latest()->paginate(10);
        
        return view('backend.parents.index', compact('parents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.parents.create');
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
            'gender'            => 'required|string|max:255',
            'phone'             => 'required|string|max:255',
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

        $user->parent()->create([
            'gender'            => $request->gender,
            'phone'             => $request->phone,
            'current_address'   => $request->current_address,
            'permanent_address' => $request->permanent_address
        ]);

        $user->assignRole('Parent');

        return redirect()->route('parents.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function show(Parents $parents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parent = Parents::with('user')->findOrFail($id); 

        return view('backend.parents.edit', compact('parent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $parents = Parents::findOrFail($id);

        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users,email,'.$parents->user_id,
            'gender'            => 'required|string',
            'phone'             => 'required|string|max:255',
            'current_address'   => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255'
        ]);

        if ($request->hasFile('profile_picture')) {
            $profile = Str::slug($parents->user->name).'-'.$parents->user->id.'.'.$request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('images/profile'), $profile);
        } else {
            $profile = $parents->user->profile_picture;
        }

        $parents->user()->update([
            'name'              => $request->name,
            'email'             => $request->email,
            'profile_picture'   => $profile
        ]);

        $parents->update([
            'gender'            => $request->gender,
            'phone'             => $request->phone,
            'current_address'   => $request->current_address,
            'permanent_address' => $request->permanent_address
        ]);

        return redirect()->route('parents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parents  $parents
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parent = Parents::findOrFail($id);

        $user = User::findOrFail($parent->user_id);
        $user->removeRole('Parent');

        if ($user->delete()) {
            if($user->profile_picture != 'avatar.png') {
                $image_path = public_path() . '/images/profile/' . $user->profile_picture;
                if (is_file($image_path) && file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }

        $parent->delete();

        return back();
    }

    /**
 * Télécharger le modèle de fichier d'import pour les parents
 */
public function downloadTemplate($type = 'excel')
{
    try {
        if ($type === 'csv') {
            $filename = 'modele_import_parents.csv';
            $headers = [
                'nom',
                'email',
                'mot_de_passe',
                'genre',
                'telephone',
                'adresse_actuelle',
                'adresse_permanente',
                'profession',
                'contact_urgence'
            ];

            // Créer le contenu CSV
            $csvContent = implode(',', $headers) . "\n";
            
            // Ajouter des exemples de données
            $examples = [
                [
                    'Ahmed Alami',
                    'ahmed.alami@parent.ma',
                    'motdepasse123',
                    'male',
                    '+212612345678',
                    '123 Avenue Hassan II, Casablanca',
                    '456 Rue Mohamed V, Rabat',
                    'Ingénieur',
                    '+212687654321'
                ],
                [
                    'Fatima Bennani',
                    'fatima.bennani@parent.ma',
                    'password456',
                    'female',
                    '+212698765432',
                    '789 Boulevard Zerktouni, Casablanca',
                    '321 Avenue des FAR, Casablanca',
                    'Médecin',
                    '+212676543210'
                ],
                [
                    'Mohammed Tazi',
                    'mohammed.tazi@parent.ma',
                    'securepwd789',
                    'male',
                    '+212665432109',
                    '45 Rue Allal Ben Abdellah, Rabat',
                    '67 Avenue Ibn Sina, Rabat',
                    'Professeur',
                    '+212654321098'
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
            return Excel::download(new ParentsTemplateExport(), 'modele_import_parents.xlsx');
        }
        
    } catch (\Exception $e) {
        \Log::error('Erreur téléchargement template parents: ' . $e->getMessage());
        
        return redirect()->back()->with('error', 'Erreur lors du téléchargement du modèle: ' . $e->getMessage());
    }
}

/**
 * Importer les parents en lot
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
        $import = new ParentsImport();
        
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
