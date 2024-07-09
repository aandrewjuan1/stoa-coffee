<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GeneralPolicy
{
    public function admin(User $user)
    {
        return $user->is_admin;
    }

    public function baristaOrAdmin(User $user)
    {
        return $user->barista !== null || $user->is_admin;
    }

    public function buyer(User $user)
    {
        return $user->buyer !== null;
    }

    public function guest()
    {
        return Auth::guest();
    }
}
