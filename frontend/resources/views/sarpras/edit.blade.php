@section('plugins.Select2', true)
<x-app-layout title="Edit Sarpras">
    <x-form method="GET" action="{{ route('admin.sarpras.update', $sarpras->id) }}">
        <div class="col-md-6">
            <x-adminlte-card theme="info" theme-mode="info" title="Isi Data Lembaga">
                <div class="row">
                    <x-adminlte-input name="nama_aset" label="Nama Aset" placeholder="Gedung"
                                      fgroup-class="col-md-12" value="{{ $sarpras->nama_aset }}" type="text" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="luas_bangunan" label="Luas Bangunan (meter persegi)" placeholder="120"
                                      fgroup-class="col-md-12" type="number" value="{{ $sarpras->luas_lahan }}" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="luas_lahan" label="Luas Lahan (meter persegi)" placeholder="200"
                                      fgroup-class="col-md-12" type="number" value="{{ $sarpras->luas_bangunan }}" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="nama_pemilik" label="Nama Pemilik" placeholder="Alfalah"
                                      fgroup-class="col-md-12" type="text" value="{{ $sarpras->nama_pemilik }}" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="no_sertifikat" label="Nomor Sertifikat" placeholder="40/X/2017/"
                                      fgroup-class="col-md-12" type="text" value="{{ $sarpras->no_sertifikat }}" required/>
                </div>
            </x-adminlte-card>
            <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
            <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
        </div>
    </x-form>
</x-app-layout>
