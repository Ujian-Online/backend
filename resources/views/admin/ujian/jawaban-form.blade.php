@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="soal_id">Soal ID</label>
            <select class="form-control @error('asesi_id') is-invalid @enderror" name="soal_id" id="soal_id">

                @foreach($soals as $soals)
                    <option
                        value="{{ $soals->id }}"

                        @if(!empty(request()->query('soal_id')) and request()->query('soal_id') == $soals->id)
                            {{  __('selected') }}
                        @elseif(isset($query->soal_id) and $query->soal_id == $soals->id)
                            {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $soals->id }}] - {{ $soals->question }}
                    </option>
                @endforeach

            </select>

            @error('soal_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="asesi_id">Asesi ID</label>
            <select class="form-control @error('asesi_id') is-invalid @enderror"
                    name="asesi_id" id="asesi_id">
            </select>

            @error('asesi_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="question">Question</label>
            <textarea class="form-control editorInput @error('question') is-invalid @enderror " name="question" id="question" cols="30" rows="5" @if(isset($isShow)) readonly @endif>{{ old('question') ?? $query->question ?? '' }}</textarea>

            @error('question')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="question_type">Question Type</label>
            <select class="form-control" name="question_type" id="question_type" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.ujian_asesi_jawabans_question_type') as $question_type)
                    <option
                        value="{{ $question_type }}"

                        @if(old('question_type') == $question_type)
                            {{ __('selected') }}
                        @elseif(isset($query->question_type) and !empty($query->question_type) and $query->question_type == $question_type)
                            {{ __('selected') }}
                        @endif
                    >
                        {{ ucwords(str_replace('_', ' ', $question_type)) }}
                    </option>
                @endforeach

            </select>

            @error('question_type')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="urutan">Urutan</label>
            <input type="number" class="form-control @error('urutan') is-invalid @enderror" name="urutan" id="urutan" placeholder="Urutan" value="{{ old('urutan') ?? $query->urutan ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('urutan')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>


        @if(isset($query) and $query->question_type == 'multiple_option')

        <div class="form-group col-md-12">
            <label for="answer_option">Answer Option</label>
            <select class="form-control" name="answer_option" id="answer_option" @if(isset($isShow)) readonly @endif>

                @foreach(config('options.ujian_asesi_jawabans_answer_option') as $answer_option)
                    <option
                        value="{{ $answer_option }}"

                        @if(old('answer_option') == $answer_option)
                            {{ __('selected') }}
                        @elseif(isset($query->answer_option) and !empty($query->answer_option) and $query->answer_option == $answer_option)
                            {{ __('selected') }}
                        @endif
                    >
                        {{ ucwords($answer_option) }}
                    </option>
                @endforeach

            </select>

            @error('answer_option')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        @else

        <div class="form-group col-md-12">
            <label for="answer_essay">Answer Essay</label>
            <textarea class="form-control editorInput @error('answer_essay') is-invalid @enderror" name="answer_essay" id="answer_essay" cols="30" rows="5" @if(isset($isShow)) readonly @endif>{{ old('answer_essay') ?? $query->answer_essay ?? '' }}</textarea>

            @error('answer_essay')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        @endif

        <div class="form-group col-md-12">
            <label for="user_answer">User Answer</label>
            <textarea class="form-control editorInput @error('user_answer') is-invalid @enderror" name="user_answer" id="user_answer" cols="30" rows="5" @if(isset($isShow)) readonly @endif>{{ old('user_answer') ?? $query->user_answer ?? '' }}</textarea>

            @error('user_answer')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="catatan_asesor">Catatan Asesor</label>
            <textarea class="form-control editorInput @error('catatan_asesor') is-invalid @enderror" name="catatan_asesor" id="catatan_asesor" cols="30" rows="5" @if(isset($isShow)) readonly @endif>{{ old('catatan_asesor') ?? $query->catatan_asesor ?? '' }}</textarea>

            @error('catatan_asesor')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="max_score">Max Score</label>
            <input type="number" class="form-control @error('max_score') is-invalid @enderror" name="max_score" id="max_score" placeholder="Max Score" value="{{ old('max_score') ?? $query->max_score ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('max_score')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="final_score">Final Score</label>
            <input type="number" class="form-control @error('final_score') is-invalid @enderror" name="final_score" id="final_score" placeholder="Final Score" value="{{ old('final_score') ?? $query->final_score ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('final_score')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>
@endsection

@section('js')
{{--    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>--}}
    <script>
        $('select').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }}
        });

        // CKEditor4
        // window.onload = function() {
        //     CKEDITOR.replaceAll( 'editorInput' );
        // };
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
@endsection
