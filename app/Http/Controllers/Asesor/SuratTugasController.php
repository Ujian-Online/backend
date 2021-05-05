<?php

namespace App\Http\Controllers\Asesor;

use App\DataTables\Asesor\SuratTugasDataTable;
use App\Http\Controllers\Controller;
use App\SoalPaket;
use App\UjianAsesiAsesor;
use App\UjianAsesiJawaban;
use Illuminate\Http\Request;

class SuratTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SuratTugasDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Surat Tugas Lists',
            'filter_route'  => route('admin.surat-tugas.index'),
            'filter_view'   => 'admin.ujian.filter-form',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        // get user login
        $user = $request->user();

        // Find Data by ID
        $query = UjianAsesiAsesor::with([
            'userasesi',
            'userasesi.asesi',
            'userasesor',
            'userasesor.asesor',
            'ujianjadwal',
            'sertifikasi',
            'order',
            'order.tuk'
        ])
            ->where('id', $id)
            ->where('asesor_id', $user->id)
            ->firstOrFail();

        // print mode
        $printMode = $request->input('print') ? true : false;
        $pageView = 'admin.ujian.asesi-form';

        if($printMode) {
            $pageView = 'admin.ujian.persetujuan-asesi-print';
        }

        // return data to view
        return view($pageView, [
            'title'         => 'Tampilkan Detail: ' . $query->id,
            'action'        => '#',
            'isShow'        => route('admin.surat-tugas.edit', $id),
            'query'         => $query,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        // Find Data by ID
        $query = UjianAsesiAsesor::findOrFail($id);

        // return data to view
        return view('admin.ujian.asesi-form', [
            'title'         => 'Ubah Data: ' . $query->id,
            'action'        => route('admin.surat-tugas.update', $id),
            'isEdit'        => true,
            'query'         => $query,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // find by id and update
        $query = UjianAsesiAsesor::findOrFail($id);
        $updateData = [];

        // validasi jika status menunggu
        if(in_array($query->status, [ 'menunggu', 'paket_soal_assigned' ])) {
            // validate input
            $request->validate([
                'soal_paket_id' => 'required'
            ]);

            // update data
            $updateData = [
                'soal_paket_id' => $request->input('soal_paket_id'),
                'status' => 'paket_soal_assigned'
            ];

            // get soal from soalpaket for snapshot
            $soal_pakets = SoalPaket::with([
                    'soalpaketitem',
                    'soalpaketitem.soal',
                    'soalpaketitem.soal.soalpilihanganda'
                ])
                ->where('id', $request->input('soal_paket_id'))
                ->where('sertifikasi_id', $query->sertifikasi_id)
                ->firstOrFail();

            // check if soal found
            if(isset($soal_pakets->soalpaketitem) and !empty($soal_pakets->soalpaketitem)) {
                // delete soal ketika ada perubahan status
                UjianAsesiJawaban::where('ujian_asesi_asesor_id', $id)
                    ->where('asesi_id', $query->asesi_id)
                    ->delete();

                // variable untuk simpan soal
                $soal_lists = [];

                foreach($soal_pakets->soalpaketitem as $key_soalpaketitem => $soal_paket_item) {

                    // soal data
                    $soal = $soal_paket_item->soal;
                    $soal_pilihanganda = [];

                    // generate array for multiple option
                    if($soal->question_type == 'multiple_option') {
                        foreach($soal->soalpilihanganda as $soalpil) {
                            // generate array with key from label
                            $soal_pilihanganda[$soalpil->label] = $soalpil->option;
                        }
                    }

                    $soal_lists[] = [
                        'ujian_asesi_asesor_id' => $id,
                        'soal_id'           => $soal_paket_item->soal_id,
                        'asesi_id'          => $query->asesi_id,
                        'question'          => $soal->question,
                        'question_type'     => $soal->question_type,
                        'answer_essay'      => $soal->answer_essay,
                        'answer_option'     => $soal->answer_option,
                        'options_label'     => ($soal->question_type == 'multiple_option') ? json_encode($soal_pilihanganda) : null,
                        'urutan'            => $key_soalpaketitem + 1,
                        'max_score'         => (int) $soal->max_score,
                        'final_score'       => ($soal->question_type == 'multiple_option') ? 0 : null,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ];
                }

                // Bulk Insert
                UjianAsesiJawaban::insert($soal_lists);
            } else {
                // return error kalau paket yang dipilih tidak ada soal sama sekali
                return redirect()->back()->withErrors('Paket yang dipilih belum memiliki daftar soal yang dikerjakan.!');
            }

        // validasi jika status paket_soal_assigned
        } elseif($query->status == 'penilaian') {
            // validate input
            $request->validate([
                'is_kompeten' => 'required',
                'final_score_percentage' => 'required',
            ]);

            // get form data
            $updateData = $request->only([
                'is_kompeten',
                'final_score_percentage',
            ]);
        }

        // update data
        $query->update($updateData);

        // redirect
        return redirect()
            ->route('admin.surat-tugas.index', ["status" => "menunggu"])
            ->with('success', trans('action.success_update', [
                'name' => $query->id
            ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
