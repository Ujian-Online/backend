<?php

namespace App\DataTables\Admin;

use App\Order;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderDataTable extends DataTable
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
            ->editColumn('tipe_sertifikasi', function($query) {
                return ucwords($query->tipe_sertifikasi);
            })
            ->editColumn('status', function($query) {
                return ucwords(str_replace('_', ' ', $query->status));
            })
            ->addColumn('action', function ($query) {
                return view('layouts.pageTableAction', [
                    'title' => $query->title,
                    'url_show' => route('admin.order.show', $query->id),
                    'url_edit' => route('admin.order.edit', $query->id),
                    'url_destroy' => route('admin.order.destroy', $query->id),
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
        $query = $model->with(['user', 'user.asesi', 'sertifikasi', 'tuk']);

        // get input filter
        $tuk_id = request()->input('tuk_id');
        $sertifikasi_id = request()->input('sertifikasi_id');
        $status = request()->input('status');
        $dateFrom = request()->input('dateFrom');
        $dateTo = request()->input('dateTo');

        // tuk_id filter query
        if(isset($tuk_id) and !empty($tuk_id)) {
            $query = $query->where('tuk_id', $tuk_id);
        }

        // sertifikasi_id filter query
        if(isset($sertifikasi_id) and !empty($sertifikasi_id)) {
            $query = $query->where('sertifikasi_id', $sertifikasi_id);
        }

        // status filter query
        if(isset($status) and !empty($status)) {
            $query = $query->where('status', $status);
        }

        // dateFrom filter query
        if(isset($dateFrom) and !empty($dateFrom)) {
            $query = $query->where('transfer_date', '>=', $dateFrom);
        }

        // dateTo filter query
        if(isset($query) and !empty($dateTo)) {
            $query = $query->where('transfer_date', '<=', $dateTo);
        }

        // return query
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
                            ],
                        ],
                    ])
                    ->setTableId('order-table')
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
            Column::make('id'),
            Column::computed('asesi')
                ->title('Asesi')
                ->data('user.asesi.name'),
            Column::computed('sertifikasi')
                ->title('Sertifikasi')
                ->data('sertifikasi.title'),
            Column::computed('tuk')
                ->title('TUK')
                ->data('tuk.title'),
            Column::make('tipe_sertifikasi'),
            Column::make('status'),
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
        return 'Order_' . date('YmdHis');
    }

    /**
     * Custom Create Button Action
     */
    public function createButton()
    {
        // Create Route URL
        $url = route('admin.order.create');

        // return function redirect
        return 'function (e, dt, button, config) {
            window.location = "'. $url .'";
        }';
    }
}
