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
                        @elseif(isset($query->unit_kompetensi_id) and $query->unit_kompetensi_id ==
                        $unitkompentensi->id)
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
            <label for="desc">Description</label>
            <textarea class="form-control @error('desc') is-invalid @enderror" name="desc" id="desc" cols="30" rows="5" @if(isset($isShow)) readonly @endif>{{ old('desc') ?? $query->desc ?? '' }}</textarea>

            @error('desc')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="upload_instruction">Upload Instruction</label>
            <textarea class="form-control @error('upload_instruction') is-invalid @enderror" name="upload_instruction" id="upload_instruction" cols="30" rows="5" @if(isset($isShow)) readonly @endif>{{ old('upload_instruction') ?? $query->upload_instruction ?? '' }}</textarea>

            @error('upload_instruction')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="media_url">Media URL</label>
            <input type="text" class="form-control @error('media_url') is-invalid @enderror" name="media_url" id="media_url" placeholder="Media URL" value="{{ old('media_url') ?? $query->media_url ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('media_url')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="is_verified">Is Verified</label>
            <select class="form-control" name="is_verified" id="is_verified" @if(isset($isShow)) readonly @endif>

                @if(isset($query->is_verified) and $query->is_verified == 1)
                    <option value="1" selected>YES</option>
                    <option value="0">NO</option>
                @else
                    <option value="1">YES</option>
                    <option value="0" selected>NO</option>
                @endif

            </select>

            @error('input_type')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="verification_note">Verification Note</label>
            <input type="text" class="form-control @error('verification_note') is-invalid @enderror" name="verification_note" id="verification_note" placeholder="Harga Baru TUK" value="{{ old('verification_note') ?? $query->verification_note ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('verification_note')
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
