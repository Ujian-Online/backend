<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\DraftAPL02DataTable;
use App\Http\Controllers\Controller;
use App\Sertifikasi;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DraftAPL02Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DraftAPL02DataTable $dataTables)
    {
        // return index data with datatables services
        return $dataTables->render('layouts.pageTable', [
            'title' => 'Draft APL02 Lists'
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
     * @return Application|Factory|View
     */
    public function show(Request $request, $id)
    {
        $query = Sertifikasi::with([
            'sertifikasiunitkompentensi',
            'sertifikasiunitkompentensi.unitkompetensi',
            'sertifikasiunitkompentensi.unitkompetensi.ukelement'
        ])
            ->where('id', $id)
            ->firstOrFail();

        $pageView = 'admin.sertifikasi-uk.apl02-view';
        if($request->print) {
            $pageView = 'admin.sertifikasi-uk.apl02-print';
        }

        // return data to view
        return view($pageView, [
            'title'     => 'Detail: ' . $query->title,
            'action'    => '#',
            'isShow'    => null,
            'query'     => $query,
        ]);
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
