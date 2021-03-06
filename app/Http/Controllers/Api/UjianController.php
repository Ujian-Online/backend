<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AsesorUjianSelesai;
use App\UjianAsesiAsesor;
use App\UjianAsesiJawaban;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Exception;

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
     * @return \Illuminate\Http\JsonResponse
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
        $ujians = UjianAsesiAsesor::with([
            'userasesi',
            'userasesi.asesi',
            'sertifikasi',
            'ujianjadwal',
        ])->where('asesi_id', $user->id)->get();

        // variable result
        $result = [];

        // looping detail ujian
        foreach($ujians as $ujian) {
            // ambil detail apl02 status
            $apl02_status = apl02_status($user->id, $ujian->sertifikasi_id);
            // varaible ujian status
            $ujian_status = null;

            if(in_array($ujian->status,['paket_soal_assigned', 'menunggu']) and $apl02_status == 'menunggu_verifikasi') {
                $ujian_status = 'menunggu_verifikasi_form_apl02';
            } elseif(in_array($ujian->status,['paket_soal_assigned', 'menunggu']) and $apl02_status == 'form_terverifikasi') {
                $ujian_status = 'menunggu_jadwal_ujian';
            } elseif($ujian->status == 'penilaian') {
                $ujian_status = 'ujian_dalam_penilaian';
            } elseif($ujian->status == 'selesai') {
                if($ujian->is_kompeten) {
                    $ujian_status = 'kompeten';
                } else {
                    $ujian_status = 'tidak_kompeten';
                }
            } else {
                $ujian_status = '';
            }

            // merge data
            $result[] = array_merge($ujian->toArray(), compact('ujian_status', 'apl02_status'));
        }

        // return response
        return response()->json($result, 200);
    }

    /**
     * Detail Ujian
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     *  @OA\Get(
     *   path="/api/ujian/detail/{id}",
     *   tags={"Ujian"},
     *   summary="Detail Ujian By ID",
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
    public function detail(Request $request, $id)
    {
        // get user login
        $user = $request->user();

        $ujian = UjianAsesiAsesor::with([
                'userasesi',
                'userasesi.asesi',
                'ujianjadwal',
                'sertifikasi',
                'soalpaket',
            ])
            ->select([
                'ujian_asesi_asesors.*',
                'user_asesors.name as asesor_name'
            ])
            ->leftJoin('user_asesors', 'user_asesors.user_id', '=', 'ujian_asesi_asesors.asesor_id')
            ->where('ujian_asesi_asesors.id', $id)
            ->where('ujian_asesi_asesors.asesi_id', $user->id)
            ->firstOrFail();

        // count soal pilihan ganda dan essay
        $total_soal_essay = UjianAsesiJawaban::where('question_type', 'essay')
            ->where('ujian_asesi_asesor_id', $ujian->id)
            ->count();
        $total_soal_pilihanganda = UjianAsesiJawaban::where('question_type', 'multiple_option')
            ->where('ujian_asesi_asesor_id', $ujian->id)
            ->count();
        // total soal
        $total_soal = (int) $total_soal_essay + (int) $total_soal_pilihanganda;

        // apl02 detail
        $apl02_status = apl02_status($user->id, $ujian->sertifikasi_id);

        // merge array
        $result = array_merge($ujian->toArray(), compact(
            'apl02_status',
            'total_soal',
            'total_soal_essay',
            'total_soal_pilihanganda'
        ));

        // return response
        return response()->json($result, 200);
    }


    /**
     * Ujian Soal dan Jawaban
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     *
     * * @OA\Get(
     *   path="/api/ujian/soal/{id}",
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
        $query = UjianAsesiAsesor::with(['ujianjadwal'])->where('id', $id)
            ->where('asesi_id', $user->id)
            ->firstOrFail();

        try {

            // cek apakah ujian jadwal sudah bisa dimulai
            $jadwalujian = $query->ujianjadwal;
            $jadwalujian_date = $jadwalujian->tanggal;
            $jadwalujian_mulai = $jadwalujian->jam_mulai;
            $jadwalujian_berakhir = $jadwalujian->jam_berakhir;

            // ambil waktu sekarang
            $now = Carbon::now();
            $nowDate = $now->toDateString();
            $nowTime = $now->toTimeString();

            // cek tanggal ujian apakah hari ini atau besok
            if($nowDate > $jadwalujian_date) {
                throw new Exception('Ujian Telah Berakhir.!');
            } elseif($nowDate < $jadwalujian_date) {
                throw new Exception('Ujian Belum Di Mulai.!');
            }

            // cek jam apakah sudah bisa dimulai
            if($nowTime < $jadwalujian_mulai) {
                throw new Exception('Ujian Belum Bisa Di Mulai.!');
            } elseif ($nowTime > $jadwalujian_berakhir) {
                throw new Exception('Ujian Telah Berakhir.!');
            }

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

        } catch (Exception $e) {
            return response()->json([
                'code' => 403,
                'message' => $e->getMessage()
            ], 403);
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

        try {
            // search jawaban data
            $saveJawaban = UjianAsesiJawaban::where('id', $id)
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

            $query = UjianAsesiAsesor::with(['ujianjadwal', 'soalpaket'])
                ->where('id', $saveJawaban->ujian_asesi_asesor_id)
                ->where('asesi_id', $user->id)
                ->firstOrFail();

            // return error kalau menjawab pertanyaan dengan ujian_start kosong
            if(empty($query->ujian_start)) {
                throw new Exception('Ujian Belum Di Mulai, Klik Tombol Mulai untuk Memulai Ujian.!');
            }

            // cek apakah ujian jadwal sudah bisa dimulai
            $jadwalujian = $query->ujianjadwal;
            $jadwalujian_date = $jadwalujian->tanggal;

            // ambil waktu sekarang
            $now = Carbon::now();
            $nowDate = $now->toDateString();

            // cek tanggal ujian apakah hari ini atau besok
            if($nowDate > $jadwalujian_date) {
                throw new Exception('Ujian Telah Berakhir.!');
            } elseif($nowDate < $jadwalujian_date) {
                throw new Exception('Ujian Belum Di Mulai.!');
            }

            // get time duration and parse
            $durasiUjian = Carbon::parse($query->soalpaket->durasi_ujian);
            // format to minutes
            $durasiUjianMenit = ($durasiUjian->hour * 60) + $durasiUjian->minute;
            // ujian jam di mulai + add minutes durasi ujian
            $ujianJamDimulai = Carbon::parse($query->ujian_start)->addMinutes($durasiUjianMenit)->timestamp;
            // time now, timestamp
            $dateNowTimestamp = $now->timestamp;

            // cek jam apakah sudah bisa dimulai
            if($dateNowTimestamp >= $ujianJamDimulai) {
                throw new Exception('Waktu Ujian Telah Berakhir.!');
            }



            // update jawaban berdasarkan multiple options
            $saveJawaban->user_answer = $answer;
            $saveJawaban->save();

            // return save data
            return response()->json($saveJawaban);
        } catch (Exception $e) {
            return response()->json([
                'code' => 403,
                'message' => $e->getMessage()
            ], 403);
        }
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

        try {
            // get detail ujian
            $query = UjianAsesiAsesor::with(['ujianjadwal', 'soalpaket'])
                ->where('id', $id)
                ->where('asesi_id', $user->id)
                ->firstOrFail();

            // cek apakah ujian jadwal sudah bisa dimulai
            $jadwalujian = $query->ujianjadwal;
            $jadwalujian_date = $jadwalujian->tanggal;
            $jadwalujian_mulai = $jadwalujian->jam_mulai;
            $jadwalujian_berakhir = $jadwalujian->jam_berakhir;

            // ambil waktu sekarang
            $now = Carbon::now();
            $nowDate = $now->toDateString();
            $nowTime = $now->toTimeString();

            // cek tanggal ujian apakah hari ini atau besok
            if($nowDate > $jadwalujian_date) {
                throw new Exception('Ujian Telah Berakhir.!');
            } elseif($nowDate < $jadwalujian_date) {
                throw new Exception('Ujian Belum Di Mulai.!');
            }

            // cek jam apakah sudah bisa dimulai
            if($nowTime < $jadwalujian_mulai) {
                throw new Exception('Ujian Belum Bisa Di Mulai.!');
            } elseif ($nowTime > $jadwalujian_berakhir) {
                throw new Exception('Ujian Telah Berakhir.!');
            }

            // waktu sekarang
            $dateNow = now();

            if(empty($query->ujian_start)) {
                // update start time
                $query->ujian_start = $dateNow;
                $query->save();

                $ujian_start = $dateNow;
            } else {
                $ujian_start = $query->ujian_start;
            }

            // get time duration and parse
            $durasiUjian = Carbon::parse($query->soalpaket->durasi_ujian);
            // format to minutes
            $durasiUjianMenit = ($durasiUjian->hour * 60) + $durasiUjian->minute;
            // ujian jam di mulai + add minutes durasi ujian
            $ujianBerakhir = Carbon::parse($ujian_start)->addMinutes($durasiUjianMenit);

            // bandingkan waktu ujian dimulai dengan sekarang
            $diffMinutes = $dateNow->diffInMinutes($ujianBerakhir->toDateTimeString());

            // return response ok
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'data' => [
                    'tanggal_jam_sekarang' => $dateNow->toDateTimeString(),
                    'ujian_start' => $ujian_start,
                    'ujian_berakhir' => $ujianBerakhir->toDateTimeString(),
                    'ujian_sisa_menit' => $diffMinutes,
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'code' => 403,
                'message' => $e->getMessage()
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

        try {
            $query = UjianAsesiAsesor::with(['ujianjadwal', 'soalpaket'])
                ->where('id', $request->input('ujian_id'))
                ->where('asesi_id', $user->id)
                ->firstOrFail();

            // return error kalau menjawab pertanyaan dengan ujian_start kosong
            if(empty($query->ujian_start)) {
                throw new Exception('Ujian Belum Di Mulai, Klik Tombol Mulai untuk Memulai Ujian.!');
            }

            // cek apakah ujian jadwal sudah bisa dimulai
            $jadwalujian = $query->ujianjadwal;
            $jadwalujian_date = $jadwalujian->tanggal;

            // ambil waktu sekarang
            $now = Carbon::now();
            $nowDate = $now->toDateString();

            // cek tanggal ujian apakah hari ini atau besok
            if($nowDate > $jadwalujian_date) {
                throw new Exception('Ujian Telah Berakhir.!');
            } elseif($nowDate < $jadwalujian_date) {
                throw new Exception('Ujian Belum Di Mulai.!');
            }

            // get time duration and parse
            $durasiUjian = Carbon::parse($query->soalpaket->durasi_ujian);
            // format to minutes
            $durasiUjianMenit = ($durasiUjian->hour * 60) + $durasiUjian->minute;
            // ujian jam di mulai + add minutes durasi ujian
            $ujianJamDimulai = Carbon::parse($query->ujian_start)->addMinutes($durasiUjianMenit)->timestamp;
            // time now, timestamp
            $dateNowTimestamp = $now->timestamp;

            // cek jam apakah sudah bisa dimulai
            if($dateNowTimestamp >= $ujianJamDimulai) {
                throw new Exception('Waktu Ujian Telah Berakhir.!');
            }

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
        } catch (Exception $e) {
            return response()->json([
                'code' => 403,
                'message' => $e->getMessage()
            ], 403);
        }
    }

    /**
     * Finish Ujian
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * * @OA\Post(
     *   path="/api/ujian/{id}/finish",
     *   tags={"Ujian"},
     *   summary="Finish Status Ujian",
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
    public function finish(Request $request, $id)
    {
        // get user login
        $user = $request->user();

        try {
            // get detail ujian
            $query = UjianAsesiAsesor::where('id', $id)
                ->where('asesi_id', $user->id)
                ->firstOrFail();

            // only update if status paket_soal_assigned
            if($query->status == 'paket_soal_assigned') {
                $query->status = 'penilaian';
                $query->save();
            }

            // return response ok
            return response()->json([
                'code' => 200,
                'message' => 'success',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'code' => 403,
                'message' => $e->getMessage()
            ], 403);
        }
    }
}
