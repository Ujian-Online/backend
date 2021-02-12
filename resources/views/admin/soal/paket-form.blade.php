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
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-tasks"></i> Soal Pilihan Ganda</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <select class="form-control" id="soal_pilihanganda_id" data-placeholder="Pilih Soal Pilihan Ganda">
                    </select>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%" style="vertical-align: middle;">ID</th>
                                    <th width="75%" style="vertical-align: middle;">Pertanyaan</th>
                                    <th width="5%" style="vertical-align: middle;">Jawaban</th>
                                    <th width="5%" style="vertical-align: middle;">Max Score</th>
                                    <th width="10%" style="vertical-align: middle;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="soal-pilihanganda-result">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-tasks"></i> Soal Essay</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <select class="form-control" id="soal_essay_id" data-placeholder="Pilih Soal Essay">
                    </select>
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
        /**
         * Select2 with Ajax Start
         * @type {string}
         */

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

        // get id soalpilihanganda
        function soalpil() {
            const soalpil = $("input[name='soal_pilihanganda_id[]']")
                .map(function(){return $(this).val();}).get();

            // convert array to string with comma separate
            return soalpil.join();
        }

        // get id soalessay
        function soalessay() {
            const soalessay = $("input[name='soal_essay_id[]']")
                .map(function(){return $(this).val();}).get();

            // convert array to string with comma separate
            return soalessay.join();
        }

        function deltr(id) {
            $(`#${id}`).remove();
            $("#soal_pilihanganda_id").val('').trigger('change');
            $("#soal_essay_id").val('').trigger('change');
        }

        // soal select2 with ajax query search
        $('#soal_pilihanganda_id').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }},
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('admin.soal.search') }}',
                dataType: 'JSON',
                delay: 100,
                cache: false,
                data: function (data) {
                    return {
                        q: data.term,
                        type: 'multiple_option',
                        skip: soalpil()
                    }
                },
                processResults: function (response) {
                    return {
                        results: response
                    }
                }
            },
        });

        $('#soal_essay_id').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }},
            allowClear: true,
            ajax: {
                url: '{{ route('admin.soal.search') }}',
                dataType: 'JSON',
                delay: 100,
                cache: false,
                minimumInputLength: 1,
                data: function (data) {
                    return {
                        q: data.term,
                        type: 'essay',
                        skip: soalessay()
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
        // listen if soal_pilihanganda_id change
        $("#soal_pilihanganda_id").on('change', async function () {
           const me = $(this)
           const value = me.val();

           try {
               if(value) {
                   const request = await axios.get('{{ url('admin/soal/daftar')  }}' + `/${value}`);
                   const { data: response } = request;

                   $("#soal-pilihanganda-result").append(`
                        <tr id="pilihanganda-${response.id}">
                            <input type="hidden" name="soal_pilihanganda_id[]" value="${response.id}">
                            <td class="text-center">${response.id}</td>
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
        // listen if soal_pilihanganda_id change
        $("#soal_essay_id").on('change', async function () {
            const me = $(this)
            const value = me.val();

            try {
                if(value) {
                    const request = await axios.get('{{ url('admin/soal/daftar')  }}' + `/${value}`);
                    const { data: response } = request;

                    $("#soal-essay-result").append(`
                        <tr id="essay-${response.id}">
                            <input type="hidden" name="soal_essay_id[]" value="${response.id}">
                            <td class="text-center">${response.id}</td>
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
@endsection
