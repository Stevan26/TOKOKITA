<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Resources\ProdukResource;

class ProdukApiController extends Controller
{
    public function index()
    {
        return ProdukResource::collection(Produk::all());
    }
}
