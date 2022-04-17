@section('plugins.Select2', true)
<x-app-layout title="Edit Sumber Dana">
    <x-form method="GET" action="{{ route('admin.sumber_dana.update', $sumberdana->id) }}">
        <x-adminlte-card theme="info" theme-mode="info" title="Edit Sumber Dana">
            <div class="row">
                <x-adminlte-input name="nama_dana" label="Sumber Dana" value="{{ $sumberdana->nama_dana }}" placeholder="Dana BOS"
                                  fgroup-class="col-md-4" type="text" required/>
            </div>
        </x-adminlte-card>
        <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
        <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
    </x-form>
</x-app-layout>
