@section('plugins.Select2', true)
<x-app-layout title="Edit Dana Masuk">
    <x-form method="GET" enctype="multipart/form-data" action="{{ route('admin.alokasi_dana.update_masuk', $danamasuk->id) }}">
        <x-adminlte-card theme="lime" theme-mode="outline" title="Dana Masuk">
            <div class="row">
                <x-adminlte-input-date name="tanggal" :config="$config_date"
                                       label="Tanggal Dana Masuk" placeholder="Choose a time..."
                                       fgroup-class="col-md-6" value="{{$danamasuk->tanggal}}" required>
                    <x-slot name="prependSlot_ibu">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-clock"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
                <x-adminlte-select2 name="id_sumberdana" fgroup-class="col-md-6" label="Pilih Sumber Dana">
                    @foreach($sumberdana as $sd)
                        <option {{old('id_sumberdana',$danamasuk->id_sumberdana)==$sd->id? 'selected':''}} value="{{ $sd->id }}">{{$sd->nama_dana}}</option>
                    @endforeach
                </x-adminlte-select2>
            </div>
            <div class="row">
                <x-adminlte-input name="nominal_dana" label="Nominal" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" value="{{$danamasuk->nominal_dana}}" required/>
                <x-adminlte-input name="lampiran" value="{{$danamasuk->lampiran}}" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" hidden/>
            </div>
        </x-adminlte-card>
        <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
        <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
    </x-form>
</x-app-layout>
