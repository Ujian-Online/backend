@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">

            <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label">Nama</label>
                <div class="col-sm-8">
                    <input type="text" readonly class="form-control-plaintext" id="name" value="{{ (isset($user) and !empty($user->asesi)) ? $user->asesi->name : '' }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="sertifikasi" class="col-sm-4 col-form-label">Sertifikasi</label>
                <div class="col-sm-8">
                    <input type="text" readonly class="form-control-plaintext" id="sertifikasi" value="{{ (isset($sertifikasi) and !empty($sertifikasi)) ? $sertifikasi->title : '' }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="nomorskemasertifikasi" class="col-sm-4 col-form-label">Nomor Skema Sertifikasi</label>
                <div class="col-sm-8">
                    <input type="text" readonly class="form-control-plaintext" id="nomorskemasertifikasi" value="{{ (isset($sertifikasi) and !empty($sertifikasi)) ? $sertifikasi->nomor_skema : '' }}">
                </div>
            </div>

        </div>

    @if(isset($unitkompetensis) and !empty($unitkompetensis))
        @foreach($unitkompetensis as $unitkompentensi)
            <div class="form-group col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td rowspan="2" width="10%" class="bg-success">Unit Kompetensi Nomor: {{ $unitkompentensi->order }}</td>
                                <td width="10%">Kode Unit</td>
                                <td width="1px">:</td>
                                <td>{{ $unitkompentensi->kode_unit_kompetensi }}</td>
                            </tr>
                            <tr>
                                <td width="10%">Judul Unit</td>
                                <td width="1px">:</td>
                                <td>{{ $unitkompentensi->title }} @if(isset($unitkompentensi->sub_title) and !empty($unitkompentensi->sub_title)) ({{ $unitkompentensi->sub_title }}) @endif</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if(isset($unitkompentensi->asesisertifikasiunitkompetensielement) and !empty($unitkompentensi->asesisertifikasiunitkompetensielement))
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th width="60%">Element</th>
                                <th width="10%">File</th>
                                <th width="5%">Verify</th>
                                <th width="20%">Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unitkompentensi->asesisertifikasiunitkompetensielement as $key => $ukelement)
                                {{-- Hidden Input ID Element--}}
                                <input type="hidden" name="ukelement[id][]" value="{{ $ukelement->id }}">

                                <tr>
                                    <td>{{ $key + 1 }}.</td>
                                    <td>
                                        <p class="text-bold">{{ $ukelement->desc }}</p>
                                        <p>Bukti-Bukti Kompetensi:</p>
                                        <p>{!! nl2br($ukelement->upload_instruction) !!}</p>
                                    </td>
                                    <td>
                                        @if(isset($ukelement->media_url) and !empty($ukelement->media_url))
                                            <a class="btn btn-sm btn-primary btn-block" href="{{ $ukelement->media_url }}">Buka File</a>
                                        @else
                                            {{ _('File belum di unggah') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($isShow))
                                            {{ $ukelement->is_verified ? 'YES' : 'NO' }}
                                        @elseif(isset($isEdit))
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="ukelement[is_verified][{{$ukelement->id}}]"
                                                       id="ukelement-is_verified-{{$ukelement->id}}" value="1" @if($ukelement->is_verified == 1) {{ _('checked') }} @endif>
                                                <label class="form-check-label">YES</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="ukelement[is_verified][{{$ukelement->id}}]"
                                                       id="ukelement-is_verified-{{$ukelement->id}}" value="0" @if($ukelement->is_verified == 0) {{ _('checked') }} @endif>
                                                <label class="form-check-label">NO</label>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($isShow))
                                            {{ $ukelement->verification_note }}
                                        @elseif(isset($isEdit))
                                            <textarea class="form-control" rows="5"
                                                      name="ukelement[verification_note][{{$ukelement->id}}]"
                                                      id="ukelement-verification_note-{{$ukelement->id}}">{{ $ukelement->verification_note }}</textarea>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        @endforeach
    @endif


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