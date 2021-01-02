@extends('layouts.pageForm')

@section('form')
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="user_id">User ID</label>
            <select class="form-control" name="user_id" id="user_id" @if(isset($isShow)) readonly @endif>

            @foreach($users as $user)
                @if($user->type == 'asessi')
                    <option
                        value="{{ $user->id }}"
                        @if(isset($query->user_id) and $query->user_id == $user->id)
                            selected
                        @endif
                    >
                        ID: {{ $user->id }} - {{ $user->email }}
                    </option>
                @endif
            @endforeach

            </select>
            @error('user_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
                <label for="user_id_admin">User ID Admin</label>
                <select class="form-control" name="user_id_admin" id="user_id_admin" @if(isset($isShow)) readonly @endif>

                @foreach($users as $user)
                    @if($user->type != 'asessi')
                        <option
                            value="{{ $user->id }}"
                            @if(isset($query->user_id_admin) and $query->user_id_admin == $user->id)
                                selected
                            @endif
                        >
                            ID: {{ $user->id }} - {{ $user->email }} [{{ ucfirst
                            ($user->type) }}]
                        </option>
                    @endif
                @endforeach

                </select>
                @error('user_id_admin')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
        </div>

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

        <div class="form-group col-md-12">
            <label for="phone_number">{{ trans('form.phone_number') }}</label>
            <input type="number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" id="phone_number" placeholder="{{ trans('form.phone_number') }}" value="{{ $query->phone_number ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('phone_number')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="gender">{{ trans('form.gender') }}</label>
            <select class="form-control" name="gender" id="gender" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.user_assesi_gender') as $key_gender => $gender)
                    <option
                        value="{{ $key_gender }}"
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
            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" id="birth_date" placeholder="{{ trans('form.birth_date') }}" value="{{ isset($query->birth_date) ? date('Y-m-d', strtotime($query->birth_date)) : '' }}" @if(isset($isShow)) readonly @endif>

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
                        value="{{ $key_has_job }}"
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
            <textarea class="form-control @error('job_address') is-invalid @enderror" name="job_address" id="job_address" cols="30" rows="3" placeholder="{{ trans('form.job_address') }}" @if(isset($isShow)) readonly @endif>{{ $query->job_address ?? '' }}</textarea>

            @error('note_admin')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="note_admin">{{ trans('form.note_admin') }}</label>
            <textarea class="form-control @error('note_admin') is-invalid @enderror" name="note_admin" id="note_admin" cols="30" rows="3" placeholder="{{ trans('form.note_admin') }}" @if(isset($isShow)) readonly @endif>{{ $query->note_admin ?? '' }}</textarea>

            @error('note_admin')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-12">
            <label for="verification_note">{{ trans('form.verification_note') }}</label>
            <textarea class="form-control @error('verification_note') is-invalid @enderror" name="verification_note" id="verification_note" cols="30" rows="3" placeholder="{{ trans('form.verification_note') }}" @if(isset($isShow)) readonly @endif>{{ $query->verification_note ?? '' }}</textarea>

            @error('verification_note')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-12">
            <label for="is_verified">Is Verified</label>
            <select class="form-control" name="is_verified" id="is_verified" @if(isset($isShow)) readonly @endif>

                @if(isset($query->is_verified) and !empty($query->is_verified))
                    <option value="1" selected>Yes</option>
                    <option value="0">No</option>
                @else
                    <option value="1">Yes</option>
                    <option value="0" selected>No</option>
                @endif

            </select>
            @error('is_verified')
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
    </script>
@endsection
