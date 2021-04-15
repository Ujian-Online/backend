@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" value="{{ old('email') ?? $query->email ?? '' }}" readonly>

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
            <input type="text" class="form-control text-uppercase" value="{{ $query->type }}" readonly>
        </div>
        <div class="form-group col-md-6">
            <label for="inputStatus">Status</label>
            <input type="text" class="form-control text-uppercase" value="{{ $query->status }}" readonly>
        </div>

        <div class="form-group col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <label for="media_url">Profile Picture</label>
                </div>
                <div class="col-md-12">
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
                            <p>{{ __('Tidak ada Profile Picture') }}</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group centered col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <label for="upload_sign">TTD/Paraf</label>
                </div>
                <div class="col-md-12">
                    @if(isset($isCreated) OR isset($isEdit))
                        <input type="file" class="form-control-file @error('upload_sign') is-invalid @enderror" name="upload_sign" id="upload_sign" accept=".jpg,.jpeg,.png">
                        <small id="helpFileUpload" class="text-muted">File Type: .jpg, .jpeg, .png</small>

                        @error('upload_sign')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    @endif

                    @if(isset($isShow))
                        @if($query->media_url_sign_user)
                            <img src="{{ $query->media_url_sign_user }}" class="img-thumbnail img-fluid" alt="" />
                        @else
                            <p>{{ __('Tidak ada TTD/Paraf') }}</p>
                        @endif
                    @endif
                </div>
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
