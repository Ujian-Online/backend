@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="soal_id">Soal ID</label>
            <select class="form-control @error('soal_id') is-invalid @enderror"
                    name="soal_id" id="soal_id" data-placeholder="Pilih Soal ID">
            </select>

            @error('soal_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="soal_paket_id">Soal Paket ID</label>
            <select class="form-control @error('soal_paket_id') is-invalid @enderror"
                    name="soal_paket_id" id="soal_paket_id" data-placeholder="Pilih Soal Paket ID">
            </select>

            @error('soal_paket_id')
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

            // default selected soal_id from query URL
        const soal_id_default = '{{ request()->input('soal_id') ?? null }}'
        // trigger load data if soal_id not null
        if(soal_id_default) {
            var soalSelected = $('#soal_id');
            $.ajax({
                url: '{{ route('admin.soal.search') }}' + '?q=' + soal_id_default,
                dataType: 'JSON',
            }).then(function (data) {
                // create the option and append to Select2
                var option = new Option(data[0].text, data[0].id, true, true);
                soalSelected.append(option).trigger('change');

                // manually trigger the `select2:select` event
                soalSelected.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }

        // soal select2 with ajax query search
        $('#soal_id').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }},
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('admin.soal.search') }}',
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

            // default selected soal_paket_id from query URL
        const soal_paket_id_default = '{{ request()->input('soal_paket_id') ?? null }}'
        // trigger load data if soal_id not null
        if(soal_paket_id_default) {
            var soalPaketSelected = $('#soal_paket_id');
            $.ajax({
                url: '{{ route('admin.soal.paket.search') }}' + '?q=' + soal_paket_id_default,
                dataType: 'JSON',
            }).then(function (data) {
                // create the option and append to Select2
                var option = new Option(data[0].text, data[0].id, true, true);
                soalPaketSelected.append(option).trigger('change');

                // manually trigger the `select2:select` event
                soalPaketSelected.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }

        // soal select2 with ajax query search
        $('#soal_paket_id').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }},
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('admin.soal.paket.search') }}',
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
@endsection
