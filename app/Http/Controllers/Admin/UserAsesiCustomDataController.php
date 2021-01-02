<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UserAsesiCustomDataDataTable;
use App\Http\Controllers\Controller;
use App\UserAsesi;
use App\UserAsesiCustomData;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UserAsesiCustomDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserAsesiCustomDataDataTable $dataTables
     *
     * @return mixed
     */
    public function index(UserAsesiCustomDataDataTable $dataTables)
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

        // return view template create
        return view('admin.assesi.customdata-form', [
            'title'         => 'Tambah Asesi Custom Data Baru',
            'action'        => route('admin.asesi.customdata.store'),
            'isCreated'     => true,
            'asesis'        => $asesis,
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
            'asesi_id'      => 'required',
            'title'         => 'required',
            'input_type'    => 'required',
            'value'         => 'required',
            'is_verified'   => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'asesi_id',
            'title',
            'input_type',
            'value',
            'is_verified',
            'verification_note',
        ]);

        // save to database
        $query = UserAsesiCustomData::create($dataInput);

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
        $query = UserAsesiCustomData::findOrFail($id);
        // get asesi lists
        $asesis = UserAsesi::all();

        // return data to view
        return view('admin.assesi.customdata-form', [
            'title'         => 'Tampilkan Detail: ' . $query->title,
            'action'        => '#',
            'isShow'        => route('admin.asesi.customdata.edit', $id),
            'query'         => $query,
            'asesis'        => $asesis,
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
        $query = UserAsesiCustomData::findOrFail($id);
        // get asesi lists
        $asesis = UserAsesi::all();

        // return data to view
        return view('admin.assesi.customdata-form', [
            'title'         => 'Ubah Data: ' . $query->id,
            'action'        => route('admin.asesi.customdata.update', $id),
            'isEdit'        => true,
            'query'         => $query,
            'asesis'        => $asesis,
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
            'asesi_id'      => 'required',
            'title'         => 'required',
            'input_type'    => 'required',
            'value'         => 'required',
            'is_verified'   => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'asesi_id',
            'title',
            'input_type',
            'value',
            'is_verified',
            'verification_note',
        ]);

        // find by id and update
        $query = UserAsesiCustomData::findOrFail($id);
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
        $query = UserAsesiCustomData::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
