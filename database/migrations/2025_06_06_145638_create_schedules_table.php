<?php
// database/migrations/xxxx_xx_xx_create_schedules_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('teacher_id');
            $table->enum('day_of_week', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']);
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room')->nullable();
            $table->string('academic_year');
            $table->enum('semester', ['1', '2'])->default('1');
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Relations
            $table->foreign('class_id')->references('id')->on('grades')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');

            // Index pour optimiser les requêtes
            $table->index(['class_id', 'day_of_week']);
            $table->index(['teacher_id', 'day_of_week']);
            $table->index(['academic_year', 'semester']);

            // Contrainte pour éviter les conflits d'horaires pour une même classe
            $table->unique(['class_id', 'day_of_week', 'start_time', 'academic_year', 'semester'], 'unique_class_schedule');
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}