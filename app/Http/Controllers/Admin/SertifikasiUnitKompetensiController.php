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
        // return view template create
        return view('admin.sertifikasi-uk.form', [
            'title'         => 'Tambah Sertifikasi Unik Kompentensi Baru',
            'action'        => route('admin.sertifikasi.uk.store'),
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
            'order'                 => 'required',
            'sertifikasi_id'        => 'required',
            'kode_unit_kompetensi'  => 'required',
            'title'                 => 'required',
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
        if(isset($desc) and !empty($desc) and isset($upload_instruction) and !empty($upload_instruction)) {
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

        // default redirect route
        $redirectRoute = route('admin.sertifikasi.uk.index');

        // route check if sertifikasi_id found
        $sertifikasi_id = $request->input('sertifikasi_id');
        if(!empty($request->input('sertifikasi_id'))) {
            $redirectRoute = route('admin.sertifikasi.uk.index', ['sertifikasi_id' => $sertifikasi_id]);
        }

        // redirect to index table
        return redirect($redirectRoute)
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

        // return data to view
        return view('admin.sertifikasi-uk.form', [
            'title'         => 'Tampilkan Detail: ' . $query->title,
            'action'        => '#',
            'isShow'        => route('admin.sertifikasi.uk.edit', $id),
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
        $query = SertifikasiUnitKompentensi::with('ukelement')->where('id', $id)->firstOrFail();

        // return data to view
        return view('admin.sertifikasi-uk.form', [
            'title'         => 'Ubah Data: ' . $query->id,
            'action'        => route('admin.sertifikasi.uk.update', $id),
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
            'order'                 => 'required',
            'sertifikasi_id'        => 'required',
            'kode_unit_kompetensi'  => 'required',
            'title'                 => 'required',
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

    /**
     * Select2 Search Data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        // database query
        $query = new SertifikasiUnitKompentensi();
        // result variable
        $result = [];

        // get input from select2 search term
        $q = $request->input('q');
        // sertifikasi query
        $sertifikasi_id = $request->input('sertifikasi_id');

        // return empty object if query is empty
        if(empty($q)) {
            return response()->json($result, 200);
        }

        // check if query is numeric or not
        if(is_numeric($q)) {

            // cari sertifikasi id kalau di query statusnya true atau 1
            if($sertifikasi_id) {
                $query = $query->where('sertifikasi_id', $q);
            } else {
                // cari hanya id unit kompetensi
                $query = $query->where('id', 'like', "%$q%");
            }

        } else {
            $query = $query->where('title', 'like', "%$q%");
        }

        // check if data found or not
        if($query->count() != 0) {
            foreach($query->get() as $data) {
                $result[] = [
                    'id' => $data->id,
                    'text' => '[ID: ' . $data->id . '] - ' . $data->title,
                ];
            }
        }

        // response result
        return response()->json($result, 200);
    }


    public function searchWithSertifikasi(Request $request)
    {
        // get input from select2 search term
        $q = $request->input('q');

        // database query
        $query = SertifikasiUnitKompentensi::select([
            'sertifikasi_unit_kompentensis.id',
            'sertifikasi_unit_kompentensis.title as unit_kompetensi_title',
            'sertifikasis.title as sertifikasi_title',
        ])
            ->leftJoin('sertifikasis', 'sertifikasis.id', '=', 'sertifikasi_unit_kompentensis.sertifikasi_id')
            ->when($q, function($query) use ($q) {
                if(is_numeric($q)) {
                    $query->where('sertifikasi_unit_kompentensis.id', $q);
                } else {
                    $query->where('sertifikasi_unit_kompentensis.title', 'like', '%' . $q . '%')
                            ->orWhere('sertifikasis.title', 'like', '%' . $q . '%');
                }
            });

        // result variable
        $result = [];

        // check if data found or not
        if($query->count() != 0) {
            foreach($query->get() as $data) {
                $result[] = [
                    'id' => $data->id,
                    'text' => $data->sertifikasi_title . ' - ' . $data->unit_kompetensi_title,
                ];
            }
        }

        // response result
        return response()->json($result, 200);
    }
}
