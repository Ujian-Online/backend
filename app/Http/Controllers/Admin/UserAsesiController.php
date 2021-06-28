<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\UserAsesi;
use App\UserAsesiCustomData;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Admin\UserAsesiDataTable;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UserAsesiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserAsesiDataTable $dataTables
     *
     * @return mixed
     */
    public function index(UserAsesiDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Asesi APL01 Lists',
            'filter_route' => route('admin.asesi.apl01.index'),
            'filter_view' => 'admin.assesi.filter-form'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        // get users list when not found in user asesi and type asesi
        $users = User::select('users.*')
            ->leftJoin('user_asesis', 'user_asesis.user_id', '=', 'users.id')
            ->where('users.type', 'asessi')
            ->whereNull('user_asesis.user_id')
            ->orderBy('users.id', 'desc')
            ->get();

        // return view template create
        return view('admin.assesi.form', [
            'title'     => 'Tambah Asesi APL-01',
            'action'    => route('admin.asesi.apl01.store'),
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
            'name'                  => 'required|min:3|max:255',
            'address'               => 'required|min:3|max:255',
            'phone_number'          => 'required|numeric',
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
            'name',
            'address',
            'phone_number',
            'gender',
            'birth_place',
            'birth_date',
            'no_ktp',
            'pendidikan_terakhir',
            'has_job',
            'job_title',
            'job_address',
            'company_name',
            'company_phone',
            'company_email',
            'is_verified',
            'verification_note',
        ]);

        // get user admin input
        $user_admin = $request->user();
        $dataInput['user_id_admin'] = $user_admin->id;

        // save to database
        UserAsesi::create($dataInput);

        // return redirect
        return redirect()
            ->route('admin.asesi.apl01.index', ['is_verified' => false])
            ->with('success', trans('action.success', [
                    'name' => $dataInput['name']
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     *
     * @return Application|Factory|Response|View
     */
    public function show(Request $request, int $id)
    {
        $query = new UserAsesi();

        // check if print mode or not
        $printMode = $request->input('print');
        $orderId = $request->input('order_id');
        if($printMode && $orderId) {
            // query get data with many relation
            $query = $query->with([
                    'asesicustomdata',
                    'singleorder',
                    'singleorder.sertifikasi',
                    'singleorder.sertifikasi.sertifikasiunitkompentensi',
                    'singleorder.sertifikasi.sertifikasiunitkompentensi.unitkompetensi',
                    'singleorder.tuk'
                ])
                ->select([
                    'user_asesis.*'
                ])
                ->join('orders', 'orders.asesi_id', '=', 'user_asesis.user_id')
                ->where('user_asesis.id', $id)
                ->where('orders.id', $orderId)
                ->firstOrFail();

            // get user detail
            $users = User::where('id', $query->user_id)->firstOrFail();
        } else {
            // query get data
            $query = $query->with([
                'asesicustomdata',
                'order',
                'order.sertifikasi',
                'order.tuk'
            ])
                ->where('id', $id)
                ->firstOrFail();

            // get user detail
            $users = User::where('id', $query->user_id)->get();
        }

        // return data to view
        return view($printMode ? 'admin.assesi.apl01-print' : 'admin.assesi.form', [
            'title'     => 'Detail Asesi APL-01: ' . $query->name,
            'action'    => '#',
            'isShow'    => route('admin.asesi.apl01.edit', $id),
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
        // query get data
        $query = UserAsesi::with('asesicustomdata')->where('id', $id)->firstOrFail();
        // get users list when not found in user asesi and type asesi
        $users = User::where('users.type', 'asessi')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.assesi.form', [
            'title'     => 'Ubah Asesi APL-01: ' . $query->name,
            'action'    => route('admin.asesi.apl01.update', $id),
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
            'name'                  => 'required|min:3|max:255',
            'address'               => 'required|min:3|max:255',
            'phone_number'          => 'required|numeric',
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
            'name',
            'address',
            'phone_number',
            'gender',
            'birth_place',
            'birth_date',
            'no_ktp',
            'pendidikan_terakhir',
            'has_job',
            'job_title',
            'job_address',
            'company_name',
            'company_phone',
            'company_email',
            'is_verified',
            'verification_note',
        ]);

        // get user admin input
        $user_admin = $request->user();
        $dataInput['user_id_admin'] = $user_admin->id;

        // custom data input update
        $customDatas = $request->input('asesicustomdata');
        if(!empty($customDatas)) {
            // loop data for update
            foreach($customDatas['id'] as $customData) {
                // get id from hidden form custom data
                $cd_id = (int) $customData;
                // get is verfieid by id
                $cd_is_verified = isset($customDatas['is_verified'][$cd_id]) ? $customDatas['is_verified'][$cd_id] : 0;
                // get verification_note by id
                $cd_verification_note = isset($customDatas['verification_note'][$cd_id]) ? $customDatas['verification_note'][$cd_id] : null;

                // update each fields
                UserAsesiCustomData::findOrFail($cd_id)
                    ->update([
                        'is_verified'       => $cd_is_verified,
                        'verification_note' => $cd_verification_note
                    ]);
            }
        }

        // update data
        $query = UserAsesi::findOrFail($id);
        $query->update($dataInput);

        return redirect()
            ->route('admin.asesi.apl01.index', ['is_verified' => false])
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
        $query = UserAsesi::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
                'code' => 200,
                'success' => true,
        ]);
    }
}
