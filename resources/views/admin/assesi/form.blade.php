@extends('layouts.pageForm')

@section('form')
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">{{ trans('form.name') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="{{ trans('form.name') }}" value="{{ $query->name ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="no_ktp">{{ trans('form.nik') }}</label>
            <input type="text" class="form-control @error('no_ktp') is-invalid @enderror" name="no_ktp" id="no_ktp" placeholder="{{ trans('form.nik') }}" value="{{ $query->no_ktp ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('no_ktp')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-12">
            <label for="address">{{ trans('form.address') }}</label>
            <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" cols="30" rows="3" @if(isset($isShow)) readonly @endif>{{ $query->address ?? '' }}</textarea>

            @error('address')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <label for="gender">{{ trans('form.gender') }}</label>
            <select class="form-control" name="gender" id="gender" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.user_assesi_gender') as $key_gender => $gender)
                    <option
                        value="{{ $gender }}"
                        @if(isset($query->gender) and $query->gender == $key_gender)
                            selected
                        @endif
                    >
                        {{ ucfirst($gender) }}
                    </option>
                @endforeach

            </select>
            @error('gender')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <label for="birth_date">{{ trans('form.birth_date') }}</label>
            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" id="birth_date" placeholder="{{ trans('form.birth_date') }}" value="{{ $query->birth_date ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('birth_date')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <label for="birth_place">{{ trans('form.birth_place') }}</label>
            <input type="text" class="form-control @error('birth_place') is-invalid @enderror" name="birth_place" id="birth_place" placeholder="{{ trans('form.birth_place') }}" value="{{ $query->birth_place ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('birth_place')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <label for="pendidikan_terakhir">{{ trans('form.last_education') }}</label>
            <select class="form-control" name="pendidikan_terakhir" id="pendidikan_terakhir" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.user_assesi_pendidikan_terakhir') as $pendidikan_terakhir)
                    <option
                        value="{{ $pendidikan_terakhir }}"
                        @if(isset($query->pendidikan_terakhir) and $query->pendidikan_terakhir == $pendidikan_terakhir)
                            selected
                        @endif
                    >
                        {{ ucfirst($pendidikan_terakhir) }}
                    </option>
                @endforeach

            </select>
            @error('pendidikan_terakhir')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <label for="has_job">{{ trans('form.has_job') }}</label>
            <select class="form-control" name="has_job" id="has_job" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.user_assesi_has_job') as $key_has_job => $has_job)
                    <option
                        value="{{ $has_job }}"
                        @if(isset($query->has_job) and $query->has_job == $key_has_job)
                            selected
                        @endif
                    >
                        {{ ucfirst($has_job) }}
                    </option>
                @endforeach

            </select>
            @error('pendidikan_terakhir')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-12">
            <label for="job_title">{{ trans('form.job_title') }}</label>
            <input type="text" class="form-control @error('job_title') is-invalid @enderror" name="job_title" id="job_title" placeholder="{{ trans('form.job_title') }}" value="{{ $query->job_title ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('job_title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-12">
            <label for="job_address">{{ trans('form.job_address') }}</label>
            <textarea class="form-control @error('job_address') is-invalid @enderror" name="job_address" id="job_address" cols="30" rows="3" @if(isset($isShow)) readonly @endif>{{ $query->job_address ?? '' }}</textarea>

            @error('job_address')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        {{-- <div class="form-group col-md-4">
            <label for="inputStatus">Status</label>
            <select class="form-control" name="status" id="inputStatus" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.user_status') as $status)
                    <option
                        value="{{ $status }}"
                        @if(isset($query->status) and $query->status == $type)
                            selected
                        @endif
                    >
                        {{ ucfirst($status) }}
                    </option>
                @endforeach

            </select>
            @error('status')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-4">
            <label for="is_active">Is Active</label>
            <select class="form-control" name="is_active" id="is_active" @if(isset($isShow)) readonly @endif>

                @if(isset($query->is_active) and !empty($query->is_active))
                    <option value="1" selected>Yes</option>
                    <option value="0">No</option>
                @else
                    <option value="1">Yes</option>
                    <option value="0" selected>No</option>
                @endif

            </select>
            @error('is_active')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div> --}}
    </div>
@endsection
