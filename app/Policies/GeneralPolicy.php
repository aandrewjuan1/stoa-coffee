<?php

namespace App\Policies;

use App\Models\User;

class GeneralPolicy
{
    public function admin(User $user)
    {
        return $user->is_admin;
    }
}
