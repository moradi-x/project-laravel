<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        //
    }

    
    public function boot(): void
    {
      Gate::define('admin',fn(User $user) => $user->isAdmin() );
      Gate::define('user',fn(User $user) => $user->isUser() );
    }
}
