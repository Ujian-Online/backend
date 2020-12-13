<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\DataTables\Admin\UserDataTable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'User Lists'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view template create
        return view('admin.user.form', [
            'title'     => 'Add New User',
            'action'    => route('admin.user.store'),
            'isCreated' => true,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // validate input
        $request->validate([
            'name'      => 'required|min:3|max:255',
            'email'     => 'required|max:255|email|unique:users,email',
            'password'  => 'required|min:6',
            'type'      => 'required|in:' . implode(',', config('options.user_type')),
            'status'    => 'required|in:' . implode(',', config('options.user_status')),
            'is_active' => 'required|boolean',
        ]);

        // get form data
        $dataInput = $request->only([
            'name',
            'email',
            'password',
            'type',
            'status',
            'media_url',
            'is_active'
        ]);

        // save to database
        User::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.user.index')
            ->with(
                'success',
                trans(
                    'action.success',
                    [
                        'name' => $dataInput['name']
                    ]
                )
            );
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
        $query = User::findOrFail($id);

        // return data to view
        return view('admin.user.form', [
            'title'     => 'Show Detail: ' . $query->name,
            'action'    => '#',
            'isShow'    => route('admin.user.edit', $id),
            'query'     => $query,
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
        $query = User::findOrFail($id);

        // return data to view
        return view('admin.user.form', [
            'title' => 'Edit Data: ' . $query->name,
            'action' => route('admin.user.update', $id),
            'isEdit' => true,
            'query' => $query,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // validate input
        $request->validate([
            'name'          => 'required|min:3|max:255',
            'email'         => 'required|max:255|email|unique:users,email,' . $id,
            'newpassword'   => 'nullable|min:6',
            'type'          => 'required|in:' . implode(',', config('options.user_type')),
            'status'        => 'required|in:' . implode(',', config('options.user_status')),
            'is_active'     => 'required|boolean',
        ]);

        // get form data
        $dataInput = $request->only(['name', 'email', 'newpassword', 'role', 'status']);

        // find by uuid and update
        $query = User::where('uuid', $id)->firstOrFail();
        $query->name = $dataInput['name'];
        $query->email = $dataInput['email'];
        $query->role = $dataInput['role'];
        $query->status = $dataInput['status'];

        // update password if new password field not empty
        if (isset($dataInput['newpassword']) and !empty($dataInput['newpassword'])) {
            $query->password = Hash::make($dataInput['newpassword']);
        }

        // update data
        $query->update();

        // redirect
        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Data berhasil diupdate.!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $query = User::findOrFail($id);
        $query->delete();

        return response()->json(
            [
                'code' => 200,
                'success' => true,
            ],
            200
        );
    }
}
