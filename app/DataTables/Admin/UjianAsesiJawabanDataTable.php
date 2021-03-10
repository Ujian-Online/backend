<?php

namespace App\DataTables\Admin;

use App\UjianAsesiAsesor;
use App\UjianAsesiJawaban;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UjianAsesiJawabanDataTable extends DataTable
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
                $status = $query->status ? ucwords(str_replace('_', ' ', $query->status)) : '';

                if($status == 'Penilaian') {
                    $status = 'Butuh Penilaian';
                }

                return $status;
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
                    'title' => $query->id,
                    'url_show' => route('admin.ujian.jawaban.show', $query->id),
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\UjianAsesiJawaban $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(UjianAsesiAsesor $model)
    {
        // default query
        $query = $model->select([
            'ujian_asesi_asesors.*'
        ])
            ->with([
                'userasesi',
                'userasesi.asesi',
                'ujianjadwal',
                'sertifikasi'
            ])
            ->join('users as uasesi', 'uasesi.id', '=', 'ujian_asesi_asesors.asesi_id')
            ->join('users as uasesor', 'uasesor.id', '=', 'ujian_asesi_asesors.asesor_id')
            ->join('sertifikasis', 'sertifikasis.id', '=', 'ujian_asesi_asesors.sertifikasi_id');

        // get filter input
        $status = request()->input('status');

        // filter status
        if(!empty($status) and in_array($status, ['penilaian', 'selesai'])) {
            $query = $query->where('ujian_asesi_asesors.status', $status);
        } else {
            $query = $query->whereIn('ujian_asesi_asesors.status', ['penilaian', 'selesai']);
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
                            'pageLength'
                        ],
                    ])
                    ->setTableId('ujianasesijawaban-table')
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
                ->width('20%'),
            Column::computed('tanggal')
                ->title('Tgl Ujian')
                ->data('ujianjadwal.tanggal')
                ->width('10%'),
            Column::computed('name_asesi')
                ->title('Asesi Name')
                ->width('15%'),
            Column::computed('name_asesor')
                ->title('Asesor')
                ->width('10%'),
            Column::computed('sertifikasi')
                ->title('Sertifikasi')
                ->data('sertifikasi.title')
                ->width('15%'),
            Column::make('status')
                ->width('10%'),
            Column::make('is_kompeten')
                ->width('10%'),
            Column::computed('action')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->width('10%')
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
        return 'UjianAsesiJawaban_' . date('YmdHis');
    }

    /**
     * Custom Create Button Action
     */
    public function createButton()
    {
        // Create Route URL
        $url = route('admin.ujian.jawaban.create');

        // return function redirect
        return 'function (e, dt, button, config) {
            window.location = "'. $url .'";
        }';
    }
}
