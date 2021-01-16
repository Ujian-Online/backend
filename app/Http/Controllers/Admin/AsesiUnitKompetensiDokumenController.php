<?php

namespace App\Http\Controllers\Admin;

use App\AsesiUnitKompetensiDokumen;
use App\DataTables\Admin\AsesiUnitKompetensiDokumenDataTable;
use App\Http\Controllers\Controller;
use App\Sertifikasi;
use App\SertifikasiUnitKompentensi;
use App\UserAsesi;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AsesiUnitKompetensiDokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param AsesiUnitKompetensiDokumenDataTable $dataTables
     *
     * @return mixed
     */
    public function index(AsesiUnitKompetensiDokumenDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Asesi Custom Data Lists'
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
        // get unit kompetensi lists
        $unitkompentensis = SertifikasiUnitKompentensi::all();
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();

        // return view template create
        return view('admin.assesi.apl02-form', [
            'title'             => 'Tambah Asesi APL02 Baru',
            'action'            => route('admin.asesi.apl02.store'),
            'isCreated'         => true,
            'asesis'            => $asesis,
            'unitkompentensis'  => $unitkompentensis,
            'sertifikasis'      => $sertifikasis,
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
            'asesi_id'              => 'required',
            'unit_kompetensi_id'    => 'required',
            'order'                 => 'required',
            'sertifikasi_id'        => 'required',
            'kode_unit_kompetensi'  => 'required',
            'title'                 => 'required',
            'sub_title'             => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'asesi_id',
            'unit_kompetensi_id',
            'order',
            'sertifikasi_id',
            'kode_unit_kompetensi',
            'title',
            'sub_title',
        ]);

        // save to database
        $query = AsesiUnitKompetensiDokumen::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.asesi.apl02.index')
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
        $query = AsesiUnitKompetensiDokumen::findOrFail($id);
        // get asesi lists
        $asesis = UserAsesi::all();
        // get unit kompetensi lists
        $unitkompentensis = SertifikasiUnitKompentensi::all();
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();

        // return data to view
        return view('admin.assesi.apl02-form', [
            'title'             => 'Tampilkan Detail: ' . $query->title,
            'action'            => '#',
            'isShow'            => route('admin.asesi.apl02.edit', $id),
            'query'             => $query,
            'asesis'            => $asesis,
            'unitkompentensis'  => $unitkompentensis,
            'sertifikasis'      => $sertifikasis,
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
        $query = AsesiUnitKompetensiDokumen::findOrFail($id);
        // get asesi lists
        $asesis = UserAsesi::all();
        // get unit kompetensi lists
        $unitkompentensis = SertifikasiUnitKompentensi::all();
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();

        // return data to view
        return view('admin.assesi.apl02-form', [
            'title'             => 'Ubah Data: ' . $query->id,
            'action'            => route('admin.asesi.apl02.update', $id),
            'isEdit'            => true,
            'query'             => $query,
            'asesis'            => $asesis,
            'unitkompentensis'  => $unitkompentensis,
            'sertifikasis'      => $sertifikasis,
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
            'asesi_id'              => 'required',
            'unit_kompetensi_id'    => 'required',
            'order'                 => 'required',
            'sertifikasi_id'        => 'required',
            'kode_unit_kompetensi'  => 'required',
            'title'                 => 'required',
            'sub_title'             => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'asesi_id',
            'unit_kompetensi_id',
            'order',
            'sertifikasi_id',
            'kode_unit_kompetensi',
            'title',
            'sub_title',
        ]);

        // find by id and update
        $query = AsesiUnitKompetensiDokumen::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.asesi.apl02.index')
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
        $query = AsesiUnitKompetensiDokumen::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
