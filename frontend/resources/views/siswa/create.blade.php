@section('plugins.Select2', true)
<x-app-layout title="Tambah Siswa">
    <x-form method="POST" action="{{ route('admin.siswa.store') }}">
        <x-adminlte-card theme="lime" theme-mode="outline" title="Isi Data Siswa">
            <div class="row">
                <x-adminlte-input name="nisn" label="Nomor Induk Siswa Nasional" placeholder="1277471818"
                                  fgroup-class="col-md-4" type="number" required/>
                <x-adminlte-input name="nisn" label="NIK" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" required/>
                <x-adminlte-input name="no_kk" label="No Kartu Keluarga" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" required/>
            </div>
            <div class="row">
                <x-adminlte-input name="nama_siswa" label="Nama Siswa" placeholder="Alfalah"
                                  fgroup-class="col-md-8" required/>
                <x-adminlte-input name="nomor_kip" label="No KIP" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" required/>
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
                <x-adminlte-select2 name="jenis_kelamin" fgroup-class="col-md-4" label="Jenis Kelamin">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-align-justify"></i>
                        </div>
                    </x-slot>
                    <option value="Laki Laki">Laki Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </x-adminlte-select2>
                <x-adminlte-select2 name="status_siswa" fgroup-class="col-md-4" label="Status Siswa">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-user"></i>
                        </div>
                    </x-slot>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </x-adminlte-select2>
                <x-adminlte-select2 name="id_kelas" fgroup-class="col-md-4" label="Kelas">
                    @foreach($kelas as $kls)
                        <option value="{{ $kls->id }}">{{$kls->nama_kelas}}</option>
                    @endforeach
                </x-adminlte-select2>
            </div>
            <div class="row">
                <x-adminlte-textarea name="alamat" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat"/>
            </div>
        </x-adminlte-card>
        <x-adminlte-card theme="lightblue" theme-mode="outline" title="Isi Data Wali">
            <div class="row">
                <x-adminlte-select2 name="id_jeniswali" fgroup-class="col-md-12" label="Pilih Jenis Wali">
                    @foreach($jeniswali as $jw)
                        <option value="{{ $jw->id }}">{{$jw->jenis_wali}}</option>
                    @endforeach
                </x-adminlte-select2>
            </div>
            <div class="row">
                <x-adminlte-input name="nama_wali" label="Nama Wali" placeholder="Alfa"
                                  fgroup-class="col-md-8" required/>
                <x-adminlte-input-file name="file_kk" igroup-size="sm" placeholder="Pilih file..." label="File Kartu Keluarga" fgroup-class="col-md-4">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-lightblue">
                            <i class="fas fa-address-card"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>
            </div>
            <div class="row">
                <x-adminlte-input name="tempat_lahir_wali" label="Tempat Lahir" placeholder="Semarang"
                                  fgroup-class="col-md-6" required/>
                <x-adminlte-input-date name="tanggal_lahir_wali" :config="$config_date" label="Tanggal Lahir" placeholder="Choose a time..." fgroup-class="col-md-6" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-clock"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
            </div>
            <div class="row">
                <x-adminlte-select2 name="pendidikan" fgroup-class="col-md-6" label="Pendidikan Terakhir">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-school"></i>
                        </div>
                    </x-slot>
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMA">SMA</option>
                    <option value="Sarjana">Sarjana</option>
                    <option value="Master">Master</option>
                    <option value="Doktor">Doktor</option>
                </x-adminlte-select2>
                <x-adminlte-input name="pekerjaan" label="Pekerjaan" placeholder="PNS"
                                  fgroup-class="col-md-6" required/>
            </div>
            <div class="row">
                <x-adminlte-input name="penghasilan" label="Penghasilan Perbulan" placeholder="124155151" type="number"
                                  fgroup-class="col-md-4" required/>
                <x-adminlte-input name="nomor_kks" label="Nomor KKS" placeholder="124155151" type="number"
                                  fgroup-class="col-md-4"/>
                <x-adminlte-input name="nomor_pkh" label="Nomor PKH" placeholder="124155151" type="number"
                                  fgroup-class="col-md-4"/>
            </div>
            <div class="row">
                <x-adminlte-input name="no_hp" label="Nomor Handphone/Telp" placeholder="08123456789" type="number"
                                  fgroup-class="col-md-6" required/>
                <x-adminlte-textarea name="alamat_wali" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat"/>
            </div>
        </x-adminlte-card>
        <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
        <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
    </x-form>
</x-app-layout>
