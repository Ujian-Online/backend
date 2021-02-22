@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

            @can('isAdmin')
                <div class="form-group col-md-6">
                    <label for="tuk_id">TUK ID</label>
                    <select class="form-control @error('tuk_id') is-invalid @enderror"
                            name="tuk_id" id="tuk_id" data-placeholder="Pilih TUK ID">
                    </select>

                    @error('tuk_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            @endcan

            @can('isTuk')
                <input type="hidden" name="tuk_id" value="{{ $query->tuk_id ?? '' }}">
            @endcan
        <div class="form-group col-md-6">
            <label for="bank_name">Bank</label>
            <select class="form-control" name="bank_name" id="bank_name" @if(isset
            ($isShow)) readonly @endif>

                @foreach(config('options.tuk_bank_name') as $bank_name)
                    <option
                        value="{{ $bank_name }}"

                        @if(old('bank') == $bank_name)
                            {{ __('selected') }}
                        @elseif(isset($query->bank_name) and !empty($query->bank_name) and
                         $query->bank_name == $bank_name)
                            {{ __('selected') }}
                        @endif
                    >
                        {{ ucwords($bank_name) }}
                    </option>
                @endforeach

            </select>

            @error('bank_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="account_number">Nomor Rekening</label>
            <input type="number" class="form-control @error('account_number')
                is-invalid
@enderror" name="account_number" id="account_number" placeholder="Nomor Rekening" value="{{ old
('account_number') ??
 $query->account_number ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('account_number')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="account_name">Nama Rekening</label>
            <input type="text" class="form-control @error('account_name') is-invalid
@enderror" name="account_name" id="account_name" placeholder="Nama Rekening" value="{{ old
('account_name') ??
 $query->account_name ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('account_name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#bank_name').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }}
        });
    </script>

    <script>
        /**
         * Select2 with Ajax Start
         * @type {string}
         */

            // default selected tuk_id from query URL
        const tuk_id_default = '{{ request()->input('tuk_id') ?? null }}'
        // trigger load data if tuk_id_default not null
        if(tuk_id_default) {
            var tukSelected = $('#tuk_id');
            $.ajax({
                url: '{{ route('admin.tuk.search') }}' + '?q=' + tuk_id_default,
                dataType: 'JSON',
            }).then(function (data) {
                // create the option and append to Select2
                var option = new Option(data[0].text, data[0].id, true, true);
                tukSelected.append(option).trigger('change');

                // manually trigger the `select2:select` event
                tukSelected.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }

        // tuk select2 with ajax query search
        $('#tuk_id').select2({
            theme: 'bootstrap4',
            disabled: false,
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('admin.tuk.search') }}',
                dataType: 'JSON',
                delay: 100,
                cache: false,
                data: function (data) {
                    return {
                        q: data.term
                    }
                },
                processResults: function (response) {
                    return {
                        results: response
                    }
                }
            },
        });

        /**
         * Select2 with Ajax End
         * @type {string}
         */
    </script>
@endsection
