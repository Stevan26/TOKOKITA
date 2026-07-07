<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use CloudinaryLabs\CloudinaryLaravel\CloudinaryServiceProvider; // Import ini

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Daftarkan Cloudinary Service ke dalam Container Laravel
        $this->app->register(CloudinaryServiceProvider::class);
    }

    public function boot(): void
    {
        Gate::define('kelola-produk', function (User $user) {
            return $user->role === 'admin';
        });

        // Tetap pertahankan macro ini
        if (!UploadedFile::hasMacro('storeOnCloudinary')) {
            UploadedFile::macro('storeOnCloudinary', function ($folder = null, $publicId = null) {
                return app('cloudinary')->upload($this->getRealPath(), [
                    'folder' => $folder,
                    'public_id' => $publicId,
                ]);
            });
        }
    }
}
