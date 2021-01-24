@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="code">Code</label>
            <input type="text" class="form-control @error('code') is-invalid
@enderror" name="code" id="code" placeholder="Code" value="{{ old('code') ??
$query->code ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('code')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="title">Nama</label>
            <input type="text" class="form-control @error('title') is-invalid
@enderror" name="title" id="title" placeholder="Title" value="{{ old('title')
 ??
$query->title ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="telp">Nomor Telp.</label>
            <input type="text" class="form-control @error('telp') is-invalid
@enderror" name="telp" id="telp" placeholder="021xxxxxx" value="{{ old('telp')
 ??
$query->telp ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('telp')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="type">Type</label>
            <select class="form-control" name="type" id="type" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.tuk_type') as $key => $type)
                    <option
                        value="{{ $key }}"

                        @if(old('type') == $key)
                            {{ __('selected') }}
                        @elseif(isset($query->type) and !empty($query->type) and $query->type == $key)
                            {{ __('selected') }}
                        @endif
                    >
                        {{ ucwords($type) }}
                    </option>
                @endforeach

            </select>

            @error('type')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-12">
            <label for="address">Address</label>
            <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" cols="30" rows="5" @if(isset($isShow)) readonly @endif>{{ old('address') ?? $query->address ?? '' }}</textarea>

            @error('address')
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
