@section('plugins.Select2', true)
<x-app-layout title="Tambah Guru">
    <x-form method="POST" action="{{ route('admin.guru.store') }}">
        <x-adminlte-card theme="lime" theme-mode="outline" title="Isi Data Guru">
            <div class="row">
                <x-adminlte-input name="nip" label="Nomor Induk Pegawai" placeholder="1277471818"
                                  fgroup-class="col-md-4" type="number" required/>
                <x-adminlte-input name="nuptk" label="NUPTK" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" required/>
                <x-adminlte-input name="nik" label="No Induk Kependudukan" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" required/>
            </div>
            <div class="row">
                <x-adminlte-input name="nama_guru" label="Nama Guru" placeholder="Annisa"
                                  fgroup-class="col-md-12" required/>
            </div>
            <div class="row">
                <x-adminlte-input name="tempat_lahir" label="Tempat Lahir" placeholder="Semarang"
                                  fgroup-class="col-md-6" required/>
                <x-adminlte-input-date name="tanggal_lahir" :config="$config_date" label="Tanggal Lahir" placeholder="Choose a time..." fgroup-class="col-md-6" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-clock"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
            </div>
            <div class="row">
                <x-adminlte-select2 name="status_perkawinan" fgroup-class="col-md-6" label="Status Perkawinan">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-align-justify"></i>
                        </div>
                    </x-slot>
                    <option value="Belum Menikah">Belum Menikah</option>
                    <option value="Menikah">Menikah</option>
                    <option value="Cerai Hidup">Cerai Hidup</option>
                    <option value="Cerai Mati">Cerai Mati</option>
                </x-adminlte-select2>
                <x-adminlte-select2 name="jenis_kelamin" fgroup-class="col-md-6" label="Jenis Kelamin">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-align-justify"></i>
                        </div>
                    </x-slot>
                    <option value="Laki Laki">Laki Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </x-adminlte-select2>
            </div>
            <div class="row">
                <x-adminlte-input name="no_hp" label="Nomor Handphone/Telp" placeholder="08123456789" type="number"
                                  fgroup-class="col-md-6" required/>
                <x-adminlte-input name="email" label="Email" placeholder="Annisa@gmail.com" type="email"
                                  fgroup-class="col-md-6" required/>
                <x-adminlte-textarea name="alamat" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat"/>
            </div>
        </x-adminlte-card>
        <x-adminlte-card theme="lightblue" theme-mode="outline" title="Isi Data Kepegawaian">
            <div class="row">
                <x-adminlte-input name="no_sk" label="Nomor SK" placeholder="1277471818"
                                  fgroup-class="col-md-4" type="number" required/>
                <x-adminlte-input name="no_sk_ypmnu" label="Nomor SK YPMNU" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" required/>
                <x-adminlte-input name="no_sk_operator" label="Nomor SK Operator" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" required/>
            </div>
            <div class="row">
                <x-adminlte-select2 name="id_jabatan" fgroup-class="col-md-4" label="Pilih Jenis Jabatan">
                    @foreach($jabatan as $jw)
                        <option value="{{ $jw->id }}">{{$jw->nama_jabatan}}</option>
                    @endforeach
                </x-adminlte-select2>
                <x-adminlte-select2 name="status_kepegawaian" fgroup-class="col-md-4" label="Status Kepegawaian">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-school"></i>
                        </div>
                    </x-slot>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </x-adminlte-select2>
                <x-adminlte-input name="alasan_tidak_aktif" label="Alasan Tidak Aktif" placeholder="Kosongkan jika status kepegawaian aktif"
                                  fgroup-class="col-md-4" required/>
            </div>
            <div class="row">
                <x-adminlte-input-file name="surat_mutasi" igroup-size="sm" placeholder="Pilih file..." label="Surat Mutasi" fgroup-class="col-md-6">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-lightblue">
                            <i class="fas fa-address-card"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>
                <x-adminlte-input name="jumlah_ajar" label="Jumlah Ajar" placeholder="Jumlah Ajar Dalam Jam" type="number"
                                  fgroup-class="col-md-6" required/>
            </div>
        </x-adminlte-card>
    </x-form>
</x-app-layout>
