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
        <div class="form-group col-md-6">
            <label for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{ old('name') ?? $query->name ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="met">MET</label>
            <input type="text" class="form-control @error('met') is-invalid @enderror" name="met" id="met" placeholder="Met" value="{{ old('met') ?? $query->met ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('met')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="expired_date">Expired Date</label>
            <input type="date" class="form-control @error('expired_date') is-invalid @enderror" name="expired_date" id="expired_date" placeholder="Expired Date" value="{{ old('expired_date') ?? $query->expired_date ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('expired_date')
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
        $('.select2').select2({
            theme: 'bootstrap4',
            disabled: true
        });
    </script>
@endsection
