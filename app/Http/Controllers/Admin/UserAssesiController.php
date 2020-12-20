<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\UserAssesi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Admin\UserAssesiDataTable;

class UserAssesiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\Admin\UserAssesiDataTable $dataTables
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserAssesiDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Assesi'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        // return view template create
        return view('admin.assesi.form', [
            'title'     => 'Tambah Assesi Baru',
            'action'    => route('admin.assesi.store'),
            'isCreated' => true,
            'users' => $users
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
        $request->validate([
            'user_id' => 'required|integer',
            'user_id_admin' => 'required|integer',
            'name' => 'required|min:3|max:255',
            'address' => 'required|min:3|max:255',
            'gender' => 'required|boolean',
            'birth_place' => 'required|min:3|max:225',
            'birth_date' => 'required|date',
            'no_ktp' => 'required|digits:16',
            'pendidikan_terakhir' => 'required|in:' . implode(',', config('options.user_assesi_pendidikan_terakhir')),
            'has_job' => 'required|boolean',
            'is_verified' => 'required|boolean',
        ]);

        // get form data
        $dataInput = $request->only([
            'user_id',
            'user_id_admin',
            'name',
            'address',
            'gender',
            'birth_place',
            'birth_date',
            'no_ktp',
            'pendidikan_terakhir',
            'has_job',
            'job_title',
            'job_address',
            'verification_note',
            'note_admin',
            'is_verified',
            'media_url_sign_user',
            'media_url_sign_admin'
        ]);

        UserAssesi::create($dataInput);

        return redirect()
            ->route('admin.assesi.index')
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
        $users = User::orderBy('created_at', 'desc')->get();
        $query = UserAssesi::findOrFail($id);

        // return data to view
        return view('admin.assesi.form', [
            'title'     => 'Show Detail: ' . $query->name,
            'action'    => '#',
            'isShow'    => route('admin.assesi.edit', $id),
            'query'     => $query,
            'users'     => $users
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
        $users = User::orderBy('created_at', 'desc')->get();
        $query = UserAssesi::findOrFail($id);

        return view('admin.assesi.form', [
            'title'     => 'Edit Data: ' . $query->name,
            'action'    => route('admin.assesi.update', $id),
            'isEdit'    => true,
            'query'     => $query,
            'users'     => $users
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
        $request->validate([
            'user_id' => 'required|integer',
            'user_id_admin' => 'required|integer',
            'name' => 'required|min:3|max:255',
            'address' => 'required|min:3|max:255',
            'gender' => 'required|boolean',
            'birth_place' => 'required|min:3|max:225',
            'birth_date' => 'required|date',
            'no_ktp' => 'required|digits:16',
            'pendidikan_terakhir' => 'required|in:' . implode(',', config('options.user_assesi_pendidikan_terakhir')),
            'has_job' => 'required|boolean',
            'is_verified' => 'required|boolean',
        ]);

        // get form data
        $dataInput = $request->only([
            'user_id',
            'user_id_admin',
            'name',
            'address',
            'gender',
            'birth_place',
            'birth_date',
            'no_ktp',
            'pendidikan_terakhir',
            'has_job',
            'job_title',
            'job_address',
            'verification_note',
            'note_admin',
            'is_verified',
            'media_url_sign_user',
            'media_url_sign_admin'
        ]);

        $query = UserAssesi::findOrFail($id);
        $query->user_id = $dataInput['user_id'];
        $query->user_id_admin = $dataInput['user_id_admin'];
        $query->name = $dataInput['name'];
        $query->address = $dataInput['address'];
        $query->gender = $dataInput['gender'];
        $query->birth_place = $dataInput['birth_place'];
        $query->birth_date = $dataInput['birth_date'];
        $query->no_ktp = $dataInput['no_ktp'];
        $query->pendidikan_terakhir = $dataInput['pendidikan_terakhir'];
        $query->has_job = $dataInput['has_job'];
        $query->job_title = $dataInput['job_title'];
        $query->job_address = $dataInput['job_address'];
        $query->verification_note = $dataInput['verification_note'];
        $query->note_admin = $dataInput['note_admin'];
        $query->is_verified = $dataInput['is_verified'];
        $query->media_url_sign_user = $dataInput['media_url_sign_user'];
        $query->media_url_sign_admin = $dataInput['media_url_sign_admin'];

        $query->update();

        return redirect()
            ->route('admin.assesi.index')
            ->with('success', trans('action.success_update', [
                'name' => $dataInput['name']
            ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = UserAssesi::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
                'code' => 200,
                'success' => true,
        ], 200);
    }
}
