<?php

namespace App\DataTables\Admin;

use App\UnitKompetensi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SertifikasiUnitKompentensiDataTable extends DataTable
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
            ->addColumn('action', function ($query) {
                return view('layouts.pageTableAction', [
                    'title' => $query->title,
                    'url_show' => route('admin.sertifikasi.uk.show', $query->id),
                    'url_edit' => route('admin.sertifikasi.uk.edit', $query->id),
                    'url_destroy' => route('admin.sertifikasi.uk.destroy', $query->id),
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\UnitKompetensi $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(UnitKompetensi $model)
    {
        return $model->newQuery();
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
                    ->setTableId('sertifikasiunitkompentensi-table')
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
            Column::make('kode_unit_kompetensi')
                ->width('20%'),
            Column::make('title')
                ->width('25%'),
            Column::make('sub_title')
                ->width('25%'),
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
        return 'UnitKompentensi_' . date('YmdHis');
    }

    /**
     * Custom Create Button Action
     */
    public function createButton()
    {
        // Create Route URL
        $url = route('admin.sertifikasi.uk.create');

        // kalau di filter ada sertifikasi_id
        // include sertifikasi_id di url create
        $sertifikasi_id = request()->input('sertifikasi_id');
        if(!empty($sertifikasi_id)) {
            $url = route('admin.sertifikasi.uk.create', ['sertifikasi_id' => $sertifikasi_id]);
        }

        // return function redirect
        return 'function (e, dt, button, config) {
            window.location = "'. $url .'";
        }';
    }
}
