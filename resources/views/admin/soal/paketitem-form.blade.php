@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">


        <div class="form-group col-md-12">
            <label for="soal_id">Soal ID</label>
            <select class="form-control @error('soal_id') is-invalid @enderror" name="soal_id" id="soal_id">

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
            <label for="soal_paket_id">Soal Paket ID</label>
            <select class="form-control @error('soal_paket_id') is-invalid @enderror" name="soal_paket_id" id="soal_paket_id">

                @foreach($soalpakets as $soalpaket)
                    <option
                        value="{{ $soalpaket->id }}"

                        @if(!empty(request()->query('soal_paket_id')) and request()->query('soal_paket_id') == $soalpaket->id)
                            {{  __('selected') }}
                        @elseif(isset($query->soal_paket_id) and $query->soal_paket_id == $soalpaket->id)
                            {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $soalpaket->id }}] - {{ $soalpaket->title }}
                    </option>
                @endforeach

            </select>

            @error('soal_paket_id')
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
