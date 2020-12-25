<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SertifikasiDataTable;
use App\Http\Controllers\Controller;
use App\Sertifikasi;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SertifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SertifikasiDataTable $dataTables
     *
     * @return mixed
     */
    public function index(SertifikasiDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Sertifikasi Lists'
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
        return view('admin.sertifikasi.sertifikasi-form', [
            'title'     => 'Tambah Sertifikasi Baru',
            'action'    => route('admin.sertifikasi.store'),
            'isCreated' => true,
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
            'nomor_skema'               => 'required',
            'title'                     => 'required',
            'original_price_baru'       => 'required',
            'original_price_perpanjang' => 'required',
            'jenis_sertifikasi'         => 'required',
            'is_active'                 => 'required|boolean',
        ]);

        // get form data
        $dataInput = $request->only([
            'nomor_skema',
            'title',
            'original_price_baru',
            'original_price_perpanjang',
            'jenis_sertifikasi',
            'is_active',
        ]);

        // save to database
        Sertifikasi::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.sertifikasi.index')
            ->with('success', trans('action.success', [
                'name' => $dataInput['title']
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
        $query = Sertifikasi::findOrFail($id);

        // return data to view
        return view('admin.sertifikasi.sertifikasi-form', [
            'title'     => 'Tampilkan Detail: ' . $query->title,
            'action'    => '#',
            'isShow'    => route('admin.sertifikasi.edit', $id),
            'query'     => $query,
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
        $query = Sertifikasi::findOrFail($id);

        // return data to view
        return view('admin.sertifikasi.sertifikasi-form', [
            'title'     => 'Ubah Data: ' . $query->title,
            'action'    => route('admin.sertifikasi.update', $id),
            'isEdit'    => true,
            'query'     => $query,
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
            'nomor_skema'               => 'required',
            'title'                     => 'required',
            'original_price_baru'       => 'required',
            'original_price_perpanjang' => 'required',
            'jenis_sertifikasi'         => 'required',
            'is_active'                 => 'required|boolean',
        ]);

        // get form data
        $dataInput = $request->only([
            'nomor_skema',
            'title',
            'original_price_baru',
            'original_price_perpanjang',
            'jenis_sertifikasi',
            'is_active',
        ]);

        // find by id and update
        $query = Sertifikasi::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.sertifikasi.index')
            ->with('success', trans('action.success_update', [
                'name' => $dataInput['title']
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
        $query = Sertifikasi::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
