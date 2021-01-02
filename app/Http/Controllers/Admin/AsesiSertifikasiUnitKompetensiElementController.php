<?php

namespace App\Http\Controllers\Admin;

use App\AsesiSertifikasiUnitKompetensiElement;
use App\DataTables\Admin\AsesiSertifikasiUnitKompetensiElementDataTable;
use App\Http\Controllers\Controller;
use App\Sertifikasi;
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
            'title' => 'Sertifikasi UK Element Lists'
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

        // return view template create
        return view('admin.sertifikasi-uk.element-form', [
            'title'         => 'Tambah Sertifikasi Unit Kompetensi Element Baru',
            'action'        => route('admin.sertifikasi.ukelement.store'),
            'isCreated'     => true,
            'asesis'        => $asesis,
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
            'asesi_id'              => 'required',
            'unit_kompetensi_id'    => 'required',
            'desc'                  => 'required',
            'upload_instruction'    => 'required',
            'media_url'             => 'required',
            'is_verified'           => 'required|boolean',
            'verification_note'     => 'required',
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
        AsesiSertifikasiUnitKompetensiElement::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.sertifikasi.ukelement.index')
            ->with('success', trans('action.success', [
                'name' => $dataInput['upload_instruction']
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
            'is_active'                 => 'required|boolean',
        ]);

        // get form data
        $dataInput = $request->only([
            'nomor_skema',
            'title',
            'original_price_baru',
            'original_price_perpanjang',
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
