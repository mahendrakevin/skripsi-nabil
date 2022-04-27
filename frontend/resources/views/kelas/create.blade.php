@section('plugins.Select2', true)
<x-app-layout title="Tambah Rombel">
    <x-form method="POST" action="{{ route('admin.kelas.store') }}">
        <x-adminlte-card theme="info" theme-mode="info" title="Isi Data Rombel">
            <div class="row">
                <x-adminlte-input name="nama_kelas" label="Nama Rombel" placeholder="Sunan Kalijaga"
                                  fgroup-class="col-md-4" type="text" required/>
            </div>
            <div class="row">
                <x-adminlte-input name="tingkat" label="Tingkat" placeholder="A"
                                  fgroup-class="col-md-4" type="text" required/>
            </div>
            <div class="row">
                <x-adminlte-input name="kapasitas_kelas" label="Kapasitas Rombel" placeholder="40"
                                  fgroup-class="col-md-4" type="number" required/>
            </div>
            <div class="row">
                <x-adminlte-select2 name="id_wali_kelas" fgroup-class="col-md-4" label="Pilih Wali Rombel">
                    @foreach($guru as $gr)
                        <option value="{{ $gr->id }}">{{$gr->nama_guru}}</option>
                    @endforeach
                </x-adminlte-select2>
            </div>
        </x-adminlte-card>
        <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
        <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
    </x-form>
</x-app-layout>
