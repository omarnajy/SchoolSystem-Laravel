<?php

namespace App\Policies;

use App\User;
use App\Schedule;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchedulePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any schedules.
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can view the schedule.
     */
    public function view(User $user, Schedule $schedule = null)
    {
        // Admin can view any schedule
        if ($user->hasRole('Admin')) {
            return true;
        }
        
        // Teacher can view their own schedules
        if ($user->hasRole('Teacher') && $user->teacher) {
            return $schedule ? $schedule->teacher_id == $user->teacher->id : true;
        }
        
        // Student can view their class schedule
        if ($user->hasRole('Student') && $user->student) {
            return $schedule ? $schedule->class_id == $user->student->class_id : true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can create schedules.
     */
    public function create(User $user)
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can update the schedule.
     */
    public function update(User $user, Schedule $schedule)
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can delete the schedule.
     */
    public function delete(User $user, Schedule $schedule)
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can restore the schedule.
     */
    public function restore(User $user, Schedule $schedule)
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can permanently delete the schedule.
     */
    public function forceDelete(User $user, Schedule $schedule)
    {
        return $user->hasRole('Admin');
    }
}