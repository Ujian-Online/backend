@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="unit_kompetensi_id">Unit Kompetensi</label>
            <select class="form-control @error('unit_kompetensi_id') is-invalid @enderror"
                    name="unit_kompetensi_id" id="unit_kompetensi_id" data-placeholder="Unit Kompetensi">
            </select>

            @error('unit_kompetensi_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="question">Pertanyaan</label>
            <textarea class="form-control @error('question') is-invalid @enderror" name="question" id="question" cols="30" rows="3" @if(isset($isShow)) readonly @endif>{{ old('question') ?? ($query->question ?? '') }}</textarea>

            @error('question')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="question_type">Tipe Pertanyaan</label>
            <select name="question_type" id="question_type" class="form-control" @if(isset($isShow)) readonly @endif>
                @foreach(config('options.question_type') as $type)
                    <option
                        value="{{ $type }}"
                        @if(old('question_type') == $type)
                            selected
                        @elseif(isset($query->question_type) and $query->question_type == $type)
                            selected
                        @endif
                        >
                            {{ ucwords(str_replace('_', ' ', $type)) }}
                        </option>
                @endforeach
            </select>

            @error('question_type')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6" id="answer_option_element">
            <label for="answer_option">Opsi Jawaban</label>
            <select name="answer_option" id="answer_option" class="form-control" @if(isset($isShow)) readonly @endif>
                <option value="" readonly>Tidak Dipilih</option>

                @foreach(config('options.answer_option') as $opsi)
                    <option
                        value="{{ $opsi }}"
                        @if(old('answer_option') == $opsi)
                            selected
                        @elseif(isset($query->answer_option) and $query->answer_option == $opsi)
                            selected
                        @endif
                        >
                            {{ ucfirst($opsi) }}
                        </option>
                @endforeach
            </select>

            @error('answer_option')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12" id="answer_essay_element">
            <label for="answer_essay">Jawaban Essay</label>
            <textarea class="form-control @error('answer_essay') is-invalid @enderror" name="answer_essay" id="answer_essay" cols="30" rows="3" @if(isset($isShow)) readonly @endif>{{ old('answer_essay') ?? ($query->answer_essay ?? '') }}</textarea>

            @error('answer_essay')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="max_score">Max Score</label>
            <input type="number" class="form-control @error('max_score') is-invalid @enderror" name="max_score" id="max_score" placeholder="Score" value="{{ old('max_score') ?? ($query->max_score ?? '') }}" @if(isset($isShow)) readonly @endif>

            @error('max_score')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-row" id="pilihan-ganda" @if(old('question_type') == 'essay' OR (isset($query->answer_option) and $query->answer_option == 'essay')) style="display: none;" @endif>
        <h3>Pilihan Ganda</h3>
        <div class="form-group col-md-12">
            <label for="option_a">Option A</label>
            <input type="text" class="form-control @error('option_a') is-invalid @enderror" name="option_a" id="option_a" placeholder="Option A" value="{{ old('option_a') ?? $pilihangandas['a']->option ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('option_a')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-12">
            <label for="option_b">Option B</label>
            <input type="text" class="form-control @error('option_b') is-invalid @enderror" name="option_b" id="option_b" placeholder="Option B" value="{{ old('option_b') ?? $pilihangandas['b']->option ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('option_b')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-12">
            <label for="option_c">Option C</label>
            <input type="text" class="form-control @error('option_c') is-invalid @enderror" name="option_c" id="option_c" placeholder="Option C" value="{{ old('option_c') ?? $pilihangandas['c']->option ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('option_c')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-12">
            <label for="option_d">Option D</label>
            <input type="text" class="form-control @error('option_d') is-invalid @enderror" name="option_d" id="option_d" placeholder="Option D" value="{{ old('option_d') ?? $pilihangandas['d']->option ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('option_d')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#question_type').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isCreated) and !empty($isCreated)) ? 'false' : 'true' }}
        });
        $('#answer_option').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }}
        });


        const hide = () => {
            let answerOptionEl = $('#answer_option_element')
            let answerEssayEl = $('#answer_essay_element')
            let answerOption = $('#answer_option')
            let answerEssay = $('#answer_essay')
            const pilihanGanda = $("#pilihan-ganda");

            if($('#question_type').val() == 'essay') {
                answerOptionEl.addClass('d-none')
                answerOption.attr('name', 'none')
                answerEssayEl.removeClass('d-none')
                answerEssay.attr('name', 'answer_essay')

                // hide pilihan ganda option
                pilihanGanda.hide();
            } else {
                answerOptionEl.removeClass('d-none')
                answerOption.attr('name', 'answer_option')
                answerEssayEl.addClass('d-none')
                answerEssay.attr('name', 'none')

                // show pilihan ganda option
                pilihanGanda.show();
            }
        }
        hide()
        $('#question_type').on('change', () => {
            hide()
        })
    </script>
    <script>
        /**
         * Select2 with Ajax Start
         * @type {string}
         */

        // default selected sertifikasi_id from query URL
        const unitkompetensi_id_default = '{{ $query->unit_kompetensi_id ?? null }}'
        // trigger load data if id not null
        if(unitkompetensi_id_default) {
            var ukSelected = $('#unit_kompetensi_id');
            $.ajax({
                url: '{{ route('admin.sertifikasi.uk.search') }}' + '?q=' + unitkompetensi_id_default,
                dataType: 'JSON',
            }).then(function (data) {
                // create the option and append to Select2
                var option = new Option(data[0].text, data[0].id, true, true);
                ukSelected.append(option).trigger('change');

                // manually trigger the `select2:select` event
                ukSelected.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }

        // select2 with ajax query search
        $('#unit_kompetensi_id').select2({
            theme: 'bootstrap4',
            disabled: '{{ isset($isShow) and !empty($isShow) ? 'readonly' : 'false' }}',
            allowClear: true,
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('admin.sertifikasi.uk.search') }}',
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
@endsection
