@section('plugins.Select2', true)
<x-app-layout title="Edit Jenis Wali">
    <x-form method="GET" action="{{ route('admin.jeniswali.update', $jeniswali->id) }}">
        <x-adminlte-card theme="lime" theme-mode="outline" title="Edit Jenis Wali">
            <div class="row">
                <x-adminlte-input name="jenis_wali" label="Nama Jenis Wali" placeholder="Ayah" value="{{ $jeniswali->jenis_wali }}"
                                  fgroup-class="col-md-4" type="text" required/>
            </div>
        </x-adminlte-card>
        <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
        <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
    </x-form>
</x-app-layout>
