@section('plugins.Select2', true)
<x-app-layout title="Tambah Siswa">
    <x-form method="POST" action="{{ route('admin.siswa.store') }}">
        <x-adminlte-card theme="lime" theme-mode="outline" title="Isi Data Siswa">
            <div class="row">
                <x-adminlte-input name="nisn" label="Nomor Induk Siswa Nasional" placeholder="1277471818"
                                  fgroup-class="col-md-3" type="number" required/>
                <x-adminlte-input name="nis" label="Nomor Induk Siswa" placeholder="7077"
                                  fgroup-class="col-md-3" type="number" required/>
                <x-adminlte-input name="nik" label="NIK"
                                  min=1000000000000000 max=9999999999999999
                                  placeholder="1234567890123456" fgroup-class="col-md-3" type="number" required/>
                <x-adminlte-input name="nomor_kk" label="No Kartu Keluarga"
                                  min=1000000000000000 max=9999999999999999
                                  placeholder="1234567890123456" fgroup-class="col-md-3" type="number" required/>
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
                <x-adminlte-select2 name="id_jeniswali" fgroup-class="col-md-6" label="Pilih Jenis Wali">
                    @foreach($jeniswali as $jw)
                        <option value="{{ $jw->id }}">{{$jw->jenis_wali}}</option>
                    @endforeach
                </x-adminlte-select2>
            </div>
        </x-adminlte-card>
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-card theme="lightblue" theme-mode="outline" title="Isi Data Ayah">
                    <div class="row">
                        <x-adminlte-input name="nama_ayah" label="Nama" placeholder="Alfa"
                                          fgroup-class="col-md-8" required/>
                        <x-adminlte-input-file name="file_kk_ayah" igroup-size="sm" placeholder="Pilih file..." label="File Kartu Keluarga" fgroup-class="col-md-4">
                            <x-slot name="prependSlot_ayah">
                                <div class="input-group-text bg-lightblue">
                                    <i class="fas fa-address-card"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-file>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="tempat_lahir_ayah" label="Tempat Lahir" placeholder="Semarang"
                                          fgroup-class="col-md-6" required/>
                        <x-adminlte-input-date name="tanggal_lahir_ayah" :config="$config_date" label="Tanggal Lahir" placeholder="Choose a time..." fgroup-class="col-md-6" required>
                            <x-slot name="prependSlot_ayah">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                    </div>
                    <div class="row">
                        <x-adminlte-select2 name="pendidikan_ayah" fgroup-class="col-md-6" label="Pendidikan Terakhir">
                            <x-slot name="prependSlot_ayah">
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
                        <x-adminlte-input name="pekerjaan_ayah" label="Pekerjaan" placeholder="PNS"
                                          fgroup-class="col-md-6" required/>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="penghasilan_ayah" label="Penghasilan Perbulan" placeholder="124155151" type="number"
                                          fgroup-class="col-md-4" required/>
                        <x-adminlte-input name="nomor_kks_ayah" label="Nomor KKS" placeholder="124155151" type="number"
                                          fgroup-class="col-md-4"/>
                        <x-adminlte-input name="nomor_pkh_ayah" label="Nomor PKH" placeholder="124155151" type="number"
                                          fgroup-class="col-md-4"/>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="no_hp_ayah" label="Nomor Handphone/Telp" placeholder="08123456789" type="number"
                                          fgroup-class="col-md-6" required/>
                        <x-adminlte-textarea name="alamat_ayah" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat"/>
                    </div>
                </x-adminlte-card>
            </div>
            <div class="col-md-6">
                <x-adminlte-card theme="lightblue" theme-mode="outline" title="Isi Data Ibu">
                    <div class="row">
                        <x-adminlte-input name="nama_ibu" label="Nama" placeholder="Alfa"
                                          fgroup-class="col-md-8" required/>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="tempat_lahir_ibu" label="Tempat Lahir" placeholder="Semarang"
                                          fgroup-class="col-md-6" required/>
                        <x-adminlte-input-date name="tanggal_lahir_ibu" :config="$config_date" label="Tanggal Lahir" placeholder="Choose a time..." fgroup-class="col-md-6" required>
                            <x-slot name="prependSlot_ibu">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                    </div>
                    <div class="row">
                        <x-adminlte-select2 name="pendidikan_ibu" fgroup-class="col-md-6" label="Pendidikan Terakhir">
                            <x-slot name="prependSlot_ibu">
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
                        <x-adminlte-input name="pekerjaan_ibu" label="Pekerjaan" placeholder="PNS"
                                          fgroup-class="col-md-6" required/>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="penghasilan_ibu" label="Penghasilan Perbulan" placeholder="124155151" type="number"
                                          fgroup-class="col-md-4" required/>
                        <x-adminlte-input name="nomor_kks_ibu" label="Nomor KKS" placeholder="124155151" type="number"
                                          fgroup-class="col-md-4"/>
                        <x-adminlte-input name="nomor_pkh_ibu" label="Nomor PKH" placeholder="124155151" type="number"
                                          fgroup-class="col-md-4"/>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="no_hp_ibu" label="Nomor Handphone/Telp" placeholder="08123456789" type="number"
                                          fgroup-class="col-md-6" required/>
                        <x-adminlte-textarea name="alamat_ibu" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat"/>
                    </div>
                </x-adminlte-card>
            </div>
        </div>
        <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
        <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
    </x-form>
</x-app-layout>
