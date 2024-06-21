<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CartPolicy
{
    public function view(User $user)
    {
        return true;
    }
    
    /**
     * Determine if the given product can be created by the user.
     */
    public function add(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine if the given product can be updated by the user.
     */
    public function update(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine if the given product can be deleted by the user.
     */
    public function delete(User $user)
    {
        return $user->is_admin;
    }
}