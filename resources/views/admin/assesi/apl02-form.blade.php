@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="asesi_id">User ID Asesi</label>
            <select class="form-control @error('asesi_id') is-invalid @enderror"
                    name="asesi_id" id="asesi_id" data-placeholder="Pilih User ID Asesi">
            </select>

            @error('asesi_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="sertifikasi_id">Sertifikasi ID</label>
            <select class="form-control @error('sertifikasi_id') is-invalid @enderror"
                    name="sertifikasi_id" id="sertifikasi_id" data-placeholder="Pilih Sertifikasi ID">
            </select>

            @error('sertifikasi_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="unit_kompetensi_id">Sertifikasi Unit Kompetensi ID</label>
            <select class="form-control @error('unit_kompetensi_id') is-invalid @enderror"
                    name="unit_kompetensi_id" id="unit_kompetensi_id" data-placeholder="Pilih Sertifikasi Unit Kompetensi ID">
            </select>

            @error('unit_kompetensi_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        @if(isset($isShow) OR isset($isEdit))

            <div class="form-group col-md-6">
                <label for="kode_unit_kompetensi">Kode Unit Kompentensi</label>
                <input type="text" class="form-control @error('kode_unit_kompetensi') is-invalid @enderror" name="kode_unit_kompetensi" id="kode_unit_kompetensi" placeholder="Kode Unit Kompentensi" value="{{ old('kode_unit_kompetensi') ?? $query->kode_unit_kompetensi ?? '' }}" @if(isset($isShow)) readonly @endif>

                @error('kode_unit_kompetensi')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="order">Order</label>
                <input type="number" class="form-control @error('order') is-invalid @enderror" name="order" id="order" placeholder="Order" value="{{ old('order') ?? $query->order ?? '' }}" @if(isset($isShow)) readonly @endif>

                @error('order')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-md-12">
                <label for="title">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Title" value="{{ old('title') ?? $query->title ?? '' }}" @if(isset($isShow)) readonly @endif>

                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-md-12">
                <label for="sub_title">Sub Title</label>
                <input type="text" class="form-control @error('sub_title') is-invalid @enderror" name="sub_title" id="sub_title" placeholder="Sub Title" value="{{ old('sub_title') ?? $query->sub_title ?? '' }}" @if(isset($isShow)) readonly @endif>

                @error('sub_title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            @endif

    </div>
@endsection

@section('js')
    <script>
        /**
         * Select2 with Ajax Start
         * @type {string}
         */

            // default selected tuk_id from query URL
        const user_asesi_id_default = '{{ old('asesi_id') ?? $query->asesi_id ?? null }}'
        // trigger load data if tuk_id_default not null
        if(user_asesi_id_default) {
            var userAsesiSelected = $('#asesi_id');
            $.ajax({
                url: '{{ route('admin.user.search') }}' + '?q=' + user_asesi_id_default + '&type=asessi',
                dataType: 'JSON',
            }).then(function (data) {
                // create the option and append to Select2
                var option = new Option(data[0].text, data[0].id, true, true);
                userAsesiSelected.append(option).trigger('change');

                // manually trigger the `select2:select` event
                userAsesiSelected.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }

        // tuk select2 with ajax query search
        $('#asesi_id').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }},
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('admin.user.search') }}',
                dataType: 'JSON',
                delay: 100,
                cache: false,
                data: function (data) {
                    return {
                        q: data.term,
                        type: 'asessi' // see config('options.user_type')
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
        const sertifikasi_id_default = '{{ old('sertifikasi_id') ?? $query->sertifikasi_id ?? null }}'
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
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }},
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
        /**
         * Select2 with Ajax Start
         * @type {string}
         */

            // default selected sertifikasi_id from query URL
        const sertifikasi_uk_id_default = '{{ old('sertifikasi_id') ?? $query->sertifikasi_id ?? null }}'
        // trigger load data if sertifikasi_id not null
        if(sertifikasi_uk_id_default) {
            var sertifikasiUKSelected = $('#unit_kompetensi_id');
            $.ajax({
                url: '{{ route('admin.sertifikasi.uk.search') }}' + '?q=' + sertifikasi_uk_id_default + '&sertifikasi_id=true',
                dataType: 'JSON',
            }).then(function (data) {
                // create the option and append to Select2
                var option = new Option(data[0].text, data[0].id, true, true);
                sertifikasiUKSelected.append(option).trigger('change');

                // manually trigger the `select2:select` event
                sertifikasiUKSelected.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }

        // sertifikasi select2 with ajax query search
        $('#unit_kompetensi_id').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }},
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('admin.sertifikasi.uk.search') }}',
                dataType: 'JSON',
                delay: 100,
                cache: false,
                data: function (data) {
                    return {
                        q: data.term,
                        sertifikasi_id: true
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
        // listen if sertifikasi id change
        $("#sertifikasi_id").on('change', function () {
            const me = $(this)
            const value = me.val();

            // change unit kompetensi lists
            $.ajax({
                url: '{{ route('admin.sertifikasi.uk.search') }}' + '?q=' + value + '&sertifikasi_id=true',
                dataType: 'JSON',
            }).then(function (data) {
                const sertifikasiUK = $('#unit_kompetensi_id');

                // update option unit kompetensi from ajax
                sertifikasiUK.html('').select2({
                    theme: 'bootstrap4',
                    data: data
                });
            });
        });
    </script>
@endsection
