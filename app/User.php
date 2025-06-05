<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profile_picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function parent()
    {
        return $this->hasOne(Parents::class);
    }

    public function getPayments()
    {
        if ($this->hasRole('Parent') && $this->parent) {
            return $this->parent->payments();
        } elseif ($this->hasRole('Student') && $this->student) {
            return $this->student->payments();
        }
        return collect([]);
    }

    public function getTotalPendingPayments()
    {
        if ($this->hasRole('Parent') && $this->parent) {
            return $this->parent->getTotalPendingPayments();
        } elseif ($this->hasRole('Student') && $this->student) {
            return $this->student->getTotalPendingPayments();
        }
        return 0;
    }

    public function hasOverduePayments()
    {
        if ($this->hasRole('Parent') && $this->parent) {
            return $this->parent->getOverduePaymentsCount() > 0;
        } elseif ($this->hasRole('Student') && $this->student) {
            return $this->student->getOverduePaymentsCount() > 0;
        }
        return false;
    }
}
