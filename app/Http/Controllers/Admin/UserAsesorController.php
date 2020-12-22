<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\UserAsesor;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Admin\UserAsesorDataTable;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UserAsesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserAsesorDataTable $dataTables
     *
     * @return mixed
     */
    public function index(UserAsesorDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'User Assesor Lists',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        // get user lists
        $users = User::orderBy('created_at', 'desc')->get();

        // return view template create
        return view('admin.assesor.form', [
            'title' => 'Tambah User Assesor',
            'action' => route('admin.user.asesor.store'),
            'isCreated' => true,
            'users' => $users,
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
            'user_id' => 'required',
            'met' => 'required',
            'name' => 'required',
            'expired_date' => 'required|date',
            'address' => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'user_id',
            'met',
            'name',
            'expired_date',
            'address',
        ]);

        // check if user_id already used in user assesor or not
        $user_assesor = UserAsesor::where('user_id', $dataInput['user_id'])->count();

        if ($user_assesor > 0) {
            return redirect()->back()->with('error', trans('action.error_assesor', [
                'id' => $dataInput['user_id'],
            ]));
        }

        // save to database
        UserAsesor::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.user.asesor.index')
            ->with('success', trans('action.success', [
                'name' => $dataInput['name'],
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
        $query = UserAsesor::findOrFail($id);
        // get user lists
        $users = User::orderBy('created_at', 'desc')->get();

        // return data to view
        return view('admin.assesor.form', [
            'title' => 'Show Detail: ' . $query->name,
            'action' => '#',
            'isShow' => route('admin.user.asesor.edit', $id),
            'query' => $query,
            'users' => $users,
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
        $query = UserAsesor::findOrFail($id);
        // get user lists
        $users = User::orderBy('created_at', 'desc')->get();

        // return data to view
        return view('admin.assesor.form', [
            'title' => 'Edit Data: ' . $query->name,
            'action' => route('admin.user.asesor.update', $id),
            'isEdit' => true,
            'query' => $query,
            'users' => $users,
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
            'user_id' => 'required',
            'met' => 'required',
            'name' => 'required',
            'expired_date' => 'required|date',
            'address' => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'user_id',
            'met',
            'name',
            'expired_date',
            'address',
        ]);

        // find by id and update
        $query = UserAsesor::findOrFail($id);

        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.user.asesor.index')
            ->with('success', trans('action.success_update', [
                'name' => $dataInput['name'],
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
        $query = UserAsesor::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
