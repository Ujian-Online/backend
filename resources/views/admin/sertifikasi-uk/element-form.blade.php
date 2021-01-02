@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="unit_kompetensi_id">Sertifikasi Unit Kompetensi ID</label>
            <select class="form-control @error('unit_kompetensi_id') is-invalid @enderror"
                    name="unit_kompetensi_id" id="unit_kompetensi_id">

                @foreach($unitkompentensis as $unitkompentensi)
                    <option
                        value="{{ $unitkompentensi->id }}"

                        @if(!empty(request()->query('unit_kompetensi_id')) and request()->query('unit_kompetensi_id') == $unitkompentensi->id)
                            {{  __('selected') }}
                        @elseif(isset($query->unit_kompetensi_id) and $query->unit_kompetensi_id ==
                        $unitkompentensi->id)
                            {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $unitkompentensi->id }}] - {{ $unitkompentensi->title }} (Kode: {{ $unitkompentensi->kode_unit_kompetensi }})
                    </option>
                @endforeach

            </select>
        </div>


        <div class="form-group col-md-12">
            <label for="desc">Deskripsi</label>
            <textarea class="form-control @error('desc') is-invalid @enderror" name="desc" id="desc" cols="30" rows="5" @if(isset($isShow)) readonly @endif>{{ old('desc') ?? $query->desc ?? '' }}</textarea>

            @error('desc')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="upload_instruction">Instruksi Upload</label>
            <textarea class="form-control @error('upload_instruction') is-invalid @enderror" name="upload_instruction" id="upload_instruction" cols="30" rows="5" @if(isset($isShow)) readonly @endif>{{ old('upload_instruction') ?? $query->upload_instruction ?? '' }}</textarea>

            @error('upload_instruction')
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
