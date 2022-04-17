<form method="{{ $method }}" action="{{ $action }}" enctype="{{ $enctype }}" class="d-inline">
    @csrf
    @method($method ?? '')
    {{ $slot }}
</form>
