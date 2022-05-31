@section('plugins.Select2', true)
<x-app-layout title="Tambah SK Lembaga">
    <x-form method="POST" action="{{ route('admin.surat_keterangan.store') }}">
        <div class="col-md-6">
            <x-adminlte-card theme="info" theme-mode="info" title="Isi Data SK Lembaga">
                <div class="row">
                    <x-adminlte-select2 name="id_lembaga" fgroup-class="col-md-12" label="Nama Lembaga">
                        @foreach($lembaga as $lbg)
                            <option value="{{ $lbg->id }}">{{$lbg->nama_lembaga}}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
                <div class="row">
                    <x-adminlte-input name="nama_surat_keterangan" label="Nama Surat Keterangan" placeholder="Surat IMB"
                                      fgroup-class="col-md-12" type="text" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="nomor_surat_keterangan" label="Nomor Surat Keterangan" placeholder="F/240/JK/2022"
                                      fgroup-class="col-md-12" type="text" required/>
                </div>
                <x-adminlte-input-date name="tanggal_surat_keterangan" :config="$config_date" label="Tanggal Surat Keterangan"
                                       placeholder="Choose a time..." fgroup-class="col-md-12" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-clock"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
                </div>
            </x-adminlte-card>
            <x-adminlte-button class="btn-flat" type="submit" label="Simpan" theme="success" icon="fas fa-lg fa-save"/>

        </div>
    </x-form>
</x-app-layout>
