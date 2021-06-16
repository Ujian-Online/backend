<?php

namespace App\DataTables\Asesor;

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
            ->rawColumns(['kode_uk']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Soal $model
     * @return \Illuminate\Database\Eloquent\Builder
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
                        ],
                    ])
                    ->setTableId('soal-table')
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
}
