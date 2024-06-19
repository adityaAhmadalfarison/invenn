<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Dosen;
use Illuminate\Auth\Access\HandlesAuthorization;

class DosenPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('view any dosen');
    }

    public function view(User $user, Dosen $dosen)
    {
        return $user->can('view dosen');
    }

    public function create(User $user)
    {
        return $user->can('create dosen');
    }

    public function update(User $user, Dosen $dosen)
    {
        return $user->can('update dosen');
    }

    public function delete(User $user, Dosen $dosen)
    {
        return $user->can('delete dosen');
    }

    public function restore(User $user, Dosen $dosen)
    {
        return $user->can('restore dosen');
    }

    public function forceDelete(User $user, Dosen $dosen)
    {
        return $user->can('force delete dosen');
    }
}
