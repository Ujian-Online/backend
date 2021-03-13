<?php

namespace App\Http\Controllers\Api;

use App\AsesiSertifikasiUnitKompetensiElement;
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
        $unitkompetensis = AsesiUnitKompetensiDokumen::with([
                    'asesisertifikasiunitkompetensielement' => function ($query) use ($user) {
                        $query->where('asesi_id', $user->id);
                    },
                    'asesisertifikasiunitkompetensielement.media' => function ($query) use ($user) {
                        $query->where('asesi_id', $user->id);
                    }
                ])
                ->where('asesi_id', $user->id)
                ->where('sertifikasi_id', $id)
                ->get();

        return response()->json([
            'user' => $user,
            'sertifikasi' => $sertifikasi,
            'unitkompetensi' => $unitkompetensis,
        ], 200);
    }


    /**
     * Update APL02 Element
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *   path="/api/apl02",
     *   tags={"APL02"},
     *   summary="Update APL02 Unit Kompetensi Element",
     *   security={{"passport":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Update Unit Kompetensi Element",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                @OA\Property(
     *                     property="id",
     *                     description="ID Unit Kompetensi Element",
     *                     type="integer",
     *                     example="5"
     *                 ),
     *                 @OA\Property(
     *                     property="value",
     *                     description="File upload. Ekstensi: JPG/JPEG/PNG/PDF",
     *                     type="file",
     *                     example="cara_penerapan_xxx.pdf"
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK"
     *     )
     * )
     */
    public function updateElement(Request $request) {
        // validate input
        $request->validate([
            'id' => 'required',
            'value' => 'required|mimes:jpg,jpeg,png,pdf'
        ]);

        // get input id
        $id = $request->input('id');

        // get user login
        $user = $request->user();

        // run upload data
        $value = upload_to_s3($request->file('value'));

        // update data element
        $query = AsesiSertifikasiUnitKompetensiElement::where('id', $id)
            ->where('asesi_id', $user->id)
            ->firstOrFail();

        // update kalau ada datanya
        $query->media_url = $value;
        $query->save();

        // return response update data
        return response()->json($query);
    }
}
