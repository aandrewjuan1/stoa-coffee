<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine if the given product can be viewed by the user.
     */
    
    /**
     * Determine if the given product can be created by the user.
     */
    public function create(User $user)
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