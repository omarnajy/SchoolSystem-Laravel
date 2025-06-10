<?php

namespace App\Imports;

use App\User;
use App\Student;
use App\Grade;
use App\Parents;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class StudentsImport implements ToCollection, WithHeadingRow
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

                // Vérifier si le numéro de matricule existe déjà dans la même classe
                $class = $this->findOrCreateClass($cleanedRow['nom_classe']);
                if (!$class) {
                    $this->results['errors']++;
                    $this->results['errorDetails'][] = [
                        'ligne' => $lineNumber,
                        'erreur' => "Impossible de trouver ou créer la classe: {$cleanedRow['nom_classe']}"
                    ];
                    DB::rollBack();
                    continue;
                }

                if (Student::where('roll_number', $cleanedRow['numero_matricule'])
                          ->where('class_id', $class->id)
                          ->exists()) {
                    $this->results['errors']++;
                    $this->results['errorDetails'][] = [
                        'ligne' => $lineNumber,
                        'erreur' => "Le numéro de matricule {$cleanedRow['numero_matricule']} existe déjà dans la classe {$cleanedRow['nom_classe']}"
                    ];
                    DB::rollBack();
                    continue;
                }

                // Trouver ou créer le parent
                $parent = $this->findOrCreateParent($cleanedRow);
                if (!$parent) {
                    $this->results['errors']++;
                    $this->results['errorDetails'][] = [
                        'ligne' => $lineNumber,
                        'erreur' => "Impossible de trouver ou créer le parent avec l'email: {$cleanedRow['email_parent']}"
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

                // Créer l'étudiant
                $user->student()->create([
                    'parent_id' => $parent->id,
                    'class_id' => $class->id,
                    'roll_number' => $cleanedRow['numero_matricule'],
                    'gender' => $cleanedRow['genre'],
                    'phone' => $cleanedRow['telephone'],
                    'dateofbirth' => $cleanedRow['date_naissance'],
                    'current_address' => $cleanedRow['adresse_actuelle'],
                    'permanent_address' => $cleanedRow['adresse_permanente']
                ]);

                // Assigner le rôle
                $user->assignRole('Student');

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
            'numero_matricule' => trim($row['numero_matricule'] ?? ''),
            'telephone' => trim($row['telephone'] ?? ''),
            'genre' => trim(strtolower($row['genre'] ?? '')),
            'date_naissance' => $this->parseDate($row['date_naissance'] ?? ''),
            'adresse_actuelle' => trim($row['adresse_actuelle'] ?? ''),
            'adresse_permanente' => trim($row['adresse_permanente'] ?? ''),
            'nom_classe' => trim($row['nom_classe'] ?? ''),
            'email_parent' => trim(strtolower($row['email_parent'] ?? '')),
            'nom_parent' => trim($row['nom_parent'] ?? '')
        ];
    }

    private function validateRowData($data, $lineNumber)
    {
        $rules = [
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mot_de_passe' => 'required|string|min:6',
            'numero_matricule' => 'required|string',
            'telephone' => 'required|string',
            'genre' => 'required|in:male,female,homme,femme',
            'date_naissance' => 'required|date',
            'adresse_actuelle' => 'required|string',
            'adresse_permanente' => 'required|string',
            'nom_classe' => 'required|string',
            'email_parent' => 'required|email',
            'nom_parent' => 'required|string'
        ];

        $messages = [
            'nom.required' => 'Le nom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être valide',
            'mot_de_passe.required' => 'Le mot de passe est obligatoire',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 6 caractères',
            'numero_matricule.required' => 'Le numéro de matricule est obligatoire',
            'telephone.required' => 'Le téléphone est obligatoire',
            'genre.required' => 'Le genre est obligatoire',
            'genre.in' => 'Le genre doit être male, female, homme ou femme',
            'date_naissance.required' => 'La date de naissance est obligatoire',
            'date_naissance.date' => 'La date de naissance doit être une date valide',
            'adresse_actuelle.required' => 'L\'adresse actuelle est obligatoire',
            'adresse_permanente.required' => 'L\'adresse permanente est obligatoire',
            'nom_classe.required' => 'Le nom de la classe est obligatoire',
            'email_parent.required' => 'L\'email du parent est obligatoire',
            'email_parent.email' => 'L\'email du parent doit être valide',
            'nom_parent.required' => 'Le nom du parent est obligatoire'
        ];

        return Validator::make($data, $rules, $messages);
    }

    private function parseDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }

        try {
            // Essayer différents formats de date
            $formats = ['Y-m-d', 'd/m/Y', 'd-m-Y', 'Y/m/d'];
            
            foreach ($formats as $format) {
                $date = \DateTime::createFromFormat($format, $dateString);
                if ($date !== false) {
                    return $date->format('Y-m-d');
                }
            }
            
            // Si aucun format ne fonctionne, essayer Carbon
            return Carbon::parse($dateString)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    private function findOrCreateClass($className)
    {
        if (empty($className)) {
            return null;
        }

        // Chercher la classe existante
        $class = Grade::where('class_name', $className)->first();
        
        if (!$class) {
            // Créer la classe si elle n'existe pas
            try {
                $class = Grade::create([
                    'class_name' => $className,
                    'section' => 'A', // Section par défaut
                    'description' => 'Classe créée automatiquement lors de l\'import'
                ]);
            } catch (\Exception $e) {
                return null;
            }
        }

        return $class;
    }

    private function findOrCreateParent($data)
    {
        if (empty($data['email_parent'])) {
            return null;
        }

        // Chercher le parent par email
        $parentUser = User::where('email', $data['email_parent'])->first();
        
        if ($parentUser && $parentUser->parent) {
            return $parentUser->parent;
        }

        // Créer le parent s'il n'existe pas
        try {
            if (!$parentUser) {
                $parentUser = User::create([
                    'name' => $data['nom_parent'],
                    'email' => $data['email_parent'],
                    'password' => Hash::make('password123'), // Mot de passe par défaut
                    'profile_picture' => 'avatar.png'
                ]);
            }

            $parent = $parentUser->parent()->create([
                'phone' => '+212600000000', // Téléphone par défaut
                'address' => 'Adresse non renseignée'
            ]);

            $parentUser->assignRole('Parent');

            return $parent;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getResults()
    {
        return $this->results;
    }
}