<form method="{{ $method }}" action="{{ $action }}" class="d-inline">
    @csrf
    @method($method ?? '')
    <button class="{{ $class }}" title="{{ $title }}">
        <i class="{{ $icon }}"></i>
    </button>
</form>
