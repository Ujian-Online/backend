<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UjianAsesiJawabanPilihanDataTable;
use App\Http\Controllers\Controller;
use App\Soal;
use App\UjianAsesiJawabanPilihan;
use App\UserAsesi;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UjianAsesiJawabanPilihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UjianAsesiJawabanPilihanDataTable $dataTables
     *
     * @return mixed
     */
    public function index(UjianAsesiJawabanPilihanDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Ujian Asesi Jawaban Pilihan Lists'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        // get soal lists
        $soals = Soal::all();
        // get asesi lists
        $asesis = UserAsesi::all();

        // return view template create
        return view('admin.ujian.jawabanpilihan-form', [
            'title'     => 'Tambah Ujian Asesi Jawaban Pilihan Baru',
            'action'    => route('admin.ujian.jawaban.store'),
            'isCreated' => true,
            'soals'     => $soals,
            'asesis'    => $asesis,
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
            'soal_id'   => 'required',
            'asesi_id'  => 'required',
            'option'    => 'required',
            'label'     => 'required|in:' . implode(',', config('options.ujian_asesi_jawaban_pilihans_label')),
        ]);

        // get form data
        $dataInput = $request->only([
            'soal_id',
            'asesi_id',
            'option',
            'label',
        ]);

        // save to database
        $query = UjianAsesiJawabanPilihan::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.ujian.jawabanpilihan.index')
            ->with('success', trans('action.success', [
                'name' => $query->id
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
        $query = UjianAsesiJawabanPilihan::findOrFail($id);
        // get soal lists
        $soals = Soal::all();
        // get asesi lists
        $asesis = UserAsesi::all();

        // return data to view
        return view('admin.ujian.jawabanpilihan-form', [
            'title'     => 'Tampilkan Detail: ' . $query->question,
            'action'    => '#',
            'isShow'    => route('admin.ujian.jawabanpilihan.edit', $id),
            'query'     => $query,
            'soals'     => $soals,
            'asesis'    => $asesis,
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
        $query = UjianAsesiJawabanPilihan::findOrFail($id);
        // get soal lists
        $soals = Soal::all();
        // get asesi lists
        $asesis = UserAsesi::all();

        // return data to view
        return view('admin.ujian.jawabanpilihan-form', [
            'title'     => 'Ubah Data: ' . $query->id,
            'action'    => route('admin.ujian.jawabanpilihan.update', $id),
            'isEdit'    => true,
            'query'     => $query,
            'soals'     => $soals,
            'asesis'    => $asesis,
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
            'soal_id'   => 'required',
            'asesi_id'  => 'required',
            'option'    => 'required',
            'label'     => 'required|in:' . implode(',', config('options.ujian_asesi_jawaban_pilihans_label')),
        ]);

        // get form data
        $dataInput = $request->only([
            'soal_id',
            'asesi_id',
            'option',
            'label',
        ]);

        // find by id and update
        $query = UjianAsesiJawabanPilihan::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.ujian.jawabanpilihan.index')
            ->with('success', trans('action.success', [
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
        $query = UjianAsesiJawabanPilihan::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
