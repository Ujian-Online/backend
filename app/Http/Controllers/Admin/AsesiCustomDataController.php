<?php

namespace App\Http\Controllers\Admin;

use App\AsesiCustomData;
use App\DataTables\Admin\AsesiCustomDataDataTable;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AsesiCustomDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param AsesiCustomDataDataTable $dataTables
     *
     * @return mixed
     */
    public function index(AsesiCustomDataDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Asesi Custom Data (APL-01) Form Lists'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        // return view template create
        return view('admin.assesi.customdata-apl01-form', [
            'title'         => 'Tambah Asesi Custom Data (APL-01) Form Baru',
            'action'        => route('admin.asesi.customdata.store'),
            'isCreated'     => true,
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
            'title'         => 'required',
            'input_type'    => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'title',
            'input_type',
        ]);

        // save to database
        $query = AsesiCustomData::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.asesi.customdata.index')
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
        $query = AsesiCustomData::findOrFail($id);

        // return data to view
        return view('admin.assesi.customdata-apl01-form', [
            'title'         => 'Detail Asesi Custom Data (APL-01) Form: ' . $query->title,
            'action'        => '#',
            'isShow'        => route('admin.asesi.customdata.edit', $id),
            'query'         => $query,
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
        $query = AsesiCustomData::findOrFail($id);

        // return data to view
        return view('admin.assesi.customdata-apl01-form', [
            'title'         => 'Ubah Asesi Custom Data (APL-01) Form Data: ' . $query->id,
            'action'        => route('admin.asesi.customdata.update', $id),
            'isEdit'        => true,
            'query'         => $query,
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
            'title'         => 'required',
            'input_type'    => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'title',
            'input_type',
        ]);

        // find by id and update
        $query = AsesiCustomData::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.asesi.customdata.index')
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
        $query = AsesiCustomData::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
