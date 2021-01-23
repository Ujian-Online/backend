<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SertifikasiUnitKompentensiDataTable;
use App\Http\Controllers\Controller;
use App\Sertifikasi;
use App\SertifikasiUnitKompentensi;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SertifikasiUnitKompetensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SertifikasiUnitKompentensiDataTable $dataTables
     *
     * @return mixed
     */
    public function index(SertifikasiUnitKompentensiDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Sertifikasi Unit Kompetensi Lists',
            'filter_route' => route('admin.sertifikasi.uk.index'),
            'filter_view' => 'admin.sertifikasi-uk.filter-form',
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

        // return view template create
        return view('admin.sertifikasi-uk.form', [
            'title'         => 'Tambah Sertifikasi Unik Kompentensi Baru',
            'action'        => route('admin.sertifikasi.uk.store'),
            'isCreated'     => true,
            'sertifikasis'  => $sertifikasis,
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
            'order'                 => 'required',
            'sertifikasi_id'        => 'required',
            'kode_unit_kompetensi'  => 'required',
            'title'                 => 'required',
            'sub_title'             => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'order',
            'sertifikasi_id',
            'kode_unit_kompetensi',
            'title',
            'sub_title',
        ]);

        // save to database
        $query = SertifikasiUnitKompentensi::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.sertifikasi.uk.index')
            ->with('success', trans('action.success', [
                'name' => $query->title
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
        $query = SertifikasiUnitKompentensi::findOrFail($id);
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();

        // return data to view
        return view('admin.sertifikasi-uk.form', [
            'title'         => 'Tampilkan Detail: ' . $query->title,
            'action'        => '#',
            'isShow'        => route('admin.sertifikasi.uk.edit', $id),
            'query'         => $query,
            'sertifikasis'  => $sertifikasis,
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
        $query = SertifikasiUnitKompentensi::findOrFail($id);
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();

        // return data to view
        return view('admin.sertifikasi-uk.form', [
            'title'         => 'Ubah Data: ' . $query->id,
            'action'        => route('admin.sertifikasi.uk.update', $id),
            'isEdit'        => true,
            'query'         => $query,
            'sertifikasis'  => $sertifikasis,
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
            'order'                 => 'required',
            'sertifikasi_id'        => 'required',
            'kode_unit_kompetensi'  => 'required',
            'title'                 => 'required',
            'sub_title'             => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'order',
            'sertifikasi_id',
            'kode_unit_kompetensi',
            'title',
            'sub_title',
        ]);

        // find by id and update
        $query = SertifikasiUnitKompentensi::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.sertifikasi.uk.index')
            ->with('success', trans('action.success_update', [
                'name' => $query->title
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
        $query = SertifikasiUnitKompentensi::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
