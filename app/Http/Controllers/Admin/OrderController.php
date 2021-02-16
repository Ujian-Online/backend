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
            'title'         => 'Order Lists',
            'filter_route'  => route('admin.order.index'),
            'filter_view'   => 'admin.order.filter-form',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        // return view template create
        return view('admin.order.form', [
            'title'         => 'Tambah Order Baru',
            'action'        => route('admin.order.store'),
            'isCreated'     => true,
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
            'transfer_date'             => 'required|date',
            'expired_date'              => 'required|date',
            'sertifikat_date_old'       => 'nullable|date',
            'sertifikat_date_new'       => 'nullable|date',
        ]);

        // get form data
        $dataInput = $request->only([
            'asesi_id',
            'sertifikasi_id',
            'tuk_id',
            'tipe_sertifikasi',
            'sertifikat_number_old',
            'sertifikat_number_new',
            'sertifikat_date_old',
            'sertifikat_date_new',
            'sertifikat_media_url_old',
            'sertifikat_media_url_new',
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
     * @param Request $request
     * @param int $id
     *
     * @return Application|Factory|Response|View
     */
    public function show(Request $request, int $id)
    {
        // get user active
        $user = $request->user();

        // Find Data by ID
        $query = Order::where('id', $id);

        // get tuk id user if access by tuk
        $tukId = null;
        if($user->can('isTuk') and isset($user->tuk) and !empty($user->tuk)) {
                $tukId = $user->tuk->tuk_id;
                $query = $query->where('tuk_id', $tukId);
        }

        // fetch data
        $query = $query->firstOrFail();

        // edit mode url
        $editUrl = true;

        // check tuk permission
        if($user->can('isTuk')) {
            $editUrl = route('admin.order.edit', $id);
        }

        // return data to view
        return view('admin.order.form', [
            'title'         => 'Tampilkan Detail Order ID: ' . $query->id,
            'action'        => '#',
            'isShow'        => $editUrl,
            'query'         => $query,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param int $id
     *
     * @return Application|Factory|RedirectResponse|Response|View
     */
    public function edit(Request $request, int $id)
    {
        // get user active
        $user = $request->user();

        // check tuk permission
        if(!$user->can('isTuk')) {
            abort(403);
        }

        // Find Data by ID
        $query = Order::where('id', $id);

        // get tuk id user if access by tuk
        $tukId = null;
        if($user->can('isTuk') and isset($user->tuk) and !empty($user->tuk)) {
            $tukId = $user->tuk->tuk_id;
            $query = $query->where('tuk_id', $tukId);
        }

        // fetch data
        $query = $query->firstOrFail();

        // order tidak bisa di edit klo status nya complete
        if($query->status == 'completed') {
            return redirect()->back()->withErrors('Tidak bisa merubah data order dengan status complete.');
        }

        // return data to view
        return view('admin.order.form', [
            'title'         => 'Ubah Data Order ID: ' . $query->id,
            'action'        => route('admin.order.update', $id),
            'isEdit'        => true,
            'query'         => $query,
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
        // get user active
        $user = $request->user();

        // check tuk permission
        if(!$user->can('isTuk')) {
            abort(403);
        }

        // validate input
        $request->validate([
            'status' => 'required|in:' . implode(',', config('options.orders_status_tuk')),
        ]);

        // get form data
        $dataInput = $request->only([
            'status',
            'comment_rejected',
            'comment_verification',
        ]);

        // Find Data by ID
        $query = Order::where('id', $id);

        // get tuk id user if access by tuk
        $tukId = null;
        if($user->can('isTuk') and isset($user->tuk) and !empty($user->tuk)) {
            $tukId = $user->tuk->tuk_id;
            $query = $query->where('tuk_id', $tukId);
        }

        // fetch data
        $query = $query->firstOrFail();

        // order tidak bisa di edit klo status nya complete
        if($query->status == 'completed') {
            return redirect()->back()->withErrors('Tidak bisa merubah data order dengan status complete.');
        }

        // update data
        $query->update($dataInput);

        // create APL01 form if payment verified
        if($dataInput['status'] == 'payment_verified') {
            UserAsesi::create(['user_id' => $query->asesi_id]);
        }

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
