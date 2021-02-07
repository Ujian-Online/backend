<?php

namespace App\DataTables\Admin;

use App\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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
            ->editColumn('type', function ($query) {
                return ucfirst($query->type);
            })
            ->editColumn('status', function ($query) {
                return ucfirst($query->status);
            })
            ->editColumn('media_url_sign_user', function ($query) {
                $link = '<a href="'.$query->media_url_sign_user.'" target="_blank">Buka</a>';

                return !empty($query->media_url_sign_user) ? $link : 'Belum ada Paraf/TTD';
            })
            ->addColumn('action', function ($query) {
                return view('layouts.pageTableAction', [
                    'title' => $query->name,
                    'url_show' => route('admin.user.show', $query->id),
                    'url_edit' => route('admin.user.edit', $query->id),
                    'url_destroy' => route('admin.user.destroy', $query->id),
                ]);
            })
            ->rawColumns(['media_url_sign_user']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        // create query variable
        $query = $model->newQuery();

        // get input filter
        $type = request()->input('type');
        $status = request()->input('status');

        // type filter query
        if(isset($type) and !empty($type)) {
            $query = $query->where('type', $type);
        }

        // status filter query
        if(isset($status) and !empty($status)) {
            $query = $query->where('status', $status);
        }

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
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(4, 'desc')
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
            Column::make('email')
                ->width('25%'),
            Column::make('type'),
            Column::make('status'),
            Column::make('media_url_sign_user')
                ->title('TTD'),
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
        return 'User_' . date('YmdHis');
    }

    /**
     * Custom Create Button Action
     */
    public function createButton()
    {
        // Create Route URL
        $url = route('admin.user.create');

        // return function redirect
        return 'function (e, dt, button, config) {
            window.location = "'. $url .'";
        }';
    }
}
