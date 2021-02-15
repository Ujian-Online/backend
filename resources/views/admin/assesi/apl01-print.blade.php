@extends('layouts.adminlte.master')
@section('title', $title)

@section('body')
    <div class="form-row">
        <div class="form-group col-md-12">
            <h3>{{ $title }}</h3>

            <div class="table-responsive mt-2 mb-2">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td width="20%">{{ trans('form.name') }}</td>
                            <td width="2%">:</td>
                            <td width="75%">{{ $query->name }}</td>
                        </tr>
                        <tr>
                            <td width="20%">{{ trans('form.nik') }}</td>
                            <td width="2%">:</td>
                            <td width="75%">{{ $query->no_ktp }}</td>
                        </tr>
                        <tr>
                            <td width="20%">{{ trans('form.gender') }}</td>
                            <td width="2%">:</td>
                            <td width="75%">{{ $query->gender }}</td>
                        </tr>
                        <tr>
                            <td width="20%">{{ trans('form.birth_place') }} & {{ trans('form.birth_date') }}</td>
                            <td width="2%">:</td>
                            <td width="75%">{{ $query->birth_place }}, {{ \Carbon\Carbon::parse($query->birth_date)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td width="20%">{{ trans('form.address') }}</td>
                            <td width="2%">:</td>
                            <td width="75%">{{ $query->address }}</td>
                        </tr>
                        <tr>
                            <td width="20%">{{ trans('form.phone_number') }}</td>
                            <td width="2%">:</td>
                            <td width="75%">{{ $query->phone_number }}</td>
                        </tr>
                        <tr>
                            <td width="20%">{{ trans('form.last_education') }}</td>
                            <td width="2%">:</td>
                            <td width="75%">{{ $query->pendidikan_terakhir }}</td>
                        </tr>
                        <tr>
                            <td width="20%">{{ trans('form.has_job') }}</td>
                            <td width="2%">:</td>
                            <td width="75%">{{ config('options.user_assesi_has_job')[$query->has_job] }}</td>
                        </tr>
                        <tr>
                            <td width="20%">{{ trans('form.job_title') }}</td>
                            <td width="2%">:</td>
                            <td width="75%">{{ $query->job_title ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td width="20%">{{ trans('form.job_address') }}</td>
                            <td width="2%">:</td>
                            <td width="75%">{{ $query->job_address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td width="20%">{{ trans('form.company_name') }}</td>
                            <td width="2%">:</td>
                            <td width="75%">{{ $query->company_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td width="20%">{{ trans('form.company_phone') }}</td>
                            <td width="2%">:</td>
                            <td width="75%">{{ $query->company_phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td width="20%">{{ trans('form.company_email') }}</td>
                            <td width="2%">:</td>
                            <td width="75%">{{ $query->company_email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td width="20%">{{ trans('form.is_verified') }}</td>
                            <td width="2%">:</td>
                            <td width="75%">{{ $query->is_verified ? 'Ya' : 'Tidak' }}</td>
                        </tr>
                        <tr>
                            <td width="20%">{{ trans('form.verification_note') }}</td>
                            <td width="2%">:</td>
                            <td width="75%">{{ $query->verification_note ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <h3>Asesi Custom Data</h3>

            <div class="table-responsive mt-2 mb-2">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th width="40%">Title</th>
                        <th width="25%">Data</th>
                        <th width="10%">Verified</th>
                        <th width="30%">Vertification Note</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($query->asesicustomdata as $asesicustomdata)
                        <tr id="asesicustomdata-{{ $asesicustomdata->id }}">
                            <th scope="row">{{ $asesicustomdata->title }}</th>
                            <td>
                                @if(in_array($asesicustomdata->input_type, ['upload_image', 'upload_pdf']))
                                    @if(!empty($asesicustomdata->value))
                                        {{$asesicustomdata->value}}
                                    @else
                                        File Belum di Unggah
                                    @endif
                                @else
                                    {{ $asesicustomdata->value }}
                                @endif
                            </td>
                            <td>{{ $asesicustomdata->is_verified ? 'YES' : 'NO' }}</td>
                            <td>{{ $asesicustomdata->verification_note }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>window.print();</script>
@endsection
