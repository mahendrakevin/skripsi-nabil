@section('plugins.Select2', true)
<x-app-layout title="Tambah Jenis Pengeluaran">
    <x-form method="POST" action="{{ route('admin.jenis_pengeluaran.store') }}">
        <x-adminlte-card theme="info" theme-mode="info" title="Isi Sumber Dana">
            <div class="row">
                <x-adminlte-input name="jenis_pengeluaran" label="Jenis Pengeluaran" placeholder="Alat Tulis"
                                  fgroup-class="col-md-4" type="text" required/>
            </div>
        </x-adminlte-card>
        <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
        <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
    </x-form>
</x-app-layout>
