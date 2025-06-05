<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    protected $table = 'parents';

    protected $fillable = [
        'user_id',
        'gender',
        'phone',
        'current_address',
        'permanent_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function children()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'parent_id');
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
