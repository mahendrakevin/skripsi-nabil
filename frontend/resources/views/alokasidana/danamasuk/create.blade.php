@section('plugins.Select2', true)
<x-app-layout title="Tambah Dana Masuk">
    @if (Auth::user()->role == '1')
        <x-form method="POST" action="{{ route('admin.alokasi_dana.store_masuk') }}" enctype="multipart/form-data">
            <x-adminlte-card theme="lime" theme-mode="outline" title="Dana Masuk">
                <div class="row">
                    <x-adminlte-input-date name="tanggal" :config="$config_date" label="Tanggal Dana Masuk" placeholder="Choose a time..." fgroup-class="col-md-6" required>
                        <x-slot name="prependSlot_ibu">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-clock"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                    <x-adminlte-select2 name="id_sumberdana" fgroup-class="col-md-6" label="Pilih Sumber Dana">
                        @foreach($sumberdana as $sd)
                            <option value="{{ $sd->id }}">{{$sd->nama_dana}}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
                <div class="row">
                    <x-adminlte-input name="nominal_dana" label="Nominal" placeholder="1234567890123456"
                                      fgroup-class="col-md-4" type="number" required/>
                    <x-adminlte-input-file name="lampiran" igroup-size="sm" placeholder="Pilih file..." label="Lampiran" fgroup-class="col-md-4">
                        <x-slot name="prependSlot_lampiran">
                            <div class="input-group-text bg-lightblue">
                                <i class="fas fa-address-card"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-file>
                </div>
            </x-adminlte-card>
            <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
            <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
        </x-form>
    @elseif(Auth::user()->role == '2')
        <x-form method="POST" action="{{ route('bendahara.alokasi_dana.store_masuk') }}" enctype="multipart/form-data">
            <x-adminlte-card theme="lime" theme-mode="outline" title="Dana Masuk">
                <div class="row">
                    <x-adminlte-input-date name="tanggal" :config="$config_date" label="Tanggal Dana Masuk" placeholder="Choose a time..." fgroup-class="col-md-6" required>
                        <x-slot name="prependSlot_ibu">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-clock"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                    <x-adminlte-select2 name="id_sumberdana" fgroup-class="col-md-6" label="Pilih Sumber Dana">
                        @foreach($sumberdana as $sd)
                            <option value="{{ $sd->id }}">{{$sd->nama_dana}}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
                <div class="row">
                    <x-adminlte-input name="nominal_dana" label="Nominal" placeholder="1234567890123456"
                                      fgroup-class="col-md-4" type="number" required/>
                    <x-adminlte-input-file name="lampiran" igroup-size="sm" placeholder="Pilih file..." label="Lampiran" fgroup-class="col-md-4">
                        <x-slot name="prependSlot_lampiran">
                            <div class="input-group-text bg-lightblue">
                                <i class="fas fa-address-card"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-file>
                </div>
            </x-adminlte-card>
            <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
            <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
        </x-form>
    @endif
</x-app-layout>
