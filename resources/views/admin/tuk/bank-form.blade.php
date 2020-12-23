@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="tuk_id">TUK ID</label>
            <select class="form-control @error('tuk_id') is-invalid @enderror"
                    name="tuk_id" id="tuk_id">

                @foreach($tuks as $tuk)
                    <option
                        value="{{ $tuk->id }}"
                    @if(!empty(request()->query('tuk_id')) and request()
                    ->query('tuk_id') == $tuk->id)
                        {{  __('selected') }}
                        @elseif(isset($query->tuk_id) and $query->tuk_id ==
                        $tuk->id)
                        {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $tuk->id }}] - {{ $tuk->title }} ({{
                        $tuk->code }})
                    </option>
                @endforeach

            </select>

            @error('tuk_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
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
        $('select').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }}
        });
    </script>
@endsection
