<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
        public function index() {
        return 'Daftar Mahasiswa';
    }

    public function show($id) {
        return 'Detail Mahasiswa: ' . $id;
    }

}
