<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\TukDataTable;
use App\Http\Controllers\Controller;
use App\Tuk;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Exception;

class TukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param TukDataTable $dataTables
     *
     * @return mixed
     */
    public function index(TukDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'TUK Lists'
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
        return view('admin.tuk.tuk-form', [
            'title'     => 'Tambah TUK Baru',
            'action'    => route('admin.tuk.store'),
            'isCreated' => true,
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
            'code'      => 'required',
            'title'     => 'required',
            'telp'      => 'required',
            'address'   => 'required',
            'type'      => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'code',
            'title',
            'telp',
            'address',
            'type',
        ]);

        // save to database
        Tuk::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.tuk.index')
            ->with('success', trans('action.success', [
                'name' => $dataInput['title']
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
        // Find User by ID
        $query = Tuk::findOrFail($id);

        // return data to view
        return view('admin.tuk.tuk-form', [
            'title'     => 'Tampilkan Detail: ' . $query->title,
            'action'    => '#',
            'isShow'    => route('admin.tuk.edit', $id),
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
        // Find User by ID
        $query = Tuk::findOrFail($id);

        // return data to view
        return view('admin.tuk.tuk-form', [
            'title'     => 'Ubah Data: ' . $query->title,
            'action'    => route('admin.tuk.update', $id),
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
            'code'      => 'required',
            'title'     => 'required',
            'telp'      => 'required',
            'address'   => 'required',
            'type'      => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'code',
            'title',
            'telp',
            'address',
            'type',
        ]);

        // find by id and update
        $query = Tuk::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.tuk.index')
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
        $query = Tuk::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
