<?php

namespace App\DataTables\Admin;

use App\Sertifikasi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DraftAPL02DataTable extends DataTable
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
                    'title' => $query->name,
                    'url_print' => route('admin.sertifikasi.draft-apl02.show', $query->id) . '?print=true',
                    'url_show' => route('admin.sertifikasi.draft-apl02.show', $query->id),
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Sertifikasi $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Sertifikasi $model)
    {
        return $model->select(['sertifikasis.*'])
        ->join('sertifikasi_unit_kompentensis', 'sertifikasi_unit_kompentensis.sertifikasi_id', '=', 'sertifikasis.id')
            ->groupBy('sertifikasis.id');
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
                        'searching' => true,
                        'responsive' => true,
                        'autoWidth' => false,
                        'lengthMenu' => [
                            [10, 25, 50, -1],
                            ['10 rows', '25 rows', '50 rows', 'Show all']
                        ],
                        'dom' => 'Bfrtip',
                        'buttons' => [
                            'pageLength',
                        ],
                    ])
                    ->setTableId('draftapl02-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0, 'desc')
                    ->buttons(
                        // Button::make('create'),
                        // Button::make('export'),
                        // Button::make('print'),
                        // Button::make('reset'),
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
            Column::make('nomor_skema')
                ->width('20%'),
            Column::make('title')
                ->width('40%'),
            Column::computed('action')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->width('15%')
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
        return 'DraftAPL02_' . date('YmdHis');
    }
}
