<?php

namespace App\DataTables\Admin;

use App\Order;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UjianAsesiBelumDapatAsesorDataTable extends DataTable
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
            ->addColumn('name_asesi', function($query) {
                $name_asesi = $query->user->email;

                if(isset($query->user->asesi) and !empty($query->user->asesi) and isset($query->user->asesi->name) and !empty($query->user->asesi->name)) {
                    $name_asesi = $query->user->asesi->name;
                }

                return $name_asesi;
            })
            ->editColumn('tipe_sertifikasi', function($query) {
                return ucwords($query->tipe_sertifikasi);
            })
            ->addColumn('action', function ($query) {
                return view('layouts.pageTableAction', [
                    'title' => $query->title,
                    'url_edit' => route('admin.ujian.asesi.create', ["order_id" => $query->id]),
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        // default query
        $query = $model->with(['user', 'user.asesi', 'tuk'])
        ->select([
            'orders.*',
            'sertifikasis.title as sertifikasi_title'
        ])
        ->leftJoin('ujian_asesi_asesors', 'ujian_asesi_asesors.order_id', '=', 'orders.id')
        ->join('users', 'users.id', '=', 'orders.asesi_id')
        ->join('sertifikasis', 'sertifikasis.id', '=', 'orders.sertifikasi_id')
        ->whereNull('ujian_asesi_asesors.asesor_id')
        ->whereNull('ujian_asesi_asesors.order_id')
        ->where('orders.status', 'payment_verified');

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
                    ->setTableId('ujianasesibelumdapatasesor-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
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
            Column::computed('name_asesi')
                ->title('Asesi')
                ->width('20%'),
            Column::computed('sertifikasi_title')
                ->title('Sertifikasi')
                ->width('20%'),
            Column::computed('tuk')
                ->title('TUK')
                ->data('tuk.title')
                ->width('20%'),
            Column::make('tipe_sertifikasi')
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
        return 'UjianAsesiBelumDapatAsesor_' . date('YmdHis');
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
