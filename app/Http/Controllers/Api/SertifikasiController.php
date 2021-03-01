<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UjianAsesiAsesor;
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
                'unitkompentensi'
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
                'unitkompentensi'
            ]
        )
            ->where('id', $id)
            ->where('is_active', 1)
            ->firstOrFail();
    }

    /**
     * Pemegang Sertifikasi Index DataTables
     *
     * @param Request $request
     * @return JsonResponse
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
    public function pemegangSertifikasi(Request $request)
    {
        $query = UjianAsesiAsesor::select([
            'ujian_asesi_asesors.id as id',
            'user_asesis.name as name',
            'sertifikasis.title as sertifikasi'
        ])
            ->leftJoin('users', 'users.id', '=', 'ujian_asesi_asesors.asesi_id')
            ->leftJoin('user_asesis', 'user_asesis.user_id', '=', 'users.id')
            ->leftJoin('sertifikasis', 'sertifikasis.id', '=', 'ujian_asesi_asesors.sertifikasi_id');

        // return query datatables
        return datatables()->eloquent($query)->toJson();
    }
}
