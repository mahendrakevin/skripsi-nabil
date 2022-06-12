@section('plugins.Select2', true)
<x-app-layout title="Tambah Aset">
    <x-form method="GET" action="{{ route('admin.aset.update', $sarpras->id) }}">
        <div class="col-md-6">
            <x-adminlte-card theme="info" theme-mode="info" title="Isi Data Aset">
                <div class="row">
                    <x-adminlte-input name="jenis_ruangan" label="Jenis Ruangan" placeholder="Ruang Kepsek"
                                      fgroup-class="col-md-6" type="text" value="{{ $sarpras->jenis_ruangan }}" required/>
                    <x-adminlte-input name="nama_ruangan" label="Nama Ruangan" placeholder="R. Kepala Sekolah"
                                      fgroup-class="col-md-6" value="{{ $sarpras->nama_ruangan }}" type="text" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="tahun" label="Tahun Bangunan" placeholder="2022"
                                      fgroup-class="col-md-6" value="{{ $sarpras->tahun }}" type="number" required/>
                    <x-adminlte-input name="panjang" label="Panjang Bangunan (meter)" placeholder="120"
                                      fgroup-class="col-md-6" type="number" value="{{ $sarpras->panjang }}" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="lebar" label="Lebar Lahan (meter)" placeholder="20"
                                      fgroup-class="col-md-12" type="number" value="{{ $sarpras->lebar }}" required/>
                </div>
            </x-adminlte-card>
            <x-adminlte-button class="btn-flat" type="submit" label="Simpan" theme="success" icon="fas fa-lg fa-save"/>

        </div>
    </x-form>
</x-app-layout>
