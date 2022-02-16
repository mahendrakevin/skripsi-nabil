@section('plugins.Select2', true)
<x-app-layout title="Tambah Kelas">
    <x-form method="POST" action="{{ route('admin.jenispembayaran.store') }}">
        <x-adminlte-card theme="info" theme-mode="info" title="Isi Data Kelas">
            <div class="row">
                <x-adminlte-input name="jenis_pembayaran" label="Jenis Pembayaran" placeholder="SPP"
                                  fgroup-class="col-md-4" type="text" required/>
            </div>
            <div class="row">
                <x-adminlte-input name="nominal_pembayaran" label="Nominal Pembayaran" placeholder="120000"
                                  fgroup-class="col-md-4" type="number" required/>
            </div>
        </x-adminlte-card>
        <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
        <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
    </x-form>
</x-app-layout>
