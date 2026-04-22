<?php

namespace App\Policies;

use App\Models\PelaksanaanPengabdian;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PelaksanaanPengabdianPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isDosen();
    }

    public function view(User $user, PelaksanaanPengabdian $pengabdian): bool
    {
        return $user->id === $pengabdian->user_id;
    }

    public function create(User $user): bool
    {
        return $user->isDosen();
    }

    public function update(User $user, PelaksanaanPengabdian $pengabdian): bool
    {
        return $user->id === $pengabdian->user_id;
    }

    public function delete(User $user, PelaksanaanPengabdian $pengabdian): bool
    {
        return $user->id === $pengabdian->user_id;
    }

    public function restore(User $user, PelaksanaanPengabdian $pengabdian): bool
    {
        return false;
    }

    public function forceDelete(User $user, PelaksanaanPengabdian $pengabdian): bool
    {
        return false;
    }
}
