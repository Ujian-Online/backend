<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UjianAsesiJawabanDataTable;
use App\Http\Controllers\Controller;
use App\Soal;
use App\UjianAsesiAsesor;
use App\UjianAsesiJawaban;
use App\UserAsesi;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UjianAsesiJawabanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UjianAsesiJawabanDataTable $dataTables
     *
     * @return mixed
     */
    public function index(UjianAsesiJawabanDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Jadwal Ujian Jawaban Lists',
            'filter_route'  => route('admin.ujian.jawaban.index'),
            'filter_view'   => 'admin.ujian.ujian-asesi-filter-form',
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
        return view('admin.ujian.jawaban-form', [
            'title'     => 'Tambah Ujian Jawaban Baru',
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
            'soal_id'       => 'required',
            'asesi_id'      => 'required',
            'question'      => 'required',
            'question_type' => 'required|in:' . implode(',', config('options.ujian_asesi_jawabans_question_type')),
            'urutan'        => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'soal_id',
            'asesi_id',
            'question',
            'question_type',
            'answer_essay',
            'answer_option',
            'urutan',
            'user_answer',
            'catatan_asesor',
            'max_score',
            'final_score',
        ]);

        // save to database
        $query = UjianAsesiJawaban::create($dataInput);

        // redirect to index table
        return redirect()
            ->route('admin.ujian.jawaban.index')
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
     * @return Application|Factory|View
     */
    public function show(Request $request, int $id)
    {
        // Find Data by ID
        $query = UjianAsesiAsesor::with([
            'userasesi',
            'userasesi.asesi',
            'userasesor',
            'userasesor.asesor',
            'ujianjadwal',
            'sertifikasi',
            'ujianasesijawaban',
            'ujianasesijawaban.soal',
            'ujianasesijawaban.soal.unitkompetensi',
            'soalpaket',
            'order',
            'order.tuk'
        ])->findOrFail($id);

        // uk soal
        $uk_soals = [];

        // pisahkan soal jawaban pilihan ganda dan essay kalau ada datanya
        $soal_pilihangandas = [];
        $soal_essays = [];
        $total_nilai = 0;
        $total_max = 0;
        if(isset($query->ujianasesijawaban) and !empty($query->ujianasesijawaban)) {
            foreach($query->ujianasesijawaban as $soal) {
                // unit kompetensi
                $uk_id = null;

                // save uk from soal detail
                if(isset($soal->soal) and !empty($soal->soal->unitkompetensi)) {
                    // get uk id
                    $uk_id = $soal->soal->unitkompetensi->id;

                    // save to uk soal
                    if(!isset($uk_soals[$uk_id])) {
                        $uk_soals[$uk_id] = $soal->soal->unitkompetensi->toArray();
                    }

                    // save soal to uk
                    if($soal->question_type == 'multiple_option') {
                        $uk_soals[$uk_id]['pilihan_ganda'][] = $soal;
                    } else {
                        $uk_soals[$uk_id]['essay'][] = $soal;
                    }
                }

                if($soal->question_type == 'multiple_option') {
                    // update object soal pilihan ganda
                    $soal_pilihangandas[] = $soal;

                    // update nilai asesi berdasarkan maxscore
                    $total_nilai += $soal->max_score;
                } else {
                    // update object soal essay
                    $soal_essays[] = $soal;

                    // update nilai asesi berdasarkan final_score
                    $total_nilai += $soal->final_score;
                }

                // update total max score semua soal
                $total_max += $soal->max_score;
            }
        }

        // print mode
        $printMode = $request->input('print') ? true : false;
        $pageView = 'asesor.ujian.penilaian-form';

        if($printMode) {
            $page = $request->input('page');

            if($page && $page == 'soal_pilihan_ganda') {
                $pageView = 'asesor.ujian.penilaian-print-pil-ganda';
            } else if($page && $page == 'jawaban_pilihan_ganda') {
                $pageView = 'asesor.ujian.penilaian-print-pil-ganda-jawaban';
            } else if($page && $page == 'jawaban_asesi_pilihan_ganda') {
                $pageView = 'asesor.ujian.penilaian-print-pil-ganda-jawaban-asesi';
            } else if($page && $page == 'soal_essay') {
                $pageView = 'asesor.ujian.penilaian-print-essay';
            } else if($page && $page == 'jawaban_essay') {
                $pageView = 'asesor.ujian.penilaian-print-essay-jawaban';
            } else if($page && $page == 'jawaban_asesi_essay') {
                $pageView = 'asesor.ujian.penilaian-print-essay-jawaban-asesi';
            }
        }

        // return data to view
        return view($pageView, [
            'title'                 => 'Ujian Asesi Detail: ' . $query->id,
            'action'                => '#',
            'isShow'                => false,
            'query'                 => $query,
            'soal_pilihangandas'    => $soal_pilihangandas,
            'soal_essays'           => $soal_essays,
            'total_nilai'           => $total_nilai,
            'total_max'             => $total_max,
            'uk_soals'              => $uk_soals,
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
        $query = UjianAsesiJawaban::findOrFail($id);
        // get soal lists
        $soals = Soal::all();
        // get asesi lists
        $asesis = UserAsesi::all();

        // return data to view
        return view('admin.ujian.jawaban-form', [
            'title'     => 'Ubah Data: ' . $query->question,
            'action'    => route('admin.ujian.jawaban.update', $id),
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
            'soal_id'       => 'required',
            'asesi_id'      => 'required',
            'question'      => 'required',
            'question_type' => 'required|in:' . implode(',', config('options.ujian_asesi_jawabans_question_type')),
            'urutan'        => 'required',
        ]);

        // get form data
        $dataInput = $request->only([
            'soal_id',
            'asesi_id',
            'question',
            'question_type',
            'answer_essay',
            'answer_option',
            'urutan',
            'user_answer',
            'catatan_asesor',
            'max_score',
            'final_score',
        ]);

        // find by id and update
        $query = UjianAsesiJawaban::findOrFail($id);
        // update data
        $query->update($dataInput);

        // redirect
        return redirect()
            ->route('admin.ujian.jawaban.index')
            ->with('success', trans('action.success', [
                'name' => $query->question
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
        $query = UjianAsesiJawaban::findOrFail($id);
        $query->delete();

        // return response json if success
        return response()->json([
            'code' => 200,
            'success' => true,
        ]);
    }
}
