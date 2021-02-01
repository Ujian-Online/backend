<?php

namespace App\Http\Controllers\Admin;

use App\Tuk;
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
        // get tuks lists
        $tuks = Tuk::orderBy('title', 'asc')->get();

        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title'         => 'User TUK Lists',
            'filter_route'  => route('admin.user.tuk.index'),
            'filter_view'   => 'admin.tuk.filter-form',
            'tuks'          => $tuks
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
        $users  = User::select('users.*')
            ->leftJoin('user_tuks', 'user_tuks.user_id', '=', 'users.id')
            ->where('users.type', 'tuk')
            ->whereNull('user_tuks.user_id')
            ->orderBy('users.id', 'desc')
            ->get();

        // get tuk lists
        $tuks   = Tuk::orderBy('created_at', 'desc')->get();

        // return view template create
        return view('admin.tuk.form', [
            'title'     => 'Tambah User TUK',
            'action'    => route('admin.user.tuk.store'),
            'isCreated' => true,
            'users'     => $users,
            'tuks'      => $tuks,
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

        // validasi apakah user tuk sudah di assign ke tuk lain?
        $user_tuk = UserTuk::where('user_id', $dataInput['user_id'])
            ->where('tuk_id', $dataInput['tuk_id'])
            ->count();

        if($user_tuk > 0) {
            return redirect()->back()->withErrors(trans('action.error_user_tuk', [
                'id' => $dataInput['user_id']
            ]));
        }

        // save to database
        $query = UserTuk::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.user.tuk.index')
            ->with('success', trans('action.success', [
                    'name' => $query->id
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
        $query  = UserTuk::findOrFail($id);
        // get user lists
        $users  = User::where('id', $query->user_id)->get();
        // get tuk lists
        $tuks   = Tuk::orderBy('created_at', 'desc')->get();

        // return data to view
        return view('admin.tuk.form', [
            'title'     => 'Tampilkan Detail: ' . $query->id,
            'action'    => '#',
            'isShow'    => route('admin.user.tuk.edit', $id),
            'query'     => $query,
            'users'     => $users,
            'tuks'      => $tuks,
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
        // get tuk lists
        $tuks   = Tuk::orderBy('created_at', 'desc')->get();

        // return data to view
        return view('admin.tuk.form', [
            'title'     => 'Ubah Data: ' . $query->id,
            'action'    => route('admin.user.tuk.update', $id),
            'isEdit'    => true,
            'query'     => $query,
            'users'     => $users,
            'tuks'      => $tuks,
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
            'tuk_id'        => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'tuk_id',
        ]);

        // find by id
        $query = UserTuk::findOrFail($id);

        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.user.tuk.index')
            ->with('success', trans('action.success_update', [
                'name' => $dataInput['user_id']
            ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(int $id): JsonResponse
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
