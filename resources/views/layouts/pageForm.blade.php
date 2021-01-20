@extends('layouts.adminlte.page-blank')

@section('title', $title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-outline card-success">
                <div class="card-body">
                    {{-- Form With Dynamic URL Action --}}
                    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Method For Edit Page --}}
                        @if(isset($isEdit))
                            @method('PATCH')
                        @endif

                        {{-- Include Form Dynamic --}}
                        @yield('form')

                        {{-- Waktu Pembuatan --}}
                        @if(!isset($isCreated))
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Tanggal Pembuatan</label>
                                    <input type="text" class="form-control" value="{{ $query->created_at }}" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Tanggal Perubahan</label>
                                    <input type="text" class="form-control" value="{{ $query->updated_at }}" readonly>
                                </div>
                            </div>
                        @endif

                        {{-- Button For Created Page --}}
                        @if(isset($isCreated))
                        <button type="submit" class="btn btn-primary m-auto">
                            <div class="row">
                                <div class="col-2">
                                    <i class="far fa-save"></i>
                                </div>
                                <div class="col">Save</div>
                            </div>
                        </button>

                        {{-- Button For Show Page --}}
                        @elseif(isset($isShow))
                        <a href="{{ $isShow }}" class="btn btn-warning m-auto">
                            <div class="row">
                                <div class="col-2">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="col">Edit</div>
                            </div>
                        </a>

                        {{-- Button For Edit Page --}}
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

                        {{-- Button For Back to Previous URL --}}
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
