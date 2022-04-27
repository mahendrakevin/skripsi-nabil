@section('plugins.Select2', true)
<x-app-layout title="Edit Lembaga">
    <x-form method="GET" action="{{ route('admin.lembaga.update', $lembaga->id) }}">
        <div class="col-md-6">
            <x-adminlte-card theme="info" theme-mode="info" title="Edit Data Lembaga">
                <div class="row">
                    <x-adminlte-input name="nama_lembaga" label="Nama Lembaga" placeholder="RA ALFALAH WAHYUREJO"
                                      fgroup-class="col-md-12" type="text" value="{{ $lembaga->nama_lembaga }}" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="akreditasi" label="akreditasi" placeholder="A"
                                      fgroup-class="col-md-12" type="text" value="{{ $lembaga->akreditasi }}" required/>
                </div>
                <div class="row">
                    <x-adminlte-input-date name="tahun_berdiri" :config="$config_date" label="Tanggal Berdiri" placeholder="Choose a time..."
                                           value="{{ $lembaga->tahun_berdiri }}" fgroup-class="col-md-12" required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-clock"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                </div>
                <div class="row">
                    <x-adminlte-input name="no_telp" label="Nomor Telp" placeholder="40"
                                      fgroup-class="col-md-12" value="{{ $lembaga->no_telp }}" type="number" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="email" label="Email" placeholder="admin@admin.com"
                                      fgroup-class="col-md-12" value="{{ $lembaga->email }}" type="email" required/>
                </div>
                <div class="row">
                    <x-adminlte-textarea name="alamat" fgroup-class="col-md-12" label="Alamat" placeholder="Masukkan alamat">
                        {{ $lembaga->alamat }}
                    </x-adminlte-textarea>
                </div>
                <div class="row">
                    <x-adminlte-input name="npsn" label="Nomor NPSN" placeholder="40"
                                      fgroup-class="col-md-12" type="number" value="{{ $lembaga->npsn }}" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="nsm" label="Nomor NSM" placeholder="40"
                                      fgroup-class="col-md-12" type="number" value="{{ $lembaga->nsm }}" required/>
                </div>
            </x-adminlte-card>
            <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
            <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
        </div>
    </x-form>
</x-app-layout>
