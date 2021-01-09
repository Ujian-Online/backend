<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SoalDataTable;
use App\Http\Controllers\Controller;
use App\Sertifikasi;
use App\Soal;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SoalDataTable $dataTables
     *
     * @return mixed
     */
    public function index(SoalDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Soal Lists'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {

        return view('admin.soal.form', [
            'title'         => 'Tambah Soal Paket Baru',
            'action'        => route('admin.soal.daftar.store'),
            'isCreated'     => true,
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
            'question'         => 'required',
            'question_type'    => 'required',
            'max_score'        => 'required|numeric',
        ]);

        // get form data
        $dataInput = $request->only([
            'question',
            'question_type',
            'max_score',
            'answer_essay',
            'answer_option'
        ]);

        // save to database
        $query = Soal::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.soal.daftar.index')
            ->with('success', trans('action.success', [
                'name' => $query->title
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
        // Find Data by ID
        $query = Soal::findOrFail($id);

        // return data to view
        return view('admin.soal.form', [
            'title'         => 'Tampilkan Detail: Pertanyaan ' . $query->id,
            'action'        => '#',
            'isShow'        => route('admin.soal.daftar.edit', $id),
            'query'         => $query,
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
        // Find Data by ID
        $query = Soal::findOrFail($id);

        // return data to view
        return view('admin.soal.form', [
            'title'         => 'Ubah Data: ' . $query->title,
            'action'        => route('admin.soal.daftar.update', $id),
            'isEdit'        => true,
            'query'         => $query,
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
            'question'         => 'required',
            'question_type'    => 'required',
            'max_score'        => 'required|numeric',
        ]);

        // get form data
        $dataInput = $request->only([
            'question',
            'question_type',
            'max_score',
            'answer_essay',
            'answer_option'
        ]);

        // find by id and update
        $query = Soal::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.soal.daftar.index')
            ->with('success', trans('action.success_update', [
                'name' => $query->id
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
        $query = Soal::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
