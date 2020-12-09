@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3>{{ $title }}</h3>

            <div class="card">
                <div class="card-body">
                    <form action="{{ $action }}" method="POST">
                        @csrf

                        @if(isset($isEdit))
                            @method('PATCH')
                        @endif

                        @include($pages)

                        @if(isset($isCreated))
                        <button type="submit" class="btn btn-primary m-auto">
                            <div class="row">
                                <div class="col-2">
                                    <i class="far fa-save"></i>
                                </div>
                                <div class="col">Save</div>
                            </div>
                        </button>
                        @elseif(isset($isShow))
                        <a href="{{ $isShow }}" class="btn btn-warning m-auto">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="col">Edit</div>
                            </div>
                        </a>
                        @elseif(isset($isEdit) and !empty($isEdit))
                            <button type="submit" class="btn btn-success m-auto">
                                <div class="row">
                                    <div class="col-2">
                                        <i class="fas fa-save"></i>
                                    </div>
                                    <div class="col">Update</div>
                                </div>
                            </button>
                        @endif

                        <a href="{{ url()->previous() }}" class="btn btn-secondary m-auto">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-arrow-alt-circle-left"></i>
                                </div>
                                <div class="col">Back</div>
                            </div>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection