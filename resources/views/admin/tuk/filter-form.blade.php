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
                    <div class="form-group col-md-12">
                        <label for="tuk">TUK</label>
                        <select class="form-control" name="tuk_id">
                            @foreach($tuks as $tuk)
                                <option
                                    value="{{ $tuk->id }}"

                                    @if(request()->input('tuk_id') == $tuk->id)
                                        {{ __('selected') }}
                                    @endif
                                >
                                    [ID: {{ $tuk->id }}] {{ $tuk->title }}
                                </option>
                            @endforeach
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
