<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SertifikasiUnitKompentensiDataTable;
use App\Http\Controllers\Controller;
use App\Sertifikasi;
use App\SertifikasiUnitKompentensi;
use App\SertifikasiUnitKompetensiElement;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SertifikasiUnitKompetensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SertifikasiUnitKompentensiDataTable $dataTables
     *
     * @return mixed
     */
    public function index(SertifikasiUnitKompentensiDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Sertifikasi Unit Kompetensi Lists',
            'filter_route' => route('admin.sertifikasi.uk.index'),
            'filter_view' => 'admin.sertifikasi-uk.filter-form',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();

        // return view template create
        return view('admin.sertifikasi-uk.form', [
            'title'         => 'Tambah Sertifikasi Unik Kompentensi Baru',
            'action'        => route('admin.sertifikasi.uk.store'),
            'isCreated'     => true,
            'sertifikasis'  => $sertifikasis,
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
            'order'                 => 'required',
            'sertifikasi_id'        => 'required',
            'kode_unit_kompetensi'  => 'required',
            'title'                 => 'required',
            'sub_title'             => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'order',
            'sertifikasi_id',
            'kode_unit_kompetensi',
            'title',
            'sub_title',
        ]);

        // save to database
        $query = SertifikasiUnitKompentensi::create($dataInput);

        /**
         * UK Element Save to Database Start
         */

        // uk element input
        $desc = $request->input('desc');
        $upload_instruction = $request->input('upload_instruction');

        // only save if description and upload instruction is found
        if(count($desc) != 0 and count($upload_instruction) != 0) {
            // merge array uk element
            $uk_element = [];
            foreach($desc as $key => $description) {
                $uk_element[] = [
                    'unit_kompetensi_id' => $query->id,
                    'desc' => $description,
                    'upload_instruction' => $upload_instruction[$key],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // save to database with insert for bulk
            SertifikasiUnitKompetensiElement::insert($uk_element);
        }

        /**
         * UK Element Save to Database End
         */

        // redirect to index table
        return redirect()
            ->route('admin.sertifikasi.uk.index')
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
        $query = SertifikasiUnitKompentensi::with('ukelement')->where('id', $id)->firstOrFail();
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();

        // return data to view
        return view('admin.sertifikasi-uk.form', [
            'title'         => 'Tampilkan Detail: ' . $query->title,
            'action'        => '#',
            'isShow'        => route('admin.sertifikasi.uk.edit', $id),
            'query'         => $query,
            'sertifikasis'  => $sertifikasis,
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
        $query = SertifikasiUnitKompentensi::with('ukelement')->where('id', $id)->firstOrFail();
        // get sertifikasi lists
        $sertifikasis = Sertifikasi::all();

        // return data to view
        return view('admin.sertifikasi-uk.form', [
            'title'         => 'Ubah Data: ' . $query->id,
            'action'        => route('admin.sertifikasi.uk.update', $id),
            'isEdit'        => true,
            'query'         => $query,
            'sertifikasis'  => $sertifikasis,
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
            'order'                 => 'required',
            'sertifikasi_id'        => 'required',
            'kode_unit_kompetensi'  => 'required',
            'title'                 => 'required',
            'sub_title'             => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'order',
            'sertifikasi_id',
            'kode_unit_kompetensi',
            'title',
            'sub_title',
        ]);

        // find by id and update
        $query = SertifikasiUnitKompentensi::findOrFail($id);
        // update data
        $query->update($dataInput);

        /**
         * UK Element Save to Database Start
         */

        // uk element input
        $desc = $request->input('desc');
        $upload_instruction = $request->input('upload_instruction');

        // merge array uk element
        $uk_element_new = [];
        $uk_element_update = [];
        $uk_element_delete = [];

        // loop all input
        foreach ($desc as $key => $description) {
            // array of data
            $uk_element = [
                'unit_kompetensi_id' => $id,
                'desc' => $description,
                'upload_instruction' => $upload_instruction[$key],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // explode key for get type input
            $splitKey = explode('-', $key);
            $typeID = $splitKey[0];
            $realID = $splitKey[1];

            if($typeID == 'new') {
                $uk_element_new[] = $uk_element;
            } else if($typeID == 'update') {
                $uk_element_update[$realID] = $uk_element;
            } else {
                $uk_element_delete[] = $realID;
            }
        }

        // run save new data in bulk
        SertifikasiUnitKompetensiElement::insert($uk_element_new);

        // run query update based on array
        foreach($uk_element_update as $uk_update_key => $uk_update) {
            // update uk element from database
            SertifikasiUnitKompetensiElement::where('id', $uk_update_key)
                ->update([
                    'desc' => $uk_update['desc'],
                    'upload_instruction' => $uk_update['upload_instruction']
                ]);
        }

        // run delete query in bulk
        SertifikasiUnitKompetensiElement::whereIn('id', $uk_element_delete)->delete();

        /**
         * UK Element Save to Database End
         */

        // redirect
        return redirect()
            ->route('admin.sertifikasi.uk.index')
            ->with('success', trans('action.success_update', [
                'name' => $query->title
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
        $query = SertifikasiUnitKompentensi::findOrFail($id);
        $query->delete();

        // delete UK Element too
        SertifikasiUnitKompetensiElement::where('unit_kompetensi_id', $id)->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
