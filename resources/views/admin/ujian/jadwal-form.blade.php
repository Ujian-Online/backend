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
            <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input @error('tanggal') is-invalid @enderror"
                       data-target="#datetimepicker2" name="tanggal" id="tanggal" placeholder="Tanggal"
                       value="{{ isset($query) ? \Carbon\Carbon::parse($query->tanggal)->format('d/m/Y') : now()->format('d/m/Y') }}"
                       @if(isset($isShow)) disabled @endif>
                <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>

            @error('tanggal')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-3">
            <label for="jam_mulai">Jam Mulai</label>
            <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input @error('jam_mulai') is-invalid @enderror"
                       data-target="#datetimepicker3" name="jam_mulai" id="jam_mulai"
                       placeholder="Jam Mulai" value="{{ old('jam_mulai') ?? $query->jam_mulai ?? '09:00' }}" @if(isset($isShow)) disabled @endif>
                <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                </div>
            </div>

            @error('tanggal')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-3">
            <label for="jam_berakhir">Jam Berakhir</label>
            <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input @error('jam_berakhir') is-invalid @enderror"
                       data-target="#datetimepicker4" name="jam_berakhir" id="jam_berakhir"
                       placeholder="Jam Mulai" value="{{ old('jam_berakhir') ?? $query->jam_berakhir ?? '13:00' }}" @if(isset($isShow)) disabled @endif>
                <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                </div>
            </div>

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
        $('#datetimepicker2').datetimepicker({
            useCurrent: false,
            format: 'DD/MM/YYYY',
            locale: 'id'
        });
        $('#datetimepicker3').datetimepicker({
            format: 'HH:mm'
        });
        $('#datetimepicker4').datetimepicker({
            format: 'HH:mm'
        });
    </script>
@endsection
