<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UjianAsesiAsesorDataTable;
use App\Http\Controllers\Controller;
use App\Order;
use App\Sertifikasi;
use App\UjianAsesiAsesor;
use App\UjianJadwal;
use App\UserAsesi;
use App\UserAsesor;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UjianAsesiAsesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UjianAsesiAsesorDataTable $dataTables
     *
     * @return mixed
     */
    public function index(UjianAsesiAsesorDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Jadwal Ujian Asesi Lists'
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
        return view('admin.ujian.asesi-form', [
            'title'         => 'Tambah Jadwal Ujian Asesi Baru',
            'action'        => route('admin.ujian.asesi.store'),
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
            'asesor_id'         => 'required',
            'ujian_jadwal_id'   => 'required',
            'order_id'          => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'asesor_id',
            'ujian_jadwal_id',
            'order_id',
        ]);

        // default status
        $dataInput['status'] = 'menunggu';

        // get order information and copy information from order
        $order = Order::findOrFail($dataInput['order_id']);
        $dataInput['asesi_id'] = $order->asesi_id;
        $dataInput['sertifikasi_id'] = $order->sertifikasi_id;

        // save to database
        $query = UjianAsesiAsesor::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.ujian.asesi.index')
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
        $query = UjianAsesiAsesor::findOrFail($id);

        // return data to view
        return view('admin.ujian.asesi-form', [
            'title'         => 'Tampilkan Detail: ' . $query->id,
            'action'        => '#',
            'isShow'        => route('admin.ujian.asesi.edit', $id),
            'query'         => $query,
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
        $query = UjianAsesiAsesor::findOrFail($id);

        // return data to view
        return view('admin.ujian.asesi-form', [
            'title'         => 'Ubah Data: ' . $query->id,
            'action'        => route('admin.ujian.asesi.update', $id),
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
        // validate input
        $request->validate([
            'asesi_id'          => 'required',
            'asesor_id'         => 'required',
            'ujian_jadwal_id'   => 'required',
            'sertifikasi_id'    => 'required',
            'order_id'          => 'required',
            'status'            => 'required|in:' . implode(',', config('options.ujian_asesi_asesors_status')),
        ]);

        // get form data
        $dataInput = $request->only([
            'asesi_id',
            'asesor_id',
            'ujian_jadwal_id',
            'sertifikasi_id',
            'order_id',
            'status',
            'is_kompeten',
            'final_score_percentage',
        ]);

        // find by id and update
        $query = UjianAsesiAsesor::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.ujian.asesi.index')
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
        $query = UjianAsesiAsesor::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
