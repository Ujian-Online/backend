@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="asesi_id">Asesi ID</label>
            <select class="form-control @error('asesi_id') is-invalid @enderror"
                    name="asesi_id" id="asesi_id">

                @foreach($asesis as $asesi)
                    <option
                        value="{{ $asesi->id }}"
                    @if(!empty(request()->query('asesi_id')) and request()
                    ->query('asesi_id') == $asesi->id)
                        {{  __('selected') }}
                        @elseif(isset($query->asesi_id) and $query->asesi_id ==
                        $asesi->id)
                        {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $asesi->id }}] - {{ $asesi->name }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="form-group col-md-6">
            <label for="sertifikasi_id">Sertifikasi ID</label>
            <select class="form-control @error('sertifikasi_id') is-invalid @enderror"
                    name="sertifikasi_id" id="sertifikasi_id">

                @foreach($sertifikasis as $sertifikasi)
                    <option
                        value="{{ $sertifikasi->id }}"
                    @if(!empty(request()->query('sertifikasi_id')) and request()->query('sertifikasi_id') == $sertifikasi->id)
                        {{  __('selected') }}
                        @elseif(isset($query->sertifikasi_id) and $query->sertifikasi_id ==
                        $sertifikasi->id)
                        {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $sertifikasi->id }}] - {{ $sertifikasi->title }} (Nomor Skema: {{ $sertifikasi->nomor_skema }})
                    </option>
                @endforeach

            </select>
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
