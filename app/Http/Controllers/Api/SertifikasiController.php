<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Sertifikasi;

class SertifikasiController extends Controller
{
    /**
     * Menampilkan List Sertifikasi
     *
     * @return JsonResponse
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
        $query = Sertifikasi::with(
            [
                'sertifikasituk',
                'sertifikasituk.tuk',
                'unitkompentensi'
            ]
        )->where('is_active', 1);

        return datatables()
            ->eloquent($query)
            ->toJson();
    }
}
