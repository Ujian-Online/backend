<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
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
