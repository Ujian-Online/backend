<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\UserAssesor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Admin\UserAssesorDataTable;

class UserAssesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\Admin\UserAssesorDataTable $dataTables
     * @return \Illuminate\Http\Response
     */
    public function index(UserAssesorDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'User Assesor Lists'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // get user lists
        $users = User::orderBy('created_at', 'desc')->get();

        // return view template create
        return view('admin.assesor.form', [
            'title'     => 'Tambah User Assesor',
            'action'    => route('admin.assesor.store'),
            'isCreated' => true,
            'users'     => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate input
        $request->validate([
            'user_id'       => 'required',
            'met'           => 'required',
            'name'          => 'required',
            'expired_date'  => 'required|date',
            'address'       => 'required',
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
        $user_assesor = UserAssesor::where('user_id', $dataInput['user_id'])->count();

        if($user_assesor > 0) {
            return redirect()->back()->with('error', trans('action.error_assesor', [
                'id' => $dataInput['user_id']
            ]));
        }

        // save to database
        UserAssesor::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.assesor.index')
            ->with('success', trans('action.success', [
                    'name' => $dataInput['name']
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find User by ID
        $query = UserAssesor::findOrFail($id);
        // get user lists
        $users = User::orderBy('created_at', 'desc')->get();

        // return data to view
        return view('admin.assesor.form', [
            'title'     => 'Show Detail: ' . $query->name,
            'action'    => '#',
            'isShow'    => route('admin.assesor.edit', $id),
            'query'     => $query,
            'users'     => $users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find User by ID
        $query = UserAssesor::findOrFail($id);
        // get user lists
        $users = User::orderBy('created_at', 'desc')->get();

        // return data to view
        return view('admin.assesor.form', [
            'title' => 'Edit Data: ' . $query->name,
            'action' => route('admin.assesor.update', $id),
            'isEdit' => true,
            'query' => $query,
            'users'     => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate input
        $request->validate([
            'user_id'       => 'required',
            'met'           => 'required',
            'name'          => 'required',
            'expired_date'  => 'required|date',
            'address'       => 'required',
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
        $query = UserAssesor::findOrFail($id);

        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.assesor.index')
            ->with('success', trans('action.success_update', [
                'name' => $dataInput['name']
            ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $query = UserAssesor::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
                'code' => 200,
                'success' => true,
        ], 200);
    }
}
