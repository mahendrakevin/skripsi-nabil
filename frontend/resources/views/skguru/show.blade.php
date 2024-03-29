@section('plugins.Select2', true)
<x-app-layout title="Tambah Guru">
    <x-form method="GET" action="{{ route('admin.guru.update', $guru->id) }}">
        <x-adminlte-card theme="lime" theme-mode="outline" title="Isi Data Guru">
            <div class="row">
                <x-adminlte-input name="nip" label="Nomor Induk Pegawai" placeholder="1277471818"
                                  fgroup-class="col-md-4" type="number" value="{{ $guru->nip }}" disabled/>
                <x-adminlte-input name="nuptk" label="NUPTK" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" value="{{ $guru->nuptk }}" disabled/>
                <x-adminlte-input name="nik" label="No Induk Kependudukan" value="{{ $guru->nik }}" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" disabled/>
            </div>
            <div class="row">
                <x-adminlte-input name="nama_guru" label="Nama Guru" placeholder="Annisa"
                                  fgroup-class="col-md-12" value="{{ $guru->nama_guru }}" disabled/>
            </div>
            <div class="row">
                <x-adminlte-input name="tempat_lahir" label="Tempat Lahir" placeholder="Semarang"
                                  fgroup-class="col-md-6" value="{{ $guru->tempat_lahir }}" disabled/>
                <x-adminlte-input-date name="tanggal_lahir" :config="$config_date" label="Tanggal Lahir"
                                       placeholder="Choose a time..." value="{{ $guru->tanggal_lahir }}" fgroup-class="col-md-6" disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-clock"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
            </div>
            <div class="row">
                <x-adminlte-select2 name="status_perkawinan" fgroup-class="col-md-6" disabled label="Status Perkawinan">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-align-justify"></i>
                        </div>
                    </x-slot>
                    <option {{old('pendidikan',$guru->status_perkawinan)=="Belum Menikah"? 'selected':''}} value="Belum Menikah">Belum Menikah</option>
                    <option {{old('pendidikan',$guru->status_perkawinan)=="Menikah"? 'selected':''}} value="Menikah">Menikah</option>
                    <option {{old('pendidikan',$guru->status_perkawinan)=="Cerai Hidup"? 'selected':''}} value="Cerai Hidup">Cerai Hidup</option>
                    <option {{old('pendidikan',$guru->status_perkawinan)=="Cerai Mati"? 'selected':''}} value="Cerai Mati">Cerai Mati</option>
                </x-adminlte-select2>
                <x-adminlte-select2 name="jenis_kelamin" disabled fgroup-class="col-md-6" label="Jenis Kelamin">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-align-justify"></i>
                        </div>
                    </x-slot>
                    <option {{old('pendidikan',$guru->jenis_kelamin)=="Laki Laki"? 'selected':''}} value="Laki Laki">Laki Laki</option>
                    <option {{old('pendidikan',$guru->jenis_kelamin)=="Perempuan"? 'selected':''}} value="Perempuan">Perempuan</option>
                </x-adminlte-select2>
            </div>
            <div class="row">
                <x-adminlte-input name="no_hp" label="Nomor Handphone/Telp" placeholder="08123456789" type="number"
                                  fgroup-class="col-md-6" value="{{ $guru->no_hp }}" disabled/>
                <x-adminlte-input name="email" label="Email" placeholder="Annisa@gmail.com" type="email"
                                  fgroup-class="col-md-6" value="{{ $guru->email }}" disabled/>
                <x-adminlte-textarea name="alamat" fgroup-class="col-md-6" disabled label="Alamat" placeholder="Masukkan alamat">
                    {{ $guru->alamat }}
                </x-adminlte-textarea>
            </div>
        </x-adminlte-card>
        <x-adminlte-card theme="lightblue" theme-mode="outline" title="Isi Data Kepegawaian">
            <div class="row">
                <x-adminlte-input name="no_sk" label="Nomor SK" placeholder="1277471818"
                                  fgroup-class="col-md-4" type="number" value="{{ $kepegawaian->no_sk }}" disabled/>
                <x-adminlte-input name="no_sk_ypmnu" label="Nomor SK YPMNU" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" value="{{ $kepegawaian->no_sk_ypmnu }}" disabled/>
                <x-adminlte-input name="no_sk_operator" label="Nomor SK Operator" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" value="{{ $kepegawaian->no_sk_operator }}" disabled/>
            </div>
            <div class="row">
                <x-adminlte-select2 name="id_jabatan" disabled fgroup-class="col-md-4" label="Pilih Jenis Jabatan">
                    @foreach($jabatan as $jw)
                        <option {{old('pendidikan',$kepegawaian->id_jabatan)==$jw->id? 'selected':''}} value="{{ $jw->id }}">{{$jw->nama_jabatan}}</option>
                    @endforeach
                </x-adminlte-select2>
                <x-adminlte-select2 name="status_kepegawaian" disabled fgroup-class="col-md-4" label="Status Kepegawaian">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-school"></i>
                        </div>
                    </x-slot>
                    <option {{old('pendidikan',$kepegawaian->status_kepegawaian)=="Aktif"? 'selected':''}} value="Aktif">Aktif</option>
                    <option {{old('pendidikan',$kepegawaian->status_kepegawaian)=="Tidak Aktif"? 'selected':''}} value="Tidak Aktif">Tidak Aktif</option>
                </x-adminlte-select2>
                <x-adminlte-input name="alasan_tidak_aktif" label="Alasan Tidak Aktif" value="{{ $kepegawaian->alasan_tidak_aktif }}"
                                  placeholder="Kosongkan jika status kepegawaian aktif"
                                  fgroup-class="col-md-4" disabled/>
            </div>
            <div class="row">
                <x-adminlte-input-file name="surat_mutasi" igroup-size="sm" placeholder="Pilih file..." disabled value="{{ $kepegawaian->surat_mutasi }}"
                                       label="Surat Mutasi" fgroup-class="col-md-6">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-lightblue">
                            <i class="fas fa-address-card"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>
                <x-adminlte-input name="jumlah_ajar" label="Jumlah Ajar" placeholder="Jumlah Ajar Dalam Jam"
                                  type="number" value="{{ $kepegawaian->jumlah_ajar }}"
                                  fgroup-class="col-md-6" disabled/>
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
