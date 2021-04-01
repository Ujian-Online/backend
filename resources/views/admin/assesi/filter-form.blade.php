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
                    <div class="form-group col-md-6">
                        <label for="is_verified">Is Verified</label>
                        <select class="form-control" name="is_verified" id="is_verified">
                            <option value="">Pilih Verified</option>
                            <option value="1" @if(request()->input('is_verified') == 1) {{ __('selected') }} @endif>Yes</option>
                            <option value="0" @if(request()->input('is_verified') == 0) {{ __('selected') }} @endif>No</option>
                        </select>
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
