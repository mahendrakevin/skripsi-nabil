@section('plugins.Select2', true)
<x-app-layout title="Tambah SK Kepegawaian">
    <x-form method="POST" action="{{ route('admin.kepegawaian.store') }}">
        <x-adminlte-card theme="lightblue" theme-mode="outline" title="Isi Data Kepegawaian">
            <div class="row">
                <x-adminlte-select2 name="id_guru" fgroup-class="col-md-4" label="Pilih Guru">
                    @foreach($guru as $gr)
                        <option value="{{ $gr->id }}">{{$gr->nama_guru}}</option>
                    @endforeach
                </x-adminlte-select2>
                <x-adminlte-input-date name="tanggal" :config="$config_date" label="Tanggal SK" placeholder="Choose a time..." fgroup-class="col-md-6" required>
                    <x-slot name="prependSlot_ibu">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-clock"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
            </div>
            <div class="row">
                <x-adminlte-input name="no_sk" label="Nomor SK" placeholder="1277471818"
                                  fgroup-class="col-md-4" type="number" required/>
                <x-adminlte-select2 name="kategori_sk" fgroup-class="col-md-4" label="Pilih Kategori SK">
                    <option value="SK Yayasan">SK Yayasan</option>
                    <option value="SK YPMNU">SK YPMNU</option>
                </x-adminlte-select2>
            </div>
            <div class="row">
                <x-adminlte-select2 name="id_jabatan" fgroup-class="col-md-4" label="Pilih Jenis Jabatan">
                    @foreach($jabatan as $jw)
                        <option value="{{ $jw->id }}">{{$jw->nama_jabatan}}</option>
                    @endforeach
                </x-adminlte-select2>
                <x-adminlte-input name="jumlah_ajar" label="Jumlah Ajar" placeholder="Jumlah Ajar Dalam Jam" type="number"
                                  fgroup-class="col-md-6" required/>
            </div>
        </x-adminlte-card>
        <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
        <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
    </x-form>
</x-app-layout>
