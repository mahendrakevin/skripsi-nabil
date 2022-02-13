<form method="{{ $method }}" action="{{ $action }}" class="d-inline">
    @csrf
    @method($method ?? '')
    {{ $slot }}
</form>
