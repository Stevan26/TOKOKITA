<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Cloudinary\Api\Upload\UploadApi; // MENGGUNAKAN SDK UTAMA CLOUDINARY SECARA LANGSUNG

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
            // Bypass Laravel Service Container dengan memanggil engine SDK Cloudinary langsung
            $response = (new UploadApi())->upload($request->file('gambar')->getRealPath(), [
                'folder' => 'produk'
            ]);
            $imageUrl = $response['secure_url']; // Mengambil URL https langsung dari respons array
        }

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'deskripsi'   => $request->deskripsi,
            'stok'        => $request->stok,
            'gambar'      => $imageUrl
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
            $response = (new UploadApi())->upload($request->file('gambar')->getRealPath(), [
                'folder' => 'produk'
            ]);
            $imageUrl = $response['secure_url'];
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
