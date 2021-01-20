@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" value="{{ old('email') ?? $query->email ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            {{-- Password Field For Created Page --}}
            @if(isset($isCreated))
                <label for="password">Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-sm btn-primary" onclick="showPassword(this, 'password', event)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" value="{{ $query->password ?? '' }}" @if(isset($isShow)) readonly @endif>
                </div>
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            @endif

            {{-- New Password For Edit Page --}}
            @if(isset($isEdit))
                <label for="newpassword">New Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-sm btn-primary" onclick="showPassword(this, 'newpassword', event)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <input type="password" class="form-control @error('newpassword') is-invalid @enderror" name="newpassword" id="newpassword" placeholder="New Password" autocomplete="new-password">
                </div>
                <small id="helpNewPassword" class="text-muted">Kosongkan Form Jika Tidak Ingin Mengganti Password</small>

                @error('newpassword')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            @endif
        </div>
        <div class="form-group col-md-6">
            <label for="type">Type</label>
            <select class="form-control" name="type" id="type" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.user_type') as $type)
                    <option
                        value="{{ $type }}"

                        @if(old('type') == $type)
                            {{ __('selected') }}
                        @elseif(isset($query->type) and !empty($query->type) and $query->type == $type)
                            {{ __('selected') }}
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
        <div class="form-group col-md-6">
            <label for="inputStatus">Status</label>
            <select class="form-control" name="status" id="inputStatus" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.user_status') as $status)
                    <option
                        value="{{ $status }}"

                        @if(old('status') == $status)
                            {{ __('selected') }}
                        @elseif(isset($query->status) and !empty($query->status) and $query->status == $status)
                            {{ __('selected') }}
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

        <div class="form-group col-md-6">
            <label for="media_url">Profile Picture</label>

            @if(isset($isCreated) OR isset($isEdit))
                <input type="file" class="form-control-file @error('upload_profile') is-invalid @enderror" name="upload_profile" id="upload_profile" accept=".jpg,.jpeg,.png">
                <small id="helpFileUpload" class="text-muted">File Type: .jpg, .jpeg, .png</small>

                @error('upload_profile')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            @endif

            @if(isset($isShow))
                @if($query->media_url)
                    <img src="{{ $query->media_url }}" class="img-thumbnail img-fluid" alt="" />
                @else
                    <p>{{ _('Tidak ada Profile Picture') }}</p>
                @endif
            @endif

        </div>

        <div class="form-group col-md-6">
            <label for="media_url_sign_user">TTD/Paraf</label>

            @if(isset($isCreated) OR isset($isEdit))
                <input type="file" class="form-control-file @error('upload_sign') is-invalid @enderror" name="upload_sign" id="upload_profile" accept=".jpg,.jpeg,.png">
                <small id="helpFileUpload" class="text-muted">File Type: .jpg, .jpeg, .png</small>

                @error('upload_sign')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            @endif

            @if(isset($isShow))
                @if($query->media_url_sign_user)
                    <img src="{{ $query->media_url_sign_user }}" class="img-thumbnail img-fluid" alt="" />
                @else
                    <p>{{ _('Tidak ada TTD/Paraf') }}</p>
                @endif
            @endif

        </div>
    </div>
@endsection

@section('js')
    <script>
        $('select').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }}
        });

        // password show hide
        function showPassword(element, id, event) {
            event.preventDefault();

            // get input
            let inputPassword = document.getElementById(id);

            // check input type
            if (inputPassword.type === "password") {
                // update button click
                element.innerHTML = '<i class="fas fa-eye-slash"></i>';

                // change input type
                inputPassword.type = "text";
            } else {
                // update button click
                element.innerHTML = '<i class="fas fa-eye"></i>';

                // change input type
                inputPassword.type = "password";
            }
        }
    </script>
@endsection
