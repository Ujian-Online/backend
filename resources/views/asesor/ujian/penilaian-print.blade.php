@extends('layouts.adminlte.master')
@section('title', $title)

@section('css')
    <style>
        td {
            border: 1px solid black !important;
        }

        th {
            border: 1px solid black !important;
        }
    </style>
@endsection

@section('body')
    @include('asesor.ujian.penilaian-print-pil-ganda')
@endsection
