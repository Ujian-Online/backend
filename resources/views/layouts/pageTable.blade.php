@extends('layouts.adminlte.page-blank')

@section('title', $title)

@section('content')
<div class="container">
    <div class="row justify-content-center">

        {{-- Only Include View If Object View Found --}}
        @if(isset($filter_view) and !empty($filter_view))
            @include($filter_view)
        @endif

        <div class="col-md-12">
            <div class="card card-outline card-success">
                <div class="card-body">
                    @include('layouts.alert')

                    {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ mix('/js/admin.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
{!! $dataTable->scripts() !!}
<script>
    $('select').select2({
        theme: 'bootstrap4',
        disabled: false
    });
</script>
@endsection
