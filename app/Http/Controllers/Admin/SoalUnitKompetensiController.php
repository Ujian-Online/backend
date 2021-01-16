<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SoalUnitKompetensiDataTable;
use App\Http\Controllers\Controller;
use App\SoalUnitKompetensi;
use App\Soal;
use App\SertifikasiUnitKompentensi;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SoalUnitKompetensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SoalUnitKompetensiDataTable $dataTables
     *
     * @return mixed
     */
    public function index(SoalUnitKompetensiDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Soal Unit Kompetensi Lists'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        // get soal lists
        $soals = Soal::all();
        $unit_kompetensis = SertifikasiUnitKompentensi::all();

        return view('admin.soal.unitkompetensi-form', [
            'title'             => 'Tambah Soal Unit Kompetensi Baru',
            'action'            => route('admin.soal.unitkompetensi.store'),
            'isCreated'         => true,
            'soals'             => $soals,
            'unit_kompetensis'  => $unit_kompetensis
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
            'soal_id'         => 'required',
            'unit_kompetensi_id'    => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'soal_id',
            'unit_kompetensi_id',
        ]);

        // save to database
        $query = SoalUnitKompetensi::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.soal.unitkompetensi.index')
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
        $query = SoalUnitKompetensi::findOrFail($id);

        $soals = Soal::all();
        $unit_kompetensis = SertifikasiUnitKompentensi::all();

        // return data to view
        return view('admin.soal.unitkompetensi-form', [
            'title'             => 'Tampilkan Detail: Soal Unit Komptensi ' . $query->id,
            'action'            => '#',
            'isShow'            => route('admin.soal.unitkompetensi.edit', $id),
            'query'             => $query,
            'soals'             => $soals,
            'unit_kompetensis'  => $unit_kompetensis
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
        $query = SoalUnitKompetensi::findOrFail($id);

        $soals = Soal::all();
        $unit_kompetensis = SertifikasiUnitKompentensi::all();

        // return data to view
        return view('admin.soal.unitkompetensi-form', [
            'title'             => 'Ubah Data: Soal Unit Kompetensi' . $query->id,
            'action'            => route('admin.soal.unitkompetensi.update', $id),
            'isEdit'            => true,
            'query'             => $query,
            'soals'             => $soals,
            'unit_kompetensis'  => $unit_kompetensis
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
            'soal_id'         => 'required',
            'unit_kompetensi_id'    => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'soal_id',
            'unit_kompetensi_id',
        ]);

        // find by id and update
        $query = SoalUnitKompetensi::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.soal.unitkompetensi.index')
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
        $query = SoalUnitKompetensi::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
