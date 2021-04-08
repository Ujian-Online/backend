@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="title">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Title" value="{{ old('title') ?? $query->title ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-12">
            <label for="sub_title">Sub Title</label>
            <input type="text" class="form-control @error('sub_title') is-invalid @enderror" name="sub_title" id="sub_title" placeholder="Sub Title" value="{{ old('sub_title') ?? $query->sub_title ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('sub_title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="kode_unit_kompetensi">Kode Unit Kompentensi</label>
            <input type="text" class="form-control @error('kode_unit_kompetensi') is-invalid @enderror" name="kode_unit_kompetensi" id="kode_unit_kompetensi" placeholder="Kode Unit Kompentensi" value="{{ old('kode_unit_kompetensi') ?? $query->kode_unit_kompetensi ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('kode_unit_kompetensi')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

{{--        <div class="form-group col-md-6">--}}
{{--            <label for="order">Urutan</label>--}}
{{--            <input type="number" class="form-control @error('order') is-invalid @enderror" name="order" id="order" placeholder="Order" value="{{ old('order') ?? $query->order ?? '' }}" @if(isset($isShow)) readonly @endif>--}}

{{--            @error('order')--}}
{{--                <div class="alert alert-danger">{{ $message }}</div>--}}
{{--            @enderror--}}
{{--        </div>--}}
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-tasks"></i> Unit Kompetensi Element</h3>
        </div>
        <div class="card-body">
            @if(old('desc') && old('upload_instruction'))
                @php
                    // fetch old input
                    $descs = old('desc');
                    $upload_instructions = old('upload_instruction');
                @endphp
                @foreach($descs as $key => $desc)
                    @include('admin.sertifikasi-uk.form-element', [
                                'id' => str_replace('new-', '', $key),
                                'desc' => $desc,
                                'upload_instruction' => $upload_instructions[$key]
                            ])
                @endforeach
            @endif

            {{--  Load UK Element  --}}
            @if(isset($isShow) OR isset($isEdit))
                <div class="form-row mb-4">
                    @if(count($query->ukelement) > 0)
                        @foreach($query->ukelement as $ukelement)
                            @include('admin.sertifikasi-uk.form-element', [
                                'view' => true,
                                'show' => isset($isShow),
                                'edit' => isset($isEdit),
                                'ukelement' => $ukelement
                            ])
                        @endforeach
                    @endif
                </div>
            @endif

            {{--  Save new UK Element  --}}
            @if(isset($isCreated) OR isset($isEdit))
                <div class="form-row mb-4" id="new-element"></div>
                <div class="form-row">
                    @if(!isset($isShow))
                        <button type="button" id="tambah-element" class="btn btn-primary mb-4" onclick="">
                            <i class="fas fa-plus-circle"></i> Tambah Element
                        </button>
                    @endif
                </div>
            @endif
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
        const sertifikasi_id_default = '{{ request()->input('sertifikasi_id') ?? old('sertifikasi_id') ?? $query->sertifikasi_id ?? null }}'
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
            disabled: {{ (!empty(request()->input('sertifikasi_id'))) ?? (isset($isShow) and !empty($isShow)) ? 'readonly' : 'false' }},
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
        // clear ukid on load
        $(document).ready(function () {
            const uk_id_last =
            localStorage.removeItem('ukid');
        });

        // create new uk element
        $("#tambah-element").on('click', async function () {
            try {
                // get raw form ukelement
                const rawFormUKElement = await axios.get('{{ route('admin.ukelement.rawform') }}');
                // convert to html form
                const htmlForm = rawFormUKElement.data;

                // create new variable id
                let newid;
                // get id from localstorage
                const ukidLocal = localStorage.getItem('ukid');

                // check if localstorage data is found
                if(ukidLocal) {
                    newid = parseInt(ukidLocal) + 1;
                } else {
                    newid = 1;
                }

                // set id
                localStorage.setItem('ukid', newid);

                // replace ukid in form using real id
                const resultForm = htmlForm.replace(/ukid/g, newid);

                // add new form to html
                $("#new-element").append(resultForm);
            } catch (e) {
                alert('Failed to Get Form UK Element.!');
            }
        });

        // delete uk
        $('body').on('click', '.uk-delete', function(event) {
            event.preventDefault();

            const me = $(this);
            const id = me.data('id');

            // parse id
            const splitID = id.split('-');
            const typeID = splitID[0];
            const realID = splitID[1];

            // form delete
            const inputFormDelete = `
                <input type="hidden" name="desc[delete-${realID}]" value="${realID}">
                <input type="hidden" name="upload_instruction[delete-${realID}]" value="${realID}">
            `;

            document.getElementById(`uk-${id}`).remove();
            $("#new-element").append(inputFormDelete);
        })
    </script>
@endsection
