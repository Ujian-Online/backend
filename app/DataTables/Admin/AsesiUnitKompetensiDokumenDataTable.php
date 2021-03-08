<?php

namespace App\DataTables\Admin;

use App\AsesiUnitKompetensiDokumen;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AsesiUnitKompetensiDokumenDataTable extends DataTable
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
            ->collection($query)
            ->addColumn('status', function($query) {

                if(isset($query['apl02_status']) and !empty($query['apl02_status'])) {
                    $statusRaw = $query['apl02_status'];
                } else {
                    $statusRaw = apl02_status($query['asesi_id'], $query['sertifikasi_id']);
                }

                // status replace
                $status = ucwords(str_replace('_', ' ', $statusRaw));

                // HTML Status
                $statusHTML = '';

                if($statusRaw == 'isi_form') {
                    $statusHTML = "<button type='button' class='btn btn-sm btn-primary'>$status</button>";
                } elseif ($statusRaw == 'menunggu_verifikasi') {
                    $statusHTML = "<button type='button' class='btn btn-sm btn-warning'>$status</button>";
                } elseif ($statusRaw == 'form_ditolak') {
                    $statusHTML = "<button type='button' class='btn btn-sm btn-danger'>$status</button>";
                } elseif ($statusRaw == 'form_terverifikasi') {
                    $statusHTML = "<button type='button' class='btn btn-sm btn-success'>$status</button>";
                } else {
                    $statusHTML = $status;
                }

                return $statusHTML;
            })
            ->addColumn('name_asesi', function($query) {
                $name_asesi = (isset($query['user']) and !empty($query['user'])) ? $query['user']['email'] : '';

                if(isset($query['user']['asesi']) and !empty($query['user']['asesi']) and isset($query['user']['asesi']['name']) and !empty($query['user']['asesi']['name'])) {
                    $name_asesi = $query['user']['asesi']['name'];
                }

                return $name_asesi;
            })
            ->addColumn('action', function ($query) {
                return view('layouts.pageTableAction', [
                    'title' => (isset($query['user']) and !empty($query['user'])
                                and isset($query['user']['asesi']) and !empty($query['user']['asesi']))
                                ? $query['user']['asesi']['name'] : $query['asesi_id'],
                    'url_print' => route('admin.asesi.apl02.view', [
                        'userid' => $query['asesi_id'],
                        'sertifikasiid' => $query['sertifikasi_id']
                    ]) . '?print=true',
                    'url_show' => route('admin.asesi.apl02.view', [
                        'userid' => $query['asesi_id'],
                        'sertifikasiid' => $query['sertifikasi_id']
                    ]),
                    'url_edit' => route('admin.asesi.apl02.viewedit', [
                        'userid' => $query['asesi_id'],
                        'sertifikasiid' => $query['sertifikasi_id']
                    ]),
                ]);
            })
            ->rawColumns(['status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\AsesiUnitKompetensiDokumen $model
     * @return array
     */
    public function query(AsesiUnitKompetensiDokumen $model)
    {
        // query ke database
        $query = $model::with(['user', 'user.asesi', 'sertifikasi'])
            ->select([
                'asesi_unit_kompetensi_dokumens.asesi_id as asesi_id',
                'sertifikasis.id as sertifikasi_id',
                'sertifikasis.title as sertifikasi_title'
            ])
            ->join('sertifikasis', 'sertifikasis.id', '=', 'asesi_unit_kompetensi_dokumens.sertifikasi_id')
            ->groupBy( 'asesi_id', 'sertifikasi_id', 'sertifikasi_title')
            ->get();

        // variable untuk simpan data
        $result = [];

        // run search query
        $status = request()->input('status');
        if(!empty($status)) {
            foreach ($query as $data) {
                $getStatus = apl02_status($data->asesi_id, $data->sertifikasi_id);

                if ($status == $getStatus) {
                    $result[] = array_merge($data, [
                        'apl02_status' => $getStatus
                    ]);
                }
            }
        } else {
            $result = $query;
        }

        return $result;
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
                        'searching' => false,
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
                    ->setTableId('asesiunitkompetensidokumen-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0, 'asc')
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
            Column::computed('name_asesi')
                ->title('Asesi')
                ->width('30%'),
            Column::computed('sertifikasi_title')
                ->title('Sertifikasi')
                ->width('40%'),
            Column::computed('status')
                ->title('Status')
                ->width('15%'),
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
        return 'AsesiUnitKompetensiDokumen_' . date('YmdHis');
    }

    /**
     * Custom Create Button Action
     */
    public function createButton()
    {
        // Create Route URL
        $url = route('admin.asesi.apl02.create');

        // return function redirect
        return 'function (e, dt, button, config) {
            window.location = "'. $url .'";
        }';
    }
}
