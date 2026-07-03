<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk; // WAJIB DIIMPORT: Agar Laravel mengenali perintah Produk::create dan Produk::all
use Illuminate\Support\Facades\Storage; // Memproses penghapusan berkas biner di folder storage
use Barryvdh\DomPDF\Facade\Pdf; // Memproses pembuatan dokumen PDF

class ProdukController extends Controller
{
    // Method untuk menampilkan daftar produk halaman utama
    public function index()
    {
        $data_produk = Produk::all();
        return view('produk.index', compact('data_produk'));
    }

    // Method untuk menampilkan formulir tambah data
    public function create()
    {
        return view('produk.create');
    }

    // Method untuk memproses penyimpanan produk baru + Upload Gambar
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|min:3|max:50',
            'harga'       => 'required|numeric|min:1000',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi Gambar
        ]);

        $namaGambar = null;
        if ($request->hasFile('gambar')) {
            // Menyimpan file gambar asli ke folder storage/app/public/produk
            $path = $request->file('gambar')->store('produk', 'public');
            $namaGambar = basename($path);
        }

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'deskripsi'   => $request->deskripsi,
            'stok'        => $request->stok,
            'gambar'      => $namaGambar
        ]);

        return redirect('/produk')->with('sukses', 'Produk baru berhasil ditambahkan!');
    }

    // Method untuk menampilkan formulir edit data
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    // Method untuk memproses perubahan data produk + Ganti Gambar
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|min:3|max:50',
            'harga'       => 'required|numeric|min:1000',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $namaGambar = $produk->gambar;
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage jika sebelumnya sudah ada gambar
            if ($produk->gambar) {
                Storage::disk('public')->delete('produk/' . $produk->gambar);
            }
            $path = $request->file('gambar')->store('produk', 'public');
            $namaGambar = basename($path);
        }

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'deskripsi'   => $request->deskripsi,
            'stok'        => $request->stok,
            'gambar'      => $namaGambar
        ]);

        return redirect('/produk')->with('sukses', 'Data produk berhasil diperbarui!');
    }

    // Method untuk menghapus data produk beserta berkas gambarnya
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus file gambar fisik dari local storage sebelum record database dihapus
        if ($produk->gambar) {
            Storage::disk('public')->delete('produk/' . $produk->gambar);
        }

        $produk->delete();
        return redirect('/produk')->with('sukses', 'Produk berhasil dihapus!');
    }

    // Method untuk mencetak laporan ke dokumen PDF
    public function cetakPdf()
    {
        // Mengambil semua data produk dari database
        $produk = Produk::all();

        // Memuat file view HTML khusus untuk dicetak ke PDF
        $pdf = Pdf::loadView('produk.laporan_pdf', compact('produk'));

        // Menghasilkan file unduhan PDF ke browser
        return $pdf->download('laporan-daftar-produk.pdf');
    }
}
