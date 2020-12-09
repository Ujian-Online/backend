@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <h3>{{ $title }}</h3>

                <div class="card">
                    <div class="card-body">
                        @include($pages)
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection