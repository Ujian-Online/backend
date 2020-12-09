@if(isset($url_show))
<a href="{{ $url_show }}" class="btn btn-primary btn-sm mb-2 btn-show" title="Detail: {{ $title }}"><i class="far fa-eye"></i></a>
@endif
@if(isset($url_edit))
<a href="{{ $url_edit }}" class="btn btn-success btn-sm mb-2 btn-edit" title="Edit: {{ $title }}"><i class="fas fa-pen-square"></i></a>
@endif
@if(isset($url_destroy))
<a href="{{ $url_destroy }}" class="btn btn-danger btn-sm mb-2 btn-delete" title="{{ $title }}"><i class="fas fa-trash-alt"></i></a>
@endif