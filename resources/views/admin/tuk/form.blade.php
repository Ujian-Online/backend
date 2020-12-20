@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="user_id">User ID</label>
            <select class="form-control" name="user_id" id="user_id" readonly>

                @foreach($users as $user)
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
                @endforeach

            </select>
            @error('user_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.select2').select2({
            theme: 'bootstrap4',
            disabled: true
        });
    </script>
@endsection
