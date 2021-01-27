<?php

namespace App\DataTables\Admin;

use App\UserAsesi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserAsesiDataTable extends DataTable
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
            ->editColumn('is_verified', function ($query) {
                return $query->is_verified == true ? 'YES' : 'NO';
            })
            ->addColumn('email', function($query) {
                return $query->user ? $query->user->email : 'Not Found';
            })
            ->addColumn('profile_picture', function($query) {
                if(!empty($query->user) and !empty($query->user->media_url)) {
                    $url = $query->user->media_url;
                    return "<a href='$url' target='_blank'><img src='$url' class='img-thumbnail img-fluid' style='width: 100px;'></a>";
                } else {
                    return 'Not Found';
                }
            })
            ->addColumn('action', function ($query) {
                return view('layouts.pageTableAction', [
                    'title' => $query->name,
                    'url_show' => route('admin.asesi.apl01.show', $query->id),
                    'url_edit' => route('admin.asesi.apl01.edit', $query->id),
                    'url_destroy' => route('admin.asesi.apl01.destroy', $query->id),
                ]);
            })
            ->rawColumns(['profile_picture']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\UserAsesi $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(UserAsesi $model)
    {
        // create query variable
        $query = $model::with('user');

        // get input filter
        $is_verified = request()->input('is_verified');

        // is_verified filter query
        if(isset($is_verified)) {
            $query = $query->where('is_verified', $is_verified);
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
                    ->setTableId('userasesi-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(4, 'desc')
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
            Column::computed('email')
                ->title('Email'),
            Column::make('name')->title('Nama'),
            Column::make('phone_number')->title('No. Telp'),
            Column::make('is_verified')->title('Verifikasi'),
            Column::computed('profile_picture')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->width('15%')
                ->title('Profile'),
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
        return 'UserAsesi_' . date('YmdHis');
    }

    /**
     * Custom Create Button Action
     */
    public function createButton()
    {
        // Create Route URL
        $url = route('admin.asesi.apl01.create');

        // return function redirect
        return 'function (e, dt, button, config) {
            window.location = "'. $url .'";
        }';
    }
}
