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
        'occupation',
        'emergency_contact'
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

     /**
     * Obtenir l'emploi du temps de tous les enfants
     */
    public function getChildrenSchedules($academicYear = null, $semester = null)
    {
        $schedules = collect([]);
        
        foreach ($this->children as $child) {
            $childSchedules = $child->getSchedules($academicYear, $semester);
            $schedules = $schedules->merge($childSchedules);
        }

        return $schedules->groupBy('class_id');
    }

    // Créer automatiquement un parent avec l'utilisateur
    public static function createWithUser($userData, $parentData = [])
    {
        try {
            \DB::beginTransaction();

            // Créer l'utilisateur
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => \Hash::make($userData['password'] ?? 'password123'),
                'profile_picture' => 'avatar.png'
            ]);

            // Créer le profil parent
            $parent = $user->parent()->create([
                'phone' => $parentData['phone'] ?? '+212600000000',
                'address' => $parentData['address'] ?? 'Adresse non renseignée',
                'occupation' => $parentData['occupation'] ?? '',
                'emergency_contact' => $parentData['emergency_contact'] ?? ''
            ]);

            // Assigner le rôle
            $user->assignRole('Parent');

            \DB::commit();
            return $parent;

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

}
