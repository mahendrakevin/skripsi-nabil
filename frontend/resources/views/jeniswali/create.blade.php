@section('plugins.Select2', true)
<x-app-layout title="Tambah Jenis Wali">
    <x-form method="POST" action="{{ route('admin.jeniswali.store') }}">
        <x-adminlte-card theme="info" theme-mode="info" title="Isi Data Jenis Wali">
            <div class="row">
                <x-adminlte-input name="jenis_wali" label="Nama Jenis Wali" placeholder="Ayah"
                                  fgroup-class="col-md-4" type="text" required/>
            </div>
        </x-adminlte-card>
        <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
        <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
    </x-form>
</x-app-layout>
