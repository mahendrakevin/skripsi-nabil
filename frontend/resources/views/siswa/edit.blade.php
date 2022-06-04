@section('plugins.Select2', true)
<x-app-layout title="Edit Siswa {{ $siswa->nama_siswa }}">
    <x-form method="GET" action="{{ route('admin.siswa.update', $siswa->id) }}">
        <x-adminlte-card theme="lime" theme-mode="outline" title="Isi Data Siswa">
            <div class="row">
                <x-adminlte-input name="nisn" label="Nomor Induk Siswa Nasional" placeholder="1277471818"
                                  fgroup-class="col-md-3" type="number" value="{{ $siswa->nisn }}" required/>
                <x-adminlte-input name="nis" label="Nomor Induk Siswa" placeholder="1277471818"
                                  fgroup-class="col-md-3" type="number" value="{{ $siswa->nis }}" required/>
                <x-adminlte-input name="nik" label="NIK" placeholder="1234567890123456"
                                  fgroup-class="col-md-3" type="number" value="{{ $siswa->nik }}" required/>
                <x-adminlte-input name="nomor_kk" label="No Kartu Keluarga" placeholder="1234567890123456"
                                  fgroup-class="col-md-3" type="number" value="{{ $siswa->nomor_kk }}" required/>
            </div>
            <div class="row">
                <x-adminlte-input name="nama_siswa" label="Nama Siswa" placeholder="Alfalah"
                                  fgroup-class="col-md-8" value="{{ $siswa->nama_siswa }}" required/>
                <x-adminlte-input name="nomor_kip" label="No KIP" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" value="{{ $siswa->nomor_kip }}" required/>
            </div>
            <div class="row">
                <x-adminlte-input name="tempat_lahir" label="Tempat Lahir" placeholder="Semarang"
                                  fgroup-class="col-md-6" value="{{ $siswa->tempat_lahir }}" required/>
                <x-adminlte-input-date name="tanggal_lahir" :config="$config_date" label="Tanggal Lahir"
                                       placeholder="Choose a time..." fgroup-class="col-md-6" value="{{ $siswa->tanggal_lahir }}" required>
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
                    <option  {{old('jenis_kelamin',$siswa->jenis_kelamin)=="Laki Laki"? 'selected':''}} value="Laki Laki">Laki Laki</option>
                    <option {{old('jenis_kelamin',$siswa->jenis_kelamin)=="Perempuan"? 'selected':''}} value="Perempuan">Perempuan</option>
                </x-adminlte-select2>
                <x-adminlte-select2 name="status_siswa" fgroup-class="col-md-4" label="Status Siswa">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-user"></i>
                        </div>
                    </x-slot>
                    <option {{old('status_siswa',$siswa->status_siswa)=="Aktif"? 'selected':''}} value="Aktif">Aktif</option>
                    <option {{old('status_siswa',$siswa->status_siswa)=="Tidak Aktif"? 'selected':''}} value="Tidak Aktif">Tidak Aktif</option>
                </x-adminlte-select2>
                <x-adminlte-select2 name="id_kelas" fgroup-class="col-md-4" label="Kelas">
                    @foreach($kelas as $kls)
                        <option {{old('id_kelas',$siswa->id_kelas)==$kls->id? 'selected':''}} value="{{ $kls->id }}">{{$kls->nama_kelas.' '.$kls->tingkat}}</option>
                    @endforeach
                </x-adminlte-select2>
            </div>
            <div class="row">
                <x-adminlte-textarea name="alamat" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat">
                    {{ $siswa->alamat }}
                </x-adminlte-textarea>
            </div>
        </x-adminlte-card>
        <div class="row">
            <div class="col-md-6">
                <x-adminlte-card theme="lightblue" theme-mode="outline" title="Isi Data Ayah">
                    <div class="row">
                        <x-adminlte-input name="nama_ayah" label="Nama Wali" placeholder="Alfa"
                                          fgroup-class="col-md-8" value="{{ $walisiswa->nama_ayah }}" />
                        <x-adminlte-input-file name="file_kk_ayah" igroup-size="sm" placeholder="Pilih file..." label="File Kartu Keluarga"
                                               value="{{ $walisiswa->file_kk }}" fgroup-class="col-md-4">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-lightblue">
                                    <i class="fas fa-address-card"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-file>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="tempat_lahir_ayah" label="Tempat Lahir" placeholder="Semarang"
                                          fgroup-class="col-md-6" value="{{ $walisiswa->tempat_lahir_ayah }}" required/>
                        <x-adminlte-input-date name="tanggal_lahir_ayah" :config="$config_date" label="Tanggal Lahir"
                                               placeholder="Choose a time..." fgroup-class="col-md-6" value="{{ $walisiswa->tanggal_lahir_ayah }}" required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                    </div>
                    <div class="row">
                        <x-adminlte-select2 name="status_keluarga_ayah" fgroup-class="col-md-6" label="Status Ayah">
                            <x-slot name="prependSlot_ayah">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-school"></i>
                                </div>
                            </x-slot>
                            <option {{old('pendidikan',$walisiswa->status_keluarga_ayah)=="Kandung"? 'selected':''}} value="Kandung">Kandung</option>
                            <option {{old('pendidikan',$walisiswa->status_keluarga_ayah)=="Tiri"? 'selected':''}} value="Tiri">Tiri</option>
                        </x-adminlte-select2>
                        <x-adminlte-select2 name="status_hidup_ayah" fgroup-class="col-md-6" label="Status">
                            <x-slot name="prependSlot_ayah">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-school"></i>
                                </div>
                            </x-slot>
                            <option {{old('pendidikan',$walisiswa->status_hidup_ayah)=="Masih Hidup"? 'selected':''}} value="Masih Hidup">Masih Hidup</option>
                            <option {{old('pendidikan',$walisiswa->status_hidup_ayah)=="Sudah Meninggal Dunia"? 'selected':''}} value="Sudah Meninggal Dunia">Sudah Meninggal Dunia</option>
                            <option {{old('pendidikan',$walisiswa->status_hidup_ayah)=="Tidak Diketahui"? 'selected':''}} value="Tidak Diketahui">Tidak Diketahui</option>
                        </x-adminlte-select2>
                    </div>
                    <div class="row">
                        <x-adminlte-select2 name="pendidikan_ayah" fgroup-class="col-md-6" label="Pendidikan Terakhir">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-school"></i>
                                </div>
                            </x-slot>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ayah)=="SD/Sederajat"? 'selected':''}} value="SD/Sederajat">SD/Sederajat</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ayah)=="SMP/Sederajat"? 'selected':''}} value="SMP/Sederajat">SMP/Sederajat</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ayah)=="SMA/Sederajat"? 'selected':''}} value="SMA/Sederajat">SMA/Sederajat</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ayah)=="D1"? 'selected':''}} value="D1">D1</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ayah)=="D2"? 'selected':''}} value="D2">D2</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ayah)=="D3"? 'selected':''}} value="D3">D3</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ayah)=="D4/S1"? 'selected':''}} value="D4/S1">D4/S1</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ayah)=="S2"? 'selected':''}} value="S2">S2</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ayah)=="S3"? 'selected':''}} value="S3">S3</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ayah)=="Tidak Bersekolah"? 'selected':''}} value="Tidak Bersekolah">Tidak Bersekolah</option>
                        </x-adminlte-select2>
                        <x-adminlte-input name="pekerjaan_ayah" label="Pekerjaan" placeholder="PNS"
                                          fgroup-class="col-md-6" value="{{ $walisiswa->pekerjaan_ayah }}" required/>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="penghasilan_ayah" label="Penghasilan Perbulan" placeholder="124155151" type="number"
                                          fgroup-class="col-md-4" value="{{ $walisiswa->penghasilan_ayah }}" required/>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="no_hp_ayah" label="Nomor Handphone/Telp" placeholder="08123456789" type="number"
                                          fgroup-class="col-md-6" value="{{ $walisiswa->no_hp_ayah }}" required/>
                        <x-adminlte-textarea name="alamat_ayah" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat">
                            {{ $walisiswa->alamat_ayah }}
                        </x-adminlte-textarea>
                    </div>
                </x-adminlte-card>
            </div>
            <div class="col-md-6">
                <x-adminlte-card theme="lightblue" theme-mode="outline" title="Isi Data Ibu">
                    <div class="row">
                        <x-adminlte-input name="nama_ibu" label="Nama Wali" placeholder="Alfa"
                                          fgroup-class="col-md-8" value="{{ $walisiswa->nama_ibu }}" required/>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="tempat_lahir_ibu" label="Tempat Lahir" placeholder="Semarang"
                                          fgroup-class="col-md-6" value="{{ $walisiswa->tempat_lahir_ibu }}" required/>
                        <x-adminlte-input-date name="tanggal_lahir_ibu" :config="$config_date" label="Tanggal Lahir"
                                               placeholder="Choose a time..." fgroup-class="col-md-6" value="{{ $walisiswa->tanggal_lahir_ibu }}" required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                    </div>
                    <div class="row">
                        <x-adminlte-select2 name="status_keluarga_ibu" fgroup-class="col-md-6" label="Status Ibu">
                            <x-slot name="prependSlot_ibu">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-school"></i>
                                </div>
                            </x-slot>
                            <option {{old('pendidikan',$walisiswa->status_keluarga_ibu)=="Kandung"? 'selected':''}} value="Kandung">Kandung</option>
                            <option {{old('pendidikan',$walisiswa->status_keluarga_ibu)=="Tiri"? 'selected':''}} value="Tiri">Tiri</option>
                        </x-adminlte-select2>
                        <x-adminlte-select2 name="status_hidup_ibu" fgroup-class="col-md-6" label="Status">
                            <x-slot name="prependSlot_ibu">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-school"></i>
                                </div>
                            </x-slot>
                            <option {{old('pendidikan',$walisiswa->status_hidup_ibu)=="Masih Hidup"? 'selected':''}} value="Masih Hidup">Masih Hidup</option>
                            <option {{old('pendidikan',$walisiswa->status_hidup_ibu)=="Sudah Meninggal Dunia"? 'selected':''}} value="Sudah Meninggal Dunia">Sudah Meninggal Dunia</option>
                            <option {{old('pendidikan',$walisiswa->status_hidup_ibu)=="Tidak Diketahui"? 'selected':''}} value="Tidak Diketahui">Tidak Diketahui</option>
                        </x-adminlte-select2>
                    </div>
                    <div class="row">
                        <x-adminlte-select2 name="pendidikan_ibu" fgroup-class="col-md-6" label="Pendidikan Terakhir">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-school"></i>
                                </div>
                            </x-slot>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="SD/Sederajat"? 'selected':''}} value="SD/Sederajat">SD/Sederajat</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="SMP/Sederajat"? 'selected':''}} value="SMP/Sederajat">SMP/Sederajat</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="SMA/Sederajat"? 'selected':''}} value="SMA/Sederajat">SMA/Sederajat</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="D1"? 'selected':''}} value="D1">D1</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="D2"? 'selected':''}} value="D2">D2</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="D3"? 'selected':''}} value="D3">D3</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="D4/S1"? 'selected':''}} value="D4/S1">D4/S1</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="S2"? 'selected':''}} value="S2">S2</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="S3"? 'selected':''}} value="S3">S3</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="Tidak Bersekolah"? 'selected':''}} value="Tidak Bersekolah">Tidak Bersekolah</option>
                        </x-adminlte-select2>
                        <x-adminlte-input name="pekerjaan_ibu" label="Pekerjaan" placeholder="PNS"
                                          fgroup-class="col-md-6" value="{{ $walisiswa->pekerjaan_ibu }}" required/>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="penghasilan_ibu" label="Penghasilan Perbulan" placeholder="124155151" type="number"
                                          fgroup-class="col-md-4" value="{{ $walisiswa->penghasilan_ibu }}" required/>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="no_hp_ibu" label="Nomor Handphone/Telp" placeholder="08123456789" type="number"
                                          fgroup-class="col-md-6" value="{{ $walisiswa->no_hp_ibu }}" required/>
                        <x-adminlte-textarea name="alamat_ibu" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat">
                            {{ $walisiswa->alamat_ibu }}
                        </x-adminlte-textarea>
                    </div>
                </x-adminlte-card>
            </div>
            <div class="col-md-6">
                <x-adminlte-card theme="lightblue" theme-mode="outline" title="Isi Data Wali">
                    <div class="row">
                        <x-adminlte-input name="jenis_wali" label="Jenis Wali" placeholder="Ayah"
                                          fgroup-class="col-md-8" value="{{ $siswa->jenis_wali }}" />
                        <x-adminlte-input name="nama_wali" label="Nama Wali" placeholder="Alfa"
                                          fgroup-class="col-md-8" value="{{ $walisiswa->nama_wali }}" />
                    </div>
                    <div class="row">
                        <x-adminlte-input name="tempat_lahir_wali" label="Tempat Lahir" placeholder="Semarang"
                                          fgroup-class="col-md-6" value="{{ $walisiswa->tempat_lahir_wali }}" />
                        <x-adminlte-input-date name="tanggal_lahir_wali" :config="$config_date" label="Tanggal Lahir"
                                               placeholder="Choose a time..." fgroup-class="col-md-6" value="{{ $walisiswa->tanggal_lahir_wali }}" >
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                    </div>
                    <div class="row">
                        <x-adminlte-select2 name="pendidikan_wali" fgroup-class="col-md-6" label="Pendidikan Terakhir">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-school"></i>
                                </div>
                            </x-slot>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="SD/Sederajat"? 'selected':''}} value="SD/Sederajat">SD/Sederajat</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="SMP/Sederajat"? 'selected':''}} value="SMP/Sederajat">SMP/Sederajat</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="SMA/Sederajat"? 'selected':''}} value="SMA/Sederajat">SMA/Sederajat</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="D1"? 'selected':''}} value="D1">D1</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="D2"? 'selected':''}} value="D2">D2</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="D3"? 'selected':''}} value="D3">D3</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="D4/S1"? 'selected':''}} value="D4/S1">D4/S1</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="S2"? 'selected':''}} value="S2">S2</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="S3"? 'selected':''}} value="S3">S3</option>
                            <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="Tidak Bersekolah"? 'selected':''}} value="Tidak Bersekolah">Tidak Bersekolah</option>
                        </x-adminlte-select2>
                        <x-adminlte-input name="pekerjaan_wali" label="Pekerjaan" placeholder="PNS"
                                          fgroup-class="col-md-6" value="{{ $walisiswa->pekerjaan_wali }}" />
                    </div>
                    <div class="row">
                        <x-adminlte-input name="penghasilan_wali" label="Penghasilan Perbulan" placeholder="124155151" type="number"
                                          fgroup-class="col-md-4" value="{{ $walisiswa->penghasilan_wali }}" />
                    </div>
                    <div class="row">
                        <x-adminlte-input name="no_hp_wali" label="Nomor Handphone/Telp" placeholder="08123456789" type="number"
                                          fgroup-class="col-md-6" value="{{ $walisiswa->no_hp_wali }}" />
                        <x-adminlte-textarea name="alamat_wali" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat">
                            {{ $walisiswa->alamat_wali }}
                        </x-adminlte-textarea>
                    </div>
                </x-adminlte-card>
            </div>
            <div class="col-md-6">
                <x-adminlte-card theme="lightblue" theme-mode="outline" title="No KKS/PKH">
                    <div class="row">
                        <x-adminlte-input name="nomor_kks" value="0" label="Nomor KKS" placeholder="124155151" type="number"
                                          fgroup-class="col-md-4" value="{{ $siswa->nomor_kks }}"/>
                        <x-adminlte-input name="nomor_pkh" value="0" label="Nomor PKH" placeholder="124155151" type="number"
                                          fgroup-class="col-md-4" value="{{ $siswa->nomor_pkh }}"/>
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
            </div>
        </div>

    </x-form>
</x-app-layout>
