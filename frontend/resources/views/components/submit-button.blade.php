<form method="{{ $method }}" action="{{ $action }}" class="d-inline">
    @csrf
    @method($method ?? '')
    <x-adminlte-button label="{{ $label }}" theme="{{ $theme }}" icon="{{ $icon }}" type="{{$type}}"/>
</form>
