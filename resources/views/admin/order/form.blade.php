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
            <label for="tuk_id">TUK ID</label>
            <select class="form-control @error('tuk_id') is-invalid @enderror"
                    name="tuk_id" id="tuk_id" data-placeholder="Pilih TUK ID">
            </select>

            @error('tuk_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="tipe_sertifikasi">Tipe Sertifikasi</label>
            <select class="form-control select2" name="tipe_sertifikasi" id="tipe_sertifikasi" @if(isset($isShow)) readonly @endif>
                <option value="" readonly>Pilih Tipe Sertifikasi</option>

                @foreach(config('options.orders_tipe_sertifikasi') as $tipe_sertifikasi)
                    <option
                        value="{{ $tipe_sertifikasi }}"

                        @if(old('tipe_sertifikasi') == $tipe_sertifikasi)
                            {{ __('selected') }}
                        @elseif(isset($query->tipe_sertifikasi) and !empty($query->tipe_sertifikasi) and $query->tipe_sertifikasi == $tipe_sertifikasi)
                            {{ __('selected') }}
                        @endif
                    >
                        {{ ucwords($tipe_sertifikasi) }}
                    </option>
                @endforeach

            </select>

            @error('tipe_sertifikasi')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="kode_sertifikat">Kode Sertifikat</label>
            <input type="text" class="form-control @error('kode_sertifikat') is-invalid @enderror" name="kode_sertifikat" id="kode_sertifikat" placeholder="Kode Sertifikat" value="{{ old('kode_sertifikat') ?? $query->kode_sertifikat ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('kode_sertifikat')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="sertifikat_number_old">Nomor Sertifikat Lama</label>
            <input type="text" class="form-control @error('sertifikat_number_old') is-invalid @enderror" name="sertifikat_number_old" id="sertifikat_number_old" placeholder="Nomor Sertifikat Lama" value="{{ old('sertifikat_number_old') ?? $query->sertifikat_number_old ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('sertifikat_number_old')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-2">
            <label for="sertifikat_date_old">Tanggal Sertifikat Lama</label>
            <input type="date" class="form-control @error('sertifikat_date_old') is-invalid @enderror" name="sertifikat_date_old" id="sertifikat_date_old" placeholder="Tanggal Sertifikat Lama" value="{{ old('sertifikat_date_old') ?? (isset($query->sertifikat_date_old) && !empty($query->sertifikat_date_old) ? \Carbon\Carbon::parse($query->sertifikat_date_old)->toDateString() : '' ) ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('sertifikat_date_old')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="sertifikat_media_url_old">File Sertifikat Lama</label>
            <input type="text" class="form-control @error('sertifikat_media_url_old') is-invalid @enderror" name="sertifikat_media_url_old" id="sertifikat_media_url_old" placeholder="File Sertifikat Lama" value="{{ old('sertifikat_media_url_old') ?? $query->sertifikat_media_url_old ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('sertifikat_media_url_old')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="sertifikat_number_new">Nomor Sertifikat Baru</label>
            <input type="text" class="form-control @error('sertifikat_number_new') is-invalid @enderror" name="sertifikat_number_new" id="sertifikat_number_new" placeholder="Nomor Sertifikat Baru" value="{{ old('sertifikat_number_new') ?? $query->sertifikat_number_new ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('sertifikat_number_new')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-2">
            <label for="sertifikat_date_new">Tanggal Sertifikat Baru</label>
            <input type="date" class="form-control @error('sertifikat_date_new') is-invalid @enderror" name="sertifikat_date_new" id="sertifikat_date_new" placeholder="Tanggal Sertifikat Baru" value="{{ old('sertifikat_date_new') ?? (isset($query->sertifikat_date_new) && !empty($query->sertifikat_date_new) ? \Carbon\Carbon::parse($query->sertifikat_date_new)->toDateString() : '' ) ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('sertifikat_date_new')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="sertifikat_media_url_new">File Sertifikat Baru</label>
            <input type="text" class="form-control @error('sertifikat_media_url_new') is-invalid @enderror" name="sertifikat_media_url_new" id="sertifikat_media_url_new" placeholder="File Sertifikat Baru" value="{{ old('sertifikat_media_url_new') ?? $query->sertifikat_media_url_new ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('sertifikat_media_url_new')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="original_price">Harga Asli</label>
            <input type="number" class="form-control @error('original_price') is-invalid @enderror" name="original_price" id="original_price" placeholder="Harga Asli" value="{{ old('original_price') ?? $query->original_price ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('original_price')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="tuk_price">Harga TUK</label>
            <input type="number" class="form-control @error('tuk_price') is-invalid @enderror" name="tuk_price" id="tuk_price" placeholder="Harga TUK" value="{{ old('tuk_price') ?? $query->tuk_price ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('tuk_price')
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

        <div class="form-group col-md-6">
            <label for="status">Status</label>
            <select class="form-control select2" name="status" id="status" @if(isset($isShow)) readonly @endif>
                <option value="" readonly>Pilih Status</option>

                @foreach(config('options.orders_status') as $status)
                    <option
                        value="{{ $status }}"

                        @if(old('status') == $status)
                            {{ __('selected') }}
                        @elseif(isset($query->status) and !empty($query->status) and $query->status == $status)
                            {{ __('selected') }}
                        @endif
                    >
                        {{ ucwords(str_replace('_', ' ', $status)) }}
                    </option>
                @endforeach

            </select>

            @error('status')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="comment_rejected">Comment Rejected</label>
            <textarea class="form-control @error('comment_rejected') is-invalid @enderror" name="comment_rejected" id="comment_rejected" cols="30" rows="5" @if(isset($isShow)) readonly @endif>{{ old('comment_rejected') ?? $query->comment_rejected ?? '' }}</textarea>

            @error('comment_rejected')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="comment_verification">Comment Verification</label>
            <textarea class="form-control @error('comment_verification') is-invalid @enderror" name="comment_verification" id="comment_verification" cols="30" rows="5" @if(isset($isShow)) readonly @endif>{{ old('comment_verification') ?? $query->comment_verification ?? '' }}</textarea>

            @error('comment_verification')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="transfer_from_bank_name">Transfer Dari Bank</label>
            <input type="text" class="form-control @error('transfer_from_bank_name') is-invalid @enderror" name="transfer_from_bank_name" id="transfer_from_bank_name" placeholder="Transfer Dari Bank" value="{{ old('transfer_from_bank_name') ?? $query->transfer_from_bank_name ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('transfer_from_bank_name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="transfer_from_bank_account">Transfer Dari Rekening Atas Nama</label>
            <input type="text" class="form-control @error('transfer_from_bank_account') is-invalid @enderror" name="transfer_from_bank_account" id="transfer_from_bank_account" placeholder="Transfer Dari Rekening Atas Nama" value="{{ old('transfer_from_bank_account') ?? $query->transfer_from_bank_account ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('transfer_from_bank_account')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="transfer_from_bank_number">Transfer Dari Nomor Rekening</label>
            <input type="text" class="form-control @error('transfer_from_bank_number') is-invalid @enderror" name="transfer_from_bank_number" id="transfer_from_bank_number" placeholder="Transfer Dari Nomor Rekening" value="{{ old('transfer_from_bank_number') ?? $query->transfer_from_bank_number ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('transfer_from_bank_number')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="transfer_to_bank_name">Transfer Ke Bank</label>
            <select class="form-control select2" name="transfer_to_bank_name" id="transfer_to_bank_name" @if(isset($isShow)) readonly @endif>
                <option value="" readonly>Pilih Bank</option>

                @foreach(config('options.tuk_bank_name') as $bank)
                    <option
                        value="{{ $bank }}"

                        @if(old('transfer_to_bank_name') == $bank)
                            {{ __('selected') }}
                        @elseif(isset($query->transfer_to_bank_name) and !empty($query->transfer_to_bank_name) and $query->transfer_to_bank_name == $bank)
                            {{ __('selected') }}
                        @endif
                    >
                        {{ ucwords($bank) }}
                    </option>
                @endforeach

            </select>

            @error('transfer_to_bank_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="transfer_to_bank_account">Transfer ke Rekening Atas nama</label>
            <input type="text" class="form-control @error('transfer_to_bank_account') is-invalid @enderror" name="transfer_to_bank_account" id="transfer_to_bank_account" placeholder="Transfer ke Rekening Atas nama" value="{{ old('transfer_to_bank_account') ?? $query->transfer_to_bank_account ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('transfer_to_bank_account')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="transfer_to_bank_number">Transfer ke Nomor Rekening</label>
            <input type="text" class="form-control @error('transfer_to_bank_number') is-invalid @enderror" name="transfer_to_bank_number" id="transfer_to_bank_number" placeholder="Transfer ke Nomor Rekening" value="{{ old('transfer_to_bank_number') ?? $query->transfer_to_bank_number ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('transfer_to_bank_number')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-2">
            <label for="transfer_date">Tanggal Transfer</label>
            <input type="date" class="form-control @error('transfer_date') is-invalid @enderror" name="transfer_date" id="transfer_date" placeholder="Tanggal Transfer" value="{{ old('transfer_date') ?? (isset($query->transfer_date) && !empty($query->transfer_date) ? \Carbon\Carbon::parse($query->transfer_date)->toDateString() : '') ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('transfer_date')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-2">
            <label for="expired_date">Jatuh Tempo</label>
            <input type="date" class="form-control @error('expired_date') is-invalid @enderror" name="expired_date" id="expired_date" placeholder="Jatuh Tempo" value="{{ old('expired_date') ?? (isset($query->expired_date) && !empty($query->expired_date) ? \Carbon\Carbon::parse($query->expired_date)->toDateString() : '') ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('expired_date')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-8">
            <label for="media_url_bukti_transfer">Bukti Transfer</label>
            <input type="text" class="form-control @error('media_url_bukti_transfer') is-invalid @enderror" name="media_url_bukti_transfer" id="media_url_bukti_transfer" placeholder="Bukti Transfer" value="{{ old('media_url_bukti_transfer') ?? $query->media_url_bukti_transfer ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('media_url_bukti_transfer')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>
@endsection

@section('js')
    <script>
        $('.select2').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }}
        });
    </script>
    <script>
        /**
         * Select2 with Ajax Start
         * @type {string}
         */

            // default selected tuk_id from query URL
        const user_asesi_id_default = '{{ request()->input('asesi_id') ?? $query->asesi_id ?? null }}'
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
@endsection
