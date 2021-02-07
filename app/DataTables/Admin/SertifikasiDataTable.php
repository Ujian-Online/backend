<?php

namespace App\DataTables\Admin;

use App\Sertifikasi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SertifikasiDataTable extends DataTable
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
            ->editColumn('original_price_baru', function($query) {
                return number_format($query->original_price_baru, 0, ',', '.');
            })
            ->editColumn('original_price_perpanjang', function($query) {
                return number_format($query->original_price_perpanjang, 0, ',', '.');
            })
            ->addColumn('action', function ($query) {
                return view('layouts.pageTableAction', [
                    'title' => $query->title,
                    'url_sertifikasi_uk' => route('admin.sertifikasi.uk.index', ['sertifikasi_id' => $query->id ]),
                    'url_show' => route('admin.sertifikasi.show', $query->id),
                    'url_edit' => route('admin.sertifikasi.edit', $query->id),
                    'url_destroy' => route('admin.sertifikasi.destroy', $query->id),
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
                    ->setTableId('sertifikasi-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0, 'asc')
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
            Column::make('nomor_skema'),
            Column::make('title'),
            Column::make('original_price_baru')
                ->title('Harga Baru'),
            Column::make('original_price_perpanjang')
                ->title('Harga Perpanjang'),
            Column::make('updated_at')
                ->title('Update')
                ->width('10%'),
            Column::computed('action')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->width('10%')
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
        return 'Sertifikasi_' . date('YmdHis');
    }

    /**
     * Custom Create Button Action
     */
    public function createButton()
    {
        // Create Route URL
        $url = route('admin.sertifikasi.create');

        // return function redirect
        return 'function (e, dt, button, config) {
            window.location = "'. $url .'";
        }';
    }
}
