@php
    $placeholder = $placeholder ?? 'Search...';
    $params = $params ?? [];
@endphp

<form action="{{ $route }}" method="GET" class="input-group input-group-sm mr-2" style="width: 250px;">
    @foreach($params as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
    @endforeach
    <input type="text" name="search" class="form-control" placeholder="{{ $placeholder }}" value="{{ request('search') }}">

    <div class="input-group-append">
        <button type="submit" class="btn btn-default">
            <i class="fas fa-search"></i>
        </button>
        @if(request('search'))
            <a href="{{ $clearRoute }}" class="btn btn-default text-danger" title="Clear Search">
                <i class="fas fa-times"></i>
            </a>
        @endif
    </div>
</form>
