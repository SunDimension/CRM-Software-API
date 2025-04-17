<?php

namespace App\Policies;

use App\Models\StudentEmergencyContact;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmergencyContactPolicy
{
    use HandlesAuthorization;

    public function view(User $user, StudentEmergencyContact $emergencyContact)
    {
        return $user->id === $emergencyContact->student->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, StudentEmergencyContact $emergencyContact)
    {
        return $user->id === $emergencyContact->student->user_id;
    }

    public function delete(User $user, StudentEmergencyContact $emergencyContact)
    {
        return $user->id === $emergencyContact->student->user_id;
    }
}