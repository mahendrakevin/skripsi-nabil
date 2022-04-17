@section('plugins.Select2', true)
<x-app-layout title="Tambah Arsip">
    <x-form method="GET" enctype="multipart/form-data" action="{{ route('admin.arsip_surat.update', $arsipsurat->id) }}">
        <div class="col-md-6">
            <x-adminlte-card theme="info" theme-mode="info" title="Isi Arsip Surat">
                <div class="row">
                    <x-adminlte-input name="nama_surat" label="Nama Surat" value="{{ $arsipsurat->nama_surat }}" placeholder="Surat Tugas"
                                      fgroup-class="col-md-12" type="text" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="nomor_surat" label="Nomor Surat" value="{{ $arsipsurat->nomor_surat }}" placeholder="40"
                                      fgroup-class="col-md-12" type="text" required/>
                </div>
                <div class="row">
                    <x-adminlte-input-date name="tanggal_surat" value="{{ $arsipsurat->tanggal_surat }}"
                                           :config="$config_date" label="Tanggal Surat" placeholder="Choose a time..." fgroup-class="col-md-12" required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-clock"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                </div>
                <div class="row">
                    <x-adminlte-select2 name="jenis_surat" fgroup-class="col-md-4" label="Pilih Jenis Surat">
                        <option {{old('jenis_surat',$arsipsurat->jenis_surat)=="Masuk"? 'selected':''}} value="Masuk">Masuk</option>
                        <option {{old('jenis_surat',$arsipsurat->jenis_surat)=="Keluar"? 'selected':''}} value="Keluar">Keluar</option>
                    </x-adminlte-select2>
                </div>
                <div class="row">
                    <x-adminlte-textarea name="keterangan" fgroup-class="col-md-12" label="Keterangan" placeholder="Keterangan">
                        {{ $arsipsurat->keterangan }}
                    </x-adminlte-textarea>
                </div>
            </x-adminlte-card>
            <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
            <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
        </div>
    </x-form>
</x-app-layout>
