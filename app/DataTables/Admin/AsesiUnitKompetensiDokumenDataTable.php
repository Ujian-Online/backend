<?php

namespace App\DataTables\Admin;

use App\AsesiUnitKompetensiDokumen;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AsesiUnitKompetensiDokumenDataTable extends DataTable
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
//            ->addColumn('status', function($query) {
//                $asesiukelement = $query->asesisertifikasiunitkompetensielement;
//
//                // return verified status
//                if(isset($asesiukelement) and !empty($asesiukelement)) {
//                    return $asesiukelement->is_verified ? 'Verified' : 'Unverified';
//                } else {
//                    return 'Unverified';
//                }
//            })
            ->addColumn('action', function ($query) {
                return view('layouts.pageTableAction', [
                    'title' => $query->asesi_id,
                    'url_show' => route('admin.asesi.apl02.view', [
                        'userid' => $query->asesi_id,
                        'sertifikasiid' => $query->sertifikasi_id
                    ]),
                    'url_edit' => route('admin.asesi.apl02.viewedit', [
                        'userid' => $query->asesi_id,
                        'sertifikasiid' => $query->sertifikasi_id
                    ]),
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\AsesiUnitKompetensiDokumen $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AsesiUnitKompetensiDokumen $model)
    {
        return $model::with(['user', 'user.asesi', 'sertifikasi'])
            ->select(['asesi_id', 'sertifikasi_id'])
            ->groupBy( 'asesi_id', 'sertifikasi_id');
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
                    ->setTableId('asesiunitkompetensidokumen-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(2, 'desc')
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
            Column::computed('asesi')
                ->title('Asesi')
                ->data('user.asesi.name'),
            Column::computed('sertifikasi')
                ->title('Sertifikasi')
                ->data('sertifikasi.title'),
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
        return 'AsesiUnitKompetensiDokumen_' . date('YmdHis');
    }

    /**
     * Custom Create Button Action
     */
    public function createButton()
    {
        // Create Route URL
        $url = route('admin.asesi.apl02.create');

        // return function redirect
        return 'function (e, dt, button, config) {
            window.location = "'. $url .'";
        }';
    }
}
