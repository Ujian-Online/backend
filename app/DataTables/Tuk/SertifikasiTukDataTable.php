<?php

namespace App\DataTables\Tuk;

use App\SertifikasiTuk;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SertifikasiTukDataTable extends DataTable
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
            ->editColumn('tuk_price_baru', function($query) {
                return number_format($query->tuk_price_baru, 0, ',', '.');
            })
            ->editColumn('tuk_price_perpanjang', function($query) {
                return number_format($query->tuk_price_perpanjang, 0, ',', '.');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\SertifikasiTuk $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SertifikasiTuk $model)
    {
        $query = $model->with('sertifikasi');

        // get user login
        $user = request()->user();
        $tuk = $user->tuk;

        // limit data based on tuk id
        return $query->where('tuk_id', $tuk->tuk_id);
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
                    ->setTableId('sertifikasituk-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0)
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
            Column::computed('sertifikasi')
                ->title('Nomor Skema')
                ->data('sertifikasi.nomor_skema'),
            Column::computed('sertifikasi')
                ->data('sertifikasi.title'),
            Column::make('tuk_price_baru')
                ->title('Harga Baru'),
            Column::make('tuk_price_perpanjang')
                ->title('Harga Perpanjang'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'SertifikasiTuk_' . date('YmdHis');
    }
}
