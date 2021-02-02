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
                        {{ ucwords(str_replace('_', ' ', $type)) }}
                    </option>
                @endforeach

            </select>

            @error('input_type')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12" id="dropdown-data" style="display: none;">
            <label for="dropdown_option">Dropdown Option</label>
            <textarea class="form-control @error('dropdown_option') is-invalid @enderror" name="dropdown_option" id="dropdown_option"
                      cols="30" rows="5" placeholder="Data Satu,Data Dua,Data Tiga"></textarea>
            <small id="helpDropdownOption" class="text-muted">Pisahkan data dengan Koma untuk membuat Dropdown Option.</small>

            @error('dropdown_option')
                <div class="alert alert-danger"> {{ $message }}</div>
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
    <script>
        // listen if input_type change
        $("#input_type").on('change', function () {
            const me = $(this);
            const value = me.val();

            // dropdown data div
            const dropdownData = $("#dropdown-data");

            // show html if value select is dropdown
            if(value === 'dropdown') {
                dropdownData.show();
            } else {
                dropdownData.hide();
            }
        })
    </script>
@endsection
