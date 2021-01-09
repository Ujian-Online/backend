@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">
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
                            {{ ucfirst($type) }}
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
                <option>Tidak Dipilih</option>
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
@endsection

@section('js')
    <script>
        $('select').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }}
        });
        const hide = () => {
            let answerOptionEl = $('#answer_option_element')
            let answerEssayEl = $('#answer_essay_element')
            let answerOption = $('#answer_option')
            let answerEssay = $('#answer_essay')
            if($('#question_type').val() == 'essay') {
                answerOptionEl.addClass('d-none')
                answerOption.attr('name', 'none')
                answerEssayEl.removeClass('d-none')
                answerEssay.attr('name', 'answer_essay')
            } else {
                answerOptionEl.removeClass('d-none')
                answerOption.attr('name', 'answer_option')
                answerEssayEl.addClass('d-none')
                answerEssay.attr('name', 'none')
            }
        }
        hide()
        $('#question_type').on('change', () => {
            hide()
        })
    </script>
@endsection
