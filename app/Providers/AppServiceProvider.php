<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Mendefinisikan aturan hak kelola produk hanya untuk admin
        Gate::define('kelola-produk', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
