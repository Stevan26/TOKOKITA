@extends('layouts.app')
@section('title', 'Buat Pesanan Laundry')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Form Pesanan Cuci Sepatu</h5>
            </div>
            <div class="card-body">
                <form action="/pesanan" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Paket Cuci</label>
                        <select name="paket" class="form-select" required>
                            <option value="">-- Pilih Paket --</option>
                            <option value="reguler">Reguler Wash (Rp 30.000/pasang)</option>
                            <option value="deep_clean">Deep Clean (Rp 50.000/pasang)</option>
                            <option value="premium">Premium Wash (Rp 100.000/pasang)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Sepatu (Pasang)</label>
                        <input type="number" name="jumlah_sepatu" class="form-control" value="1" min="1" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Layanan Tambahan (Opsional)</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="layanan_tambahan[]" value="repaint" id="repaint">
                            <label class="form-check-label" for="repaint">Ubah warna / Repaint (+ Rp 80.000)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="layanan_tambahan[]" value="wangi_premium" id="wangi">
                            <label class="form-check-label" for="wangi">Wangi Premium Eksklusif (+ Rp 10.000)</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-bold">Hitung & Buat Pesanan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
