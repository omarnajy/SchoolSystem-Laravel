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
        
        // Ajouter les enseignants additionnels
        $additionalTeachers = $this->teachers()->where('teachers.id', '!=', $this->teacher_id)->get();
        $allTeachers = $allTeachers->merge($additionalTeachers);
        
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
}
