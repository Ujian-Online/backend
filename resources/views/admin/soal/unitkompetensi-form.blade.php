@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="soal_id">Soal ID</label>
            <select class="form-control @error('soal_id') is-invalid @enderror" name="soal_id" id="soal_id">

                @foreach($soals as $soal)
                    <option
                        value="{{ $soal->id }}"

                        @if(!empty(request()->query('soal_id')) and request()->query('soal_id') == $soal->id)
                            {{  __('selected') }}
                        @elseif(isset($query->soal_id) and $query->soal_id == $soal->id)
                            {{  __('selected') }}
                        @endif
                    >
                        {{$soal->id}}
                    </option>
                @endforeach

            </select>

            @error('soal_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="unit_kompetensi_id">Unit Kompetensi ID</label>
            <select class="form-control @error('unit_kompetensi_id') is-invalid @enderror" name="unit_kompetensi_id" id="unit_kompetensi_id">

                @foreach($unit_kompetensis as $unit_kompetensi)
                    <option
                        value="{{ $unit_kompetensi->id }}"

                        @if(!empty(request()->query('unit_kompetensi_id')) and request()->query('unit_kompetensi_id') == $unit_kompetensi->id)
                            {{  __('selected') }}
                        @elseif(isset($query->unit_kompetensi_id) and $query->unit_kompetensi_id == $unit_kompetensi->id)
                            {{  __('selected') }}
                        @endif
                    >
                        [ID : {{$unit_kompetensi->id}}] - {{$unit_kompetensi->title}}
                    </option>
                @endforeach

            </select>

            @error('unit_kompetensi_id')
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
