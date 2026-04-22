<?php

namespace App\Policies;

use App\Models\SimulasiAngkaKredit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SimulasiAngkaKreditPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SimulasiAngkaKredit $simulasi): bool
    {
        return $user->id === $simulasi->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SimulasiAngkaKredit $simulasi): bool
    {
        return $user->id === $simulasi->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SimulasiAngkaKredit $simulasi): bool
    {
        return $user->id === $simulasi->user_id;
    }
}
