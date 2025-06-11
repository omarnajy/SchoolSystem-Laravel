<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MigrateExistingClassTeachers extends Migration
{
    public function up()
    {
        // Récupérer toutes les classes qui ont un teacher_id
        $classes = DB::table('grades')->whereNotNull('teacher_id')->get();
        
        foreach ($classes as $class) {
            // Vérifier si la relation n'existe pas déjà
            $exists = DB::table('grade_teacher')
                       ->where('grade_id', $class->id)
                       ->where('teacher_id', $class->teacher_id)
                       ->exists();
            
            if (!$exists) {
                // Insérer dans la table pivot
                DB::table('grade_teacher')->insert([
                    'grade_id' => $class->id,
                    'teacher_id' => $class->teacher_id,
                    'is_main_teacher' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down()
    {
        // Supprimer toutes les relations de la table pivot
        DB::table('grade_teacher')->truncate();
    }
}