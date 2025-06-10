<?php

namespace App\Imports;

use App\User;
use App\Teacher;
use App\Subject;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class TeachersImport implements ToCollection, WithHeadingRow
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

                // Créer l'enseignant
                $teacher = $user->teacher()->create([
                    'gender' => $cleanedRow['genre'],
                    'phone' => $cleanedRow['telephone'],
                    'dateofbirth' => $cleanedRow['date_naissance'],
                    'current_address' => $cleanedRow['adresse_actuelle'],
                    'permanent_address' => $cleanedRow['adresse_permanente']
                ]);

                // Assigner le rôle
                $user->assignRole('Teacher');

                

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
            'date_naissance' => $this->parseDate($row['date_naissance'] ?? ''),
            'adresse_actuelle' => trim($row['adresse_actuelle'] ?? ''),
            'adresse_permanente' => trim($row['adresse_permanente'] ?? '')
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
            'date_naissance' => 'required|date',
            'adresse_actuelle' => 'required|string',
            'adresse_permanente' => 'required|string'
        ];

        $messages = [
            'nom.required' => 'Le nom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être valide',
            'mot_de_passe.required' => 'Le mot de passe est obligatoire',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 6 caractères',
            'genre.required' => 'Le genre est obligatoire',
            'genre.in' => 'Le genre doit être male, female, homme ou femme',
            'telephone.required' => 'Le téléphone est obligatoire',
            'date_naissance.required' => 'La date de naissance est obligatoire',
            'date_naissance.date' => 'La date de naissance doit être une date valide',
            'adresse_actuelle.required' => 'L\'adresse actuelle est obligatoire',
            'adresse_permanente.required' => 'L\'adresse permanente est obligatoire'
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

    private function assignSubjects($teacher, $subjectsString)
    {
        if (empty($subjectsString)) {
            return;
        }

        // Séparer les matières par virgule
        $subjectNames = array_map('trim', explode(',', $subjectsString));

        foreach ($subjectNames as $subjectName) {
            if (empty($subjectName)) {
                continue;
            }

            // Chercher ou créer la matière
            $subject = Subject::firstOrCreate(
                ['subject_name' => $subjectName],
                [
                    'subject_code' => strtoupper(substr($subjectName, 0, 3)) . rand(100, 999),
                    'description' => 'Matière créée automatiquement lors de l\'import'
                ]
            );

            // Associer la matière à l'enseignant si elle n'est pas déjà associée
            if (!$teacher->subjects()->where('subject_id', $subject->id)->exists()) {
                $teacher->subjects()->attach($subject->id);
            }
        }
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