@extends('layouts.adminlte.page-auth')

@section('title', __('Login'))

@section('pagetype', __('login'))

@section('content')
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">{{ trans('theme.login_message') }}</p>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group row">
          <label for="username" class="col-md-12 col-sm-12 col-form-label">
            {{ trans('theme.email') }}
          </label>
          <div class="col-md-12 col-sm-12">
              <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="email" autofocus>

              @error('username')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
      </div>

      <div class="form-group row">
          <label for="password" class="col-md-12 col-sm-12 col-form-label">
            {{ trans('theme.password') }}
          </label>

          <div class="col-md-12 col-sm-12">
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
      </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

              <label class="form-check-label" for="remember">
                {{ trans('theme.remember_me') }}
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">
              <i class="fas fa-sign-in-alt"></i>
              {{ trans('theme.login') }}
            </button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      @if (Route::has('password.request'))
          <p class="mb-1">
            <a class="btn btn-link" href="{{ route('password.request') }}">
              {{ trans('theme.forgot_password') }}
            </a>
          </p>
      @endif
    </div>
  </div>
@endsection
