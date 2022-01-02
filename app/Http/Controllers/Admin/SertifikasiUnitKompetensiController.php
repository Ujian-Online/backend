<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SertifikasiUnitKompentensiDataTable;
use App\DataTables\Asesor\UnitKompetensiDataTable;
use App\Http\Controllers\Controller;
use App\Sertifikasi;
use App\SertifikasiUnitKompentensi;
use App\SertifikasiUnitKompetensiElement;
use App\UnitKompetensi;
use App\UnitKompetensiElement;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
     * @return mixed
     */
    public function index(Request $request)
    {
        // get user login
        $user = $request->user();

        $dataTables = new SertifikasiUnitKompentensiDataTable();

        if($user->can("isAssesor")) {
            $dataTables = new UnitKompetensiDataTable();
        }

        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Unit Kompetensi Lists',
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
            'kode_unit_kompetensi'  => 'required',
            'jenis_standar'         => 'required',
            'title'                 => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'kode_unit_kompetensi',
            'title',
            'sub_title',
            'jenis_standar',
        ]);

        // save to database
        $query = UnitKompetensi::create($dataInput);

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
            UnitKompetensiElement::insert($uk_element);
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
     * @param Request $request
     * @param int $id
     *
     * @return Application|Factory|Builder|Model|Response|View
     */
    public function show(Request $request, int $id)
    {
        // Find Data by ID
        $query = UnitKompetensi::with('ukelement')->where('id', $id)->firstOrFail();

        // return json if request by ajax
        if($request->ajax()) {
            return $query;
        }

        // return data to view
        return view('admin.sertifikasi-uk.form', [
            'title'         => 'Detail: ' . $query->title,
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
        $query = UnitKompetensi::with('ukelement')->where('id', $id)->firstOrFail();

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
            'kode_unit_kompetensi'  => 'required',
            'jenis_standar'         => 'required',
            'title'                 => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'kode_unit_kompetensi',
            'title',
            'sub_title',
            'jenis_standar',
        ]);

        // find by id and update
        $query = UnitKompetensi::findOrFail($id);
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
        UnitKompetensiElement::insert($uk_element_new);

        // run query update based on array
        foreach($uk_element_update as $uk_update_key => $uk_update) {
            // update uk element from database
            UnitKompetensiElement::where('id', $uk_update_key)
                ->update([
                    'desc' => $uk_update['desc'],
                    'upload_instruction' => $uk_update['upload_instruction']
                ]);
        }

        // run delete query in bulk
        UnitKompetensiElement::whereIn('id', $uk_element_delete)->delete();

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
        $query = UnitKompetensi::findOrFail($id);
        $query->delete();

        // delete UK Element too
        UnitKompetensiElement::where('unit_kompetensi_id', $id)->delete();

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
        // result variable
        $result = [];

        // get input from select2 search term
        $q = $request->input('q');
        $skip = $request->input('skip');

        $query = UnitKompetensi::when($skip, function ($query) use ($skip) {
                return $query->whereNotIn('id', explode(',', $skip));
            })
            ->when($q, function ($query) use ($q) {
                // check if query is numeric or not
                if(is_numeric($q)) {
                    return $query->where('id', 'like', "%$q%")
                        ->orWhere('kode_unit_kompetensi', 'like', "%$q%");
                } else {
                    return $query->where('title', 'like', "%$q%")
                        ->orWhere('kode_unit_kompetensi', 'like', "%$q%");
                }
            });

        // check if data found or not
        if($query->count() != 0) {
            foreach($query->get() as $data) {
                // check if skip id is not null
                if(!empty($skip)) {
                    // if id not in array skip, then print result
                    if(!in_array($data->id, explode(',', $skip))) {
                        $result[] = [
                            'id' => $data->id,
                            'text' => '[ID: ' . $data->id . '] ' . $data->kode_unit_kompetensi . ' - ' .$data->title,
                        ];
                    }
                } else {
                    // return default if null
                    $result[] = [
                        'id' => $data->id,
                        'text' => '[ID: ' . $data->id . '] ' . $data->kode_unit_kompetensi . ' - ' .$data->title,
                    ];
                }

            }
        }

        // response result
        return response()->json($result, 200);
    }


    public function searchWithSertifikasi(Request $request)
    {
        // get input from select2 search term
        $q = $request->input('q');
        $sertifikasi_id = $request->input('sertifikasi_id');

        // database query
        $query = SertifikasiUnitKompentensi::select([
            'unit_kompetensis.id',
            'unit_kompetensis.title as unit_kompetensi_title',
            'unit_kompetensis.kode_unit_kompetensi as unit_kompetensi_kode',
            'sertifikasis.title as sertifikasi_title',
        ])
            ->join('sertifikasis', 'sertifikasis.id', '=', 'sertifikasi_unit_kompentensis.sertifikasi_id')
            ->join('unit_kompetensis', 'unit_kompetensis.id', '=', 'sertifikasi_unit_kompentensis.unit_kompetensi_id')
            ->when($sertifikasi_id, function($query) use ($sertifikasi_id) {
                $query->where('sertifikasi_unit_kompentensis.sertifikasi_id', $sertifikasi_id);
            })
            ->when($q, function($query) use ($q) {
                if(is_numeric($q)) {
                    $query->where('sertifikasi_unit_kompentensis.id', $q)
                        ->orWhere('sertifikasis.id', $q);
                } else {
                    $query->where('unit_kompetensis.title', 'like', '%' . $q . '%')
                        ->orWhere('unit_kompetensis.kode_unit_kompetensi', 'like', '%' . $q . '%')
                        ->orWhere('sertifikasis.title', 'like', '%' . $q . '%');
                }
            });

        // result variable
        $result = [];

        // check if data found or not
        if($query->count() != 0) {
            foreach($query->get() as $data) {
                $sertifikasi = $sertifikasi_id ? null : $data->sertifikasi_title . ' - ';

                $result[] = [
                    'id' => $data->id,
                    'text' => $sertifikasi . $data->unit_kompetensi_title . ' [' . $data->unit_kompetensi_kode . ']',
                ];
            }
        }

        // response result
        return response()->json($result, 200);
    }
}
