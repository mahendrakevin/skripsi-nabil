@section('plugins.Select2', true)
<x-app-layout title="Tambah Lembaga">
    <x-form method="POST" action="{{ route('admin.lembaga.store') }}">
        <div class="col-md-6">
            <x-adminlte-card theme="info" theme-mode="info" title="Isi Data Lembaga">
                <div class="row">
                    <x-adminlte-input name="nama_lembaga" label="Nama Lembaga" placeholder="RA ALFALAH WAHYUREJO"
                                      fgroup-class="col-md-12" type="text" required/>
                </div>
                <div class="row">
                    <x-adminlte-input-date name="tahun_berdiri" :config="$config_date" label="Tanggal Berdiri" placeholder="Choose a time..." fgroup-class="col-md-12" required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-clock"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                </div>
                <div class="row">
                    <x-adminlte-input name="no_telp" label="Nomor Telp" placeholder="40"
                                      fgroup-class="col-md-12" type="number" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="email" label="Email" placeholder="admin@admin.com"
                                      fgroup-class="col-md-12" type="email" required/>
                </div>
                <div class="row">
                    <x-adminlte-textarea name="alamat" fgroup-class="col-md-12" label="Alamat" placeholder="Masukkan alamat"/>
                </div>
                <div class="row">
                    <x-adminlte-input name="npsn" label="Nomor NPSN" placeholder="40"
                                      fgroup-class="col-md-12" type="number" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="nsm" label="Nomor NSM" placeholder="40"
                                      fgroup-class="col-md-12" type="number" required/>
                </div>
            </x-adminlte-card>
            <x-adminlte-button class="btn-flat" type="submit" label="Simpan" theme="success" icon="fas fa-lg fa-save"/>

        </div>
    </x-form>
</x-app-layout>
