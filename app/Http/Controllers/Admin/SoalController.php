<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SoalDataTable;
use App\Http\Controllers\Controller;
use App\Soal;
use App\SoalPilihanGanda;
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
            'unit_kompetensi_id' => 'required',
            'question'      => 'required',
            'question_type' => 'required',
            'max_score'     => 'required|numeric',
            'answer_essay'  => 'nullable|required_if:question_type,essay',
            'answer_option' => 'nullable|required_if:question_type,multiple_option',
            'option_a'      => 'nullable|required_if:question_type,multiple_option',
            'option_b'      => 'nullable|required_if:question_type,multiple_option',
            'option_c'      => 'nullable|required_if:question_type,multiple_option',
            'option_d'      => 'nullable|required_if:question_type,multiple_option',
        ]);

        // get form data
        $dataInput = $request->only([
            'unit_kompetensi_id',
            'question',
            'question_type',
            'max_score',
            'answer_essay',
            'answer_option'
        ]);

        // get user login, and set asesor_id if loggin by asesor
        $user = $request->user();
        if($user->can('isAssesor')) {
            $dataInput['asesor_id'] = $user->id;
        }

        // save to database
        $query = Soal::create($dataInput);

        // pilihan ganda check and create data
        if($dataInput['question_type'] == 'multiple_option') {
            $pilihanGandas = [
                [
                    'soal_id'       => $query->id,
                    'option'        => $request->input('option_a'),
                    'label'         => 'A',
                    'created_at'    => now(),
                    'updated_at'    => now()
                ],
                [
                    'soal_id'       => $query->id,
                    'option'        => $request->input('option_b'),
                    'label'         => 'B',
                    'created_at'    => now(),
                    'updated_at'    => now()
                ],
                [
                    'soal_id'       => $query->id,
                    'option'        => $request->input('option_c'),
                    'label'         => 'C',
                    'created_at'    => now(),
                    'updated_at'    => now()
                ],
                [
                    'soal_id'       => $query->id,
                    'option'        => $request->input('option_d'),
                    'label'         => 'D',
                    'created_at'    => now(),
                    'updated_at'    => now()
                ],
            ];

            // bulk save to pilihan ganda
            SoalPilihanGanda::insert($pilihanGandas);
        }

        // redirect to index table
        return redirect()
            ->route('admin.soal.daftar.index')
            ->with('success', trans('action.success', [
                'name' => $query->question
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     *
     * @return Application|Factory|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|JsonResponse|View
     */
    public function show(Request $request, int $id)
    {
        // Find Data by ID
        $query = Soal::with('soalpilihanganda')->where('id', $id)->firstOrFail();

        // return as json if request by ajax
        if($request->ajax()) {
            return $query;
        }

        // pilihan ganda convert to array
        $pilihangandas = [];
        if(isset($query->soalpilihanganda) and !empty($query->soalpilihanganda)) {
            foreach($query->soalpilihanganda as $pilihanganda) {
                $pilihangandas[strtolower($pilihanganda->label)] = $pilihanganda;
            }
        }

        // return data to view
        return view('admin.soal.form', [
            'title'         => 'Tampilkan Detail: Pertanyaan ' . $query->id,
            'action'        => '#',
            'isShow'        => route('admin.soal.daftar.edit', $id),
            'query'         => $query,
            'pilihangandas' => $pilihangandas,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param int $id
     *
     * @return Application|Factory|RedirectResponse|Response|View
     */
    public function edit(Request $request, int $id)
    {
        // Find Data by ID
        $query = Soal::with('soalpilihanganda')->where('id', $id)->firstOrFail();

        // get user login, and get asesor_id if loggin by asesor
        $user = $request->user();
        if($user->can('isAssesor') and $query->asesor_id != $user->id) {
            return redirect()->route('admin.soal.daftar.index')->withErrors('Anda tidak memiliki akses ke soal: [ID: ' . $query->id . '] ' . $query->question);
        }

        // pilihan ganda convert to array
        $pilihangandas = [];
        foreach($query->soalpilihanganda as $pilihanganda) {
            $pilihangandas[strtolower($pilihanganda->label)] = $pilihanganda;
        }

        // return data to view
        return view('admin.soal.form', [
            'title'         => 'Ubah Data: ' . $query->title,
            'action'        => route('admin.soal.daftar.update', $id),
            'isEdit'        => true,
            'query'         => $query,
            'pilihangandas' => $pilihangandas,
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
            'unit_kompetensi_id' => 'required',
            'question'      => 'required',
            'max_score'     => 'required|numeric',
            'answer_essay'  => 'nullable|required_if:question_type,essay',
            'answer_option' => 'nullable|required_if:question_type,multiple_option',
            'option_a'      => 'nullable|required_if:question_type,multiple_option',
            'option_b'      => 'nullable|required_if:question_type,multiple_option',
            'option_c'      => 'nullable|required_if:question_type,multiple_option',
            'option_d'      => 'nullable|required_if:question_type,multiple_option',
        ]);

        // get form data
        $dataInput = $request->only([
            'unit_kompetensi_id',
            'question',
            'max_score',
            'answer_essay',
            'answer_option'
        ]);

        // find by id and update
        $query = Soal::findOrFail($id);

        // get user login, and get asesor_id if loggin by asesor
        $user = $request->user();
        if($user->can('isAssesor') and $query->asesor_id != $user->id) {
            return redirect()->route('admin.soal.daftar.index')->withErrors('Anda tidak memiliki akses ke soal: [ID: ' . $query->id . '] ' . $query->question);
        }

        // update data
        $query->update($dataInput);

        // pilihan ganda check and update data
        if($query->question_type == 'multiple_option') {
            // update option A
            SoalPilihanGanda::where('soal_id', $id)
                ->where('label', 'A')
                ->update([
                    'option'=> $request->input('option_a')
                ]);

            // update option B
            SoalPilihanGanda::where('soal_id', $id)
                ->where('label', 'B')
                ->update([
                    'option'=> $request->input('option_b')
                ]);

            // update option C
            SoalPilihanGanda::where('soal_id', $id)
                ->where('label', 'C')
                ->update([
                    'option'=> $request->input('option_c')
                ]);

            // update option D
            SoalPilihanGanda::where('soal_id', $id)
                ->where('label', 'D')
                ->update([
                    'option'=> $request->input('option_d')
                ]);
        }

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
     * @param Request $request
     * @param int $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        // get user login
        $user = $request->user();

        // find data by id
        $query = Soal::findOrFail($id);

        // delete query based on asesor id if login by asesor
        if($user->can('isAssesor') and $query->asesor_id != $user->id) {
            return response()->json([
                'message' => 'Anda tidak memiliki akses ke soal: [ID: ' . $query->id . '] ' . $query->question
            ], 403);
        }

        // run delete data query
        $query->delete();

        // delete on soalpilihanganda too
        SoalPilihanGanda::where('soal_id', $id)->delete();

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
     *
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        // database query
        $query = Soal::select(['soals.*'])
            ->leftJoin('sertifikasi_unit_kompentensis', 'sertifikasi_unit_kompentensis.id', '=', 'soals.unit_kompetensi_id')
            ->leftJoin('sertifikasis', 'sertifikasis.id', '=', 'sertifikasi_unit_kompentensis.sertifikasi_id');

        // result variable
        $result = [];

        // get input from select2 search term
        $q = $request->input('q');
        $type = $request->input('type');
        $skip = $request->input('skip');
        $sertifikasi_id = $request->input('sertifikasi_id');

        // return empty object if query is empty
        if(!empty($q) and is_numeric($q)) {
            $query = $query->where('soals.id', 'like', "%$q%");
        } else {
            $query = $query->where('soals.question', 'like', "%$q%");
        }

        // filter by type
        if(!empty($type)) {
            $questionType = ($type == 'multiple_option') ? 'multiple_option' : 'essay';
            $query = $query->where('soals.question_type', $questionType);
        }

        // exclude or skip by id
        if(!empty($skip)) {
            $query = $query->whereNotIn('soals.id', explode(',', $skip));
        }

        // search by sertifikasi id
        if(!empty($sertifikasi_id)) {
            $query = $query->where('sertifikasis.id', $sertifikasi_id);
        }

        // check if data found or not
        if($query->count() != 0) {
            foreach($query->get() as $data) {
                $result[] = [
                    'id' => $data->id,
                    'text' => '[ID: ' . $data->id . '] - ' . $data->question,
                ];
            }
        }

        // response result
        return response()->json($result, 200);
    }
}
