<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Http\UploadedFile; // WAJIB ADA

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1. Aturan hak akses admin yang sudah kamu buat
        Gate::define('kelola-produk', function (User $user) {
            return $user->role === 'admin';
        });

        // 2. Tambahkan Macro untuk Cloudinary agar tidak error lagi
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
