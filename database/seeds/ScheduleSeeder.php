<?php
// database/seeders/ScheduleSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Schedule;
use App\Grade;
use App\Subject;
use App\Teacher;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Récupérer les données existantes
        $classes = Grade::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();

        if ($classes->isEmpty() || $subjects->isEmpty() || $teachers->isEmpty()) {
            $this->command->info('Veuillez d\'abord créer des classes, matières et enseignants avant de générer les emplois du temps.');
            return;
        }

        $academicYear = date('Y');
        $semester = '1';
        
        // Horaires disponibles
        $timeSlots = [
            ['08:00', '09:00'],
            ['09:00', '10:00'],
            ['10:00', '11:00'],
            ['11:00', '12:00'],
            ['13:00', '14:00'],
            ['14:00', '15:00'],
            ['15:00', '16:00'],
            ['16:00', '17:00'],
        ];

        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        $rooms = ['A101', 'A102', 'A103', 'B201', 'B202', 'B203', 'Lab1', 'Lab2'];

        $schedules = [];
        
        foreach ($classes as $class) {
            $this->command->info("Création d'emploi du temps pour la classe: {$class->class_name}");
            
            $usedSlots = []; // Pour éviter les conflits
            $subjectHours = []; // Pour répartir les heures par matière
            
            // Répartir les matières sur la semaine
            $classSubjects = $subjects->random(min(6, $subjects->count()));
            
            foreach ($classSubjects as $index => $subject) {
                // Assigner un enseignant aléatoire pour cette matière
                $teacher = $teachers->random();
                
                // Déterminer le nombre d'heures pour cette matière (entre 2 et 4h par semaine)
                $hoursPerWeek = rand(2, 4);
                $subjectHours[$subject->id] = $hoursPerWeek;
                
                $assignedHours = 0;
                $attempts = 0;
                $maxAttempts = 50;
                
                while ($assignedHours < $hoursPerWeek && $attempts < $maxAttempts) {
                    $attempts++;
                    
                    // Choisir un jour et un créneau aléatoirement
                    $day = $days[array_rand($days)];
                    $timeSlot = $timeSlots[array_rand($timeSlots)];
                    
                    $slotKey = $class->id . '_' . $day . '_' . $timeSlot[0];
                    
                    // Vérifier si le créneau est libre pour cette classe
                    if (!in_array($slotKey, $usedSlots)) {
                        // Vérifier si l'enseignant est libre à ce moment
                        $teacherConflict = Schedule::where('teacher_id', $teacher->id)
                                                 ->where('day_of_week', $day)
                                                 ->where('academic_year', $academicYear)
                                                 ->where('semester', $semester)
                                                 ->where(function($query) use ($timeSlot) {
                                                     $query->whereBetween('start_time', [$timeSlot[0], $timeSlot[1]])
                                                           ->orWhereBetween('end_time', [$timeSlot[0], $timeSlot[1]])
                                                           ->orWhere(function($q) use ($timeSlot) {
                                                               $q->where('start_time', '<=', $timeSlot[0])
                                                                 ->where('end_time', '>=', $timeSlot[1]);
                                                           });
                                                 })
                                                 ->exists();
                        
                        if (!$teacherConflict) {
                            $schedules[] = [
                                'class_id' => $class->id,
                                'subject_id' => $subject->id,
                                'teacher_id' => $teacher->id,
                                'day_of_week' => $day,
                                'start_time' => $timeSlot[0],
                                'end_time' => $timeSlot[1],
                                'room' => $rooms[array_rand($rooms)],
                                'academic_year' => $academicYear,
                                'semester' => $semester,
                                'notes' => $this->generateRandomNote(),
                                'is_active' => true,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                            
                            $usedSlots[] = $slotKey;
                            $assignedHours++;
                            
                            $this->command->info("  - {$subject->subject_name} assigné le {$day} de {$timeSlot[0]} à {$timeSlot[1]} avec {$teacher->user->name}");
                        }
                    }
                }
                
                if ($assignedHours < $hoursPerWeek) {
                    $this->command->warn("  ⚠ Impossible d'assigner toutes les heures pour {$subject->subject_name} (assigné: {$assignedHours}/{$hoursPerWeek})");
                }
            }
        }

        // Insérer tous les emplois du temps en une fois
        if (!empty($schedules)) {
            Schedule::insert($schedules);
            $this->command->info("✅ {count($schedules)} cours créés avec succès !");
            
            // Statistiques
            $this->command->info("\n📊 Statistiques:");
            $this->command->info("- Classes: " . $classes->count());
            $this->command->info("- Matières: " . $subjects->count());
            $this->command->info("- Enseignants: " . $teachers->count());
            $this->command->info("- Total cours/semaine: " . count($schedules));
            $this->command->info("- Moyenne cours/classe: " . round(count($schedules) / $classes->count(), 1));
        } else {
            $this->command->error("❌ Aucun emploi du temps n'a pu être créé.");
        }
    }

    /**
     * Générer une note aléatoire pour le cours
     */
    private function generateRandomNote()
    {
        $notes = [
            'Cours magistral',
            'Travaux pratiques',
            'Travaux dirigés',
            'Cours interactif',
            'Projet en groupe',
            'Évaluation',
            'Révisions',
            'Cours de rattrapage',
            null, null, null // Plus de chances d'avoir pas de notes
        ];

        return $notes[array_rand($notes)];
    }
}

// Pour utiliser ce seeder, ajoutez ceci à votre DatabaseSeeder.php :
/*
public function run()
{
    $this->call([
        // Vos autres seeders...
        ScheduleSeeder::class,
    ]);
}
*/