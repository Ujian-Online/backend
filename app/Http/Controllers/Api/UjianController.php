<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AsesorUjianSelesai;
use App\UjianAsesiAsesor;
use App\UjianAsesiJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
     *   security={{"passport":{}}},
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

        // get ujian soal kalau dan tampilkan berdasarkan status ujian
        $query = UjianAsesiAsesor::where('id', $id)
            ->where('asesi_id', $user->id)
            ->firstOrFail();

        // hide jawaban kalau status bukan selesai
        if($query->status != 'selesai') {
            return UjianAsesiAsesor::with([
                'userasesi',
                'userasesi.asesi',
                'ujianjadwal',
                'sertifikasi',
                'soalpaket',
                'ujianasesijawaban' => function($query) {
                    $query->select([
                        'id',
                        'ujian_asesi_asesor_id',
                        'soal_id',
                        'asesi_id',
                        'question',
                        'question_type',
                        'options_label',
                        'urutan',
                        'user_answer',
                    ]);
                },
            ])
                ->where('id', $id)
                ->where('asesi_id', $user->id)
                ->firstOrFail();
        } else {
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

    /**
     * Asesi Menjawab Pertanyaan
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     *
     *
     * @OA\Post(
     *   path="/api/ujian/jawaban",
     *   tags={"Ujian"},
     *   summary="Menjawab Pertanyaan Dari Ujian",
     *   security={{"passport":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Menjawab Pertanyaan",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                @OA\Property(
     *                     property="id",
     *                     description="ID Pertanyaan",
     *                     type="integer",
     *                     example="5"
     *                 ),
     *                 @OA\Property(
     *                     property="answer",
     *                     description="Jawaban Pertanyaan, Bisa untuk multiple_option atau essay",
     *                     type="string",
     *                     example="C"
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
    public function jawaban(Request $request)
    {
        // validate input
        $request->validate([
            'id' => 'required',
            'answer' => 'required'
        ]);

        // get user login
        $user = $request->user();

        // get input
        $id = $request->input('id');
        $answer = $request->input('answer');

        // search jawaban data
        $query = UjianAsesiJawaban::where('id', $id)
            ->select([
                'id',
                'ujian_asesi_asesor_id',
                'soal_id',
                'asesi_id',
                'question',
                'question_type',
                'options_label',
                'urutan',
                'user_answer',
            ])
            ->where('asesi_id', $user->id)
            ->firstOrFail();

        // update jawaban berdasarkan multiple options
        $query->user_answer = $answer;
        $query->save();

        // return save data
        return response()->json($query);
    }

    /**
     * Start Ujian Count
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * * @OA\Post(
     *   path="/api/ujian/{id}/start",
     *   tags={"Ujian"},
     *   summary="Start Ujian DateTime",
     *   security={{"passport":{}}},
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
    public function start(Request $request, $id)
    {
        // get user login
        $user = $request->user();

        // search jawaban data
        $query = UjianAsesiAsesor::where('id', $id)->where('asesi_id', $user->id)->firstOrFail();

        if(empty($query->ujian_start)) {
            // update start time
            $query->ujian_start = now();
            $query->save();

            return response()->json([
                'code' => 200,
                'message' => 'success'
            ]);
        } else {
            return response()->json([
                'code' => 403,
                'message' => 'Gagal memulai ujian karena sudah dimulai sebelumnya..!'
            ], 403);
        }
    }

    /**
     * Bulk Save Jawaban
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *   path="/api/ujian/jawaban/bulksave",
     *   tags={"Ujian"},
     *   summary="Menjawab Pertanyaan Dari Ujian",
     *   security={{"passport":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Bulk Save Jawaban",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                @OA\Property(
     *                     property="ujian_id",
     *                     description="ID Ujian",
     *                     type="integer",
     *                     example="10"
     *                 ),
     *                @OA\Property(
     *                     property="ids",
     *                     description="ID Pertanyaan",
     *                     type="object",
     *                     example={2, 5}
     *                 ),
     *                @OA\Property(
     *                     property="answers",
     *                     description="Jawaban Pertanyaan",
     *                     type="object",
     *                     example={"2": "B", "5":"C"}
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
    public function bulkSave(Request $request)
    {
        // validate input
        $request->validate([
            'ujian_id'   => 'required',
            'ids'        => 'required|array',
            'answers'    => 'required|array'
        ]);

        // get user login
        $user = $request->user();

        // get all input
        $ujian_id = $request->input('ujian_id');
        $ids = $request->input('ids');
        $answers = $request->input('answers');

        // loop input based on id
        foreach($ids as $id) {
            $updateJawaban = UjianAsesiJawaban::where('id', $id)->where('asesi_id', $user->id)->firstOrFail();
            $updateJawaban->user_answer = (isset($answers[$id]) and !empty($answers[$id])) ? $answers[$id] : null;
            $updateJawaban->save();
        }

        // update ujian ke selesai
        $ujian = UjianAsesiAsesor::with('userasesor')
            ->where('id', $ujian_id)
            ->where('asesi_id', $user->id)
            ->firstOrFail();

        // update status ke selesai
        $ujian->status = 'selesai';

        // kirim email ke  asesor
        $asesorEmail = $ujian->userasesor->email;
        Mail::to($asesorEmail)->send(new AsesorUjianSelesai($ujian_id));

        // return response
        return response()->json([
            'code' => 200,
            'message' => 'success'
        ], 200);
    }
}
