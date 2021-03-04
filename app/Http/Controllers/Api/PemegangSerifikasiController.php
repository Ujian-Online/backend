<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UjianAsesiAsesor;
use Illuminate\Http\Request;

class PemegangSerifikasiController extends Controller
{
    /**
     * List Pemegang Sertifikasi
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * * @OA\Get(
     *   path="/api/pemegang-sertifikasi",
     *   tags={"Sertifikasi"},
     *   summary="Pemegang Sertifikasi Lists",
     *
     *   @OA\Response(
     *      response="200",
     *      description="OK"
     *   )
     * )
     */
    public function index()
    {
        $query = UjianAsesiAsesor::select([
            'user_asesis.name as name',
            'ujian_asesi_asesors.order_id as nomor_registrasi',
            'ujian_asesi_asesors.ujian_start as tanggal_sertifikasi',
            'sertifikasis.title as sertifikasi_title',
            'sertifikasis.nomor_skema as sertifikasi_nomor_skema',
        ])
            ->join('users', 'users.id', '=', 'ujian_asesi_asesors.asesi_id')
            ->join('user_asesis', 'user_asesis.user_id', '=', 'ujian_asesi_asesors.asesi_id')
            ->join('sertifikasis', 'sertifikasis.id', '=', 'ujian_asesi_asesors.sertifikasi_id')
            ->whereNotNull('ujian_asesi_asesors.ujian_start')
            ->where('status', 'selesai');

        return datatables()
            ->eloquent($query)
            ->toJson();
    }
}
