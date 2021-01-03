@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="soal_id">Soal ID</label>
            <select class="form-control @error('asesi_id') is-invalid @enderror" name="soal_id" id="soal_id">

                @foreach($soals as $soals)
                    <option
                        value="{{ $soals->id }}"

                    @if(!empty(request()->query('soal_id')) and request()->query('soal_id') == $soals->id)
                        {{  __('selected') }}
                        @elseif(isset($query->soal_id) and $query->soal_id == $soals->id)
                        {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $soals->id }}] - {{ $asesi->question }}
                    </option>
                @endforeach

            </select>

            @error('soal_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

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
            <label for="option">Option</label>
            <input type="text" class="form-control @error('option') is-invalid @enderror" name="option" id="option" placeholder="Option" value="{{ old('option') ?? $query->option ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('option')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="label">Label</label>
            <select class="form-control" name="label" id="label" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.ujian_asesi_jawaban_pilihans_label') as $label)
                    <option
                        value="{{ $label }}"

                        @if(old('label') == $label)
                            {{ __('selected') }}
                        @elseif(isset($query->label) and !empty($query->label) and $query->label == $label)
                            {{ __('selected') }}
                        @endif
                    >
                        {{ ucwords($label) }}
                    </option>
                @endforeach

            </select>

            @error('label')
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
