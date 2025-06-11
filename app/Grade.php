<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'class_name',
        'class_numeric',
        'class_description'
        // Suppression de teacher_id car plus de notion de professeur principal
    ];

    public function students()
    {
        return $this->hasMany(Student::class,'class_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    /**
     * Enseignants assignés à cette classe
     * (indépendamment des matières qu'ils enseignent)
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'grade_teacher')
                   ->withTimestamps();
    }

    /**
     * Relation avec les emplois du temps
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }

    /**
     * Obtenir l'emploi du temps actuel
     */
    public function getCurrentSchedules($academicYear = null, $semester = null)
    {
        $academicYear = $academicYear ?: date('Y');
        $semester = $semester ?: '1';

        return $this->schedules()
                   ->with(['subject', 'teacher.user'])
                   ->where('academic_year', $academicYear)
                   ->where('semester', $semester)
                   ->where('is_active', true)
                   ->orderBy('day_of_week')
                   ->orderBy('start_time')
                   ->get();
    }

    /**
     * Obtenir tous les enseignants qui enseignent dans cette classe
     * (via les matières assignées ET les enseignants directement assignés)
     */
    public function getAllTeachers()
{
    $allTeachers = collect();
    
    // 1. Enseignants directement assignés à la classe
    if ($this->teachers && $this->teachers->count() > 0) {
        $allTeachers = $allTeachers->merge($this->teachers);
    }
    
    // 2. Enseignants via les matières assignées
    if ($this->subjects && $this->subjects->count() > 0) {
        foreach ($this->subjects as $subject) {
            // Enseignant principal de la matière
            if ($subject->teacher && !$allTeachers->contains('id', $subject->teacher->id)) {
                $allTeachers->push($subject->teacher);
            }
            
            // Enseignants additionnels de la matière
            if ($subject->teachers && $subject->teachers->count() > 0) {
                foreach ($subject->teachers as $additionalTeacher) {
                    if (!$allTeachers->contains('id', $additionalTeacher->id)) {
                        $allTeachers->push($additionalTeacher);
                    }
                }
            }
        }
    }
    
    return $allTeachers->unique('id');
}

    /**
     * Obtenir les matières enseignées par un enseignant spécifique dans cette classe
     */
    public function getSubjectsForTeacher($teacherId)
{
    if (!$this->subjects || $this->subjects->count() === 0) {
        return collect();
    }

    return $this->subjects->filter(function($subject) use ($teacherId) {
        return $subject->teacher_id === $teacherId || 
               ($subject->teachers && $subject->teachers->contains('id', $teacherId));
    });
}

    /**
     * Obtenir les enseignants qui enseignent une matière spécifique dans cette classe
     */
    public function getTeachersForSubject($subjectId)
{
    $subject = $this->subjects->where('id', $subjectId)->first();
    
    if (!$subject) {
        return collect();
    }

    $teachers = collect();
    
    // Enseignant principal de la matière
    if ($subject->teacher) {
        $teachers->push($subject->teacher);
    }
    
    // Enseignants additionnels
    if ($subject->teachers && $subject->teachers->count() > 0) {
        $teachers = $teachers->merge($subject->teachers);
    }
    
    return $teachers->unique('id');
}

    /**
     * Vérifier si un enseignant enseigne dans cette classe
     */
    public function hasTeacher($teacherId)
{
    // Vérifier s'il est directement assigné à la classe
    if ($this->teachers && $this->teachers->contains('id', $teacherId)) {
        return true;
    }
    
    // Vérifier s'il enseigne une matière de cette classe
    if ($this->subjects && $this->subjects->count() > 0) {
        foreach ($this->subjects as $subject) {
            if ($subject->teacher_id === $teacherId || 
                ($subject->teachers && $subject->teachers->contains('id', $teacherId))) {
                return true;
            }
        }
    }
    
    return false;
}

    /**
     * Obtenir le nombre total d'enseignants uniques dans cette classe
     */
    public function getTeachersCount()
    {
        return $this->getAllTeachers()->count();
    }
    /**
 * Obtenir un résumé des enseignants avec leur rôle
 */
public function getTeachersSummary()
{
    $summary = collect();
    $allTeachers = $this->getAllTeachers();
    
    foreach ($allTeachers as $teacher) {
        $roles = [];
        
        // Vérifier s'il est directement assigné
        if ($this->teachers && $this->teachers->contains('id', $teacher->id)) {
            $roles[] = 'Enseignant de classe';
        }
        
        // Vérifier les matières qu'il enseigne
        $subjects = $this->getSubjectsForTeacher($teacher->id);
        if ($subjects->count() > 0) {
            $roles[] = 'Matières: ' . $subjects->pluck('name')->join(', ');
        }
        
        $summary->push([
            'teacher' => $teacher,
            'roles' => $roles
        ]);
    }
    
    return $summary;
}
}