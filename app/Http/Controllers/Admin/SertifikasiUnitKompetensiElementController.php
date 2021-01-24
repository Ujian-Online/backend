<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SertifikasiUnitKompetensiElementDataTable;
use App\Http\Controllers\Controller;
use App\SertifikasiUnitKompentensi;
use App\SertifikasiUnitKompetensiElement;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SertifikasiUnitKompetensiElementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SertifikasiUnitKompetensiElementDataTable $dataTables
     *
     * @return mixed
     */
    public function index(SertifikasiUnitKompetensiElementDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Sertifikasi Unit Kompetensi Lists'
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
        $unitkompentensis = SertifikasiUnitKompentensi::all();

        // return view template create
        return view('admin.sertifikasi-uk.element-form', [
            'title'             => 'Tambah Sertifikasi Unik Kompentensi Element Baru',
            'action'            => route('admin.sertifikasi.ukelement.store'),
            'isCreated'         => true,
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
            'unit_kompetensi_id'    => 'required',
            'desc'                  => 'required',
            'upload_instruction'    => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'unit_kompetensi_id',
            'desc',
            'upload_instruction',
        ]);

        // save to database
        $query = SertifikasiUnitKompetensiElement::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.sertifikasi.ukelement.index')
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
        $query = SertifikasiUnitKompetensiElement::findOrFail($id);
        // get sertifikasi lists
        $unitkompentensis = SertifikasiUnitKompentensi::all();

        // return data to view
        return view('admin.sertifikasi-uk.element-form', [
            'title'             => 'Tampilkan Detail: ' . $query->title,
            'action'            => '#',
            'isShow'            => route('admin.sertifikasi.ukelement.edit', $id),
            'query'             => $query,
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
        $query = SertifikasiUnitKompetensiElement::findOrFail($id);
        // get sertifikasi lists
        $unitkompentensis = SertifikasiUnitKompentensi::all();

        // return data to view
        return view('admin.sertifikasi-uk.element-form', [
            'title'             => 'Ubah Data: ' . $query->id,
            'action'            => route('admin.sertifikasi.ukelement.update', $id),
            'isEdit'            => true,
            'query'             => $query,
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
            'unit_kompetensi_id'    => 'required',
            'desc'                  => 'required',
            'upload_instruction'    => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'unit_kompetensi_id',
            'desc',
            'upload_instruction',
        ]);

        // find by id and update
        $query = SertifikasiUnitKompetensiElement::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.sertifikasi.ukelement.index')
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
        $query = SertifikasiUnitKompetensiElement::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }

    /**
     * UKElement RAW Form HTML
     *
     * @return Application|Factory|View
     */
    public function rawForm()
    {
        return view('admin.sertifikasi-uk.form-element');
    }
}
