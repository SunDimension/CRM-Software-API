<?php

namespace App\Policies;

use App\Models\StudentDocument;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, StudentDocument $document)
    {
        return $user->id === $document->student->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, StudentDocument $document)
    {
        return $user->id === $document->student->user_id;
    }

    public function delete(User $user, StudentDocument $document)
    {
        return $user->id === $document->student->user_id;
    }
}