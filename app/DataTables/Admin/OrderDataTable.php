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
     * Data User Login
     */
    private $user;

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
            ->editColumn('status', function($query) {
                return ucwords(str_replace('_', ' ', $query->status));
            })
            ->addColumn('action', function ($query) {
                $editButton = null;

                if($this->user->can('isTuk') and $query->status != 'completed') {
                    $editButton = route('admin.order.edit', $query->id);
                }

                return view('layouts.pageTableAction', [
                    'title' => $query->id,
                     'url_show' => route('admin.order.show', $query->id),
                     'url_edit' => $editButton,
                    // 'url_destroy' => route('admin.order.destroy', $query->id),
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
        $query = $model->with(['user', 'user.asesi', 'tuk'])
            ->select([
                'orders.*',
                'sertifikasis.title as sertifikasi_title'
            ])
            ->leftJoin('sertifikasis', 'sertifikasis.id', '=', 'orders.sertifikasi_id');

        // get user active before apply filter
        $user = request()->user();

        // inject ke data user global property
        $this->user = $user;

        /**
         * Filter For Admin Access Only
         */
        if($user->can('isAdmin')) {
            // get input filter for admin only
            $tuk_id = request()->input('tuk_id');
            $sertifikasi_id = request()->input('sertifikasi_id');

            // tuk_id filter query
            if(isset($tuk_id) and !empty($tuk_id)) {
                $query = $query->where('tuk_id', $tuk_id);
            }

            // sertifikasi_id filter query
            if(isset($sertifikasi_id) and !empty($sertifikasi_id)) {
                $query = $query->where('sertifikasi_id', $sertifikasi_id);
            }
        }

        // Added Filter if Access by TUK
        if($user->can('isTuk')) {
            // get tuk id based from user id
            $tukid = $user->tuk->tuk_id;
            $query = $query->where('tuk_id', $tukid);
        }

        // get input filter for admin and tuk
        $status = request()->input('status');
        $dateFrom = request()->input('dateFrom');
        $dateTo = request()->input('dateTo');

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
                            // [
                            //     'text' => '<i class="fas fa-plus-circle"></i> ' . trans('table.create'),
                            //     'action' => $this->createButton()
                            // ],
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
            Column::computed('name_asesi')
                ->title('Asesi'),
            Column::computed('sertifikasi_title')
                ->title('Sertifikasi'),
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
