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
     *
     * * @OA\Get(
     *   path="/api/sertifikasi",
     *   tags={"Sertifikasi"},
     *   summary="Sertifikasi Lists",
     *
     *   @OA\Response(
     *      response="200",
     *      description="OK"
     *   )
     * )
     */
    public function index()
    {
        return Sertifikasi::with('sertifikasituk')->get();
    }
}
