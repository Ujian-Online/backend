<?php

namespace App\DataTables\Admin;

use App\UjianAsesiAsesor;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UjianAsesiAsesorDataTable extends DataTable
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
                $name_asesi = $query->userasesi->email;

                if(isset($query->userasesi->asesi) and !empty($query->userasesi->asesi) and isset($query->userasesi->asesi->name) and !empty($query->userasesi->asesi->name)) {
                    $name_asesi = $query->userasesi->asesi->name;
                }

                return $name_asesi;
            })
            ->addColumn('name_asesor', function($query) {
                $name_asesor = $query->userasesor->email;

                if(isset($query->userasesor->asesor) and !empty($query->userasesor->asesor) and isset($query->userasesor->asesor->name) and !empty($query->userasesor->asesor->name)) {
                    $name_asesor = $query->userasesor->asesor->name;
                }

                return $name_asesor;
            })
            ->editColumn('status', function($query) {
                return $query->status ? ucwords(str_replace('_', ' ', $query->status)) : '';
            })
            ->editColumn('is_kompeten', function ($query) {
                $kompeten = '';
                // cek apa datanya ada atau tidak
                if(!empty($query->is_kompeten)) {
                    $kompeten = $query->is_kompeten ? 'Kompeten' : 'Tidak Kompeten';
                }
                // return kompeten status
                return $kompeten;
            })
            ->addColumn('action', function ($query) {
                return view('layouts.pageTableAction', [
                    'title' => $query->title,
                    'url_show' => route('admin.ujian.asesi.show', $query->id),
                    'url_edit' => route('admin.ujian.asesi.edit', $query->id),
                    'url_destroy' => route('admin.ujian.asesi.destroy', $query->id),
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\UjianAsesiAsesor $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(UjianAsesiAsesor $model)
    {
        // default query
        $query = $model->with([
            'userasesi',
            'userasesi.asesi',
            'userasesor',
            'userasesor.asesor',
            'ujianjadwal',
            'sertifikasi',
            'order'
        ]);

        // get input filter
        $ujian_jadwal_id = request()->input('ujian_jadwal_id');
        $sertifikasi_id = request()->input('sertifikasi_id');
        $status = request()->input('status');

        // filter by jadwal id
        if(!empty($ujian_jadwal_id)) {
            $query = $query->whereHas('ujianjadwal', function($query) use ($ujian_jadwal_id) {
                $query->where('id', $ujian_jadwal_id);
            });
        }

        // filter by sertifikasi
        if(!empty($sertifikasi_id)) {
            $query = $query->whereHas('sertifikasi', function($query) use ($sertifikasi_id) {
                $query->where('id', $sertifikasi_id);
            });
        }

        // filter by ujian jadwal
        if(!empty($status)) {
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
                    ->setTableId('ujianasesiasesor-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
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
            Column::computed('jadwal')
                ->title('Jadwal Ujian')
                ->data('ujianjadwal.title')
                ->width('10%'),
            Column::computed('tanggal')
                ->title('Tgl Ujian')
                ->data('ujianjadwal.tanggal')
                ->width('10%'),
            Column::computed('name_asesi')
                ->title('Asesi')
                ->width('10%'),
            Column::computed('name_asesor')
                ->title('Asesor')
                ->width('10%'),
            Column::computed('sertifikasi')
                ->title('Sertifikasi')
                ->data('sertifikasi.title')
                ->width('20%'),
            Column::make('status')
                ->width('10%'),
            Column::make('is_kompeten')
                ->width('5%'),
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
        return 'UjianAsesiAsesor_' . date('YmdHis');
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
