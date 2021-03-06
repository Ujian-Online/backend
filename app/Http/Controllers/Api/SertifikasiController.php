<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
                'sertifikasiunitkompentensi',
                'sertifikasiunitkompentensi.unitkompetensi'
            ]
        )->where('is_active', 1);

        return datatables()
            ->eloquent($query)
            ->toJson();
    }

    /**
     * Menampilkan List Sertifikasi
     *
     * @param $id
     *
     * @return Sertifikasi[]|Builder|Collection|Model
     *
     * * @OA\Get(
     *   path="/api/sertifikasi/{id}",
     *   tags={"Sertifikasi"},
     *   summary="Sertifikasi Detail By ID",
     *   @OA\Parameter(
     *      name="id",
     *      description="Sertifikasi id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *   ),
     *   @OA\Response(
     *      response="200",
     *      description="OK"
     *   )
     * )
     */
    public function show($id)
    {
        return Sertifikasi::with(
            [
                'sertifikasituk',
                'sertifikasituk.tuk',
                'sertifikasiunitkompentensi',
                'sertifikasiunitkompentensi.unitkompetensi'
            ]
        )
            ->where('id', $id)
            ->where('is_active', 1)
            ->firstOrFail();
    }
}
