<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Filter Data</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form id="filter-form" action="{{ $filter_route }}" method="GET">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="" readonly>Pilih Status</option>

                            @foreach(['penilaian' => 'Butuh Penilaian', 'selesai' => 'Selesai'] as $key => $status)
                                <option
                                    value="{{ $key }}"

                                    @if(request()->input('status') == $key)
                                        {{ __('selected') }}
                                    @endif
                                >
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>

                        @error('status')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
                <a href="{{ $filter_route }}" class="btn btn-warning">
                    <i class="fas fa-sync"></i> Reset
                </a>
            </form>
        </div>
    </div>
</div>
