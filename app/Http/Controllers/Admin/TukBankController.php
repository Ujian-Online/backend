<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\TukBankDataTable;
use App\Http\Controllers\Controller;
use App\Tuk;
use App\TukBank;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class TukBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param TukBankDataTable $dataTables
     *
     * @return mixed
     */
    public function index(Request $request, TukBankDataTable $dataTables)
    {
        // get user login
        $user = $request->user();
        // change index if loggin by tuk
        if($user->can('isTuk')) {
            $dataTables = new \App\DataTables\Tuk\TukBankDataTable();
            return $dataTables->render('layouts.pageTable', [
                'title' => 'TUK Bank Lists',
            ]);
        }

        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title'         => 'TUK Bank Lists',
            'filter_route'  => route('admin.tuk.bank.index'),
            'filter_view'   => 'admin.tuk.filter-form',
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
        return view('admin.tuk.bank-form', [
            'title'     => 'Tambah TUK Bank Baru',
            'action'    => route('admin.tuk.bank.store'),
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
            'bank_name'         => 'required',
            'account_number'    => 'required',
            'account_name'      => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'tuk_id',
            'bank_name',
            'account_number',
            'account_name',
        ]);

        // filter if loggin by tuk
        $user = $request->user();
        if($user->can('isTuk')) {
            $tuk = $user->tuk->tuk_id;
            $dataInput['tuk_id'] = $tuk;
        }

        // save to database
        TukBank::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.tuk.bank.index')
            ->with('success', trans('action.success', [
                'name' => 'Bank ' . $dataInput['bank_name'] . ' - ' . $dataInput['account_name']
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
        // filter if loggin by tuk
        $user = $request->user();

        // Find User by ID
        $query = TukBank::findOrFail($id);

        // check access by tuk
        if($user->can('isTuk')) {
            $tuk = $user->tuk->tuk_id;

            // throw error if tuk_id not same
            if($query->tuk_id != $tuk) {
                abort(403);
            }
        }

        // return data to view
        return view('admin.tuk.bank-form', [
            'title'     => 'Tampilkan Detail: ' . $query->bank_name . ': ' .
                $query->account_name,
            'action'    => '#',
            'isShow'    => route('admin.tuk.bank.edit', $id),
            'query'     => $query,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param int $id
     *
     * @return Application|Factory|Response|View
     */
    public function edit(Request $request, int $id)
    {
        // filter if loggin by tuk
        $user = $request->user();

        // Find User by ID
        $query = TukBank::findOrFail($id);

        // check access by tuk
        if($user->can('isTuk')) {
            $tuk = $user->tuk->tuk_id;

            // throw error if tuk_id not same
            if($query->tuk_id != $tuk) {
                abort(403);
            }
        }

        // return data to view
        return view('admin.tuk.bank-form', [
            'title'     => 'Ubah Data: ' . $query->bank_name . ': ' .
                $query->account_name,
            'action'    => route('admin.tuk.bank.update', $id),
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
        // filter if loggin by tuk
        $user = $request->user();

        // validate input
        $request->validate([
            'tuk_id'            => 'required',
            'bank_name'         => 'required',
            'account_number'    => 'required',
            'account_name'      => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'tuk_id',
            'bank_name',
            'account_number',
            'account_name',
        ]);

        // find by id and update
        $query = TukBank::findOrFail($id);

        // filter by tuk_id
        if($user->can('isTuk')) {
            // get tuk id
            $tuk = $user->tuk->tuk_id;
            // update inpjut
            $dataInput['tuk_id'] = $tuk;

            // throw error if tuk_id not same
            if($query->tuk_id != $tuk) {
                abort(403);
            }
        }

        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.tuk.bank.index')
            ->with('success', trans('action.success_update', [
                'name' => 'Bank ' . $dataInput['bank_name'] . ' - ' .
                    $dataInput['account_name']
            ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        // filter if loggin by tuk
        $user = $request->user();

        // query tukbank
        $query = TukBank::findOrFail($id);

        // filter by tuk_id
        if($user->can('isTuk')) {
            // get tuk id
            $tuk = $user->tuk->tuk_id;

            // throw error if tuk_id not same
            if($query->tuk_id != $tuk) {
                abort(403);
            }
        }

        // query delete
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
