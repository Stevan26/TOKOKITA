@extends('layouts.app')
@section('title', 'Login Pengguna')

@section('content')
<div class="row mt-5">
    <div class="col-md-5 mx-auto">
        <div class="card shadow-sm border-primary">
            <div class="card-header bg-primary text-white text-center py-3">
                <h4 class="mb-0 fw-bold">Masuk ke Tokokita</h4>
            </div>
            <div class="card-body p-4">
                <form action="/login" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Kata Sandi (Password)</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Masuk Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection