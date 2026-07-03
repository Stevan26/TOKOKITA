<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdukResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_produk'   => $this->id,
            'nama'        => $this->nama_produk,
            'harga_pasar' => 'Rp ' . number_format($this->harga, 0, ',', '.'),
            'sisa_stok'   => $this->stok,
            'keterangan'  => $this->deskripsi ?? 'Tidak ada deskripsi produk.'
        ];
    }
}
