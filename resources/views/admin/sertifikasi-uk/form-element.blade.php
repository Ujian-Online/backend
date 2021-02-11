@if(isset($view))
    <div class="col-md-12 bg-gray border" id="uk-update-{{ $ukelement->id }}">
        <div class="form-row">
            <div class="form-group col-md-2">
                <button type="button" class="btn btn-primary m-2"><i class="fas fa-info-circle"></i> ID: {{ $ukelement->id }}</button>

                @if(isset($edit) and !empty($edit))
                    <button type="button" class="btn btn-danger uk-delete m-2" data-id="update-{{ $ukelement->id }}"><i class="fas fa-trash-alt"></i> Hapus</button>
                @endif
            </div>
            <div class="form-group col-md-10">
                <label for="desc">Deskripsi</label>
                <textarea class="form-control" name="desc[update-{{ $ukelement->id }}]" cols="30" rows="5" @if(isset($show) and !empty($show)) readonly @endif>{{ $ukelement->desc }}</textarea>
                <label for="upload_instruction">Instruksi Upload</label>
                <textarea class="form-control" name="upload_instruction[update-{{ $ukelement->id }}]" cols="30" rows="5" @if(isset($show) and !empty($show)) readonly @endif>{{ $ukelement->upload_instruction }}</textarea>
            </div>
        </div>
    </div>
@else
    <div class="col-md-12 bg-gray border" id="uk-new-ukid">
        <div class="form-row">
            <div class="form-group col-md-2">
                <button type="button" class="btn btn-primary m-2"><i class="fas fa-info-circle"></i> ID: NEW-{{ $id ?? 'ukid' }}</button>
                <button type="button" class="btn btn-danger uk-delete m-2" data-id="new-{{ $id ?? 'ukid' }}"><i class="fas fa-trash-alt"></i> Hapus</button>
            </div>
            <div class="form-group col-md-10">
                <label for="desc">Deskripsi</label>
                <textarea class="form-control" name="desc[new-{{ $id ?? 'ukid' }}]" cols="30" rows="5">{{ $desc ?? '' }}</textarea>
                <label for="upload_instruction">Instruksi Upload</label>
                <textarea class="form-control" name="upload_instruction[new-{{ $id ?? 'ukid' }}]" cols="30" rows="5">{{ $upload_instruction ?? '' }}</textarea>
            </div>
        </div>
    </div>
@endif
