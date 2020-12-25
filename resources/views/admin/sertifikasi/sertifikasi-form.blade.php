@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="nomor_skema">Nomor Skema</label>
            <input type="text" class="form-control @error('nomor_skema') is-invalid @enderror" name="nomor_skema" id="nomor_skema" placeholder="Nomor Skema" value="{{ old('nomor_skema') ?? $query->nomor_skema ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('nomor_skema')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="title">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Title" value="{{ old('title') ?? $query->title ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="original_price_baru">Harga Baru</label>
            <input type="number" class="form-control @error('original_price_baru') is-invalid @enderror" name="original_price_baru" id="original_price_baru" placeholder="Harga Baru" value="{{ old('original_price_baru') ?? $query->original_price_baru ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('original_price_baru')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="original_price_perpanjang">Harga Perpanjang</label>
            <input type="number" class="form-control @error('original_price_perpanjang') is-invalid @enderror" name="original_price_perpanjang" id="original_price_perpanjang" placeholder="Harga Perpanjang" value="{{ old('original_price_perpanjang') ?? $query->original_price_perpanjang ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('original_price_perpanjang')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="jenis_sertifikasi">Jenis Sertifikasi</label>
            <select class="form-control" name="jenis_sertifikasi" id="jenis_sertifikasi" @if(isset
            ($isShow)) readonly @endif>

                @foreach(config('options.sertifikasis_jenis_sertifikasi') as $jenis_sertifikasi)
                    <option
                        value="{{ $jenis_sertifikasi }}"

                        @if(old('jenis_sertifikasi') == $jenis_sertifikasi)
                            {{ __('selected') }}
                        @elseif(isset($query->jenis_sertifikasi) and !empty($query->jenis_sertifikasi) and
                         $query->jenis_sertifikasi == $jenis_sertifikasi)
                            {{ __('selected') }}
                        @endif
                    >
                        {{ ucwords($jenis_sertifikasi) }}
                    </option>
                @endforeach

            </select>

            @error('jenis_sertifikasi')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="is_active">Is Active</label>
            <select class="form-control" name="is_active" id="is_active" @if(isset($isShow)) readonly @endif>

                @if(old('is_active') == 1 or !empty($query->is_active) == 1))
                    <option value="1" selected>Yes</option>
                    <option value="0">No</option>
                @else
                    <option value="1">Yes</option>
                    <option value="0" selected>No</option>
                @endif

            </select>

            @error('is_active')
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
