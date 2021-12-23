@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="sertifikasi_id">Sertifikasi ID</label>
            <select class="form-control @error('sertifikasi_id') is-invalid @enderror"
                    name="sertifikasi_id" id="sertifikasi_id" data-placeholder="Pilih Sertifikasi ID">
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="title">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Title" value="{{ old('title') ?? $query->title ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="jenis_ujian">Jenis Ujian</label>
            <select name="jenis_ujian" id="jenis_ujian" class="form-control" @if(isset($isShow)) readonly @endif>
                @foreach(config('options.jenis_ujian') as $jenis_ujian)
                    <option
                        value="{{ $jenis_ujian }}"
                        @if(old('jenis_ujian') == $jenis_ujian)
                            {{ __('selected') }}
                        @elseif(isset($query->jenis_ujian) and $query->jenis_ujian == $jenis_ujian)
                            {{ __('selected') }}
                        @endif
                    >
                        {{ ucwords($jenis_ujian) }}
                    </option>
                @endforeach
            </select>

            @error('jenis_ujian')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="durasi_ujian">Durasi Ujian (Dalam Menit)</label>
            <input type="number" class="form-control @error('durasi_ujian') is-invalid @enderror" name="durasi_ujian" id="durasi_ujian" placeholder="Durasi Ujian" value="{{ old('durasi_ujian') ?? (isset($query) && $query->durasi_ujian ? durasi_ujian($query->durasi_ujian) : null) ?? '' }}" @if(isset($isShow)) readonly @endif>
            <p class="text-muted">Catatan: Durasi dalam menit (contoh 2 jam isinya 120)</p>

            @error('durasi_ujian')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group bg-gray col-md-12" id="soal-detail" style="display: none;">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="question">Pertanyaan</label>
                    <textarea class="form-control" id="question" cols="30" rows="3" readonly></textarea>
                </div>

                <div class="form-group col-md-6">
                    <label for="question_type">Tipe Pertanyaan</label>
                    <input type="text" class="form-control" id="question_type" placeholder="Tipe Pertanyaan" value="" style="text-transform: capitalize;" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-outline card-primary d-none" id="soal_pilihanganda_element">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">
                <span class="fa-stack">
                  <i class="far fa-circle fa-stack-2x"></i>
                  <i class="fas fa-tasks fa-stack-1x"></i>
                </span>
                Soal Pilihan Ganda
            </h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="mb-2">
                        <select class="form-control" id="soal_pilihanganda_ukid" data-placeholder="Pilih Unit Kompetensi"></select>
                    </div>
                    <div class="mb-2" id="soal_pilihanganda_parent_id" style="display: none;">
                        <select class="form-control" id="soal_pilihanganda_id" data-placeholder="Pilih Soal Pilihan Ganda"></select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%" style="vertical-align: middle;">No</th>
                                    <th width="75%" style="vertical-align: middle;">Pertanyaan</th>
                                    <th width="5%" style="vertical-align: middle;">Jawaban</th>
                                    <th width="5%" style="vertical-align: middle;">Max Score</th>
                                    <th width="10%" style="vertical-align: middle;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="soal-pilihanganda-result">
                            @if(isset($isShow) && isset($soal_pilihangandas) OR isset($isEdit) && isset($soal_pilihangandas))
                                @foreach($soal_pilihangandas as $key_soal_pilihanganda => $soal_pilihanganda)
                                    <tr id="pilihanganda-{{ $soal_pilihanganda->id }}">
                                        <input type="hidden" name="soal_pilihanganda_id[]" value="{{ $soal_pilihanganda->id }}">
                                        <td class="text-center">{{ $key_soal_pilihanganda + 1 }}</td>
                                        <td>
                                            {!! $soal_pilihanganda->question !!}
                                            <ol type="A">
                                                @if(isset($soal_pilihanganda->soalpilihanganda) and !empty($soal_pilihanganda->soalpilihanganda))
                                                    @foreach($soal_pilihanganda->soalpilihanganda as $pilganda)
                                                        <li>{{ $pilganda->option }}</li>
                                                    @endforeach
                                                @endif
                                            </ol>
                                        </td>
                                        <td class="text-center">{{ $soal_pilihanganda->answer_option }}</td>
                                        <td class="text-center">{{ $soal_pilihanganda->max_score }}</td>
                                        <td><button type="button" class="btn btn-danger" onclick="deltr('pilihanganda-{{ $soal_pilihanganda->id }}')" @if(isset($isShow)) disabled @endif >Delete</button></td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-outline card-info d-none" id="soal_essay_element">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">
                <span class="fa-stack">
                  <i class="far fa-circle fa-stack-2x"></i>
                  <i class="fas fa-pencil-alt fa-stack-1x"></i>
                </span>
                Soal Essay
            </h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="mb-2">
                        <select class="form-control" id="soal_essay_ukid" data-placeholder="Pilih Unit Kompetensi"></select>
                    </div>
                    <div class="mb-2" id="soal_essay_parent_id" style="display: none;">
                        <select class="form-control" id="soal_essay_id" data-placeholder="Pilih Soal Essay"></select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="text-center">
                                <th width="5%" style="vertical-align: middle;">ID</th>
                                <th width="40%" style="vertical-align: middle;">Pertanyaan</th>
                                <th width="40%" style="vertical-align: middle;">Jawaban</th>
                                <th width="5%" style="vertical-align: middle;">Max Score</th>
                                <th width="10%" style="vertical-align: middle;">Action</th>
                            </tr>
                            </thead>
                            <tbody id="soal-essay-result">
                            @if(isset($isShow) && isset($soal_essays) OR isset($isEdit) && isset($soal_essays))
                                @foreach($soal_essays as $key_soal_essay => $soal_essay)
                                    <tr id="essay-{{ $soal_essay->id }}">
                                        <input type="hidden" name="soal_essay_id[]" value="{{ $soal_essay->id }}">
                                        <td class="text-center">{{ $key_soal_essay + 1 }}</td>
                                        <td>{!! $soal_essay->question !!}</td>
                                        <td>{{ $soal_essay->answer_essay }}</td>
                                        <td class="text-center">{{ $soal_essay->max_score }}</td>
                                        <td><button type="button" class="btn btn-danger" onclick="deltr('essay-{{ $soal_essay->id }}')" @if(isset($isShow)) disabled @endif >Delete</button></td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-outline card-warning d-none" id="soal_lisan_element">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">
                <span class="fa-stack">
                  <i class="far fa-circle fa-stack-2x"></i>
                  <i class="fas fa-microphone-alt fa-stack-1x"></i>
                </span>
                Soal Lisan
            </h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="mb-2">
                        <select class="form-control" id="soal_lisan_ukid" data-placeholder="Pilih Unit Kompetensi"></select>
                    </div>
                    <div class="mb-2" id="soal_lisan_parent_id" style="display: none;">
                        <select class="form-control" id="soal_lisan_id" data-placeholder="Pilih Soal Lisan"></select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="text-center">
                                <th width="5%" style="vertical-align: middle;">ID</th>
                                <th width="40%" style="vertical-align: middle;">Pertanyaan</th>
                                <th width="40%" style="vertical-align: middle;">Jawaban</th>
                                <th width="5%" style="vertical-align: middle;">Max Score</th>
                                <th width="10%" style="vertical-align: middle;">Action</th>
                            </tr>
                            </thead>
                            <tbody id="soal-lisan-result">
                            @if(isset($isShow) && isset($soal_lisans) OR isset($isEdit) && isset($soal_lisans))
                                @foreach($soal_lisans as $key_soal_lisan => $soal_lisan)
                                    <tr id="lisan-{{ $soal_lisan->id }}">
                                        <input type="hidden" name="soal_lisan_id[]" value="{{ $soal_lisan->id }}">
                                        <td class="text-center">{{ $key_soal_lisan + 1 }}</td>
                                        <td>{!! $soal_lisan->question !!}</td>
                                        <td>{{ $soal_lisan->answer_essay }}</td>
                                        <td class="text-center">{{ $soal_lisan->max_score }}</td>
                                        <td><button type="button" class="btn btn-danger" onclick="deltr('lisan-{{ $soal_lisan->id }}')" @if(isset($isShow)) disabled @endif >Delete</button></td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-outline card-danger d-none" id="soal_wawancara_element">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">
                <span class="fa-stack">
                  <i class="far fa-circle fa-stack-2x"></i>
                  <i class="fas fa-user-friends fa-stack-1x"></i>
                </span>
                Soal Wawancara
            </h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="mb-2">
                        <select class="form-control" id="soal_wawancara_ukid" data-placeholder="Pilih Unit Kompetensi"></select>
                    </div>
                    <div class="mb-2" id="soal_wawancara_parent_id" style="display: none;">
                        <select class="form-control" id="soal_wawancara_id" data-placeholder="Pilih Soal Wawancara"></select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="text-center">
                                <th width="5%" style="vertical-align: middle;">ID</th>
                                <th width="40%" style="vertical-align: middle;">Pertanyaan</th>
                                <th width="5%" style="vertical-align: middle;">Max Score</th>
                                <th width="10%" style="vertical-align: middle;">Action</th>
                            </tr>
                            </thead>
                            <tbody id="soal-wawancara-result">
                                @if(isset($isShow) && isset($soal_wawancaras) OR isset($isEdit) && isset($soal_wawancaras))
                                    @foreach($soal_wawancaras as $key_soal_wawancara => $soal_wawancara)
                                        <tr id="wawancara-{{ $soal_wawancara->id }}">
                                            <input type="hidden" name="soal_wawancara_id[]" value="{{ $soal_wawancara->id }}">
                                            <td class="text-center">{{ $key_soal_wawancara + 1 }}</td>
                                            <td>{!! $soal_wawancara->question !!}</td>
                                            <td class="text-center">{{ $soal_wawancara->max_score }}</td>
                                            <td><button type="button" class="btn btn-danger" onclick="deltr('wawancara-{{ $soal_wawancara->id }}')" @if(isset($isShow)) disabled @endif >Delete</button></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')
    <script>

        const showHide = () => {
            const jenis_ujian = $('#jenis_ujian').val();
            if(jenis_ujian === 'wawancara') {
                $('#soal_pilihanganda_element').addClass('d-none');
                $('#soal_essay_element').addClass('d-none');
                $('#soal_lisan_element').removeClass('d-none');
                $('#soal_wawancara_element').removeClass('d-none');
            } else {
                $('#soal_pilihanganda_element').removeClass('d-none');
                $('#soal_essay_element').removeClass('d-none');
                $('#soal_lisan_element').addClass('d-none');
                $('#soal_wawancara_element').addClass('d-none');
            }
        }

        $('#jenis_ujian').on('change', () => {
            showHide();
        });

        showHide();

        const soalNumber = (key) => {
            const oldKey = localStorage.getItem(key);
            let newKey = 1;

            // check old key
            if(oldKey) {
                newKey = parseInt(oldKey) + parseInt(newKey);
            }

            // save key
            localStorage.setItem(key, newKey);
            return newKey;
        }

        // clean local storage in first load
        const cleanLocalStorage = () => {
            localStorage.removeItem('soal_pilihanganda_id');
            localStorage.removeItem('soal_essay_id');
            localStorage.removeItem('soal_wawancara_id');
            localStorage.removeItem('soal_lisan_id');
        }
        cleanLocalStorage();
    </script>
    <script>
        // default selected sertifikasi_id from query URL
        const sertifikasi_id_default = '{{ request()->input('sertifikasi_id') ?? $query->sertifikasi_id ?? null }}'
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
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }},
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
    </script>
    <script>
        function deltr(id) {
            $(`#${id}`).remove();
            $("#soal_pilihanganda_id").val('').trigger('change');
            $("#soal_essay_id").val('').trigger('change');
        }

        const Select2UKID = (UKId, ParentID) => {
            $(`#${UKId}`).select2({
                theme: 'bootstrap4',
                disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }},
                allowClear: true,
                minimumInputLength: 0,
                ajax: {
                    url: '{{ route('admin.sertifikasi.uk.search.sertifikasi') }}',
                    dataType: 'JSON',
                    delay: 100,
                    cache: false,
                    data: function (data) {
                        return {
                            q: data.term,
                            sertifikasi_id: $('#sertifikasi_id').val(),
                        }
                    },
                    processResults: function (response) {
                        $(`#${ParentID}`).show();

                        return {
                            results: response
                        }
                    }
                },
            })
            .on('change', function() {
                const sertifikasiId = $('#sertifikasi_id').val();
                if(!sertifikasiId) {
                    alert('Anda belum memilih Sertifikasi.!');
                }
            })
        }

        const soalCount = (id) => {
            const count = $(`input[name='${id}[]']`)
                .map(function(){return $(this).val();}).get();

            // convert array to string with comma separate
            return count.join();
        }

        const Select2SoalID = (UKID, Select2ID, Type) => {
            $(`#${Select2ID}`).select2({
                theme: 'bootstrap4',
                disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }},
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.soal.search') }}',
                    dataType: 'JSON',
                    delay: 100,
                    cache: false,
                    data: function (data) {
                        return {
                            q: data.term,
                            type: Type,
                            skip: soalCount(Select2ID),
                            sertifikasi_id: $('#sertifikasi_id').val(),
                            unit_kompetensi_id: $(`#${UKID}`).val(),
                        }
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        }
                    }
                },
            });
        }

        Select2UKID('soal_pilihanganda_ukid', 'soal_pilihanganda_parent_id');
        Select2SoalID('soal_pilihanganda_ukid', 'soal_pilihanganda_id', 'multiple_option');

        Select2UKID('soal_essay_ukid', 'soal_essay_parent_id');
        Select2SoalID('soal_essay_ukid', 'soal_essay_id', 'essay');

        Select2UKID('soal_lisan_ukid', 'soal_lisan_parent_id');
        Select2SoalID('soal_lisan_ukid', 'soal_lisan_id', 'lisan');

        Select2UKID('soal_wawancara_ukid', 'soal_wawancara_parent_id');
        Select2SoalID('soal_wawancara_ukid', 'soal_wawancara_id', 'wawancara');

        /**
         * Select2 with Ajax End
         * @type {string}
         */
    </script>
    <script>
        // listen if soal_pilihanganda_id change
        $("#soal_pilihanganda_id").on('change', async function () {
           const me = $(this)
           const value = me.val();

           try {
               if(value) {
                   const request = await axios.get('{{ url('admin/soal/daftar')  }}' + `/${value}`);
                   const { data: response } = request;

                   const soalID = soalNumber('soal_pilihanganda_id');

                   $("#soal-pilihanganda-result").append(`
                        <tr id="pilihanganda-${response.id}">
                            <input type="hidden" name="soal_pilihanganda_id[]" value="${response.id}">
                            <td class="text-center">${soalID}</td>
                            <td>
                                ${response.question}
                                <ol type="A">
                                    <li>${response.soalpilihanganda[0].option}</li>
                                    <li>${response.soalpilihanganda[1].option}</li>
                                    <li>${response.soalpilihanganda[2].option}</li>
                                    <li>${response.soalpilihanganda[3].option}</li>
                                </ol>
                            </td>
                            <td class="text-center">${response.answer_option}</td>
                            <td class="text-center">${response.max_score}</td>
                            <td><button type="button" class="btn btn-danger" onclick="deltr('pilihanganda-${response.id}')">Delete</button></td>
                        </tr>
                   `);
               }

           } catch (e) {
                alert('Gagal mengambil detail soal pilihan ganda.!');
           }
        });
    </script>
    <script>
        // listen if soal_essay_id change
        $("#soal_essay_id").on('change', async function () {
            const me = $(this)
            const value = me.val();

            try {
                if(value) {
                    const request = await axios.get('{{ url('admin/soal/daftar')  }}' + `/${value}`);
                    const { data: response } = request;

                    const soalID = soalNumber('soal_essay_id');

                    $("#soal-essay-result").append(`
                        <tr id="essay-${response.id}">
                            <input type="hidden" name="soal_essay_id[]" value="${response.id}">
                            <td class="text-center">${soalID}</td>
                            <td>${response.question}</td>
                            <td>${response.answer_essay}</td>
                            <td class="text-center">${response.max_score}</td>
                            <td><button type="button" class="btn btn-danger" onclick="deltr('essay-${response.id}')">Delete</button></td>
                        </tr>
                   `);
                }

            } catch (e) {
                alert('Gagal mengambil detail soal essay.!');
            }
        });
    </script>
    <script>
        // listen if soal_lisan_id change
        $("#soal_lisan_id").on('change', async function () {
            const me = $(this)
            const value = me.val();

            try {
                if(value) {
                    const request = await axios.get('{{ url('admin/soal/daftar')  }}' + `/${value}`);
                    const { data: response } = request;

                    const soalID = soalNumber('soal_lisan_id');

                    $("#soal-lisan-result").append(`
                        <tr id="lisan-${response.id}">
                            <input type="hidden" name="soal_lisan_id[]" value="${response.id}">
                            <td class="text-center">${soalID}</td>
                            <td>${response.question}</td>
                            <td>${response.answer_essay}</td>
                            <td class="text-center">${response.max_score}</td>
                            <td><button type="button" class="btn btn-danger" onclick="deltr('lisan-${response.id}')">Delete</button></td>
                        </tr>
                   `);
                }

            } catch (e) {
                alert('Gagal mengambil detail soal lisan.!');
            }
        });
    </script>
    <script>
        // listen if soal_wawancara_id change
        $("#soal_wawancara_id").on('change', async function () {
            const me = $(this)
            const value = me.val();

            try {
                if(value) {
                    const request = await axios.get('{{ url('admin/soal/daftar')  }}' + `/${value}`);
                    const { data: response } = request;

                    const soalID = soalNumber('soal_wawancara_id');

                    $("#soal-wawancara-result").append(`
                        <tr id="wawancara-${response.id}">
                            <input type="hidden" name="soal_wawancara_id[]" value="${response.id}">
                            <td class="text-center">${soalID}</td>
                            <td>${response.question}</td>
                            <td class="text-center">${response.max_score}</td>
                            <td><button type="button" class="btn btn-danger" onclick="deltr('wawancara-${response.id}')">Delete</button></td>
                        </tr>
                   `);
                }

            } catch (e) {
                alert('Gagal mengambil detail soal lisan.!');
            }
        });
    </script>
@endsection
