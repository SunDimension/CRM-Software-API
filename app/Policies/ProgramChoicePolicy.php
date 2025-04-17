<?php

namespace App\Policies;

use App\Models\StudentProgramChoice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgramChoicePolicy
{
    use HandlesAuthorization;

    public function view(User $user, StudentProgramChoice $programChoice)
    {
        return $user->id === $programChoice->student->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, StudentProgramChoice $programChoice)
    {
        return $user->id === $programChoice->student->user_id;
    }

    public function delete(User $user, StudentProgramChoice $programChoice)
    {
        return $user->id === $programChoice->student->user_id;
    }
}