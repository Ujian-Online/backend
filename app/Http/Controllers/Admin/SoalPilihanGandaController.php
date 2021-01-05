<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SoalPilihanGandaDataTable;
use App\Http\Controllers\Controller;
use App\Soal;
use App\SoalPilihanGanda;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SoalPilihanGandaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SoalPilihanGandaDataTable $dataTables
     *
     * @return mixed
     */
    public function index(SoalPilihanGandaDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Soal Pilihan Ganda Lists'
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

        // return view template create
        return view('admin.soal.pilihanganda-form', [
            'title'     => 'Tambah Pilihan Ganda Baru',
            'action'    => route('admin.soal.pilihanganda.store'),
            'isCreated' => true,
            'soals'     => $soals
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
            'soal_id'   => 'required',
            'option'    => 'required',
            'label'     => 'required|in:' . implode(',', config('options.soal_pilihan_gandas_label')),
        ]);

        // get form data
        $dataInput = $request->only([
            'soal_id',
            'option',
            'label',
        ]);

        // save to database
        $query = SoalPilihanGanda::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.soal.pilihanganda.index')
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
        $query = SoalPilihanGanda::findOrFail($id);
        // get soal lists
        $soals = Soal::all();

        // return data to view
        return view('admin.soal.pilihanganda-form', [
            'title'     => 'Tampilkan Detail: ' . $query->id,
            'action'    => '#',
            'isShow'    => route('admin.soal.pilihanganda.edit', $id),
            'query'     => $query,
            'soals'     => $soals,
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
        $query = SoalPilihanGanda::findOrFail($id);
        // get soal lists
        $soals = Soal::all();

        // return data to view
        return view('admin.soal.pilihanganda-form', [
            'title'     => 'Ubah Data: ' . $query->id,
            'action'    => route('admin.soal.pilihanganda.update', $id),
            'isEdit'    => true,
            'query'     => $query,
            'soals'     => $soals,
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
            'soal_id'   => 'required',
            'option'    => 'required',
            'label'     => 'required|in:' . implode(',', config('options.soal_pilihan_gandas_label')),
        ]);

        // get form data
        $dataInput = $request->only([
            'soal_id',
            'option',
            'label',
        ]);

        // find by id and update
        $query = SoalPilihanGanda::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.soal.pilihanganda.index')
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
        $query = SoalPilihanGanda::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
