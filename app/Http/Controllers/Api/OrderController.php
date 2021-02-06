<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
use App\Sertifikasi;
use App\SertifikasiTuk;
use App\TukBank;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Str;
use Storage;

class OrderController extends Controller
{
    /**
     * Order Index Function
     *
     * @param Request $request
     *
     * @return LengthAwarePaginator
     *
     * * @OA\Get(
     *   path="/api/order",
     *   tags={"Order"},
     *   summary="Order Index",
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

        // get order detail
        return Order::with('sertifikasi')
            ->leftjoin('user_asesis', 'user_asesis.id', '=', 'orders.asesi_id')
            ->leftjoin('users', 'users.id', '=', 'user_asesis.user_id')
            ->select('orders.*')
            ->where('users.id', $user->id)
            ->paginate(10);
    }



    /**
     * Create New Order
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *   path="/api/order",
     *   tags={"Order"},
     *   summary="Create New Order",
     *   security={{"passport":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Update Order Data",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="sertifikasi_id",
     *                     description="Sertifikasi ID",
     *                     type="number",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="tuk_id",
     *                     description="TUK ID",
     *                     type="number",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="tipe_sertifikasi",
     *                     description="Tipe Order, Example: baru/perpanjang",
     *                     type="string",
     *                     example="baru"
     *                 ),
     *                 @OA\Property(
     *                     property="training",
     *                     description="Order dengan Training",
     *                     type="boolean",
     *                     example="false"
     *                 ),
     *                 @OA\Property(
     *                     property="sertifikat_number_old",
     *                     description="Nomor Sertifikat Lama, Kirimkan value jika Tipe Order: perpanjang",
     *                     type="boolean",
     *                     example="123-123-123"
     *                 ),
     *                 @OA\Property(
     *                     property="sertifikat_date_old",
     *                     description="Tanggal Sertifikat Lama, Kirimkan value jika Tipe Order: perpanjang",
     *                     type="date",
     *                     example="2020-10-25"
     *                 ),
     *                 @OA\Property(
     *                     property="sertifikat_upload_old",
     *                     description="File Sertifikat Lama, Ekstensi: JPG, JPEG, PNG atau PDF",
     *                     type="file",
     *                     example="sertifikat_lama.pdf"
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
            'sertifikasi_id'        => 'required|numeric',
            'tuk_id'                => 'required|numeric',
            'tipe_sertifikasi'      => 'required|in:' . implode(',', config('options.orders_tipe_sertifikasi')),
            'training'              => 'required|boolean',
            'sertifikat_number_old' => 'nullable|required_if:tipe_sertifikasi,perpanjang',
            'sertifikat_date_old'   => 'nullable|required_if:tipe_sertifikasi,perpanjang|date',
            'sertifikat_upload_old' => 'nullable|required_if:tipe_sertifikasi,perpanjang|mimes:jpg,jpeg,png,pdf',
        ]);

        // get user login
        $user = $request->user();

        // tipe sertifikasi
        $tipeSertifikasi = $request->input('tipe_sertifikasi');
        $training = $request->input('training');

        // get input from array
        $getInput = $request->only([
            'sertifikasi_id',
            'tuk_id',
            'tipe_sertifikasi',
        ]);

        // add user id to input
        $getInput['asesi_id'] = $user->id;

        // array get input form based on selected
        if($tipeSertifikasi == 'perpanjang') {
            // update input value
            $getInput['sertifikat_number_old']  = $request->input('sertifikat_number_old');
            $getInput['sertifikat_date_old']    = $request->input('sertifikat_date_old');

            // get file upload
            $file = $request->file('sertifikat_upload_old');

            // generate uuid filename
            $fileextension = $file->extension();
            $filenewName   = (string) Str::uuid() . '.' . $fileextension;

            // folder path based on year/month
            $dateNow  = now();
            $filePath = '/' . $dateNow->year . '/' . $dateNow->month;

            // store file attachment to s3 with public access
            $filesave = Storage::disk('s3')->putFileAs(
                $filePath,
                $file,
                $filenewName,
                'public'
            );

            // build url to files
            $urlFile = Storage::disk('s3')->url($filesave);

            // update input value
            $getInput['sertifikat_media_url_old'] = $urlFile;
        }

        // get price by sertifikasi_id and tukid
        $sertifikasiTuk = SertifikasiTuk::with('sertifikasi')
            ->where('tuk_id', $getInput['tuk_id'])
            ->where('sertifikasi_id', $getInput['sertifikasi_id'])
            ->firstOrFail();


        // update input value price
        $getInput['original_price'] = ($tipeSertifikasi == 'baru') ? $sertifikasiTuk->sertifikasi->original_price_baru : $sertifikasiTuk->sertifikasi->original_price_perpanjang;
        $getInput['tuk_price'] = ($tipeSertifikasi == 'baru') ? $sertifikasiTuk->tuk_price_baru : $sertifikasiTuk->tuk_price_perpanjang;
        $getInput['tuk_price_training'] = $training ? $sertifikasiTuk->tuk_price_training : null;

        // update status and expired date
        $getInput['status'] = 'waiting_payment';
        $getInput['expired_date'] = now()->addDay();

        // save to database
        Order::create($getInput);

        // return response success
        return response()->json([
            'code' => 200,
            'message' => 'success'
        ], 200);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder
     *
     * @OA\Get(
     *   path="/api/order/{id}",
     *   tags={"Order"},
     *   summary="Order Detail by ID",
     *   security={{"passport":{}}},
     *
     *   @OA\Parameter(
     *      name="id",
     *      description="Order id",
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

        // get order detail by ID
        return Order::with(['sertifikasi', 'tuk', 'tuk.bank', 'asesi'])
            ->leftjoin('user_asesis', 'user_asesis.id', '=', 'orders.asesi_id')
            ->leftjoin('users', 'users.id', '=', 'user_asesis.user_id')
            ->select('orders.*')
            ->where('users.id', $user->id)
            ->where('orders.id', $id)
            ->firstOrFail();
    }

    /**
     * Update Order with Upload Bukti Transfer
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Put(
     *   path="/api/order/{id}",
     *   tags={"Order"},
     *   summary="Update Order by ID",
     *   security={{"passport":{}}},
     *
     *   @OA\Parameter(
     *      name="id",
     *      description="Order id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     *   ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Update Order Data",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="transfer_from_bank_name",
     *                     description="Transfer dari Bank (Nama Bank)",
     *                     type="string",
     *                     example="bri"
     *                 ),
     *                 @OA\Property(
     *                     property="transfer_from_bank_account",
     *                     description="Transfer dari Bank (Nama Akun Bank)",
     *                     type="string",
     *                     example="john doe"
     *                 ),
     *                 @OA\Property(
     *                     property="transfer_from_bank_number",
     *                     description="Transfer dari Bank (Nomor Akun Bank)",
     *                     type="string",
     *                     example="3322114456"
     *                 ),
     *                 @OA\Property(
     *                     property="bukti_transfer",
     *                     description="Bukti Transfer Ekstensi: JPG, JPEG, PNG atau PDF",
     *                     type="file",
     *                     example="bukti_transfer.pdf"
     *                 ),
     *                 @OA\Property(
     *                     property="bank_id",
     *                     description="TUK Bank ID Tujuan Transfer",
     *                     type="int",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="transfer_date",
     *                     description="Tanggal Transfer",
     *                     type="date",
     *                     example="2020-10-31"
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
    public function update(Request $request, $id)
    {
        // validate input
        $request->validate([
            'bukti_transfer'                => 'required|mimes:jpg,jpeg,png,pdf',
            'transfer_from_bank_name'       => 'required',
            'transfer_from_bank_account'    => 'required',
            'transfer_from_bank_number'     => 'required',
            'bank_id'                       => 'required|integer',
            'transfer_date'                 => 'required|date',
        ]);

        // get user login
        $user = $request->user();

        // get input form
        $getInput = $request->only([
            'transfer_from_bank_name',
            'transfer_from_bank_account',
            'transfer_from_bank_number',
            'bank_id',
            'transfer_date'
        ]);

        // get file upload
        $file = $request->file('bukti_transfer');

        // generate uuid filename
        $fileextension = $file->extension();
        $filenewName   = (string) Str::uuid() . '.' . $fileextension;

        // folder path based on year/month
        $dateNow  = now();
        $filePath = '/' . $dateNow->year . '/' . $dateNow->month;

        // store file attachment to s3 with public access
        $filesave = Storage::disk('s3')->putFileAs(
            $filePath,
            $file,
            $filenewName,
            'public'
        );

        // build url to files
        $urlFile = Storage::disk('s3')->url($filesave);

        // get bank detail
        $bank = TukBank::findOrFail($getInput['bank_id']);

        // save to database
        $order = Order::select('orders.*')
            ->leftjoin('user_asesis', 'user_asesis.id', '=', 'orders.asesi_id')
            ->leftjoin('users', 'users.id', '=', 'user_asesis.user_id')
            ->where('users.id', $user->id)
            ->where('orders.id', $id)
            ->firstOrFail();

        // update fields
        $order->update([
            'transfer_from_bank_name' => $getInput['transfer_from_bank_name'],
            'transfer_from_bank_account' => $getInput['transfer_from_bank_account'],
            'transfer_from_bank_number' => $getInput['transfer_from_bank_number'],
            'transfer_to_bank_name' => $bank->bank_name,
            'transfer_to_bank_account' => $bank->account_name,
            'transfer_to_bank_number' => $bank->account_number,
            'transfer_date' => $getInput['transfer_date'],
            'media_url_bukti_transfer' => $urlFile,
            'status' => 'pending_verification',
        ]);

        // return response success
        return response()->json([
            'code' => 200,
            'message' => 'success'
        ], 200);
    }
}
