<?php

namespace App\Imports;

use App\User;
use App\Parents;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class ParentsImport implements ToCollection, WithHeadingRow
{
    private $results = [
        'total' => 0,
        'success' => 0,
        'errors' => 0,
        'errorDetails' => []
    ];

    public function collection(Collection $rows)
    {
        $this->results['total'] = $rows->count();

        foreach ($rows as $index => $row) {
            $lineNumber = $index + 2; // +2 car les en-têtes sont à la ligne 1
            
            try {
                DB::beginTransaction();
                
                // Nettoyer et valider les données
                $cleanedRow = $this->cleanRowData($row);
                
                // Validation des données
                $validator = $this->validateRowData($cleanedRow, $lineNumber);
                
                if ($validator->fails()) {
                    $this->results['errors']++;
                    $this->results['errorDetails'][] = [
                        'ligne' => $lineNumber,
                        'erreur' => implode(', ', $validator->errors()->all())
                    ];
                    DB::rollBack();
                    continue;
                }

                // Vérifier si l'email existe déjà
                if (User::where('email', $cleanedRow['email'])->exists()) {
                    $this->results['errors']++;
                    $this->results['errorDetails'][] = [
                        'ligne' => $lineNumber,
                        'erreur' => "L'email {$cleanedRow['email']} existe déjà"
                    ];
                    DB::rollBack();
                    continue;
                }

                // Créer l'utilisateur
                $user = User::create([
                    'name' => $cleanedRow['nom'],
                    'email' => $cleanedRow['email'],
                    'password' => Hash::make($cleanedRow['mot_de_passe']),
                    'profile_picture' => 'avatar.png'
                ]);

                // Créer le parent
                $parent = $user->parent()->create([
                    'gender' => $this->normalizeGender($cleanedRow['genre']),
                    'phone' => $cleanedRow['telephone'],
                    'current_address' => $cleanedRow['adresse_actuelle'],
                    'permanent_address' => $cleanedRow['adresse_permanente']
                ]);

                // Assigner le rôle
                $user->assignRole('Parent');

                $this->results['success']++;
                DB::commit();

            } catch (\Exception $e) {
                $this->results['errors']++;
                $this->results['errorDetails'][] = [
                    'ligne' => $lineNumber,
                    'erreur' => 'Erreur système: ' . $e->getMessage()
                ];
                DB::rollBack();
            }
        }
    }

    private function cleanRowData($row)
    {
        return [
            'nom' => trim($row['nom'] ?? ''),
            'email' => trim(strtolower($row['email'] ?? '')),
            'mot_de_passe' => trim($row['mot_de_passe'] ?? ''),
            'genre' => trim(strtolower($row['genre'] ?? '')),
            'telephone' => trim($row['telephone'] ?? ''),
            'adresse_actuelle' => trim($row['adresse_actuelle'] ?? ''),
            'adresse_permanente' => trim($row['adresse_permanente'] ?? ''),
            'profession' => trim($row['profession'] ?? ''),
            'contact_urgence' => trim($row['contact_urgence'] ?? '')
        ];
    }

    private function validateRowData($data, $lineNumber)
    {
        $rules = [
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mot_de_passe' => 'required|string|min:6',
            'genre' => 'required|in:male,female,homme,femme',
            'telephone' => 'required|string',
            'adresse_actuelle' => 'required|string|max:500',
            'adresse_permanente' => 'required|string|max:500'
        ];

        $messages = [
            'nom.required' => 'Le nom est obligatoire',
            'nom.max' => 'Le nom ne doit pas dépasser 255 caractères',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être valide',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères',
            'mot_de_passe.required' => 'Le mot de passe est obligatoire',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 6 caractères',
            'genre.required' => 'Le genre est obligatoire',
            'genre.in' => 'Le genre doit être male, female, homme ou femme',
            'telephone.required' => 'Le téléphone est obligatoire',
            'adresse_actuelle.required' => 'L\'adresse actuelle est obligatoire',
            'adresse_actuelle.max' => 'L\'adresse actuelle ne doit pas dépasser 500 caractères',
            'adresse_permanente.required' => 'L\'adresse permanente est obligatoire',
            'adresse_permanente.max' => 'L\'adresse permanente ne doit pas dépasser 500 caractères'
        ];

        return Validator::make($data, $rules, $messages);
    }

    private function normalizeGender($gender)
    {
        $gender = strtolower(trim($gender));
        
        if (in_array($gender, ['homme', 'male', 'm'])) {
            return 'male';
        } elseif (in_array($gender, ['femme', 'female', 'f'])) {
            return 'female';
        }
        
        return $gender;
    }

    public function getResults()
    {
        return $this->results;
    }
}