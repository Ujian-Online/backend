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
                    <div class="form-group col-md-12">
                        <label for="tuk">Sertifikasi</label>
                        <select class="form-control" name="sertifikasi_id" id="sertifikasi_id" data-placeholder="Pilih Sertifikasi">
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

@push('script')
    <script>
        /**
         * Select2 with Ajax Start
         * @type {string}
         */

        // default selected sertifikasi_id from query URL
        const sertifikasi_id_default = '{{ request()->input('sertifikasi_id') ?? null }}'
        // trigger load data if sertifikasi_id not null
        if(sertifikasi_id_default) {
            var sertifikasiSelected = $('#sertifikasi_id');
            $.ajax({
                url: '{{ route('admin.sertifikasi.search') }}' + '?q=' + sertifikasi_id_default,
                dataType: 'JSON',
            }).then(function (data) {
                // create the option and append to Select2
                var option = new Option(data[0].text, data[0].id, true, true);
                sertifikasiSelected.append(option).trigger('change');

                // manually trigger the `select2:select` event
                sertifikasiSelected.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }

        // sertifikasi select2 with ajax query search
        $('#sertifikasi_id').select2({
            theme: 'bootstrap4',
            disabled: false,
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('admin.sertifikasi.search') }}',
                dataType: 'JSON',
                delay: 100,
                cache: false,
                data: function (data) {
                    return {
                        q: data.term
                    }
                },
                processResults: function (response) {
                    return {
                        results: response
                    }
                }
            },
        });

        /**
         * Select2 with Ajax End
         * @type {string}
         */
    </script>
@endpush
