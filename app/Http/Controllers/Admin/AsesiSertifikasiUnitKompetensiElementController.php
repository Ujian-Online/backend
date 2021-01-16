<?php

namespace App\Http\Controllers\Admin;

use App\AsesiSertifikasiUnitKompetensiElement;
use App\DataTables\Admin\AsesiSertifikasiUnitKompetensiElementDataTable;
use App\Http\Controllers\Controller;
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

class AsesiSertifikasiUnitKompetensiElementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param AsesiSertifikasiUnitKompetensiElementDataTable $dataTables
     *
     * @return mixed
     */
    public function index(AsesiSertifikasiUnitKompetensiElementDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Asesi Sertifikasi Unit Kompentensi Element Lists'
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

        // return view template create
        return view('admin.assesi.element-form', [
            'title'             => 'Tambah Asesi Sertifikasi Unit Kompetensi Element Baru',
            'action'            => route('admin.asesi.ukelement.store'),
            'isCreated'         => true,
            'asesis'            => $asesis,
            'unitkompentensis'  => $unitkompentensis,
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
            'desc'                  => 'required',
            'upload_instruction'    => 'required',
            'is_verified'           => 'required|boolean',
        ]);

        // get form data
        $dataInput = $request->only([
            'asesi_id',
            'unit_kompetensi_id',
            'desc',
            'upload_instruction',
            'media_url',
            'is_verified',
            'verification_note',
        ]);

        // save to database
        $query = AsesiSertifikasiUnitKompetensiElement::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.asesi.ukelement.index')
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
        $query = AsesiSertifikasiUnitKompetensiElement::findOrFail($id);
        // get asesi lists
        $asesis = UserAsesi::all();
        // get unit kompetensi lists
        $unitkompentensis = SertifikasiUnitKompentensi::all();

        // return data to view
        return view('admin.assesi.element-form', [
            'title'             => 'Tampilkan Detail: ' . $query->id,
            'action'            => '#',
            'isShow'            => route('admin.asesi.ukelement.edit', $id),
            'query'             => $query,
            'asesis'            => $asesis,
            'unitkompentensis'  => $unitkompentensis,
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
        $query = AsesiSertifikasiUnitKompetensiElement::findOrFail($id);
        // get asesi lists
        $asesis = UserAsesi::all();
        // get unit kompetensi lists
        $unitkompentensis = SertifikasiUnitKompentensi::all();

        // return data to view
        return view('admin.assesi.element-form', [
            'title'             => 'Ubah Data: ' . $query->id,
            'action'            => route('admin.asesi.ukelement.update', $id),
            'isEdit'            => true,
            'query'             => $query,
            'asesis'            => $asesis,
            'unitkompentensis'  => $unitkompentensis,
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
            'desc'                  => 'required',
            'upload_instruction'    => 'required',
            'is_verified'           => 'required|boolean',
        ]);

        // get form data
        $dataInput = $request->only([
            'asesi_id',
            'unit_kompetensi_id',
            'desc',
            'upload_instruction',
            'media_url',
            'is_verified',
            'verification_note',
        ]);

        // find by id and update
        $query = AsesiSertifikasiUnitKompetensiElement::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.asesi.ukelement.index')
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
        $query = AsesiSertifikasiUnitKompetensiElement::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
