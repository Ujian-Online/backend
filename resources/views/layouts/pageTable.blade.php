@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <h3>{{ $title }}</h3>

                <div class="card">
                    <div class="card-body">
                        @include('layouts.alert')

                        {!! $dataTable->table() !!}
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link href="{{ asset('assets/DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('js')
<script src="{{ mix('/js/admin.js') }}"></script>
<script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
{!! $dataTable->scripts() !!}
@endsection