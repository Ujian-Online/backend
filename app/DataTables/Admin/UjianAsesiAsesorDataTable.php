<?php

namespace App\DataTables\Admin;

use App\UjianAsesiAsesor;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UjianAsesiAsesorDataTable extends DataTable
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
            ->editColumn('status', function($query) {
                return $query->status ? ucwords($query->status) : '';
            })
            ->editColumn('is_kompeten', function($query) {
                return $query->is_kompeten ? config('options.ujian_asesi_is_kompeten')[$query->is_kompeten] : '';
            })
            ->addColumn('action', function ($query) {
                return view('layouts.pageTableAction', [
                    'title' => $query->title,
                    'url_show' => route('admin.ujian.jadwal.show', $query->id),
                    'url_edit' => route('admin.ujian.jadwal.edit', $query->id),
                    'url_destroy' => route('admin.ujian.jadwal.destroy', $query->id),
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\UjianAsesiAsesor $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(UjianAsesiAsesor $model)
    {
        return $model->with(['asesi', 'asesor', 'ujianjadwal', 'sertifikasi', 'order']);
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
                    ->setTableId('ujianasesiasesor-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
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
            Column::computed('jadwal')
                ->title('Jadwal Ujian')
                ->data('ujianjadwal.title'),
            Column::computed('tanggal')
                ->title('Tgl Ujian')
                ->data('ujianjadwal.tanggal'),
            Column::computed('asesi')
                ->title('Asesi')
                ->data('asesi.name'),
            Column::computed('asesor')
                ->title('Asesor')
                ->data('asesor.name'),
            Column::computed('sertifikasi')
                ->title('Sertifikasi')
                ->data('sertifikasi.title'),
            Column::make('status'),
            Column::make('is_kompeten'),
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
        return 'UjianAsesiAsesor_' . date('YmdHis');
    }

    /**
     * Custom Create Button Action
     */
    public function createButton()
    {
        // Create Route URL
        $url = route('admin.ujian.asesi.create');

        // return function redirect
        return 'function (e, dt, button, config) {
            window.location = "'. $url .'";
        }';
    }
}
