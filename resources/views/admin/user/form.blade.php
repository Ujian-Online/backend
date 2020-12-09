@extends('layouts.pageForm')

@section('form')
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{ $query->name ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" value="{{ $query->email ?? '' }}" @if(isset($isShow)) readonly @endif>
            
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-12">
            {{-- Password Field For Created Page --}}
            @if(isset($isCreated))
                <label for="password">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" value="{{ $query->password ?? '' }}" @if(isset($isShow)) readonly @endif>

                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            @endif

            {{-- New Password For Edit Page --}}
            @if(isset($isEdit))
                <label for="newpassword">New Password</label>
                <input type="password" class="form-control @error('newpassword') is-invalid @enderror" name="newpassword" id="newpassword" placeholder="New Password" autocomplete="new-password">
                <small id="helpNewPassword" class="text-muted">Kosongkan Form Jika Tidak Ingin Mengganti Password</small>

                @error('newpassword')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            @endif
        </div>
        <div class="form-group col-md-4">
            <label for="type">Type</label>
            <select class="form-control" name="type" id="type" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.user_type') as $type)
                    <option 
                        value="{{ $type }}"
                        @if(isset($query->type) and $query->type == $type)
                            selected
                        @endif
                    >
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
                
            </select>
            @error('type')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <label for="inputStatus">Status</label>
            <select class="form-control" name="status" id="inputStatus" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.user_status') as $status)
                    <option 
                        value="{{ $status }}"
                        @if(isset($query->status) and $query->status == $type)
                            selected
                        @endif
                    >
                        {{ ucfirst($status) }}
                    </option>
                @endforeach

            </select>
            @error('status')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <label for="is_active">Is Active</label>
            <select class="form-control" name="is_active" id="is_active" @if(isset($isShow)) readonly @endif>

                @if(isset($query->is_active) and !empty($query->is_active))
                    <option value="1" selected>Active</option>
                    <option value="0">Disable</option>
                @else
                    <option value="1">Active</option>
                    <option value="0" selected>Disable</option>
                @endif

            </select>
            @error('is_active')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endsection