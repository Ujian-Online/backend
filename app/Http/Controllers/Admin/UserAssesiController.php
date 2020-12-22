<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\UserAssesi;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Admin\UserAssesiDataTable;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UserAssesiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserAssesiDataTable $dataTables
     *
     * @return mixed
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
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        $users = User::orderBy('created_at', 'desc')->get();

        // return view template create
        return view('admin.assesi.form', [
            'title'     => 'Tambah Assesi Baru',
            'action'    => route('admin.assesi.store'),
            'isCreated' => true,
            'users'     => $users
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
        $request->validate([
            'user_id'               => 'required|integer',
            'user_id_admin'         => 'required|integer',
            'name'                  => 'required|min:3|max:255',
            'address'               => 'required|min:3|max:255',
            'gender'                => 'required|boolean',
            'birth_place'           => 'required|min:3|max:225',
            'birth_date'            => 'required|date',
            'no_ktp'                => 'required|digits:16',
            'pendidikan_terakhir'   => 'required|in:' . implode(',', config('options.user_assesi_pendidikan_terakhir')),
            'has_job'               => 'required|boolean',
            'is_verified'           => 'required|boolean',
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
            'is_verified'
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
     * @param int $id
     *
     * @return Application|Factory|Response|View
     */
    public function show(int $id)
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
     * @param int $id
     *
     * @return Application|Factory|Response|View
     */
    public function edit(int $id)
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
     * @param Request $request
     * @param int     $id
     *
     * @return RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'user_id'               => 'required|integer',
            'user_id_admin'         => 'required|integer',
            'name'                  => 'required|min:3|max:255',
            'address'               => 'required|min:3|max:255',
            'gender'                => 'required|boolean',
            'birth_place'           => 'required|min:3|max:225',
            'birth_date'            => 'required|date',
            'no_ktp'                => 'required|digits:16',
            'pendidikan_terakhir'   => 'required|in:' . implode(',', config('options.user_assesi_pendidikan_terakhir')),
            'has_job'               => 'required|boolean',
            'is_verified'           => 'required|boolean',
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
            'is_verified'
        ]);

        $query = UserAssesi::findOrFail($id);
        $query->update($dataInput);

        return redirect()
            ->route('admin.assesi.index')
            ->with('success', trans('action.success_update', [
                'name' => $dataInput['name']
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
    public function destroy($id): JsonResponse
    {
        $query = UserAssesi::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
                'code' => 200,
                'success' => true,
        ]);
    }
}
