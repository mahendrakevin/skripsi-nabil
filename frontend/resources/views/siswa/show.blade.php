@section('plugins.Select2', true)
<x-app-layout title="Lihat Siswa {{ $siswa->nama_siswa }}">
    <x-form method="GET" action="{{ route('admin.siswa.update', $siswa->id) }}">
        <x-adminlte-card theme="lime" theme-mode="outline" title="Isi Data Siswa">
            <div class="row">
                <x-adminlte-input name="nis" label="Nomor Induk Siswa Nasional" placeholder="1277471818"
                                  fgroup-class="col-md-3" type="number" value="{{ $siswa->nis }}" disabled/>
                <x-adminlte-input name="nisn" label="Nomor Induk Siswa Nasional" placeholder="1277471818"
                                  fgroup-class="col-md-3" type="number" value="{{ $siswa->nisn }}" disabled/>
                <x-adminlte-input name="nik" label="NIK" placeholder="1234567890123456"
                                  fgroup-class="col-md-3" type="number" value="{{ $siswa->nik }}" disabled/>
                <x-adminlte-input name="no_kk" label="No Kartu Keluarga" placeholder="1234567890123456"
                                  fgroup-class="col-md-3" type="number" value="{{ $siswa->nomor_kk }}" disabled/>
            </div>
            <div class="row">
                <x-adminlte-input name="nama_siswa" label="Nama Siswa" placeholder="Alfalah"
                                  fgroup-class="col-md-8" value="{{ $siswa->nama_siswa }}" disabled/>
                <x-adminlte-input name="nomor_kip" label="No KIP" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" value="{{ $siswa->nomor_kip }}" disabled/>
            </div>
            <div class="row">
                <x-adminlte-input name="tempat_lahir" label="Tempat Lahir" placeholder="Semarang"
                                  fgroup-class="col-md-6" value="{{ $siswa->tempat_lahir }}" disabled/>
                <x-adminlte-input-date name="tanggal_lahir" :config="$config_date" label="Tanggal Lahir"
                                       placeholder="Choose a time..." fgroup-class="col-md-6" value="{{ $siswa->tanggal_lahir }}" disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-clock"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
            </div>
            <div class="row">
                <x-adminlte-select2 name="jenis_kelamin" fgroup-class="col-md-4" label="Jenis Kelamin" disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-align-justify"></i>
                        </div>
                    </x-slot>
                    <option  {{old('jenis_kelamin',$siswa->jenis_kelamin)=="Laki Laki"? 'selected':''}} value="Laki Laki">Laki Laki</option>
                    <option {{old('jenis_kelamin',$siswa->jenis_kelamin)=="Perempuan"? 'selected':''}} value="Perempuan">Perempuan</option>
                </x-adminlte-select2>
                <x-adminlte-select2 name="status_siswa" fgroup-class="col-md-4" label="Status Siswa" disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-user"></i>
                        </div>
                    </x-slot>
                    <option {{old('status_siswa',$siswa->status_siswa)=="Aktif"? 'selected':''}} value="Aktif">Aktif</option>
                    <option {{old('status_siswa',$siswa->status_siswa)=="Tidak Aktif"? 'selected':''}} value="Tidak Aktif">Tidak Aktif</option>
                </x-adminlte-select2>
                <x-adminlte-select2 name="id_kelas" fgroup-class="col-md-4" label="Kelas" disabled>
                    @foreach($kelas as $kls)
                        <option {{old('id_kelas',$siswa->id_kelas)==$kls->id? 'selected':''}} value="{{ $kls->id }}">{{$kls->nama_kelas}}</option>
                    @endforeach
                </x-adminlte-select2>
            </div>
            <div class="row">
                <x-adminlte-textarea name="alamat" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat" disabled>
                    {{ $siswa->alamat }}
                </x-adminlte-textarea>
            </div>
        </x-adminlte-card>
        <x-adminlte-card theme="lightblue" theme-mode="outline" title="Isi Data Wali">
            <div class="row">
                <x-adminlte-select2 name="id_jeniswali" fgroup-class="col-md-12" label="Pilih Jenis Wali" disabled>
                    @foreach($jeniswali as $jw)
                        <option {{old('id_jeniswali',$walisiswa->id_jeniswali)==$jw->id? 'selected':''}} value="{{ $jw->id }}">{{$jw->jenis_wali}}</option>
                    @endforeach
                </x-adminlte-select2>
            </div>
            <div class="row">
                <x-adminlte-input name="nama_wali" label="Nama Wali" placeholder="Alfa"
                                  fgroup-class="col-md-8" value="{{ $walisiswa->nama_wali }}" disabled/>
                <x-adminlte-input-file name="file_kk" igroup-size="sm" placeholder="Pilih file..." label="File Kartu Keluarga"
                                       value="{{ $walisiswa->file_kk }}" disabled fgroup-class="col-md-4">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-lightblue">
                            <i class="fas fa-address-card"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>
            </div>
            <div class="row">
                <x-adminlte-input name="tempat_lahir_wali" label="Tempat Lahir" placeholder="Semarang"
                                  fgroup-class="col-md-6" value="{{ $walisiswa->tempat_lahir }}" disabled/>
                <x-adminlte-input-date name="tanggal_lahir_wali" :config="$config_date" label="Tanggal Lahir"
                                       placeholder="Choose a time..." fgroup-class="col-md-6" value="{{ $walisiswa->tanggal_lahir }}" disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-clock"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
            </div>
            <div class="row">
                <x-adminlte-select2 name="pendidikan" fgroup-class="col-md-6" label="Pendidikan Terakhir" disabled>
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-school"></i>
                        </div>
                    </x-slot>
                    <option {{old('pendidikan',$walisiswa->pendidikan)=="SD"? 'selected':''}} value="SD">SD</option>
                    <option {{old('pendidikan',$walisiswa->pendidikan)=="SMP"? 'selected':''}} value="SMP">SMP</option>
                    <option {{old('pendidikan',$walisiswa->pendidikan)=="SMA"? 'selected':''}} value="SMA">SMA</option>
                    <option {{old('pendidikan',$walisiswa->pendidikan)=="Sarjana"? 'selected':''}} value="Sarjana">Sarjana</option>
                    <option {{old('pendidikan',$walisiswa->pendidikan)=="Master"? 'selected':''}} value="Master">Master</option>
                    <option {{old('pendidikan',$walisiswa->pendidikan)=="Doktor"? 'selected':''}} value="Doktor">Doktor</option>
                </x-adminlte-select2>
                <x-adminlte-input name="pekerjaan" label="Pekerjaan" placeholder="PNS"
                                  fgroup-class="col-md-6" value="{{ $walisiswa->pekerjaan }}" disabled/>
            </div>
            <div class="row">
                <x-adminlte-input name="penghasilan" label="Penghasilan Perbulan" placeholder="124155151" type="number"
                                  fgroup-class="col-md-4" value="{{ $walisiswa->penghasilan }}" disabled/>
                <x-adminlte-input name="nomor_kks" label="Nomor KKS" placeholder="124155151" type="number"
                                  fgroup-class="col-md-4" value="{{ $walisiswa->nomor_kks }}" disabled/>
                <x-adminlte-input name="nomor_pkh" label="Nomor PKH" placeholder="124155151" type="number"
                                  fgroup-class="col-md-4" value="{{ $walisiswa->nomor_pkh }}" disabled/>
            </div>
            <div class="row">
                <x-adminlte-input name="no_hp" label="Nomor Handphone/Telp" placeholder="08123456789" type="number"
                                  fgroup-class="col-md-6" value="{{ $walisiswa->no_hp }}" disabled/>
                <x-adminlte-textarea name="alamat_wali" fgroup-class="col-md-6" label="Alamat" disabled placeholder="Masukkan alamat">
                    {{ $walisiswa->alamat }}
                </x-adminlte-textarea>
            </div>
        </x-adminlte-card>
    </x-form>
</x-app-layout>
