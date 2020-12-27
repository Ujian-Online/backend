<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Sertifikasi;

class SertifikasiController extends Controller
{
    /**
     * Menampilkan List Sertifikasi
     *
     * @return Sertifikasi[]|Collection
     */
    public function index()
    {
        return Sertifikasi::with('sertifikasituk')->get();
    }
}
