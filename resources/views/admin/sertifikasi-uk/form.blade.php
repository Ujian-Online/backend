@extends('layouts.pageForm')

@section('form')
    @include('layouts.alert')

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="sertifikasi_id">Sertifikasi ID</label>
            <select class="form-control @error('sertifikasi_id') is-invalid @enderror"
                    name="sertifikasi_id" id="sertifikasi_id">

                @foreach($sertifikasis as $sertifikasi)
                    <option
                        value="{{ $sertifikasi->id }}"
                    @if(!empty(request()->query('sertifikasi_id')) and request()->query('sertifikasi_id') == $sertifikasi->id)
                        {{  __('selected') }}
                        @elseif(isset($query->sertifikasi_id) and $query->sertifikasi_id ==
                        $sertifikasi->id)
                        {{  __('selected') }}
                        @endif
                    >
                        [ID: {{ $sertifikasi->id }}] - {{ $sertifikasi->title }} (Nomor Skema: {{ $sertifikasi->nomor_skema }})
                    </option>
                @endforeach

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

        <div class="form-group col-md-6">
            <label for="order">Order</label>
            <input type="number" class="form-control @error('order') is-invalid @enderror" name="order" id="order" placeholder="Order" value="{{ old('order') ?? $query->order ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('order')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <h3>UK Element</h3>

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

@endsection

@section('js')
    <script>
        $('select').select2({
            theme: 'bootstrap4',
            disabled: {{ (isset($isShow) and !empty($isShow)) ? 'true' : 'false' }}
        });
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
