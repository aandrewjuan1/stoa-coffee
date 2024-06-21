<?php

namespace App\Providers;

use App\Models\Product;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

   class AuthServiceProvider extends ServiceProvider
   {
       /**
        * The policy mappings for the application.
        *
        * @var array
        */


       /**
        * Register any authentication / authorization services.
        */
       public function boot()
       {
           $this->registerPolicies();
       }
   }