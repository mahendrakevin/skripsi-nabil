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
                    <option value="SK Sekolah">SK Sekolah</option>
                </x-adminlte-select2>
            </div>
            <div class="row">
                <x-adminlte-input name="jabatan" label="Jabatan" placeholder="Guru" type="text"
                                  fgroup-class="col-md-6"/>
            </div>
        </x-adminlte-card>
        <x-adminlte-modal id="modalCustom" title="Konfirmasi Simpan" size="lg" theme="teal"
                              icon="fas fa-bell" v-centered static-backdrop scrollable>
                <div>Apakah Anda yakin untuk menyimpan data?</div>
                <x-slot name="footerSlot">
                    <x-adminlte-button theme="danger" label="Tidak" data-dismiss="modal"/>
                    <x-adminlte-button class="btn-flat" type="submit" label="Ya" theme="success"/>
                </x-slot>
            </x-adminlte-modal>
            <x-adminlte-button label="Simpan" data-toggle="modal" theme="success" data-target="#modalCustom" class="btn-flat"/>

    </x-form>
</x-app-layout>
