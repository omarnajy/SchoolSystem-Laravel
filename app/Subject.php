<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'subject_code',
        'teacher_id',
        'description'
    ];

     /**
     * Relation belongsTo avec l'enseignant principal (pour teacher_id)
     * Utilisée pour l'enseignant responsable principal de la matière
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }


    /**
     * Relation many-to-many avec les enseignants
     * Une matière peut être enseignée par plusieurs enseignants
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher', 'subject_id', 'teacher_id');
    }

    /**
     * Relation many-to-many avec les classes (grades)
     */
    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'grade_subject', 'subject_id', 'grade_id')
                   ->withTimestamps();
    }

    /**
     * Relation avec les emplois du temps
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }


    /**
     * Obtenir tous les enseignants qui enseignent cette matière
     * (incluant l'enseignant principal et les enseignants additionnels)
     */
    public function getAllTeachers()
    {
        $allTeachers = collect();
        
        // Ajouter l'enseignant principal
        if ($this->teacher) {
            $allTeachers->push($this->teacher);
        }
        
        // Ajouter les enseignants additionnels (en évitant les doublons)
        $additionalTeachers = $this->teachers;
        foreach ($additionalTeachers as $teacher) {
            if (!$allTeachers->contains('id', $teacher->id)) {
                $allTeachers->push($teacher);
            }
        }
        
        return $allTeachers->unique('id');
    }
    
    /**
     * Obtenir les enseignants qui enseignent cette matière
     */
    public function getTeachers()
    {
        return Teacher::whereHas('schedules', function($query) {
            $query->where('subject_id', $this->id);
        })->with('user')->get();
    }

    /**
     * Obtenir les enseignants qui enseignent cette matière via les horaires
     */
    public function getScheduledTeachers()
    {
        return Teacher::whereHas('schedules', function($query) {
            $query->where('subject_id', $this->id);
        })->with('user')->get();
    }

    /**
     * Vérifier si un enseignant peut enseigner cette matière
     */
    public function hasTeacher($teacherId)
    {
        return $this->teacher_id === $teacherId || 
               $this->teachers->contains('id', $teacherId);
    }

    /**
     * Obtenir les classes où cette matière est enseignée
     */
    public function getGrades()
    {
        return $this->grades()->with(['teachers', 'students'])->get();
    }
}
