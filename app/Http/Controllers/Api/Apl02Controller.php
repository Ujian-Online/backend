<?php

namespace App\Http\Controllers\Api;

use App\AsesiUnitKompetensiDokumen;
use App\Http\Controllers\Controller;
use App\Sertifikasi;
use App\User;
use Illuminate\Http\Request;

class Apl02Controller extends Controller
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
     *   path="/api/apl02",
     *   tags={"APL02"},
     *   summary="Asesi APL02 Index Data",
     *   security={{"passport":{}}},
     *
     *   @OA\Response(
     *      response="200",
     *      description="OK"
     *   )
     * )
     */
    public function index(Request $request)
    {
        // get user login
        $user = $request->user();

        // query data
        return AsesiUnitKompetensiDokumen::with(['user', 'user.asesi', 'sertifikasi'])
            ->select(['asesi_id', 'sertifikasi_id'])
            ->where('asesi_id', $user->id)
            ->groupBy( 'asesi_id', 'sertifikasi_id')
            ->paginate(10);
    }


    /**
     * Menampilkan List Sertifikasi
     *
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * * @OA\Get(
     *   path="/api/apl02/{id}",
     *   tags={"APL02"},
     *   summary="APL02 Detail By ID",
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
    public function show(Request $request, $id)
    {
        // get user login
        $user = $request->user();
        // get user asesi detail
        $user = User::with('asesi')->findOrFail($user->id);
        // get sertifikasi detail
        $sertifikasi = Sertifikasi::findOrFail($id);
        // get UK Dokumen and Element
        $unitkompetensis = AsesiUnitKompetensiDokumen::with('asesisertifikasiunitkompetensielement')
                ->where('asesi_id', $user->id)
                ->where('sertifikasi_id', $id)
                ->get();

        return response()->json([
            'user' => $user,
            'sertifikasi' => $sertifikasi,
            'unitkompetensi' => $unitkompetensis,
        ], 200);
    }
}
