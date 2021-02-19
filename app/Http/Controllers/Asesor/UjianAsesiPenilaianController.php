<?php

namespace App\Http\Controllers\Asesor;

use App\DataTables\Asesor\UjianAsesiPenilaianDataTable;
use App\Http\Controllers\Controller;
use App\UjianAsesiAsesor;
use App\UjianAsesiJawaban;
use Illuminate\Http\Request;

class UjianAsesiPenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UjianAsesiPenilaianDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(UjianAsesiPenilaianDataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Ujian Asesi (Penilaian) Lists',
            'filter_route'  => route('admin.ujian-asesi.index'),
            'filter_view'   => 'admin.ujian.ujian-asesi-filter-form',
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
    public function show($id)
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
            'soalpaket',
            'order',
            'order.tuk'
        ])->findOrFail($id);

        // pisahkan soal jawaban pilihan ganda dan essay kalau ada datanya
        $soal_pilihangandas = [];
        $soal_essays = [];
        $total_nilai = 0;
        $total_max = 0;
        if(isset($query->ujianasesijawaban) and !empty($query->ujianasesijawaban)) {
            foreach($query->ujianasesijawaban as $soal) {
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

        // return data to view
        return view('asesor.ujian.penilaian-form', [
            'title'                 => 'Ujian Asesi Detail: ' . $query->id,
            'action'                => '#',
            'isShow'                => route('admin.ujian-asesi.edit', $id),
            'query'                 => $query,
            'soal_pilihangandas'    => $soal_pilihangandas,
            'soal_essays'           => $soal_essays,
            'total_nilai'           => $total_nilai,
            'total_max'             => $total_max,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
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
            'soalpaket',
            'order',
            'order.tuk'
        ])->findOrFail($id);

        // hanya bisa update jika status penilaian
        if($query->status != 'penilaian') {
            return redirect()->back()->withErrors('Data tidak bisa di ubah lagi.!');
        }

        // pisahkan soal jawaban pilihan ganda dan essay kalau ada datanya
        $soal_pilihangandas = [];
        $soal_essays = [];
        if(isset($query->ujianasesijawaban) and !empty($query->ujianasesijawaban)) {
            foreach($query->ujianasesijawaban as $soal) {
                if($soal->question_type == 'multiple_option') {
                    $soal_pilihangandas[] = $soal;
                } else {
                    $soal_essays[] = $soal;
                }
            }
        }

        // return data to view
        return view('asesor.ujian.penilaian-form', [
            'title'                 => 'Ujian Asesi Penilaian ID: ' . $query->id,
            'action'                => route('admin.ujian-asesi.update', $id),
            'isEdit'                => true,
            'query'                 => $query,
            'soal_pilihangandas'    => $soal_pilihangandas,
            'soal_essays'           => $soal_essays,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // get user login
        $user = $request->user();

        // Find Data by ID
        $query = UjianAsesiAsesor::with('ujianasesijawaban')
                ->where('asesor_id', $user->id)->where('id', $id)->firstOrFail();

        // hanya bisa update jika status penilaian
        if($query->status != 'penilaian') {
            return redirect()->back()->withErrors('Data tidak bisa di ubah lagi.!');
        }

        // get input soal_essay
        $soal_essay_id = $request->input('soal_essay_id');
        $soal_essay = $request->input('soal_essay');

        // loop essay id for update fields
        foreach($soal_essay_id as $essay) {

            // run update query based on id ujian_asesi_asesor and asesi_id
            // prevent from hijack id in html
            $ujianjawaban = UjianAsesiJawaban::where('ujian_asesi_asesor_id', $id)
                ->where('asesi_id', $query->asesi_id)
                ->where('id', $essay)
                ->first();

            // only run update if data found
            if($ujianjawaban) {
                $ujianjawaban_update = [
                    'final_score' => $soal_essay['final_score'][$essay] ?? null,
                    'catatan_asesor' => $soal_essay['catatan_asesor'][$essay] ?? null,
                ];

                $ujianjawaban->update($ujianjawaban_update);
            }
        }

        // fetch ulang database untuk kalkulasi ulang nilai precentage
        $ujianasesiasesor = UjianAsesiAsesor::with('ujianasesijawaban')->findOrFail($id);

        // hitung nilai
        $total_nilai = 0;
        $total_max = 0;
        if(isset($ujianasesiasesor->ujianasesijawaban) and !empty($ujianasesiasesor->ujianasesijawaban)) {
            foreach($ujianasesiasesor->ujianasesijawaban as $soal) {
                if($soal->question_type == 'multiple_option') {
                    // update nilai asesi berdasarkan maxscore
                    $total_nilai += $soal->max_score;
                } else {
                    // update nilai asesi berdasarkan final_score
                    $total_nilai += $soal->final_score;
                }

                // update total max score semua soal
                $total_max += $soal->max_score;
            }
        }

        // update status to selesai
        $query->final_score_percentage = ceil(($total_nilai/$total_max)*100);
        $query->status = 'selesai';
        $query->save();

        // return redirect
        return redirect()->route('admin.ujian-asesi.index', ['status' => 'penilaian'])
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
