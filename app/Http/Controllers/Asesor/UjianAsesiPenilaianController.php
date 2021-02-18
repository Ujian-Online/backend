<?php

namespace App\Http\Controllers\Asesor;

use App\DataTables\Asesor\UjianAsesiPenilaianDataTable;
use App\Http\Controllers\Controller;
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
