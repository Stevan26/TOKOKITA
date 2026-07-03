@extends('layouts.app')
@section('title', 'Edit Produk') @section('content')
<div class="row mt-4">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark"> <h4 class="mb-0">Edit Produk</h4>
            </div>
            <div class="card-body">
                <form action="/produk/{{ $produk->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" class="form-control @error('nama_produk') is-invalid @enderror">
                        @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}" class="form-control @error('harga') is-invalid @enderror">
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}" class="form-control @error('stok') is-invalid @enderror">
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Foto/Gambar Produk</label>
                        <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror">
                        <div class="form-text text-muted">Format yang didukung: JPG, JPEG, PNG. Maksimal 2 MB. Kosongkan jika tidak ingin mengubah gambar.</div>

                        @if($produk->gambar)
                            <div class="mt-2">
                                <small class="text-muted">Gambar saat ini: <strong>{{ $produk->gambar }}</strong></small>
                            </div>
                        @endif

                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-warning">Perbarui Data</button>
                    <a href="/produk" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
