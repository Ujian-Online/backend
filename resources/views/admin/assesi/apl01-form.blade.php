@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="title">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Title" value="{{ old('title') ?? $query->title ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('title')
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
