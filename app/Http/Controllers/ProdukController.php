<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary; // WAJIB TAMBAHKAN INI

class ProdukController extends Controller
{
    public function index()
    {
        $data_produk = Produk::all();
        return view('produk.index', compact('data_produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|min:3|max:50',
            'harga'       => 'required|numeric|min:1000',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageUrl = null;
        if ($request->hasFile('gambar')) {
            // Upload ke Cloudinary dan ambil URL permanennya
            $uploadedFile = $request->file('gambar')->storeOnCloudinary('produk');
            $imageUrl = $uploadedFile->getSecurePath();
        }

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'deskripsi'   => $request->deskripsi,
            'stok'        => $request->stok,
            'gambar'      => $imageUrl // Sekarang ini berisi link https://...
        ]);

        return redirect('/produk')->with('sukses', 'Produk baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|min:3|max:50',
            'harga'       => 'required|numeric|min:1000',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageUrl = $produk->gambar;
        if ($request->hasFile('gambar')) {
            // Karena menggunakan Cloudinary, kita tidak perlu menghapus file secara manual
            // kecuali jika ingin menghemat kuota Cloudinary
            $uploadedFile = $request->file('gambar')->storeOnCloudinary('produk');
            $imageUrl = $uploadedFile->getSecurePath();
        }

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'deskripsi'   => $request->deskripsi,
            'stok'        => $request->stok,
            'gambar'      => $imageUrl
        ]);

        return redirect('/produk')->with('sukses', 'Data produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus record dari database
        $produk->delete();

        return redirect('/produk')->with('sukses', 'Produk berhasil dihapus!');
    }

    public function cetakPdf()
    {
        $produk = Produk::all();
        $pdf = Pdf::loadView('produk.laporan_pdf', compact('produk'));
        return $pdf->download('laporan-daftar-produk.pdf');
    }
}
