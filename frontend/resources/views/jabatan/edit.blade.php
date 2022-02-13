@section('plugins.Select2', true)
<x-app-layout title="Edit Jabatan">
    <x-form method="GET" action="{{ route('admin.jabatan.update', $jabatan->id) }}">
        <x-adminlte-card theme="lime" theme-mode="outline" title="Edit Jabatan">
            <div class="row">
                <x-adminlte-input name="nama_jabatan" label="Nama Jabatan" placeholder="Pengajar" value="{{ $jabatan->nama_jabatan }}"
                                  fgroup-class="col-md-4" type="text" required/>
            </div>
        </x-adminlte-card>
        <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
        <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
    </x-form>
</x-app-layout>
