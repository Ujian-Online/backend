@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="asesi_id">Asesi ID</label>
            <select class="form-control @error('asesi_id') is-invalid @enderror"
                    name="asesi_id" id="asesi_id">

                @foreach($asesis as $asesi)
                    <option
                        value="{{ $asesi->id }}"

                    @if(!empty(request()->query('asesi_id')) and request()->query('asesi_id') == $asesi->id)
                        {{  __('selected') }}
                        @elseif(isset($query->asesi_id) and $query->asesi_id == $asesi->id)
                        {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $asesi->id }}] - {{ $asesi->name }}
                    </option>
                @endforeach

            </select>

            @error('asesi_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="sertifikasi_id">Sertifikasi ID</label>
            <select class="form-control @error('sertifikasi_id') is-invalid @enderror"
                    name="sertifikasi_id" id="sertifikasi_id">

                @foreach($sertifikasis as $sertifikasi)
                    <option
                        value="{{ $sertifikasi->id }}"

                    @if(!empty(request()->query('sertifikasi_id')) and request()->query('sertifikasi_id') == $sertifikasi->id)
                        {{  __('selected') }}
                        @elseif(isset($query->sertifikasi_id) and $query->sertifikasi_id == $sertifikasi->id)
                        {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $sertifikasi->id }}] - {{ $sertifikasi->title }} (Nomor Skema: {{ $sertifikasi->nomor_skema }})
                    </option>
                @endforeach

            </select>

            @error('sertifikasi_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="tuk_id">TUK ID</label>
            <select class="form-control @error('tuk_id') is-invalid @enderror"
                    name="tuk_id" id="tuk_id">

                @foreach($tuks as $tuk)
                    <option
                        value="{{ $tuk->id }}"
                    @if(!empty(request()->query('tuk_id')) and request()
                    ->query('tuk_id') == $tuk->id)
                        {{  __('selected') }}
                        @elseif(isset($query->tuk_id) and $query->tuk_id ==
                        $tuk->id)
                        {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $tuk->id }}] - {{ $tuk->title }} ({{
                        $tuk->code }})
                    </option>
                @endforeach

            </select>

            @error('tuk_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="tipe_sertifikasi">Tipe Sertifikasi</label>
            <select class="form-control" name="tipe_sertifikasi" id="tipe_sertifikasi" @if(isset($isShow)) readonly @endif>

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
            <select class="form-control" name="status" id="status" @if(isset($isShow)) readonly @endif>

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
            <select class="form-control" name="transfer_to_bank_name" id="transfer_to_bank_name" @if(isset($isShow)) readonly @endif>

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
            <input type="date" class="form-control @error('transfer_date') is-invalid @enderror" name="transfer_date" id="transfer_date" placeholder="Tanggal Transfer" value="{{ old('transfer_date') ?? $query->transfer_date ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('transfer_date')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-2">
            <label for="expired_date">Jatuh Tempo</label>
            <input type="date" class="form-control @error('expired_date') is-invalid @enderror" name="expired_date" id="expired_date" placeholder="Jatuh Tempo" value="{{ old('expired_date') ?? $query->expired_date ?? '' }}" @if(isset($isShow)) readonly @endif>

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
        $('select').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }}
        });
    </script>
@endsection
