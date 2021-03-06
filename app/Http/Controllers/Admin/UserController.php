<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\DataTables\Admin\UserDataTable;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserDataTable $dataTables
     *
     * @return mixed
     */
    public function index(UserDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title'         => 'User Lists',
            'filter_route'  => route('admin.user.index'),
            'filter_view'   => 'admin.user.filter-form',
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
        return view('admin.user.form', [
            'title'     => 'Add New User',
            'action'    => route('admin.user.store'),
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
            'email'             => 'required|max:255|email|unique:users,email',
            'password'          => 'required|min:6',
            'type'              => 'required|in:' . implode(',', config('options.user_type')),
            'status'            => 'required|in:' . implode(',', config('options.user_status')),
            'upload_profile'    => 'nullable|mimes:jpg,jpeg,png',
            'upload_sign'       => 'nullable|mimes:jpg,jpeg,png'
        ]);

        // get form data
        $dataInput = $request->only([
            'email',
            'password',
            'type',
            'status',
        ]);

        // Hash Password
        $dataInput['password'] = Hash::make($dataInput['password']);

        // upload file profile picture to s3
        if($request->file('upload_profile')) {
            $dataInput['media_url']  = upload_to_s3($request->file('upload_profile'));
        }

        // upload file ttd/paraf to s3
        if($request->file('upload_sign')) {
            $dataInput['media_url_sign_user']  = upload_to_s3($request->file('upload_sign'));
        }

        // save to database
        $user = User::create($dataInput);

        // set redirect url
        $redirect_route = route('admin.user.index');

        // check if user type is assesor or not
        if ($dataInput['type'] == 'assesor') {
            $redirect_route = route('admin.user.asesor.create', [
                'user_id' => $user->id
            ]);
        } elseif ($dataInput['type'] == 'tuk') {
            $redirect_route = route('admin.user.tuk.create', [
                'user_id' => $user->id
            ]);
        }

        // redirect to index table
        return redirect($redirect_route)
            ->with('success', trans('action.success', [
                    'name' => $dataInput['email']
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
     * @param int $id
     *
     * @return Application|Factory|Response|View
     */
    public function edit(int $id)
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
     * @param Request $request
     * @param int     $id
     *
     * @return RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        // validate input
        $request->validate([
            'email'             => 'required|max:255|email|unique:users,email,' . $id,
            'newpassword'       => 'nullable|min:6',
            'type'              => 'required|in:' . implode(',', config('options.user_type')),
            'status'            => 'required|in:' . implode(',', config('options.user_status')),
            'upload_profile'    => 'nullable|mimes:jpg,jpeg,png',
            'upload_sign'       => 'nullable|mimes:jpg,jpeg,png'
        ]);

        // get form data
        $dataInput = $request->only([
            'email',
            'newpassword',
            'type',
            'status',
        ]);

        // find by id and update
        $query = User::findOrFail($id);
        $query->email       = $dataInput['email'];
        $query->type        = $dataInput['type'];
        $query->status      = $dataInput['status'];

        // update password if new password field not empty
        if (isset($dataInput['newpassword']) and !empty($dataInput['newpassword'])) {
            $query->password = Hash::make($dataInput['newpassword']);
        }

        // upload file profile picture to s3
        if($request->file('upload_profile')) {
            $query->media_url = upload_to_s3($request->file('upload_profile'));
        }

        // upload file ttd/paraf to s3
        if($request->file('upload_sign')) {
            $query->media_url_sign_user = upload_to_s3($request->file('upload_sign'));
        }

        // update data
        $query->update();

        // redirect
        return redirect()
            ->route('admin.user.index')
            ->with('success', trans('action.success_update', [
                'name' => $dataInput['email']
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
        $query = User::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
                'code' => 200,
                'success' => true,
        ]);
    }

    /**
     * Select2 Ajax Search
     *
     * param :
     * q = query select2
     * type = user type
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        // database query
        $query = new User();
        // result variable
        $result = [];

        // get input from select2 search term
        $q = $request->input('q');

        // return empty object if query is empty
        if(empty($q)) {
            return response()->json($result, 200);
        }

        // type search query
        $type = $request->input('type');
        // type allowed
        $typeUser = ['asessi', 'assesor', 'tuk'];
        // check type allowed from default type search or using asesi
        $typeSearch = in_array($type, $typeUser) ? $type : 'asessi';

        // update query type
        $query = $query->where('users.type', $typeSearch);

        if($typeSearch == 'asessi') {
            $query = $query->leftJoin('user_asesis', 'user_asesis.user_id', '=', 'users.id')
            ->select([
                'users.id as id',
                'users.email as email',
                'user_asesis.id as asesi_id',
                'user_asesis.name as name'
            ])
            ->when($q, function($query) use ($q) {
                // check if query is numeric or not
                if(is_numeric($q)) {
                     return $query->where('users.id', 'like', "%$q%");
                } else {
                    return $query->where('user_asesis.name', 'like', "%$q%");
                }
            });
        } elseif($typeSearch == 'assesor') {
            $query = $query->leftJoin('user_asesors', 'user_asesors.user_id', '=', 'users.id')
                ->select([
                    'users.id as id',
                    'users.email as email',
                    'user_asesors.id as asesor_id',
                    'user_asesors.name as name'
                ])
                ->when($q, function($query) use ($q) {
                    // check if query is numeric or not
                    if(is_numeric($q)) {
                        return $query->where('users.id', 'like', "%$q%");
                    } else {
                        return $query->where('user_asesors.name', 'like', "%$q%");
                    }
                });
        } elseif($typeSearch == 'tuk') {
            $query = $query->leftJoin('user_tuks', 'user_tuks.user_id', '=', 'users.id')
                ->leftJoin('tuks', 'tuks.id', '=', 'user_tuks.tuk_id')
                ->select([
                    'users.id as id',
                    'users.email as name',
                    'user_tuks.id as usertuk_id',
                    'tuks.title as email'
                ])
                ->when($q, function($query) use ($q) {
                    // check if query is numeric or not
                    if(is_numeric($q)) {
                        return $query->where('users.id', 'like', "%$q%");
                    } else {
                        return $query->where('tuks.title', 'like', "%$q%");
                    }
                });
        }

        // check if data found or not
        if($query->count() != 0) {
            foreach($query->get() as $data) {
                $result[] = [
                    'id' => $data->id,
                    'text' => '[ID: ' . $data->id . '] - ' . $data->name . ' (' . $data->email .')',
                ];
            }
        }

        // response result
        return response()->json($result, 200);
    }
}
