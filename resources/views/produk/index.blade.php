@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')
@section('title', 'Daftar Produk')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
        <h1 class="h3 mb-0">Daftar Produk Tersedia</h1>

        @can('kelola-produk')
            <a href="/produk/create" class="btn btn-primary">Tambah Produk Baru</a>
            <a href="/produk/cetak-pdf" class="btn btn-danger">Ekspor PDF</a>
        @endcan
    </div>

    <div class="row">
        @foreach ($data_produk as $item)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        @if ($item->gambar)
                            @if (Str::startsWith($item->gambar, ['http://', 'https://']))
                                <img src="{{ $item->gambar }}" class="card-img-top mb-3" alt="Foto Produk"
                                    style="height: 200px; object-fit: cover;">
                            @else
                                <img src="{{ asset('storage/produk/' . $item->gambar) }}" class="card-img-top mb-3"
                                    alt="Foto Produk" style="height: 200px; object-fit: cover;">
                            @endif
                        @else
                            <img src="https://placehold.co/600x400?text=No+Image" class="card-img-top mb-3" alt="No Image"
                                style="height: 200px; object-fit: cover;">
                        @endif
                        <h5 class="card-title fw-bold">{{ $item->nama_produk }}</h5>
                        <h6 class="card-subtitle mb-3 text-primary">Rp {{ number_format($item->harga, 0, ',', '.') }}</h6>
                        <p class="card-text text-muted">{{ $item->deskripsi }}</p>

                        @if ($item->stok > 0)
                            <p class="card-text text-success mb-2 fw-semibold">Stok: {{ $item->stok }} Tersedia</p>
                        @else
                            <p class="card-text text-danger mb-2 fw-semibold">Stok Habis</p>
                        @endif

                        @can('kelola-produk')
                            <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                                <a href="/produk/{{ $item->id }}/edit"
                                    class="btn btn-sm btn-outline-warning w-50 me-2">Edit</a>

                                <form action="/produk/{{ $item->id }}" method="POST" class="w-50"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">Hapus</button>
                                </form>
                            </div>
                        @endcan

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
