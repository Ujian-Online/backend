<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SertifikasiTukDataTable;
use App\Http\Controllers\Controller;
use App\Sertifikasi;
use App\SertifikasiTuk;
use App\Tuk;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SertifikasiTukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SertifikasiTukDataTable $dataTables
     *
     * @return mixed
     */
    public function index(SertifikasiTukDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Sertifikasi TUK Lists',
            'filter_route' => route('admin.sertifikasi.tuk.index'),
            'filter_view' => 'admin.sertifikasi-tuk.filter-form'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();
        // get tuk lists
        $tuks = Tuk::all();

        // return view template create
        return view('admin.sertifikasi-tuk.sertifikasi-tuk-form', [
            'title'         => 'Tambah Sertifikasi TUK Baru',
            'action'        => route('admin.sertifikasi.tuk.store'),
            'isCreated'     => true,
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
            'sertifikasi_id'        => 'required',
            'tuk_id'                => 'required',
            'tuk_price_baru'        => 'required',
            'tuk_price_perpanjang'  => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'sertifikasi_id',
            'tuk_id',
            'tuk_price_baru',
            'tuk_price_perpanjang',
            'tuk_price_training',
        ]);

        // save to database
        $query = SertifikasiTuk::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.sertifikasi.tuk.index')
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
        $query = SertifikasiTuk::findOrFail($id);
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();
        // get tuk lists
        $tuks = Tuk::all();

        // return data to view
        return view('admin.sertifikasi-tuk.sertifikasi-tuk-form', [
            'title'         => 'Tampilkan Detail: ' . $query->id,
            'action'        => '#',
            'isShow'        => route('admin.sertifikasi.tuk.edit', $id),
            'query'         => $query,
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
        $query = SertifikasiTuk::findOrFail($id);
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();
        // get tuk lists
        $tuks = Tuk::all();

        // return data to view
        return view('admin.sertifikasi-tuk.sertifikasi-tuk-form', [
            'title'         => 'Ubah Data: ' . $query->id,
            'action'        => route('admin.sertifikasi.tuk.update', $id),
            'isEdit'        => true,
            'query'         => $query,
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
            'sertifikasi_id'        => 'required',
            'tuk_id'                => 'required',
            'tuk_price_baru'        => 'required',
            'tuk_price_perpanjang'  => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'sertifikasi_id',
            'tuk_id',
            'tuk_price_baru',
            'tuk_price_perpanjang',
            'tuk_price_training',
        ]);

        // find by id and update
        $query = SertifikasiTuk::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.sertifikasi.tuk.index')
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
        $query = SertifikasiTuk::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
