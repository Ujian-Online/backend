<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\UserTuk;
use App\Http\Controllers\Controller;
use App\DataTables\Admin\UserTukDataTable;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserTukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserTukDataTable $dataTables
     *
     * @return mixed
     */
    public function index(UserTukDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'User TUK Lists'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        // get user lists
        $users = User::orderBy('created_at', 'desc')->get();

        // return view template create
        return view('admin.tuk.form', [
            'title'     => 'Tambah User TUK',
            'action'    => route('admin.tuk.store'),
            'isCreated' => true,
            'users'     => $users,
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
            'user_id'       => 'required',
            'tuk_id'        => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'user_id',
            'tuk_id',
        ]);

        // save to database
        UserTuk::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.tuk.index')
            ->with('success', trans('action.success', [
                    'name' => $dataInput['id']
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show(int $id)
    {
        // Find User by ID
        $query = UserTuk::findOrFail($id);
        // get user lists
        $users = User::orderBy('created_at', 'desc')->get();

        // return data to view
        return view('admin.tuk.form', [
            'title'     => 'Show Detail: ' . $query->id,
            'action'    => '#',
            'isShow'    => route('admin.tuk.edit', $id),
            'query'     => $query,
            'users'     => $users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
        // Find User by ID
        $query = UserTuk::findOrFail($id);
        // get user lists
        $users = User::orderBy('created_at', 'desc')->get();

        // return data to view
        return view('admin.tuk.form', [
            'title'     => 'Edit Data: ' . $query->id,
            'action'    => route('admin.tuk.update', $id),
            'isEdit'    => true,
            'query'     => $query,
            'users'     => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        // validate input
        $request->validate([
            'user_id'       => 'required',
            'tuk_id'        => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'user_id',
            'tuk_id',
        ]);

        // find by id and update
        $query = UserTuk::findOrFail($id);

        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.tuk.index')
            ->with('success', trans('action.success_update', [
                'name' => $dataInput['id']
            ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(int $id)
    {
        $query = UserTuk::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
                'code' => 200,
                'success' => true,
        ]);
    }
}
