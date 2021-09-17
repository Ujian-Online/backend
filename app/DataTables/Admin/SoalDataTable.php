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
            ->editColumn('kode_uk', function ($query) {
                return $query->unit_kompetensi_kode_unit_kompetensi . "<br />" . $query->unit_kompetensi_title;
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
            })
            ->rawColumns(['question', 'kode_uk'])
            ->filterColumn('kode_uk', function($query, $keyword) {
               $query->where('unit_kompetensis.title', 'LIKE', "%$keyword%")
                   ->orWhere('unit_kompetensis.kode_unit_kompetensi', 'LIKE', "%$keyword%");
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Soal $model
     * @return Soal|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function query(Soal $model)
    {
        return $model->select([
                'soals.*',
                'unit_kompetensis.title as unit_kompetensi_title',
                'unit_kompetensis.kode_unit_kompetensi as unit_kompetensi_kode_unit_kompetensi',
            ])
            ->leftJoin('unit_kompetensis', 'unit_kompetensis.id', '=', 'soals.unit_kompetensi_id');
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
                ->width('40%'),
            Column::make('kode_uk')
                ->title('Unit Kompetensi')
                ->data('kode_uk')
                ->width('40%'),
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
