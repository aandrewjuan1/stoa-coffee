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
    public function view(User $user)
    {
        return $user->role === User::ROLE_SELLER || 
               $user->role === User::ROLE_ADMIN || 
               $user->role === User::ROLE_BUYER;
    }
    
    /**
     * Determine if the given product can be created by the user.
     */
    public function create(User $user)
    {
        return $user->role === User::ROLE_SELLER || 
               $user->role === User::ROLE_ADMIN;
    }

    /**
     * Determine if the given product can be updated by the user.
     */
    public function update(User $user)
    {
        return $user->role === User::ROLE_SELLER || 
               $user->role === User::ROLE_ADMIN;
    }

    /**
     * Determine if the given product can be deleted by the user.
     */
    public function delete(User $user)
    {
        return $user->role === User::ROLE_SELLER || 
               $user->role === User::ROLE_ADMIN;
    }
}