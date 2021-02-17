@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="asesi_id">Asesi ID</label>
            <select class="form-control @error('asesi_id') is-invalid @enderror"
                    name="asesi_id" id="asesi_id">

                @foreach($asesis as $asesi)
                    <option
                        value="{{ $asesi->id }}"

                        @if(!empty(request()->query('asesi_id')) and request()->query('asesi_id') == $asesi->id)
                            {{  __('selected') }}
                        @elseif(isset($query->asesi_id) and $query->asesi_id == $asesi->id)
                            {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $asesi->id }}] - {{ $asesi->name }}
                    </option>
                @endforeach

            </select>

            @error('asesi_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="asesor_id">Asesor ID</label>
            <select class="form-control @error('asesor_id') is-invalid @enderror"
                    name="asesor_id" id="asesor_id">

                @foreach($asesors as $asesor)
                    <option
                        value="{{ $asesor->id }}"

                        @if(!empty(request()->query('asesor_id')) and request()->query('asesi_id') == $asesor->id)
                            {{  __('selected') }}
                        @elseif(isset($query->asesor_id) and $query->asesor_id == $asesor->id)
                            {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $asesor->id }}] - {{ $asesor->name }}
                    </option>
                @endforeach

            </select>

            @error('asesor_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="ujian_jadwal_id">Jadwal Ujian</label>
            <select class="form-control @error('ujian_jadwal_id') is-invalid @enderror"
                    name="ujian_jadwal_id" id="ujian_jadwal_id">

                @foreach($jadwalujians as $jadwalujian)
                    <option
                        value="{{ $jadwalujian->id }}"

                        @if(!empty(request()->query('ujian_jadwal_id')) and request()->query('ujian_jadwal_id') == $jadwalujian->id)
                            {{  __('selected') }}
                        @elseif(isset($query->ujian_jadwal_id) and $query->ujian_jadwal_id == $jadwalujian->id)
                            {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $jadwalujian->id }}] - {{ $jadwalujian->title }} (Tanggal: {{ \Carbon\Carbon::parse($jadwalujian->tanggal)->format('d/m/Y') }})
                    </option>
                @endforeach

            </select>

            @error('ujian_jadwal_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="sertifikasi_id">Sertifikasi ID</label>
            <select class="form-control @error('sertifikasi_id') is-invalid @enderror"
                    name="sertifikasi_id" id="sertifikasi_id">

                @foreach($sertifikasis as $sertifikasi)
                    <option
                        value="{{ $sertifikasi->id }}"

                        @if(!empty(request()->query('sertifikasi_id')) and request()->query('sertifikasi_id') == $sertifikasi->id)
                            {{  __('selected') }}
                        @elseif(isset($query->sertifikasi_id) and $query->sertifikasi_id == $sertifikasi->id)
                            {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $sertifikasi->id }}] - {{ $sertifikasi->title }} (Nomor Skema: {{ $sertifikasi->nomor_skema }})
                    </option>
                @endforeach

            </select>

            @error('sertifikasi_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="order_id">Order ID</label>
            <select class="form-control @error('order_id') is-invalid @enderror" name="order_id" id="order_id">

                @foreach($orders as $order)
                    <option
                        value="{{ $order->id }}"

                        @if(!empty(request()->query('order_id')) and request()->query('order_id') == $order->id)
                            {{  __('selected') }}
                        @elseif(isset($query->order_id) and $query->order_id == $order->id)
                            {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $order->id }}] - {{ $order->status }}
                    </option>
                @endforeach

            </select>

            @error('order_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.ujian_asesi_asesors_status') as $status)
                    <option
                        value="{{ $status }}"

                        @if(old('status') == $status)
                            {{ __('selected') }}
                        @elseif(isset($query->status) and !empty($query->status) and $query->status == $status)
                            {{ __('selected') }}
                        @endif
                    >
                        {{ ucwords(str_replace('_', ' ', $status)) }}
                    </option>
                @endforeach

            </select>

            @error('status')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>



        <div class="form-group col-md-6">
            <label for="is_kompeten">Kompeten</label>
            <select class="form-control" name="is_kompeten" id="is_kompeten" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.ujian_asesi_is_kompeten') as $key => $kompeten)
                    <option
                        value="{{ $key }}"

                        @if(old('is_kompeten') == $key)
                            {{ __('selected') }}
                        @elseif(isset($query->is_kompeten) and !empty($query->is_kompeten) and $query->is_kompeten == $key)
                            {{ __('selected') }}
                        @endif
                    >
                        {{ ucwords($kompeten) }}
                    </option>
                @endforeach

            </select>

            @error('is_kompeten')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="final_score_percentage">Skor Final</label>
            <input type="number" class="form-control @error('final_score_percentage') is-invalid @enderror" name="final_score_percentage" id="final_score_percentage" placeholder="Skor Final" value="{{ old('final_score_percentage') ?? $query->final_score_percentage ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('final_score_percentage')
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
