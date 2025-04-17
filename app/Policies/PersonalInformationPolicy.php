<?php

namespace App\Policies;

use App\Models\StudentPersonalInformation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PersonalInformationPolicy
{
    use HandlesAuthorization;

    public function view(User $user, StudentPersonalInformation $personalInformation)
    {
        return $user->id === $personalInformation->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, StudentPersonalInformation $personalInformation)
    {
        return $user->id === $personalInformation->user_id;
    }

    public function delete(User $user, StudentPersonalInformation $personalInformation)
    {
        return $user->id === $personalInformation->user_id;
    }
}