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
            <label for="nomor_skema">Nomor Skema</label>
            <input type="text" class="form-control @error('nomor_skema') is-invalid @enderror" name="nomor_skema" id="nomor_skema" placeholder="Nomor Skema" value="{{ old('nomor_skema') ?? $query->nomor_skema ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('nomor_skema')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="original_price_baru">Harga Baru</label>
            <input type="number" class="form-control @error('original_price_baru') is-invalid @enderror" name="original_price_baru" id="original_price_baru" placeholder="Harga Baru" value="{{ old('original_price_baru') ?? $query->original_price_baru ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('original_price_baru')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="original_price_perpanjang">Harga Perpanjang</label>
            <input type="number" class="form-control @error('original_price_perpanjang') is-invalid @enderror" name="original_price_perpanjang" id="original_price_perpanjang" placeholder="Harga Perpanjang" value="{{ old('original_price_perpanjang') ?? $query->original_price_perpanjang ?? '' }}" @if(isset($isShow)) readonly @endif>

            @error('original_price_perpanjang')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="is_active">Is Active</label>
            <select class="form-control" name="is_active" id="is_active" @if(isset($isShow)) readonly @endif>

                @if(isset($isCreated))
                    <option value="1" selected>Yes</option>
                    <option value="0">No</option>
                @else
                    <option value="1" @if(old('is_active') == 1 or !empty($query->is_active) == 1) {{ __('selected') }}@endif>Yes</option>
                    <option value="0" @if(old('is_active') == 0 or !empty($query->is_active) == 0) {{ __('selected') }}@endif>No</option>
                @endif

            </select>

            @error('is_active')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-tasks"></i> Unit Kompetensi</h3>
        </div>
        <div class="card-body">
            <div class="form-group col-md-12">
                <select class="form-control" name="unit_kompetensi" id="unit_kompetensi" data-placeholder="Pilih Unit Kompetensi">
                </select>
            </div>

            <div class="form-group col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="25%">Kode Unit Kompetensi</th>
                                <th width="60%">Title</th>
                                <th width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="uk-result">

                            @if(isset($isShow) OR isset($isEdit))
                                @foreach($query->sertifikasiunitkompentensi as $suk)
                                    <tr id="uk-{{ $suk->id }}">
                                        <input type="hidden" name="unit_kompetensi_id[]" value="{{ $suk->unitkompetensi->id }}">
                                        <td>{{ $suk->unitkompetensi->id }}</td>
                                        <td>{{ $suk->unitkompetensi->kode_unit_kompetensi }}</td>
                                        <td>{{ $suk->unitkompetensi->title }}</td>
                                        <td><button type="button" class="btn btn-danger" onclick="deltr('uk-{{ $suk->id }}')" @if(isset($isShow)) disabled @endif >Delete</button></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
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

        // select2 with ajax query search
        $('#unit_kompetensi').select2({
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

        function deltr(id) {
            $(`#${id}`).remove();
            $("#unit_kompetensi").val('').trigger('change');
        }

        $('#unit_kompetensi').on('change', async function() {
            const me = $(this)
            const value = me.val();

            try {
                if(value) {
                    // get data by id
                    const request = await axios.get('{{ url('/admin/sertifikasi/uk')  }}' + `/${value}`);
                    const { data: response } = request;

                    // append selected to table
                    $("#uk-result").append(`
                        <tr id="uk-${response.id}">
                            <input type="hidden" name="unit_kompetensi_id[]" value="${response.id}">
                            <td>${response.id}</td>
                            <td>${response.kode_unit_kompetensi}</td>
                            <td>${response.title}</td>
                            <td><button type="button" class="btn btn-danger" onclick="deltr('uk-${response.id}')">Delete</button></td>
                        </tr>
                   `);

                    // clear select2
                    me.val('').trigger('change');
                }

            } catch (e) {
                alert('Gagal mengambil detail unit kompetensi.!');
            }
        })

        /**
         * Select2 with Ajax End
         * @type {string}
         */
    </script>
@endsection
