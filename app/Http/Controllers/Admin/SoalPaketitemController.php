<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SoalPaketitemDataTable;
use App\Http\Controllers\Controller;
use App\Soal;
use App\SoalPaket;
use App\SoalPaketItem;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SoalPaketitemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SoalPaketitemDataTable $dataTables
     *
     * @return mixed
     */
    public function index(SoalPaketitemDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Soal Paket Item Lists'
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
        // get asesi lists
        $soalpakets = SoalPaket::all();

        // return view template create
        return view('admin.soal.paketitem-form', [
            'title'         => 'Tambah Paket Item Baru',
            'action'        => route('admin.soal.paketitem.store'),
            'isCreated'     => true,
            'soals'         => $soals,
            'soalpakets'    => $soalpakets,
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
            'soal_paket_id' => 'required',
            'soal_id'       => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'soal_paket_id',
            'soal_id',
        ]);

        // save to database
        $query = SoalPaketItem::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.soal.paketitem.index')
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
        $query = SoalPaketItem::findOrFail($id);
        // get soal lists
        $soals = Soal::all();
        // get asesi lists
        $soalpakets = SoalPaket::all();

        // return view template create
        return view('admin.soal.paketitem-form', [
            'title'         => 'Tampilkan Detail: ' . $query->id,
            'action'        => '#',
            'isShow'        => route('admin.soal.paketitem.edit', $id),
            'query'         => $query,
            'soals'         => $soals,
            'soalpakets'    => $soalpakets,
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
        $query = SoalPaketItem::findOrFail($id);
        // get soal lists
        $soals = Soal::all();
        // get asesi lists
        $soalpakets = SoalPaket::all();

        // return view template create
        return view('admin.soal.paketitem-form', [
            'title'         => 'Ubah Data: ' . $query->id,
            'action'        => route('admin.soal.paketitem.update', $id),
            'isEdit'        => true,
            'query'         => $query,
            'soals'         => $soals,
            'soalpakets'    => $soalpakets,
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
            'soal_paket_id' => 'required',
            'soal_id'       => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'soal_paket_id',
            'soal_id',
        ]);

        // find by id and update
        $query = SoalPaketItem::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.soal.paketitem.index')
            ->with('success', trans('action.success', [
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
        $query = SoalPaketItem::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
