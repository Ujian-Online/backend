@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="user_id">User ID</label>
            <select class="form-control" name="user_id" id="user_id" readonly>

                @foreach($users as $user)
                    @if($user->type == 'tuk')
                        <option
                            value="{{ $user->id }}"
                            @if(!empty(request()->query('user_id')) and request()->query('user_id') == $user->id)
                                {{  __('selected') }}
                            @elseif(isset($query->user_id) and $query->user_id == $user->id)
                                {{  __('selected') }}
                            @endif
                        >
                            [ID: {{ $user->id }}] - {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endif
                @endforeach

            </select>
            @error('user_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
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
    </div>
@endsection

@section('js')
    <script>
        $('#user_id').select2({
            theme: 'bootstrap4',
            disabled: {{ (!empty(request()->query('user_id')) ? 'true' : ((isset($isCreated) and !empty($isCreated)) ?  'false' : 'true')) }}
        });
        $('#tuk_id').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ?  'true' :
            'false' }}
        });
    </script>
@endsection
