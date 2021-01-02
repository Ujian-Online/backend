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
            <label for="unit_kompetensi_id">Sertifikasi Unit Kompetensi ID</label>
            <select class="form-control @error('unit_kompetensi_id') is-invalid @enderror"
                    name="unit_kompetensi_id" id="unit_kompetensi_id">

                @foreach($unitkompentensis as $unitkompentensi)
                    <option
                        value="{{ $unitkompentensi->id }}"

                        @if(!empty(request()->query('unit_kompetensi_id')) and request()->query('unit_kompetensi_id') == $unitkompentensi->id)
                            {{  __('selected') }}
                        @elseif(isset($query->unit_kompetensi_id) and $query->unit_kompetensi_id == $unitkompentensi->id)
                            {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $unitkompentensi->id }}] - {{ $unitkompentensi->title }} (Kode: {{ $unitkompentensi->kode_unit_kompetensi }})
                    </option>
                @endforeach

            </select>

            @error('unit_kompetensi_id')
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
                        @elseif(isset($query->sertifikasi_id) and $query->sertifikasi_id ==
                        $sertifikasi->id)
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
