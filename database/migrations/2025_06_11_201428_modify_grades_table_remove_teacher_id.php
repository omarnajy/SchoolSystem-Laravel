<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyGradesTableRemoveTeacherId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grades', function (Blueprint $table) {
            // Supprimer la colonne teacher_id
            $table->dropColumn('teacher_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            // Ajouter la colonne teacher_id en cas de rollback
            $table->unsignedBigInteger('teacher_id')->nullable();
        });
    }
}