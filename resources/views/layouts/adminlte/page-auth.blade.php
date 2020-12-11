@extends('layouts.adminlte.master')

@section('bodyclass')
  @yield('pagetype')-page
@endsection

@section('body')
  <div class="@yield('pagetype')-box">
    <div class="@yield('pagetype')-logo">
      <a href="/"><b>{{ config('app.name', 'Laravel') }}</b></a>
    </div>

    @yield('content')
  </div>
@endsection
