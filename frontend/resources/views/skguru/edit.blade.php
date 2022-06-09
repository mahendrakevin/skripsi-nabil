@section('plugins.Select2', true)
<x-app-layout title="Edit Kepegawaian {{ $guru->nama_guru }}">
    <x-form method="GET" action="{{ route('admin.kepegawaian.update', $kepegawaian->id) }}">
        <x-adminlte-card theme="lightblue" theme-mode="outline" title="Edit Data Kepegawaian">
            <div class="row">
            <x-adminlte-select2 name="id_guru" fgroup-class="col-md-4" label="Nama Guru">
                    <option selected value="{{ $guru->id }}" readonly>{{$guru->nama_guru}}</option>
            </x-adminlte-select2>
            <x-adminlte-input-date name="tanggal" :config="$config_date" label="Tanggal SK"
                                   placeholder="Choose a time..." fgroup-class="col-md-6"
                                   value="{{ $kepegawaian->tanggal }}" required>
                <x-slot name="prependSlot_ibu">
                    <div class="input-group-text bg-gradient-info">
                        <i class="fas fa-clock"></i>
                    </div>
                </x-slot>
            </x-adminlte-input-date>
            </div>
            <div class="row">
                @if($kepegawaian->isskpengangkatan != true)
                    <x-adminlte-select2 name="kategori_sk" fgroup-class="col-md-4" label="Pilih Jenis Jabatan">
                        <option {{old('kategori_sk',$kepegawaian->kategori_sk)=='SK Yayasan'? 'selected':''}} value="SK Yayasan">SK Yayasan</option>
                        <option {{old('kategori_sk',$kepegawaian->kategori_sk)=='SK YPMNU'? 'selected':''}} value="SK YPMNU">SK YPMNU</option>
                        <option {{old('kategori_sk',$kepegawaian->kategori_sk)=='SK Sekolah'? 'selected':''}} value="SK Sekolah">SK Sekolah</option>
                    </x-adminlte-select2>
                @endif
                    <x-adminlte-input name="no_sk" label="Nomor SK" placeholder="1277471818"
                                      fgroup-class="col-md-4" type="number" value="{{ $kepegawaian->no_sk }}" required/>
            </div>
            @if($kepegawaian->isskpengangkatan != true)
                    <x-adminlte-select2 name="jabatan" fgroup-class="col-md-4" label="Pilih Jabatan">
                        @foreach($jabatan as $jb)
                            <option {{old('jabatan',$jb->nama_jabatan)==$kepegawaian->jabatan? 'selected':''}} value="{{ $jb->nama_jabatan }}">{{$jb->nama_jabatan}}</option>
                        @endforeach
                    </x-adminlte-select2>
            @endif
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
