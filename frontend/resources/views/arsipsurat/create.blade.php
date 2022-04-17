@section('plugins.Select2', true)
<x-app-layout title="Tambah Arsip">
    <x-form method="POST" enctype="multipart/form-data" action="{{ route('admin.arsip_surat.store') }}">
        <div class="col-md-6">
            <x-adminlte-card theme="info" theme-mode="info" title="Isi Arsip Surat">
                <div class="row">
                    <x-adminlte-input name="nama_surat" label="Nama Surat" placeholder="Surat Tugas"
                                      fgroup-class="col-md-12" type="text" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="nomor_surat" label="Nomor Surat" placeholder="40"
                                      fgroup-class="col-md-12" type="text" required/>
                </div>
                <div class="row">
                    <x-adminlte-input-date name="tanggal_surat" :config="$config_date" label="Tanggal Surat" placeholder="Choose a time..." fgroup-class="col-md-12" required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-clock"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                </div>
                <div class="row">
                    <x-adminlte-select2 name="jenis_surat" fgroup-class="col-md-4" label="Pilih Jenis Surat">
                        <option value="Masuk">Masuk</option>
                        <option value="Keluar">Keluar</option>
                    </x-adminlte-select2>
                </div>
                <div class="row">
                    <x-adminlte-textarea name="keterangan" fgroup-class="col-md-12" label="Keterangan" placeholder="Keterangan"/>
                </div>
                <div class="row">
                    <x-adminlte-input-file name="lampiran" igroup-size="sm" placeholder="Pilih file..."
                                           label="Lampiran Surat" fgroup-class="col-md-6">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-lightblue">
                                <i class="fas fa-address-card"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-file>
                </div>
            </x-adminlte-card>
            <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
            <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
        </div>
    </x-form>
</x-app-layout>
