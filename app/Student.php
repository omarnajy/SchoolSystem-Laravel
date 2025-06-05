<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'parent_id',
        'class_id',
        'roll_number',
        'gender',
        'phone',
        'dateofbirth',
        'current_address',
        'permanent_address',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function parent() 
    {
        return $this->belongsTo(Parents::class);
    }

    public function class() 
    {
        return $this->belongsTo(Grade::class, 'class_id');
    }

    public function attendances() 
    {
        return $this->hasMany(Attendance::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_id');
    }

    public function getTotalPendingPayments()
    {
        return $this->payments()->where('status', 'pending')->sum('amount');
    }

    public function getTotalPaidPayments($year = null)
    {
        $query = $this->payments()->where('status', 'paid');
        if ($year) {
            $query->where('academic_year', $year);
        }
        return $query->sum('amount');
    }

    public function getOverduePaymentsCount()
    {
        return $this->payments()->where('status', 'pending')
                                ->where('due_date', '<', now())
                                ->count();
    }
}
