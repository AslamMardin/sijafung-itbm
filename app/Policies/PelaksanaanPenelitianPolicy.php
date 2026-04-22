<?php

namespace App\Policies;

use App\Models\PelaksanaanPenelitian;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PelaksanaanPenelitianPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isDosen();
    }

    public function view(User $user, PelaksanaanPenelitian $penelitian): bool
    {
        return $user->id === $penelitian->user_id;
    }

    public function create(User $user): bool
    {
        return $user->isDosen();
    }

    public function update(User $user, PelaksanaanPenelitian $penelitian): bool
    {
        return $user->id === $penelitian->user_id;
    }

    public function delete(User $user, PelaksanaanPenelitian $penelitian): bool
    {
        return $user->id === $penelitian->user_id;
    }

    public function restore(User $user, PelaksanaanPenelitian $penelitian): bool
    {
        return false;
    }

    public function forceDelete(User $user, PelaksanaanPenelitian $penelitian): bool
    {
        return false;
    }
}
