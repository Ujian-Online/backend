<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SoalPaketDataTable;
use App\Http\Controllers\Controller;
use App\Sertifikasi;
use App\SoalPaket;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SoalPaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SoalPaketDataTable $dataTables
     *
     * @return mixed
     */
    public function index(SoalPaketDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Soal Paket Lists'
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
        return view('admin.soal.paket-form', [
            'title'         => 'Tambah Soal Paket Baru',
            'action'        => route('admin.soal.paket.store'),
            'isCreated'     => true,
            'sertifikasis'  => $sertifikasis
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
            'title'             => 'required',
            'sertifikasi_id'    => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'title',
            'sertifikasi_id',
        ]);

        // save to database
        $query = SoalPaket::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.soal.paket.index')
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
        $query = SoalPaket::findOrFail($id);
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();

        // return data to view
        return view('admin.soal.paket-form', [
            'title'         => 'Tampilkan Detail: ' . $query->title,
            'action'        => '#',
            'isShow'        => route('admin.soal.paket.edit', $id),
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
        $query = SoalPaket::findOrFail($id);
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();

        // return data to view
        return view('admin.soal.paket-form', [
            'title'         => 'Ubah Data: ' . $query->title,
            'action'        => route('admin.soal.paket.update', $id),
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
            'title'             => 'required',
            'sertifikasi_id'    => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'title',
            'sertifikasi_id',
        ]);

        // find by id and update
        $query = SoalPaket::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.soal.paket.index')
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
        $query = SoalPaket::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
