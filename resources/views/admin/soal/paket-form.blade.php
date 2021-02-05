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

        <div class="form-group col-md-12">
            <label for="soal_id">Soal ID</label>
            <select class="form-control @error('soal_id') is-invalid @enderror"
                    name="soal_id" id="soal_id" data-placeholder="Pilih Soal ID">
            </select>

            @error('soal_id')
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

            // default selected soal_id from query URL
        const soal_id_default = '{{ request()->input('soal_id') ?? null }}'
        // trigger load data if soal_id not null
        if(soal_id_default) {
            var soalSelected = $('#soal_id');
            $.ajax({
                url: '{{ route('admin.soal.search') }}' + '?q=' + soal_id_default,
                dataType: 'JSON',
            }).then(function (data) {
                // create the option and append to Select2
                var option = new Option(data[0].text, data[0].id, true, true);
                soalSelected.append(option).trigger('change');

                // manually trigger the `select2:select` event
                soalSelected.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }

        // soal select2 with ajax query search
        $('#soal_id').select2({
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
        // listen if soal_id change
        $("#soal_id").on('change', async function () {
           const me = $(this)
           const value = me.val();

           try {
               const request = await axios.get('{{ url('admin/soal/daftar')  }}' + `/${value}`);
               const { data: response } = request;

               // show soal html
               $("#soal-detail").show();

               // change value question
               $("#question").val(response.question);
               // change value question_type
               // format value
               const questionType = response.question_type;
               $("#question_type").val(questionType.replace('_', ' '));

           } catch (e) {

           }
        });
    </script>
@endsection
