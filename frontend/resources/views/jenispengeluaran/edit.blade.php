@section('plugins.Select2', true)
<x-app-layout title="Tambah Kelas">
    <x-form method="GET" action="{{ route('admin.kelas.update', $kelas->id) }}">
        <x-adminlte-card theme="info" theme-mode="info" title="Isi Data Kelas">
            <div class="row">
                <x-adminlte-input name="nama_kelas" label="Nama Kelas" placeholder="Kelas A"
                                  fgroup-class="col-md-4" value="{{ $kelas->nama_kelas }}" type="text" required/>
            </div>
            <div class="row">
                <x-adminlte-input name="kapasitas_kelas" label="Kapasitas Kelas" placeholder="40"
                                  fgroup-class="col-md-4" value="{{ $kelas->kapasitas_kelas }}" type="number" required/>
            </div>
        </x-adminlte-card>
        <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
        <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
    </x-form>
</x-app-layout>
