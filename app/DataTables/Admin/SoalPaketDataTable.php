<?php

namespace App\DataTables\Admin;

use App\SoalPaket;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SoalPaketDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('total_soal', function ($query) {
                return (isset($query->soalpaketitem) and !empty($query->soalpaketitem)) ? count($query->soalpaketitem) : 0;
            })
            ->editColumn('durasi_ujian', function ($query) {
                return $query->durasi_ujian ? durasi_ujian($query->durasi_ujian) : null;
            })
            ->addColumn('action', function ($query) {
                return view('layouts.pageTableAction', [
                    'title' => $query->title,
                    'url_show' => route('admin.soal.paket.show', $query->id),
                    'url_edit' => route('admin.soal.paket.edit', $query->id),
                    'url_destroy' => route('admin.soal.paket.destroy', $query->id),
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\SoalPaket $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SoalPaket $model)
    {
        // default query
        $query = $model->with(['sertifikasi', 'soalpaketitem']);

        // get user login
        $user = request()->user();

        // add filter if access by asesor
        if($user->can('isAssesor')) {
            $query = $query->where('asesor_id', $user->id);
        }

        // get input filter
        $sertifikasi_id = request()->input('sertifikasi_id');

        // sertifikasi_id filter query
        if(isset($sertifikasi_id) and !empty($sertifikasi_id)) {
            $query = $query->where('sertifikasi_id', $sertifikasi_id);
        }

        // return query
        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->parameters([
                        'responsive' => true,
                        'autoWidth' => false,
                        'lengthMenu' => [
                            [10, 25, 50, -1],
                            ['10 rows', '25 rows', '50 rows', 'Show all']
                        ],
                        'dom' => 'Bfrtip',
                        'buttons' => [
                            'pageLength',
                            [
                                'text' => '<i class="fas fa-plus-circle"></i> ' . trans('table.create'),
                                'action' => $this->createButton()
                            ]
                        ],
                    ])
                    ->setTableId('soalpaket-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0, 'desc')
                    ->buttons(
                        // Button::make('export'),
                        // Button::make('print'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')
                ->width('5%'),
            Column::make('title')
                ->width('35%'),
            Column::computed('sertifikasi')
                ->title('Sertifikasi')
                ->data('sertifikasi.title')
                ->width('35%'),
            Column::make('total_soal')
                ->width('10%'),
            Column::make('durasi_ujian')
                ->width('10%'),
            Column::computed('action')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->width('5%')
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'SoalPaket_' . date('YmdHis');
    }

    /**
     * Custom Create Button Action
     */
    public function createButton()
    {
        // Create Route URL
        $url = route('admin.soal.paket.create');

        // return function redirect
        return 'function (e, dt, button, config) {
            window.location = "'. $url .'";
        }';
    }
}
