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
        </div>

        <div class="form-group col-md-12">
            <label for="title">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Title" value="{{ old('title') ?? $query->title ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="value">Value</label>
            <input type="text" class="form-control @error('value') is-invalid @enderror" name="value" id="value" placeholder="Value" value="{{ old('value') ?? $query->value ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('value')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="input_type">Input Type</label>
            <select class="form-control" name="input_type" id="input_type" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.asesi_custom_data_input_type') as $type)
                    <option
                        value="{{ $type }}"

                    @if(old('type') == $type)
                        {{ __('selected') }}
                        @elseif(isset($query->input_type) and !empty($query->input_type) and $query->input_type == $type)
                        {{ __('selected') }}
                        @endif
                    >
                        {{ ucfirst($type) }}
                    </option>
                @endforeach

            </select>

            @error('input_type')
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
            <label for="verification_note">Catatan Verifikasi</label>
            <textarea class="form-control @error('verification_note') is-invalid @enderror" name="verification_note" id="verification_note" cols="30" rows="5" @if(isset($isShow)) readonly @endif>{{ old('verification_note') ?? $query->verification_note ?? '' }}</textarea>

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
