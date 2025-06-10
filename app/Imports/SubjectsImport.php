<?php

namespace App\Imports;

use App\Subject;
use App\Teacher;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class SubjectsImport implements ToCollection, WithHeadingRow
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

                // Vérifier si la matière existe déjà (par nom)
                if (Subject::where('name', $cleanedRow['nom'])->exists()) {
                    $this->results['errors']++;
                    $this->results['errorDetails'][] = [
                        'ligne' => $lineNumber,
                        'erreur' => "La matière '{$cleanedRow['nom']}' existe déjà"
                    ];
                    DB::rollBack();
                    continue;
                }

                // Vérifier si le code matière existe déjà
                if (Subject::where('subject_code', $cleanedRow['code_matiere'])->exists()) {
                    $this->results['errors']++;
                    $this->results['errorDetails'][] = [
                        'ligne' => $lineNumber,
                        'erreur' => "Le code matière '{$cleanedRow['code_matiere']}' existe déjà"
                    ];
                    DB::rollBack();
                    continue;
                }

                // Trouver l'enseignant responsable
                $teacher = $this->findTeacher($cleanedRow['email_enseignant']);
                if (!$teacher) {
                    $this->results['errors']++;
                    $this->results['errorDetails'][] = [
                        'ligne' => $lineNumber,
                        'erreur' => "Enseignant avec l'email '{$cleanedRow['email_enseignant']}' non trouvé"
                    ];
                    DB::rollBack();
                    continue;
                }

                // Créer la matière
                $subject = Subject::create([
                    'name' => $cleanedRow['nom'],
                    'slug' => Str::slug($cleanedRow['nom']),
                    'subject_code' => $cleanedRow['code_matiere'],
                    'teacher_id' => $teacher->id,
                    'description' => $cleanedRow['description']
                ]);

                // Assigner les enseignants additionnels s'il y en a
                if (!empty($cleanedRow['emails_enseignants_additionnels'])) {
                    $this->assignAdditionalTeachers($subject, $cleanedRow['emails_enseignants_additionnels'], $teacher->id);
                }

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
            'code_matiere' => trim($row['code_matiere'] ?? ''),
            'description' => trim($row['description'] ?? ''),
            'email_enseignant' => trim(strtolower($row['email_enseignant'] ?? '')),
            'emails_enseignants_additionnels' => trim($row['emails_enseignants_additionnels'] ?? '')
        ];
    }

    private function validateRowData($data, $lineNumber)
    {
        $rules = [
            'nom' => 'required|string|max:255',
            'code_matiere' => 'required|numeric',
            'description' => 'required|string|max:500',
            'email_enseignant' => 'required|email'
        ];

        $messages = [
            'nom.required' => 'Le nom de la matière est obligatoire',
            'nom.max' => 'Le nom de la matière ne doit pas dépasser 255 caractères',
            'code_matiere.required' => 'Le code matière est obligatoire',
            'code_matiere.numeric' => 'Le code matière doit être numérique',
            'description.required' => 'La description est obligatoire',
            'description.max' => 'La description ne doit pas dépasser 500 caractères',
            'email_enseignant.required' => 'L\'email de l\'enseignant responsable est obligatoire',
            'email_enseignant.email' => 'L\'email de l\'enseignant doit être valide'
        ];

        return Validator::make($data, $rules, $messages);
    }

    private function findTeacher($email)
    {
        if (empty($email)) {
            return null;
        }

        return Teacher::whereHas('user', function($query) use ($email) {
            $query->where('email', $email);
        })->first();
    }

    private function assignAdditionalTeachers($subject, $emailsString, $mainTeacherId)
    {
        if (empty($emailsString)) {
            return;
        }

        // Séparer les emails par virgule
        $emails = array_map('trim', explode(',', strtolower($emailsString)));
        $teacherIds = [];

        foreach ($emails as $email) {
            if (empty($email)) {
                continue;
            }

            $teacher = $this->findTeacher($email);
            if ($teacher && $teacher->id !== $mainTeacherId) {
                $teacherIds[] = $teacher->id;
            }
        }

        if (!empty($teacherIds)) {
            $subject->teachers()->attach(array_unique($teacherIds));
        }
    }

    public function getResults()
    {
        return $this->results;
    }
}