@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="title">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Title" value="{{ old('title') ?? $query->title ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="tanggal">Tanggal</label>
            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="tanggal" placeholder="Tanggal" value="{{ old('tanggal') ?? $query->tanggal ?? '' }}" min="{{ now()->toDateString() }}" @if(isset($isShow)) readonly @endif>

            @error('tanggal')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-3">
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" name="jam_mulai" id="jam_mulai" placeholder="Jam Mulai" value="{{ old('jam_mulai') ?? $query->jam_mulai ?? '09:00' }}" @if(isset($isShow)) readonly @endif>

            @error('tanggal')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-3">
            <label for="jam_berakhir">Jam Berakhir</label>
            <input type="time" class="form-control @error('jam_berakhir') is-invalid @enderror" name="jam_berakhir" id="jam_berakhir" placeholder="Jam Berakhir" value="{{ old('jam_berakhir') ?? $query->jam_berakhir ?? '13:00' }}" @if(isset($isShow)) readonly @endif>

            @error('jam_berakhir')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="description">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" cols="30" rows="5" @if(isset($isShow)) readonly @endif>{{ old('description') ?? $query->description ?? '' }}</textarea>

            @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('select').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }}
        });
        $("#tanggal").datepicker({
            dateFormat: "dd/mm/yyyy"
        });
        $('#jam_mulai').timepicker({
            timeFormat: "HH:mm"
        });
        $('#jam_berakhir').timepicker({
            timeFormat: "HH:mm"
        });
    </script>
@endsection
