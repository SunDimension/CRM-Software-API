<?php


namespace App\Policies;

use App\Models\StudentEducationalQualification;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EducationalQualificationPolicy
{
    use HandlesAuthorization;

    public function view(User $user, StudentEducationalQualification $educationalQualification)
    {
        return $user->id === $educationalQualification->student->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, StudentEducationalQualification $educationalQualification)
    {
        return $user->id === $educationalQualification->student->user_id;
    }

    public function delete(User $user, StudentEducationalQualification $educationalQualification)
    {
        return $user->id === $educationalQualification->student->user_id;
    }
}