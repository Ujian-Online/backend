@extends('layouts.adminlte.master')

@section('bodyclass', 'sidebar-mini layout-fixed layout-navbar-fixed')

@section('body')
{{-- Site wrapper --}}
<div class="wrapper">
    {{-- Navbar --}}
    <nav class="main-header navbar navbar-expand navbar-green navbar-light">
      {{-- Left navbar links --}}
      @include('layouts.adminlte.navbar-left')

      {{-- SEARCH FORM --}}
      {{-- @include('layouts.adminlte.navbar-search') --}}

      {{-- Right navbar links --}}
      @include('layouts.adminlte.navbar-right')
    </nav>

    {{-- Main Sidebar Container --}}
    <aside class="main-sidebar sidebar-dark-green elevation-4">
      {{-- Brand Logo --}}
      <a href="/" class="brand-link {{ config('adminlte.sidebar.logo_color') ?? '' }} ">

        @if(!empty(config('adminlte.logo')))
          <img src="{{ asset(config('adminlte.logo')) }}"
             alt="{{ config('adminlte.title') }}"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        @endif

        <span class="brand-text font-weight-bold">{{ config('adminlte.title') }}</span>
      </a>

      {{-- Sidebar --}}
      <div class="sidebar">
        {{-- Sidebar Menu --}}
        @include('layouts.adminlte.sidebar')
        {{-- @include('layouts.adminlte.sidebar-ori') --}}
      </div>
    </aside>

    {{-- Page Content --}}
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        @include('layouts.adminlte.page-breadcrumb')
      </section>

      {{-- Main content --}}
      <section class="content">
        @yield('content')
      </section>
    </div>

    {{-- Footer --}}
    @include('layouts.adminlte.footer')
  </div>

@endsection
