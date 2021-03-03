<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Filter Data</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form id="filter-form" action="{{ $filter_route }}" method="GET">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">Pilih Status</option>
                            <option value="isi_form" @if(request()->input('status') == 'isi_form') {{ _('selected') }} @endif>Isi Form</option>
                            <option value="menunggu_verifikasi" @if(request()->input('status') == 'menunggu_verifikasi') {{ _('selected') }} @endif>Menunggu Verifikasi</option>
                            <option value="form_ditolak" @if(request()->input('status') == 'form_ditolak') {{ _('selected') }} @endif>Form Ditolak</option>
                            <option value="form_terverifikasi" @if(request()->input('status') == 'form_terverifikasi') {{ _('selected') }} @endif>Form Terverifikasi</option>
                        </select>
                    </div>
                </div>
                <button class="btn btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
                <a href="{{ $filter_route }}" class="btn btn-warning">
                    <i class="fas fa-sync"></i> Reset
                </a>
            </form>
        </div>
    </div>
</div>
