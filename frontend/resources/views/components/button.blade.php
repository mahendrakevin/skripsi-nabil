<form method="{{ $method }}" action="{{ $action }}" class="d-inline">
    @csrf
    @method($method ?? '')
    <button class="{{ $class }}" id="{{ $id }}" title="{{ $title }}" onclick="{{$onclick}}">
        <i class="{{ $icon }}"></i>
    </button>
</form>
