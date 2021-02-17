<?php

namespace App\Http\Controllers\Asesor;

use App\DataTables\Asesor\SuratTugasDataTable;
use App\Http\Controllers\Controller;
use App\UjianAsesiAsesor;
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
    public function show($id)
    {
        // Find Data by ID
        $query = UjianAsesiAsesor::findOrFail($id);

        // return data to view
        return view('admin.ujian.asesi-form', [
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

        // validasi jika status menunggu
        if($query->status == 'menunggu') {
            // validate input
            $request->validate([
                'soal_paket_id' => 'required',
            ]);

            // get form data
            $dataInput = $request->only([
                'soal_paket_id',
            ]);

            // update status ke paket_soal_assigned
            $dataInput['status'] = 'paket_soal_assigned';

            // validasi jika status paket_soal_assigned
        } elseif($query->status == 'paket_soal_assigned') {
            // validate input
            $request->validate([
                'is_kompeten' => 'required',
                'final_score_percentage' => 'required',
            ]);

            // get form data
            $dataInput = $request->only([
                'is_kompeten',
                'final_score_percentage',
            ]);
        }

        // update data
        $query->update($dataInput);

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
