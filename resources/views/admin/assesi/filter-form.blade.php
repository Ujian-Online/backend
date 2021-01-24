<div class="col-md-12">
    <div class="card card-outline card-primary @if(empty(request()->input('filter'))) {{ _('collapsed-card')  }} @endif">
        <div class="card-header">
            <h3 class="card-title">Filter Data</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    @if(empty(request()->input('filter')))
                        <i class="fas fa-plus"></i>
                    @else
                        <i class="fas fa-minus"></i>
                    @endif
                </button>
            </div>
        </div>
        <div class="card-body">
            <form id="filter-form" action="{{ $filter_route }}" method="GET">
                <input type="hidden" name="filter" value="true">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="is_verified">Is Verified</label>
                        <select class="form-control" name="is_verified" id="is_verified">
                            <option value="" readonly>Pilih Verified</option>

                            @if(request()->input('is_verified') == 1)
                                <option value="1" selected>Yes</option>
                                <option value="0">No</option>
                            @else
                                <option value="1">Yes</option>
                                <option value="0" selected>No</option>
                            @endif

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
