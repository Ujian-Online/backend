@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="user_id">User ID</label>
            <select class="form-control" name="user_id" id="user_id" @if(isset($isShow)) readonly @endif>

                @foreach($users as $user)
                    <option
                        value="{{ $user->id }}"
                        @if(isset($query->user_id) and $query->user_id == $user->id)
                            selected
                        @endif
                    >
                        {{ $user->id }} - {{ $user->email }}
                    </option>
                @endforeach

            </select>
            @error('type')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{ $query->name ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="met">MET</label>
            <input type="text" class="form-control @error('met') is-invalid @enderror" name="met" id="met" placeholder="Met" value="{{ $query->met ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('met')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="expired_date">Expired Date</label>
            <input type="date" class="form-control @error('expired_date') is-invalid @enderror" name="expired_date" id="expired_date" placeholder="Expired Date" value="{{ $query->expired_date ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('expired_date')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-12">
            <label for="address">Address</label>
            <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" cols="30" rows="5" @if(isset($isShow)) readonly @endif>{{ $query->address ?? '' }}</textarea>

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
            disabled: {{ isset($isShow) ? 'true' : 'false' }}
        });
    </script>
@endsection
