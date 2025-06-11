<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyGradeTeacherTableRemoveMainTeacher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grade_teacher', function (Blueprint $table) {
            // Supprimer la colonne is_main_teacher
            $table->dropColumn('is_main_teacher');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grade_teacher', function (Blueprint $table) {
            // Ajouter la colonne is_main_teacher en cas de rollback
            $table->boolean('is_main_teacher')->default(false);
        });
    }
}