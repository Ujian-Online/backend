<?php

namespace App\DataTables\Asesor;

use App\UjianAsesiAsesor;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SuratTugasDataTable extends DataTable
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
                    $name_asesi = $query->user->asesi->name;
                }

                return $name_asesi;
            })
            ->editColumn('status', function($query) {
                return $query->status ? ucwords(str_replace('_', ' ', $query->status)) : '';
            })
            ->addColumn('action', function ($query) {
                return view('layouts.pageTableAction', [
                    'title' => $query->title,
                    'url_show' => route('admin.surat-tugas.show', $query->id),
                    'url_edit' => route('admin.surat-tugas.edit', $query->id),
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
            'ujianjadwal',
            'sertifikasi'
        ]);

        // get filter input
        $ujianjadwal = request()->input('ujian_jadwal_id');
        $sertifikasi = request()->input('sertifikasi_id');
        $status = request()->input('status');

        // filter ujian_jadwal_id
        if(!empty($ujianjadwal)) {
            $query = $query->where('ujian_jadwal_id', $ujianjadwal);
        }

        // filter sertifikasi_id
        if(!empty($sertifikasi)) {
            $query = $query->where('sertifikasi_id', $sertifikasi);
        }

        // filter status
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
                        ],
                    ])
                    ->setTableId('surattugas-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(4, 'desc')
                    ->buttons(
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
            Column::computed('name_asesi')
                ->title('Asesi Name')
                ->width('15%'),
            Column::computed('email_asesi')
                ->title('Asesi Email')
                ->data('userasesi.email')
                ->width('15%'),
            Column::computed('sertifikasi')
                ->title('Sertifikasi')
                ->data('sertifikasi.title')
                ->width('20%'),
            Column::computed('jadwal')
                ->title('Jadwal Ujian')
                ->data('ujianjadwal.title')
                ->width('20%'),
            Column::computed('tanggal')
                ->title('Tgl Ujian')
                ->data('ujianjadwal.tanggal')
                ->width('10%'),
            Column::make('status')
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
        return 'SuratTugas_' . date('YmdHis');
    }
}
