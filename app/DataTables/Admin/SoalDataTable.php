<?php

namespace App\DataTables\Admin;

use App\Soal;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SoalDataTable extends DataTable
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
            ->editColumn('question_type', function ($query) {
                return ucwords(str_replace('_', ' ', $query->question_type));
            })
            ->addColumn('action', function ($query) {
                // get user login
                $user = request()->user();

                return view('layouts.pageTableAction', [
                    'title' => $query->title,
                    'url_show' => route('admin.soal.daftar.show', $query->id),
                    'url_edit' => $user->can('isAdmin') ?
                        route('admin.soal.daftar.edit', $query->id) :
                        (
                            ($user->can('isAssesor') and $query->asesor_id == $user->id) ?
                                route('admin.soal.daftar.edit', $query->id) :
                                null
                        ),
                    'url_destroy' => $user->can('isAdmin') ?
                        route('admin.soal.daftar.destroy', $query->id) :
                        (
                            ($user->can('isAssesor') and $query->asesor_id == $user->id) ?
                                route('admin.soal.daftar.destroy', $query->id) :
                                null
                        ),
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Soaltest $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Soal $model)
    {
        return $model->select([
            'soals.*',
            'sertifikasi_unit_kompentensis.sertifikasi_id',
            'sertifikasi_unit_kompentensis.title as unit_kompetensi_title',
            'sertifikasis.title as sertifikasi_title',
        ])
            ->leftJoin('sertifikasi_unit_kompentensis', 'sertifikasi_unit_kompentensis.id', '=', 'soals.unit_kompetensi_id')
            ->leftJoin('sertifikasis', 'sertifikasis.id', '=', 'sertifikasi_unit_kompentensis.sertifikasi_id');
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
                    ->setTableId('soal-table')
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
            Column::make('question')
                ->width('30%'),
            Column::make('sertifikasi_title')
                ->title('Sertifikasi')
                ->width('25%'),
            Column::make('unit_kompetensi_title')
                ->title('Unit Kompetensi')
                ->width('25%'),
            Column::make('question_type')
                ->title('Question Type')
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
        return 'Soal_' . date('YmdHis');
    }

    /**
     * Custom Create Button Action
     */
    public function createButton()
    {
        // Create Route URL
        $url = route('admin.soal.daftar.create');

        // return function redirect
        return 'function (e, dt, button, config) {
            window.location = "'. $url .'";
        }';
    }
}
