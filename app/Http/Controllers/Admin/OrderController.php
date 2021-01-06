<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Order;
use App\Sertifikasi;
use App\Tuk;
use App\UserAsesi;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param OrderDataTable $dataTables
     *
     * @return mixed
     */
    public function index(OrderDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Order Lists'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        // get asesi lists
        $asesis = UserAsesi::all();
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();
        // get tuk lists
        $tuks = Tuk::all();

        // return view template create
        return view('admin.order.form', [
            'title'         => 'Tambah Order Baru',
            'action'        => route('admin.order.store'),
            'isCreated'     => true,
            'asesis'        => $asesis,
            'sertifikasis'  => $sertifikasis,
            'tuks'          => $tuks,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        // validate input
        $request->validate([
            'asesi_id'                  => 'required',
            'sertifikasi_id'            => 'required',
            'tuk_id'                    => 'required',
            'tipe_sertifikasi'          => 'required|in:' . implode(',', config('options.orders_tipe_sertifikasi')),
            'original_price'            => 'required',
            'tuk_price'                 => 'required',
            'status'                    => 'required|in:' . implode(',', config('options.orders_status')),
            'transfer_to_bank_name'     => 'required',
            'transfer_to_bank_account'  => 'required',
            'transfer_to_bank_number'   => 'required',
            'expired_date'              => 'required|date',
        ]);

        // get form data
        $dataInput = $request->only([
            'asesi_id',
            'sertifikasi_id',
            'tuk_id',
            'tipe_sertifikasi',
            'kode_sertifikat',
            'original_price',
            'tuk_price',
            'tuk_price_training',
            'status',
            'comment_rejected',
            'comment_verification',
            'transfer_from_bank_name',
            'transfer_from_bank_account',
            'transfer_from_bank_number',
            'transfer_to_bank_name',
            'transfer_to_bank_account',
            'transfer_to_bank_number',
            'transfer_date',
            'media_url_bukti_transfer',
            'expired_date',
        ]);

        // save to database
        $query = Order::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.order.index')
            ->with('success', trans('action.success', [
                'name' => $query->id
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Application|Factory|Response|View
     */
    public function show(int $id)
    {
        // Find Data by ID
        $query = Order::findOrFail($id);
        // get asesi lists
        $asesis = UserAsesi::where('id', $query->asesi_id)->get();
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::where('id', $query->sertifikasi_id)->get();
        // get tuk lists
        $tuks = Tuk::where('id', $query->tuk_id)->get();

        // return data to view
        return view('admin.order.form', [
            'title'         => 'Tampilkan Detail: ' . $query->id,
            'action'        => '#',
            'isShow'        => route('admin.order.edit', $id),
            'query'         => $query,
            'asesis'        => $asesis,
            'sertifikasis'  => $sertifikasis,
            'tuks'          => $tuks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Application|Factory|Response|View
     */
    public function edit(int $id)
    {
        // Find Data by ID
        $query = Order::findOrFail($id);
        // get asesi lists
        $asesis = UserAsesi::all();
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();
        // get tuk lists
        $tuks = Tuk::all();

        // return data to view
        return view('admin.order.form', [
            'title'         => 'Ubah Data: ' . $query->id,
            'action'        => route('admin.order.update', $id),
            'isEdit'        => true,
            'query'         => $query,
            'asesis'        => $asesis,
            'sertifikasis'  => $sertifikasis,
            'tuks'          => $tuks,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        // validate input
        $request->validate([
            'asesi_id'                  => 'required',
            'sertifikasi_id'            => 'required',
            'tuk_id'                    => 'required',
            'tipe_sertifikasi'          => 'required|in:' . implode(',', config('options.orders_tipe_sertifikasi')),
            'original_price'            => 'required',
            'tuk_price'                 => 'required',
            'status'                    => 'required|in:' . implode(',', config('options.orders_status')),
            'transfer_to_bank_name'     => 'required',
            'transfer_to_bank_account'  => 'required',
            'transfer_to_bank_number'   => 'required',
            'expired_date'              => 'required|date',
        ]);

        // get form data
        $dataInput = $request->only([
            'asesi_id',
            'sertifikasi_id',
            'tuk_id',
            'tipe_sertifikasi',
            'kode_sertifikat',
            'original_price',
            'tuk_price',
            'tuk_price_training',
            'status',
            'comment_rejected',
            'comment_verification',
            'transfer_from_bank_name',
            'transfer_from_bank_account',
            'transfer_from_bank_number',
            'transfer_to_bank_name',
            'transfer_to_bank_account',
            'transfer_to_bank_number',
            'transfer_date',
            'media_url_bukti_transfer',
            'expired_date',
        ]);

        // find by id and update
        $query = Order::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.order.index')
            ->with('success', trans('action.success_update', [
                'name' => $query->id
            ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(int $id): JsonResponse
    {
        $query = Order::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}