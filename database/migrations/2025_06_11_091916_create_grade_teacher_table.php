<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradeTeacherTable extends Migration
{
    public function up()
    {
        Schema::create('grade_teacher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->boolean('is_main_teacher')->default(false); // Pour identifier le prof principal
            $table->timestamps();
            
            $table->unique(['grade_id', 'teacher_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('grade_teacher');
    }
}