<?php

namespace App\Http\Controllers\Api;

use App\AsesiCustomData;
use App\Http\Controllers\Controller;
use App\Jobs\APL01AdminNotification;
use App\UserAsesi;
use App\UserAsesiCustomData;
use Illuminate\Http\Request;

class Apl01Controller extends Controller
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
     *   path="/api/apl01",
     *   tags={"APL01"},
     *   summary="Asesi APL01 Data",
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

        // get data APL01
        $asesi = UserAsesi::with('user')
                ->where('user_id', $user->id)
                ->firstOrFail();

        // get data asesi custom data
        $asesicustomdata = UserAsesiCustomData::select([
            'user_asesi_custom_data.*',
            'asesi_custom_data.dropdown_option as dropdown_option'
        ])
            ->leftJoin('asesi_custom_data', 'asesi_custom_data.title', '=', 'user_asesi_custom_data.title')
            ->where('user_asesi_custom_data.asesi_id', $user->id)
            ->get();

        // get only title in asesi custom data
        $asesiCDTitle = null;
        $resultAsesiCustomData = null;
        foreach($asesicustomdata as $acd) {
            // title only
            $asesiCDTitle[] = $acd->title;

            // merge status custom data
            $resultAsesiCustomData[] = array_merge($acd->toArray(), ['type' => 'update']);
        }

        // get data custom data index
        if(!empty($asesiCDTitle)) {
            $customdata = AsesiCustomData::whereNotIn('title', $asesiCDTitle)->get();
        } else {
            $customdata = AsesiCustomData::all();
        }

        if($customdata->count() == 0) {
            // return response
            return response()->json([
                'data' => $asesi,
                'customdata' => $resultAsesiCustomData,
            ], 200);
        }

        // set index custom data
        $resultCustomData = null;
        foreach($customdata as $cd) {
            $resultCustomData[] = array_merge($cd->toArray(), ['type' => 'new']);
        }

        // return response
        return response()->json([
            'data' => $asesi,
            'customdata' => (!empty($resultAsesiCustomData) and !empty($resultCustomData)) ? array_merge($resultAsesiCustomData, $resultCustomData) : $resultCustomData,
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *   path="/api/apl01",
     *   tags={"APL01"},
     *   summary="Update APL01 Data",
     *   security={{"passport":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Update APL01 Data",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     description="Nama Lengkap",
     *                     type="string",
     *                     example="john doe"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     description="Alamat Lengkap",
     *                     type="string",
     *                     example="Jl. Ahmad Yani No. 1 RT 1 RW 2, Dukuh Menanggal, Surabaya, Jawa Timur"
     *                 ),
     *                 @OA\Property(
     *                     property="phone_number",
     *                     description="Nomor Telpon",
     *                     type="string",
     *                     example="081212341234"
     *                 ),
     *                 @OA\Property(
     *                     property="gender",
     *                     description="Jenis Kelamin: pria/wanita",
     *                     type="string",
     *                     example="pria"
     *                 ),
     *                 @OA\Property(
     *                     property="birth_place",
     *                     description="Tempat Lahir",
     *                     type="string",
     *                     example="Surabaya"
     *                 ),
     *                 @OA\Property(
     *                     property="birth_date",
     *                     description="Tanggal Lahir, Date Format: Y-m-d",
     *                     type="date",
     *                     example="2020-01-01"
     *                 ),
     *                 @OA\Property(
     *                     property="no_ktp",
     *                     description="Nomor KTP, Example: 1234567890123456",
     *                     type="string",
     *                     example="1234567890123456"
     *                 ),
     *                 @OA\Property(
     *                     property="pendidikan_terakhir",
     *                     description="Pendidikan Terakhir: SMA/SMK/D1/D2/D3/D4/S1/S2/S3",
     *                     type="string",
     *                     example="SMA"
     *                 ),
     *                 @OA\Property(
     *                     property="has_job",
     *                     description="Apakah memiliki pekerjaan?, Example: true = bekerja, false = tidak bekerja",
     *                     type="boolean",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="job_title",
     *                     description="Jenis/Pangkat Pekerjaan",
     *                     type="string",
     *                     example="Teknisi"
     *                 ),
     *                 @OA\Property(
     *                     property="job_address",
     *                     description="Alamat Pekerjaan",
     *                     type="string",
     *                     example="Jl. Raya Darmo, Surabaya, Jawa Timur"
     *                 ),
     *                 @OA\Property(
     *                     property="company_name",
     *                     description="Nama Perusahaan",
     *                     type="string",
     *                     example="IT Tech"
     *                 ),
     *                 @OA\Property(
     *                     property="company_phone",
     *                     description="Nomor Telpon Perusahaan",
     *                     type="string",
     *                     example="02112341234"
     *                 ),
     *                 @OA\Property(
     *                     property="company_email",
     *                     description="Email Perusahaan",
     *                     type="string",
     *                     example="company@test.com"
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
    public function store(Request $request)
    {
        // validate input
        $request->validate([
            'name'                  => 'required|min:3|max:255',
            'address'               => 'required|min:3|max:255',
            'phone_number'          => 'required|numeric',
            'gender'                => 'required|in:pria,wanita',
            'birth_place'           => 'required|min:3|max:225',
            'birth_date'            => 'required|date',
            'no_ktp'                => 'required|digits:16',
            'pendidikan_terakhir'   => 'required|in:' . implode(',', config('options.user_assesi_pendidikan_terakhir')),
            'has_job'               => 'required|boolean',
        ]);

        // get form data
        $dataInput = $request->only([
            'name',
            'address',
            'phone_number',
            'gender',
            'birth_place',
            'birth_date',
            'no_ktp',
            'pendidikan_terakhir',
            'has_job',
            'job_title',
            'job_address',
            'company_name',
            'company_phone',
            'company_email',
        ]);

        // get user login
        $user = $request->user();

        // update gender to boolean
        $dataInput['gender'] = $dataInput['gender'] == 'pria';

        // inject user id based on user login
        $dataInput['user_id'] = $user->id;

        // check if data found or not
        $queryData = UserAsesi::where('user_id', $user->id)->first();

        // kalau data ada, maka update
        if($queryData) {
            $queryData->update($dataInput);
        } else {
            // verified set to false if new data
            $dataInput['is_verified'] = false;

            // kalau ga ada, buat baru
            $queryData = UserAsesi::create($dataInput);
        }

        // set redis key
        $redisKey = 'notif_apl01_id' . $user->id;
        if(redis_check($redisKey)) {
            // Kirim Email ke Admin
            APL01AdminNotification::dispatch($user->id);
        }

        // return json response
        return response()->json($queryData);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *   path="/api/apl01/customdata",
     *   tags={"APL01"},
     *   summary="Update APL01 Custom Data",
     *   security={{"passport":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Update Custom Data",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="customdataid",
     *                     description="Custom Data ID dari Index Custom Data dari API: GET /api/apl01 object customdata",
     *                     type="integer",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     description="Informasikan apakah data yang di input itu baru atau perubahan, cek di index array type.! Input Type: 'new' or 'update'.",
     *                     type="string",
     *                     example="new"
     *                 ),
     *                 @OA\Property(
     *                     property="value",
     *                     description="Value ini berbeda-beda inputannya,
     *                         tergantung dari custom data, jika file upload, maka berupa file ekstensi: JPG/JPEG/PNG/PDF,
     *                          jika dropdown maka sesuai value dari dropdown_option, jika text, maka text biasa.",
     *                     type="file",
     *                     example="scan_ijazah.pdf"
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
    public function customdata(Request $request)
    {
        // get user login
        $user = $request->user();

        // before save custom data, asesi need fill all apl01 first
        $apl01 = UserAsesi::where('user_id', $user->id)->first();

        // return error klo APL01 blm lengkap
        if(!$apl01) {
            return response()->json([
                'message' => 'Gagal update custom data, karena APL-01 belum lengkap.!'
            ], 403);
        }

        // get custom data id before validate
        $customdataid = $request->input('customdataid');
        // get input type
        $type = $request->input('type');
        if(empty($type)) {
            return response()->json([
                'message' => 'Set form type sebelum mengupdate atau menyimpan data baru'
            ], 403);
        }

        // check index custom data
        $customdata = null;
        if($type == 'new') {
            $customdata = AsesiCustomData::findOrFail($customdataid);
        } else {
            $customdata = UserAsesiCustomData::select([
                'user_asesi_custom_data.*',
                'asesi_custom_data.dropdown_option as dropdown_option'
            ])
                ->leftJoin('asesi_custom_data', 'asesi_custom_data.title', '=', 'user_asesi_custom_data.title')
                ->where('user_asesi_custom_data.id', $customdataid)
                ->where('user_asesi_custom_data.asesi_id', $user->id)
                ->firstOrFail();
        }

        // variable for save value
        $value = $request->input('value');

        // request validate based on input type
        if($customdata->input_type == 'upload_image') {
            $request->validate([
                'customdataid'  => 'required',
                'type'          => 'required|in:new,update',
                'value'         => 'required|mimes:jpg,jpeg,png'
            ]);

            // run upload data
            $value = upload_to_s3($request->file('value'));
        } else if($customdata->input_type == 'upload_pdf') {
            $request->validate([
                'customdataid'  => 'required',
                'type'          => 'required|in:new,update',
                'value'         => 'required|mimes:pdf'
            ]);

            // run upload data
            $value = upload_to_s3($request->file('value'));
        } else if($customdata->input_type == 'dropdown') {
            $request->validate([
                'customdataid'  => 'required',
                'type'          => 'required|in:new,update',
                'value'         => 'required|in:' . $customdata->dropdown_option
            ]);
        }

        // set redis key
        $redisKey = 'notif_apl01_id' . $user->id;

        // update jika ada customdata
        if($type == 'update') {
            $customdata->value = $value;
            $customdata->save();

            if(redis_check($redisKey)) {
                // Kirim Email ke Admin
                APL01AdminNotification::dispatch($user->id, $customdata->id);
            }
        } else {
            // buat baru jika tidak ada customdata
            $save = UserAsesiCustomData::create([
                'asesi_id' => $user->id,
                'title' => $customdata->title,
                'input_type' => $customdata->input_type,
                'value' => $value,
                'is_verified' => false,
            ]);

            if(redis_check($redisKey)) {
                // Kirim Email ke Admin
                APL01AdminNotification::dispatch($user->id, $save->id);
            }
        }

        return response()->json([
            'code' => 200,
            'message' => 'success'
        ], 200);
    }
}
