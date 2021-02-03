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
            <select class="form-control @error('input_type') is-invalid @enderror" name="input_type" id="input_type" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.asesi_custom_data_input_type') as $type)
                    <option
                        value="{{ $type }}"

                        @if(old('input_type') == $type)
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

            @if(isset($isCreated) OR isset($isEdit))
                <button type="button" class="btn btn-primary btn-sm" id="add-dropdown">
                    Tambah Opsi Dropdown
                </button>
            @endif

            <div id="input-dropdown-result" class="form-row mt-2">

                {{-- Loop data kalau form show atau edit --}}
                @if(isset($isShow) OR isset($isEdit) and $query->input_type == 'dropdown' and !empty($query->dropdown_option))
                        @foreach(explode(',', $query->dropdown_option) as $key => $dropdownOption)
                            <div id="dropdown-option-data-{{ $key }}" class="col-md-12 form-row">

                                @if(isset($isEdit))
                                    <div class="form-group col-md-2">
                                        <button type="button" class="btn btn-danger btn-block" onclick="deleteButton({{$key}})">Delete</button>
                                    </div>
                                @endif

                                <div class="form-group col-md-10">
                                    <input type="text" class="form-control mb-2"
                                           name="dropdown_option[]" id="dropdown_option_{{$key}}" placeholder="Opsi Dropdown"
                                           value="{{ $dropdownOption }}" @if(isset($isShow)) readonly @endif>
                                </div>
                            </div>
                        @endforeach
                @endif
            </div>
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
        // show input if page show
        const input_type_show = '{{ $query->input_type ?? '' }}';
        const isShow = {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }};
        if(input_type_show === 'dropdown' || isShow) {
            $("#dropdown-data").show();
        }

        // listen if input_type change
        $("#input_type").on('change', function () {
            const me = $(this);
            const value = me.val();

            // dropdown data div
            const dropdownData = $("#dropdown-data");

            // show html if value select is dropdown
            if(value === 'dropdown') {
                dropdownData.show();
                $("#add-dropdown").click();
            } else {
                dropdownData.hide();
                $("#dropdown_option").val('');
            }
        });

        // tambah form dropdown option jika klik tambah
        $("#add-dropdown").on('click', function () {
            const randomID = Date.now();
            const divRandomId = "dropdown-option-data-" + randomID;

            $("#input-dropdown-result").append(`
                <div id=${divRandomId} class="col-md-12 form-row">
                    <div class="form-group col-md-2">
                        <button type="button" class="btn btn-danger btn-block" onclick="deleteButton(${randomID})">Delete</button>
                    </div>
                    <div class="form-group col-md-10">
                        <input type="text" class="form-control mb-2" name="dropdown_option[]" id="dropdown_option_${randomID}" placeholder="Opsi Dropdown">
                    </div>
                </div>
            `);
        })

        // delete button function
        function deleteButton(id)
        {
            $(`#dropdown-option-data-${id}`).remove();
        }
    </script>
@endsection
