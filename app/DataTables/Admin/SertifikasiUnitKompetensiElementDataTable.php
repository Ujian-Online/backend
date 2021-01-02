<?php

namespace App\DataTables\Admin;

use App\SertifikasiUnitKompetensiElement;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SertifikasiUnitKompetensiElementDataTable extends DataTable
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
            ->editColumn('title', function($query) {
                return $query->unitkompetensi ? $query->unitkompetensi->title : '';
            })
            ->addColumn('action', function ($query) {
                return view('layouts.pageTableAction', [
                    'title' => $query->title,
                    'url_show' => route('admin.sertifikasi.ukelement.show', $query->id),
                    'url_edit' => route('admin.sertifikasi.ukelement.edit', $query->id),
                    'url_destroy' => route('admin.sertifikasi.ukelement.destroy', $query->id),
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\SertifikasiUnitKompetensiElement $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SertifikasiUnitKompetensiElement $model)
    {
        return $model->with('unitkompetensi');
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
                    ->setTableId('sertifikasiunitkompetensielement-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(3, 'desc')
                    ->buttons(
                        Button::make('export'),
                        Button::make('print'),
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
            Column::computed('title')
                ->title('Title')
                ->data('title'),
            Column::make('desc'),
            Column::make('upload_instruction'),
            Column::make('updated_at')
                ->title('Update')
                ->width('10%'),
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
        return 'SertifikasiUnitKompetensiElement_' . date('YmdHis');
    }

    /**
     * Custom Create Button Action
     */
    public function createButton()
    {
        // Create Route URL
        $url = route('admin.sertifikasi.ukelement.create');

        // return function redirect
        return 'function (e, dt, button, config) {
            window.location = "'. $url .'";
        }';
    }
}
