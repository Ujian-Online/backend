<?php

namespace App\Http\Controllers\Api;

use App\AsesiSertifikasiUnitKompetensiElement;
use App\AsesiSUKElementMedia;
use App\AsesiUnitKompetensiDokumen;
use App\AsesiUnitKompetensiDokumenVerification;
use App\Http\Controllers\Controller;
use App\Mail\AsesorAPL02Notification;
use App\Sertifikasi;
use App\UjianAsesiAsesor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
            ->groupBy('asesi_id', 'sertifikasi_id')
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
     *                     property="sertifikasi_id",
     *                     description="Sertifikasi ID",
     *                     type="integer",
     *                     example="1"
     *                 ),
     *                @OA\Property(
     *                     property="element_id",
     *                     description="ID Unit Kompetensi Element",
     *                     type="integer",
     *                     example="5"
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     description="Informasikan apakah data yang di input itu baru atau perubahan, jika update maka harus input media_id, jika baru tidak perlu.! Input Type: 'new' or 'update'.",
     *                     type="string",
     *                     example="new"
     *                 ),
     *                @OA\Property(
     *                     property="media_id",
     *                     description="ID Media digunakan jika type update!",
     *                     type="integer",
     *                     example="5"
     *                 ),
     *                @OA\Property(
     *                     property="description",
     *                     description="Deskripsi File Upload, Digunakan untuk type: new/update",
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
    public function updateElement(Request $request)
    {
        // validate input
        $request->validate([
            'sertifikasi_id' => 'required',
            'element_id'    => 'required',
            'type'          => 'required|in:new,update',
            'media_id'      => 'required_if:type,update',
            'description'   => 'required',
            'value'         => 'required_if:type,new|mimes:jpg,jpeg,png,pdf'
        ]);

        // get user login
        $user = $request->user();

        try {
            // check type input
            // create if new
            // update just update media url
            $type = $request->input('type');

            // get sertifikasi id
            $sertifikasi_id = $request->input('sertifikasi_id');
            // get element id
            $element_id = $request->input('element_id');
            // get description
            $description = $request->input('description');

            // search element by user id first, if no elemtn, then will be fail
            AsesiSertifikasiUnitKompetensiElement::where('id', $element_id)
                ->where('asesi_id', $user->id)
                ->firstOrFail();

            // get ujian status
            $ujian = UjianAsesiAsesor::with('userasesor')
                        ->where('asesi_id', $user->id)
                        ->where('sertifikasi_id', $sertifikasi_id)
                        ->whereIn('status', [
                            'menunggu',
                            'paket_soal_assigned',
                        ])
                        ->firstOrFail();

            // only send email if asesor found
            if(isset($ujian->userasesor) and !empty($ujian->userasesor)) {
                // redis key
                $redisKey = 'notifasesor_id_' . $user->id . '_' . $ujian->userasesor->id . '_' . $sertifikasi_id;
                // if redis data not found, then set redis
                // and sending email to asesor
                if(redis_check($redisKey)) {
                    Mail::to($ujian->userasesor->email)->send(new AsesorAPL02Notification($user->id, $sertifikasi_id));
                }
            }

            // save if type new
            if ($type == 'new') {
                // upload file to s3
                $value = upload_to_s3($request->file('value'));

                $query = AsesiSUKElementMedia::create([
                    'asesi_id' => $user->id,
                    'asesi_suk_element_id' => $element_id,
                    'description' => $description,
                    'media_url' => $value,
                ]);

            // update if other than new
            } else {
                // get media id
                $media_id = $request->input('media_id');

                // search data by media id with asesi_id
                $query = AsesiSUKElementMedia::where('id', $media_id)
                    ->where('asesi_id', $user->id)
                    ->firstOrFail();

                // upload file to s3 if value not empty
                if ($request->file('value')) {
                    $value = upload_to_s3($request->file('value'));
                    $query->media_url = $value;
                }

                // update if found
                $query->description = $description;
                $query->save();
            }

            // update verification date
            $apl02_verification = AsesiUnitKompetensiDokumenVerification::where('user_id', $user->id)
                ->where('sertifikasi_id', $sertifikasi_id);

            // if verification not found, create new data
            // if found, update exiting data
            if($apl02_verification->count() === 0) {
                AsesiUnitKompetensiDokumenVerification::create([
                    'asesi_id' => $user->id,
                    'sertifikasi_id' => $sertifikasi_id,
                    'asesi_verification_date' => now()->toDateString()
                ]);
            } else {
                $apl02_verification->update([
                    'asesi_verification_date' => now()->toDateString()
                ]);
            }

            // return response update data
            return response()->json($query);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete Asesi Sertifikasi Unit Kompetensi Media Element
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * * @OA\Delete(
     *   path="/api/apl02/{id}",
     *   tags={"APL02"},
     *   summary="Delete APL02 Unit Kompetensi Element Media",
     *   @OA\Parameter(
     *      name="id",
     *      description="Media ID",
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
    public function deleteElement(Request $request, $id)
    {
        try {
            // get user login
            $user = $request->user();

            $query = AsesiSUKElementMedia::where('id', $id)
                ->where('asesi_id', $user->id)
                ->firstOrFail();

            // delete data
            $query->delete();

            // return response
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Send Email APL02
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *   path="/api/apl02/done",
     *   tags={"APL02"},
     *   summary="Send Email APL02",
     *   security={{"passport":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Send Email After Input APL02",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                @OA\Property(
     *                     property="sertifikasi_id",
     *                     description="Sertifikasi ID",
     *                     type="integer",
     *                     example="1"
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
    public function sendEmailApl02(Request $request)
    {
        // validate input
        $request->validate([
            'sertifikasi_id' => 'required',
        ]);

        // get user login
        $user = $request->user();

        try {
            // check type input
            // create if new
            // update just update media url
            $type = $request->input('type');

            // get sertifikasi id
            $sertifikasi_id = $request->input('sertifikasi_id');

            // get ujian status
            $ujian = UjianAsesiAsesor::with('userasesor')
                ->where('asesi_id', $user->id)
                ->where('sertifikasi_id', $sertifikasi_id)
                ->whereIn('status', [
                    'menunggu',
                    'paket_soal_assigned',
                ])
                ->firstOrFail();

            // only send email if asesor found
            if(isset($ujian->userasesor) and !empty($ujian->userasesor)) {
                // redis key
                $redisKey = 'notifasesor_id_' . $user->id . '_' . $ujian->userasesor->id . '_' . $sertifikasi_id;
                // if redis data not found, then set redis
                // and sending email to asesor
                if(redis_check($redisKey)) {
                    Mail::to($ujian->userasesor->email)->send(new AsesorAPL02Notification($user->id, $sertifikasi_id));
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
