@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="sertifikasi_id">Sertifikasi ID</label>
            <select class="form-control @error('sertifikasi_id') is-invalid @enderror"
                    name="sertifikasi_id" id="sertifikasi_id" data-placeholder="Pilih Sertifikasi ID">
            </select>

            @error('sertifikasi_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Only Show TUK ID if Access by Admin --}}
        @can('isAdmin')
        <div class="form-group col-md-12">
            <label for="tuk_id">TUK ID</label>
            <select class="form-control @error('tuk_id') is-invalid @enderror"
                    name="tuk_id" id="tuk_id" data-placeholder="Pilih TUK ID">
            </select>

            @error('tuk_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        @endcan

        <div class="form-group bg-gray col-md-12" id="harga-original-sertifikasi" style="display: none;">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="original_price_baru">Harga Baru</label>
                    <input type="number" class="form-control" id="original_price_baru" placeholder="Harga Baru" value="" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label for="original_price_perpanjang">Harga Perpanjang</label>
                    <input type="number" class="form-control" id="original_price_perpanjang" placeholder="Harga Perpanjang" value="" readonly>
                </div>
            </div>
        </div>

        <div class="form-group col-md-6">
            <label for="tuk_price_baru">Harga Baru TUK</label>
            <input type="number" class="form-control @error('tuk_price_baru') is-invalid @enderror" name="tuk_price_baru" id="tuk_price_baru" placeholder="Harga Baru TUK" value="{{ old('tuk_price_baru') ?? $query->tuk_price_baru ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('tuk_price_baru')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="tuk_price_perpanjang">Harga Perpanjang TUK</label>
            <input type="number" class="form-control @error('tuk_price_perpanjang') is-invalid @enderror" name="tuk_price_perpanjang" id="tuk_price_perpanjang" placeholder="Harga Perpanjang TUK" value="{{ old('tuk_price_perpanjang') ?? $query->tuk_price_perpanjang ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('tuk_price_perpanjang')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="tuk_price_training">Harga Training TUK</label>
            <input type="number" class="form-control @error('tuk_price_training') is-invalid @enderror" name="tuk_price_training" id="tuk_price_training" placeholder="Harga Training TUK" value="{{ old('tuk_price_training') ?? $query->tuk_price_training ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('tuk_price_training')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endsection

@section('js')
    <script>
        /**
         * Select2 with Ajax Start
         * @type {string}
         */

            // default selected tuk_id from query URL
        const tuk_id_default = '{{ request()->input('tuk_id') ?? $query->tuk_id ?? null }}'
        // trigger load data if tuk_id_default not null
        if(tuk_id_default) {
            var tukSelected = $('#tuk_id');
            $.ajax({
                url: '{{ route('admin.tuk.search') }}' + '?q=' + tuk_id_default,
                dataType: 'JSON',
            }).then(function (data) {
                // create the option and append to Select2
                var option = new Option(data[0].text, data[0].id, true, true);
                tukSelected.append(option).trigger('change');

                // manually trigger the `select2:select` event
                tukSelected.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }

        // tuk select2 with ajax query search
        $('#tuk_id').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }},
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('admin.tuk.search') }}',
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
    <script>
        /**
         * Select2 with Ajax Start
         * @type {string}
         */

            // default selected sertifikasi_id from query URL
        const sertifikasi_id_default = '{{ request()->input('sertifikasi_id') ?? $query->sertifikasi_id ?? null }}'
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
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : ($user->type == 'admin' ? 'false' : 'readonly') }},
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
    <script>
        // listen if sertifikasi change
        $("#sertifikasi_id").on('change', async function () {
            // get select option
            const me = $(this);
            // get select option value
            const value = me.val();

            try {
                // fetch sertifikasi detail with axios
                const request = await axios.get('{{ url('admin/sertifikasi') }}' + `/${value}`)
                const { data: response } = request;

                // show original price form
                $("#harga-original-sertifikasi").show();

                // update value original price baru
                $("#original_price_baru").val(response.original_price_baru);
                // update value origin price perpanjang
                $("#original_price_perpanjang").val(response.original_price_perpanjang);

            } catch (e) {
                alert(`Gagal mengambil detail sertifikasi, ID: ${value}`);
            }
        })
    </script>
@endsection
