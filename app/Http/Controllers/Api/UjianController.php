<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UjianAsesiAsesor;
use Illuminate\Http\Request;

class UjianController extends Controller
{
    /**
     * Apply Middleware Verified in All Function
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @OA\Get(
     *   path="/api/ujian",
     *   tags={"Ujian"},
     *   summary="Jadwal Ujian Asesi",
     *   security={{"passport":{}}},
     *
     *   @OA\Response(
     *      response="200",
     *      description="OK"
     *   )
     * )
     */
    public function jadwal(Request $request)
    {
        // get user login
        $user = $request->user();

        // query to jadwal ujian
        return UjianAsesiAsesor::with([
            'userasesi',
            'userasesi.asesi',
            'sertifikasi',
            'ujianjadwal',
            'soalpaket'
        ])->where('asesi_id', $user->id)->paginate(10);
    }

    /**
     * Ujian Soal dan Jawaban
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     *
     * * @OA\Get(
     *   path="/api/ujian/{id}",
     *   tags={"Ujian"},
     *   summary="Detail Ujian Soal dan Jawaban By ID",
     *   @OA\Parameter(
     *      name="id",
     *      description="Ujian id",
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
    public function soal(Request $request, $id)
    {
        // get user login
        $user = $request->user();

        // Find Data by ID
        return UjianAsesiAsesor::with([
            'userasesi',
            'userasesi.asesi',
            'ujianjadwal',
            'sertifikasi',
            'soalpaket',
            'ujianasesijawaban',
        ])
            ->where('id', $id)
            ->where('asesi_id', $user->id)
            ->firstOrFail();
    }
}
