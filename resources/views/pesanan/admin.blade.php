@extends('layouts.app')
@section('title', 'Manajemen Pesanan')

@section('content')
<div class="mt-4">
    <h2 class="mb-4">Manajemen Pesanan Pelanggan</h2>
    <div class="card shadow-sm">
        <div class="card-body p-0 table-responsive">
            <table class="table table-bordered table-hover mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID / Waktu</th>
                        <th>Nama Pelanggan</th>
                        <th>Rincian Pesanan</th>
                        <th>Total Tagihan</th>
                        <th>Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pesanan as $item)
                    <tr>
                        <td>
                            <strong>#ORD-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</strong><br>
                            <small class="text-muted">{{ $item->created_at->format('d M Y H:i') }}</small>
                        </td>
                        <td>{{ $item->user->name }}</td>
                        <td>
                            <div class="text-capitalize fw-bold">{{ str_replace('_' , ' ', $item->paket) }} ({{ $item->jumlah_sepatu }} Pasang)</div>
                            @if($item->layanan_tambahan)
                                <small class="text-muted">+ {{ implode(', ', $item->layanan_tambahan) }}</small>
                            @endif
                        </td>
                        <td class="fw-bold text-success">Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</td>
                        <td style="width: 250px;">
                            <form action="/admin/pesanan/{{ $item->id }}" method="POST" class="d-flex">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm me-2">
                                    <option value="Menunggu Pembayaran" {{ $item->status == 'Menunggu Pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                    <option value="Sedang Dicuci" {{ $item->status == 'Sedang Dicuci' ? 'selected' : '' }}>Sedang Dicuci</option>
                                    <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada pesanan masuk di sistem.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
