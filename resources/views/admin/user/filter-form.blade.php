<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header text-bold">
            Filter Data
        </div>
        <div class="card-body">
            <form id="filter-form" action="{{ $filter_route }}" method="GET">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="type">Type</label>
                        <select class="form-control" name="type" id="type" @if(isset($isShow)) readonly @endif>
                            <option value="" readonly>Pilih Type</option>

                            @foreach(config('options.user_type') as $type)
                                <option
                                    value="{{ $type }}"

                                    @if(request()->input('type') == $type)
                                        {{ __('selected') }}
                                    @endif
                                >
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="" readonly>Pilih Status</option>

                            @foreach(config('options.user_status') as $status)
                                <option
                                    value="{{ $status }}"

                                    @if(request()->input('status') == $status)
                                        {{ __('selected') }}
                                    @endif
                                >
                                    {{ ucfirst($status) }}
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
