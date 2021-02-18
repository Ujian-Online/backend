@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="ujian_jadwal_id">Jadwal Ujian</label>
            <select class="form-control @error('ujian_jadwal_id') is-invalid @enderror"
                    name="ujian_jadwal_id" id="ujian_jadwal_id" data-placeholder="Pilih Jadwal Ujian">
            </select>

            @error('ujian_jadwal_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        @can('isAdmin')
            <div class="form-group col-md-12">
                <label for="asesor_id">Asesor ID</label>
                <select class="form-control @error('asesor_id') is-invalid @enderror"
                        name="asesor_id" id="asesor_id" data-placeholder="Pilih Asesor ID">
                </select>

                @error('asesor_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-md-12">
                <label for="order_id">Order ID</label>
                <select class="form-control @error('order_id') is-invalid @enderror" name="order_id" id="order_id" data-placeholder="Pilih Order ID">
                </select>

                @error('order_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        @endcan

        <div class="form-group col-md-12">
            <label for="asesi_id">Asesi ID</label>
            <select class="form-control @error('asesi_id') is-invalid @enderror"
                    name="asesi_id" id="asesi_id" data-placeholder="Pilih Asesi ID">
            </select>

            @error('asesi_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="sertifikasi_id">Sertifikasi ID</label>
            <select class="form-control @error('sertifikasi_id') is-invalid @enderror"
                    name="sertifikasi_id" id="sertifikasi_id" data-placeholder="Pilih Sertifikasi ID">
            </select>

            @error('sertifikasi_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        @if(isset($isShow) OR isset($isEdit))

        <div class="form-group col-md-12">
            <label for="soal_paket_id">Soal Paket ID</label>
            <select class="form-control @error('soal_paket_id') is-invalid @enderror"
                    name="soal_paket_id" id="soal_paket_id" data-placeholder="Pilih Soal Paket ID">
            </select>

            @error('soal_paket_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status"
                @if(isset($isShow)) readonly @endif
                @if(isset($isEdit))
                    {{ _('readonly') }}
                @endif

            >

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

        <div class="form-group col-md-4">
            <label for="is_kompeten">Kompeten</label>
            <select class="form-control" name="is_kompeten" id="is_kompeten"
                @if(isset($isShow)) readonly @endif
                @if(isset($isEdit))
                    @can('isAdmin')
                        {{ _('readonly') }}
                    @endcan
                    @if(isset($query->status) and !empty($query->status) and in_array($query->status, ['menunggu','paket_soal_assigned']))
                        {{ _('readonly') }}
                    @endif
                @endif
            >

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

        <div class="form-group col-md-4">
            <label for="final_score_percentage">Skor Final</label>
            <input type="number" class="form-control @error('final_score_percentage') is-invalid @enderror"
                   name="final_score_percentage" id="final_score_percentage"
                   placeholder="Skor Final" value="{{ old('final_score_percentage') ?? $query->final_score_percentage ?? '' }}"
                   @if(isset($isShow)) readonly @endif
                   @if(isset($isEdit))
                       @can('isAdmin')
                           {{ _('readonly') }}
                       @endcan
                       @if(isset($query->status) and !empty($query->status) and $query->status != 'penilaian')
                           {{ _('readonly') }}
                       @endif
                   @endif
            >

            @error('final_score_percentage')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        @endif

    </div>
@endsection

@section('js')
    <script>
        // order_id watch
        $("#order_id").on('change', async function () {
            const me = $(this);
            const value = me.val();

            try {
                if(value) {
                    const request = await axios.get('{{ url('/admin/order') }}' + `/${value}`)
                    const { data: response } = request;

                    $.ajax({
                        url: '{{ route('admin.sertifikasi.search') }}' + '?q=' + response.sertifikasi_id,
                        dataType: 'JSON',
                    }).then(function (data) {
                        var sertifikasiSelected = $('#sertifikasi_id');
                        // create the option and append to Select2
                        var option = new Option(data[0].text, data[0].id, true, true);
                        sertifikasiSelected.append(option).trigger('change');

                        // manually trigger the `select2:select` event
                        sertifikasiSelected.trigger({
                            type: 'select2:select',
                            params: {
                                data: data
                            }
                        });
                    });
                    $.ajax({
                        url: '{{ route('admin.user.search') }}' + '?q=' + response.asesi_id + '&type=asessi',
                        dataType: 'JSON',
                    }).then(function (data) {
                        var userAsesiSelected = $('#asesi_id');
                        // create the option and append to Select2
                        var option = new Option(data[0].text, data[0].id, true, true);
                        userAsesiSelected.append(option).trigger('change');

                        // manually trigger the `select2:select` event
                        userAsesiSelected.trigger({
                            type: 'select2:select',
                            params: {
                                data: data
                            }
                        });
                    });
                }

            } catch (e) {
                alert('Gagal mengambil informasi order');
            }
        });
    </script>
    <script>
        /**
         * Select2 with Ajax Start
         * @type {string}
         */

            // default selected asesi_id from query URL
        const user_asesi_id_default = '{{ old('asesi_id') ?? request()->input('asesi_id') ?? $query->asesi_id ?? null }}'
        // trigger load data if user_asesi_id_default not null
        if(user_asesi_id_default) {
            var userAsesiSelected = $('#asesi_id');
            $.ajax({
                url: '{{ route('admin.user.search') }}' + '?q=' + user_asesi_id_default + '&type=asessi',
                dataType: 'JSON',
            }).then(function (data) {
                // create the option and append to Select2
                var option = new Option(data[0].text, data[0].id, true, true);
                userAsesiSelected.append(option).trigger('change');

                // manually trigger the `select2:select` event
                userAsesiSelected.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }

        // asesi select2 with ajax query search
        $('#asesi_id').select2({
            theme: 'bootstrap4',
            disabled: 'readonly',
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('admin.user.search') }}',
                dataType: 'JSON',
                delay: 100,
                cache: false,
                data: function (data) {
                    return {
                        q: data.term,
                        type: 'asessi' // see config('options.user_type')
                    }
                },
                processResults: function (response) {
                    return {
                        results: response
                    }
                }
            },
        });

        /**
         * Select2 with Ajax End
         * @type {string}
         */
    </script>
    <script>
        /**
         * Select2 with Ajax Start
         * @type {string}
         */

            // default selected asesor_id from query URL
        const user_asesor_id_default = '{{ old('asesor_id') ?? request()->input('asesor_id') ?? $query->asesor_id ?? null }}'
        // trigger load data if user_asesor_id_default not null
        if(user_asesor_id_default) {
            var userAsesorSelected = $('#asesor_id');
            $.ajax({
                url: '{{ route('admin.user.search') }}' + '?q=' + user_asesor_id_default + '&type=assesor',
                dataType: 'JSON',
            }).then(function (data) {
                // create the option and append to Select2
                var option = new Option(data[0].text, data[0].id, true, true);
                userAsesorSelected.append(option).trigger('change');

                // manually trigger the `select2:select` event
                userAsesorSelected.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }

        // asesor select2 with ajax query search
        $('#asesor_id').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : ((request()->user()->can('isAdmin') and in_array($query->status, ['menunggu','paket_soal_assigned'])) ? 'false' : true) }},
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('admin.user.search') }}',
                dataType: 'JSON',
                delay: 100,
                cache: false,
                data: function (data) {
                    return {
                        q: data.term,
                        type: 'assesor' // see config('options.user_type')
                    }
                },
                processResults: function (response) {
                    return {
                        results: response
                    }
                }
            },
        });

        /**
         * Select2 with Ajax End
         * @type {string}
         */
    </script>
    <script>
        /**
         * Select2 with Ajax Start
         * @type {string}
         */

            // default selected tuk_id from query URL
        const ujian_jadwal_id_default = '{{ old('ujian_jadwal_id') ?? $query->ujian_jadwal_id ?? null }}'
        // trigger load data if tuk_id_default not null
        if(ujian_jadwal_id_default) {
            var ujianJadwalSelected = $('#ujian_jadwal_id');
            $.ajax({
                url: '{{ route('admin.ujian.jadwal.search') }}' + '?q=' + ujian_jadwal_id_default,
                dataType: 'JSON',
            }).then(function (data) {
                // create the option and append to Select2
                var option = new Option(data[0].text, data[0].id, true, true);
                ujianJadwalSelected.append(option).trigger('change');

                // manually trigger the `select2:select` event
                ujianJadwalSelected.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }

        // tuk select2 with ajax query search
        $('#ujian_jadwal_id').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : ((request()->user()->can('isAdmin') and in_array($query->status, ['menunggu','paket_soal_assigned'])) ? 'false' : true) }},
            allowClear: true,
            ajax: {
                url: '{{ route('admin.ujian.jadwal.search') }}',
                dataType: 'JSON',
                delay: 100,
                cache: false,
                data: function (data) {
                    return {
                        q: data.term,
                        date: true
                    }
                },
                processResults: function (response) {
                    return {
                        results: response
                    }
                }
            },
        });

        /**
         * Select2 with Ajax End
         * @type {string}
         */
    </script>
    <script>
        /**
         * Select2 with Ajax Start
         * @type {string}
         */

            // default selected sertifikasi_id from query URL
        const sertifikasi_id_default = '{{ old('sertifikasi_id') ?? request()->input('sertifikasi_id') ?? $query->sertifikasi_id ?? null }}'
        // trigger load data if sertifikasi_id not null
        if(sertifikasi_id_default) {
            var sertifikasiSelected = $('#sertifikasi_id');
            $.ajax({
                url: '{{ route('admin.sertifikasi.search') }}' + '?q=' + sertifikasi_id_default,
                dataType: 'JSON',
            }).then(function (data) {
                // create the option and append to Select2
                var option = new Option(data[0].text, data[0].id, true, true);
                sertifikasiSelected.append(option).trigger('change');

                // manually trigger the `select2:select` event
                sertifikasiSelected.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }

        // sertifikasi select2 with ajax query search
        $('#sertifikasi_id').select2({
            theme: 'bootstrap4',
            disabled: true,
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('admin.sertifikasi.search') }}',
                dataType: 'JSON',
                delay: 100,
                cache: false,
                data: function (data) {
                    return {
                        q: data.term
                    }
                },
                processResults: function (response) {
                    return {
                        results: response
                    }
                }
            },
        });

        /**
         * Select2 with Ajax End
         * @type {string}
         */
    </script>

    <script>
        /**
         * Select2 with Ajax Start
         * @type {string}
         */

            // default selected soal_paket_id from query URL
        const soal_paket_id_default = '{{ old('soal_paket_id') ?? $query->soal_paket_id ?? null }}'
        // trigger load data if soal_id not null
        if(soal_paket_id_default) {
            var soalPaketSelected = $('#soal_paket_id');
            $.ajax({
                url: '{{ route('admin.soal.paket.search') }}' + '?q=' + soal_paket_id_default,
                dataType: 'JSON',
            }).then(function (data) {
                // create the option and append to Select2
                var option = new Option(data[0].text, data[0].id, true, true);
                soalPaketSelected.append(option).trigger('change');

                // manually trigger the `select2:select` event
                soalPaketSelected.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }

        // soal select2 with ajax query search
        $('#soal_paket_id').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isEdit) and !empty($isEdit) and request()->user()->can('isAssesor') and isset($query->status) and !empty($query->status) and $query->status == 'menunggu') ? 'false' : 'true' }},
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('admin.soal.paket.search') }}',
                dataType: 'JSON',
                delay: 100,
                cache: false,
                data: function (data) {
                    return {
                        q: data.term
                    }
                },
                processResults: function (response) {
                    return {
                        results: response
                    }
                }
            },
        });

        /**
         * Select2 with Ajax End
         * @type {string}
         */
    </script>
    <script>
        /**
         * Select2 with Ajax Start
         * @type {string}
         */

            // default selected order_id from query URL
        const order_id_default = '{{ old('order_id') ?? $query->order_id ?? null }}'
        // trigger load data if order_id not null
        if(order_id_default) {
            var orderSelected = $('#order_id');
            $.ajax({
                url: '{{ route('admin.order.search') }}' + '?q=' + order_id_default,
                dataType: 'JSON',
            }).then(function (data) {
                // create the option and append to Select2
                var option = new Option(data[0].text, data[0].id, true, true);
                orderSelected.append(option).trigger('change');

                // manually trigger the `select2:select` event
                orderSelected.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }

        // sertifikasi select2 with ajax query search
        $('#order_id').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isCreated) and !empty($isCreated)) ? 'false' : 'true' }},
            allowClear: true,
            ajax: {
                url: '{{ route('admin.order.search') }}',
                dataType: 'JSON',
                delay: 100,
                cache: false,
                data: function (data) {
                    return {
                        q: data.term,
                        status: 'payment_verified'
                    }
                },
                processResults: function (response) {
                    return {
                        results: response
                    }
                }
            },
        });

        /**
         * Select2 with Ajax End
         * @type {string}
         */
    </script>
@endsection
