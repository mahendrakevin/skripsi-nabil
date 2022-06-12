@section('plugins.Select2', true)
<x-app-layout title="Data Siswa {{ $siswa->nama_siswa }}">

        <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Biodata Siswa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Laporan Pembayaran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-settings-tab" data-toggle="pill" href="#custom-tabs-two-settings" role="tab" aria-controls="custom-tabs-two-settings" aria-selected="false">Orang Tua / Wali</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-two-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                    <div class="row">
                        <x-adminlte-input name="nama_siswa" label="Nama Siswa" placeholder="Alfalah"
                                          fgroup-class="col-md-4" value="{{ $siswa->nama_siswa }}"  readonly/>
                        <x-adminlte-input name="nomor_kip" label="No KIP" placeholder="1234567890123456"
                                          fgroup-class="col-md-4" type="number" value="{{ $siswa->nomor_kip }}"  readonly/>
                        <x-adminlte-input name="nis" label="NIS" placeholder="1277471818"
                                          fgroup-class="col-md-4" type="number" value="{{ $siswa->nis }}" readonly/>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="nisn" label="NISN" placeholder="1277471818"
                                          fgroup-class="col-md-3" type="number" value="{{ $siswa->nisn }}" readonly/>
                        <x-adminlte-input name="nik" label="NIK" placeholder="1234567890123456"
                                          fgroup-class="col-md-3" type="number" value="{{ $siswa->nik }}" readonly/>
                        <x-adminlte-select2 name="id_kelas" fgroup-class="col-md-3" label="Kelas" disabled>
                            @foreach($kelas as $kls)
                                <option {{old('id_kelas',$siswa->id_kelas)==$kls->id? 'selected':''}} value="{{ $kls->id }}">{{$kls->nama_kelas}}</option>
                            @endforeach
                        </x-adminlte-select2>
                        <x-adminlte-select2 name="status_siswa" fgroup-class="col-md-3" label="Status Siswa" disabled>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-user"></i>
                                </div>
                            </x-slot>
                            <option {{old('status_siswa',$siswa->status_siswa)=="Aktif"? 'selected':''}} value="Aktif">Aktif</option>
                            <option {{old('status_siswa',$siswa->status_siswa)=="Tidak Aktif"? 'selected':''}} value="Tidak Aktif">Tidak Aktif</option>
                        </x-adminlte-select2>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="current_state" label="Tahun Pelajaran" placeholder="1277471818"
                                          fgroup-class="col-md-3" type="text" value="{{ $siswa->current_state }}" readonly/>
                        <x-adminlte-input name="tempat_lahir" label="Tempat Lahir" placeholder="Semarang"
                                          fgroup-class="col-md-3" value="{{ $siswa->tempat_lahir }}"  readonly/>
                        <x-adminlte-input-date name="tanggal_lahir" :config="$config_date" label="Tanggal Lahir"
                                               placeholder="Choose a time..." fgroup-class="col-md-3" value="{{ $siswa->tanggal_lahir }}"  disabled>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                        <x-adminlte-select2 name="jenis_kelamin" fgroup-class="col-md-3" label="Jenis Kelamin" disabled>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-align-justify"></i>
                                </div>
                            </x-slot>
                            <option  {{old('jenis_kelamin',$siswa->jenis_kelamin)=="Laki Laki"? 'selected':''}} value="Laki Laki">Laki Laki</option>
                            <option {{old('jenis_kelamin',$siswa->jenis_kelamin)=="Perempuan"? 'selected':''}} value="Perempuan">Perempuan</option>
                        </x-adminlte-select2>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="nomor_kk" label="No Kartu Keluarga" placeholder="1234567890123456"
                                          fgroup-class="col-md-3" type="number" value="{{ $siswa->nomor_kk }}" readonly/>
                        <x-adminlte-textarea name="alamat" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat" disabled>
                            {{ $siswa->alamat }}
                        </x-adminlte-textarea>
                    </div>
                    @foreach($kelas as $kls)
                        @if (Auth::user()->role == '1' && $siswa->id_kelas == $kls->id)
                            @if($kls->tingkat == 'B')
                                <x-submit-button method="GET" action="{{route('admin.siswa.change_status', [$siswa->id, 'Lulus'])}}"
                                             theme="info" label="Luluskan Siswa" icon="fas fa-plus" type="submit"></x-submit-button>
                            @elseif($kls->tingkat == 'A')
                                <x-submit-button method="GET" action="{{route('admin.siswa.edit', $siswa->id)}}"
                                                 theme="warning" label="Naik Kelas" icon="fas fa-plus" type="submit"></x-submit-button>
                            @endif
                        @endif
                    @endforeach
                </div>
                <div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
                    <div class="row">
                        <div class="col-md-12">
                            @if (Auth::user()->role == '1')
                                <x-submit-button method="POST" action="{{route('admin.laporan_pembayaran.create')}}"
                                                 theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>
                            @endif
                            <x-adminlte-datatable id="datasiswa" :heads="$heads_pembayaran" :config="$config_pembayaran"  striped hoverable with-footer beautify>
                                @foreach($config_pembayaran['data'] as $row)
                                    <tr>
                                        @foreach($row as $cell)
                                            <td> {!!  $cell !!}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </x-adminlte-datatable>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-two-settings" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <x-adminlte-card theme="lightblue" theme-mode="outline" title="Biodata Diri Ayah">
                                <div class="row">
                                    <x-adminlte-input name="nama_ayah" label="Nama Wali" placeholder="Alfa" fgroup-class="col-md-6" value="{{ $walisiswa->nama_ayah }}" disabled />
                                    <x-adminlte-input-file name="file_kk_ayah" igroup-size="md" placeholder="Pilih file..." label="File KK Ayah" value="{{ $walisiswa->file_kk_ayah }}" fgroup-class="col-md-6" disabled>
                                        <x-slot name="prependSlot">
                                            <!-- <div class="input-group-text bg-lightblue">
                                            <i class="fas fa-address-card"></i>
                                        </div> -->
                                        </x-slot>
                                    </x-adminlte-input-file>
                                </div>
                                <div class="row">
                                    <!-- <x-adminlte-input name="nik" label="NIK" placeholder="1234567890123456" fg  -->
                                    <x-adminlte-input name="nik_ayah" label="NIK" value="{{$walisiswa->nik_ayah}}" placeholder="1234567890123456" fgroup-class="col-md-6" type="number" value="{{ $walisiswa->nik_ayah }}" disabled />
                                    <x-adminlte-input-date name="tanggal_lahir_ayah" :config="$config_date" label="Tanggal Lahir" placeholder="Choose a time..." fgroup-class="col-md-6" value="{{ $walisiswa->tanggal_lahir_ayah }}" disabled>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-date>
                                </div>
                                <div class="row">
                                    <x-adminlte-input name="tempat_lahir_ayah" label="Tempat Lahir" placeholder="Semarang" fgroup-class="col-md-6" value="{{ $walisiswa->tempat_lahir_ayah }}" disabled />
                                    <x-adminlte-select2 name="status_keluarga_ayah" fgroup-class="col-md-6" label="Status Ayah" disabled>
                                        <x-slot name="prependSlot_ayah">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-school"></i>
                                            </div>
                                        </x-slot>
                                        <option {{old('pendidikan',$walisiswa->status_keluarga_ayah)=="Kandung"? 'selected':''}} value="Kandung">Kandung</option>
                                        <option {{old('pendidikan',$walisiswa->status_keluarga_ayah)=="Tiri"? 'selected':''}} value="Tiri">Tiri</option>
                                    </x-adminlte-select2>
                                </div>
                                <div class="row">
                                    <x-adminlte-select2 name="status_hidup_ayah" fgroup-class="col-md-6" label="Status" disabled>
                                        <x-slot name="prependSlot_ayah">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-school"></i>
                                            </div>
                                        </x-slot>
                                        <option {{old('pendidikan',$walisiswa->status_hidup_ayah)=="Masih Hidup"? 'selected':''}} value="Masih Hidup">Masih Hidup</option>
                                        <option {{old('pendidikan',$walisiswa->status_hidup_ayah)=="Meninggal Dunia"? 'selected':''}} value="Meninggal Dunia">Meninggal Dunia</option>
                                        <option {{old('pendidikan',$walisiswa->status_hidup_ayah)=="Tidak Diketahui"? 'selected':''}} value="Tidak Diketahui">Tidak Diketahui</option>
                                    </x-adminlte-select2>
                                    <x-adminlte-input name="pekerjaan_ayah" label="Pekerjaan" placeholder="PNS" fgroup-class="col-md-6" value="{{ $walisiswa->pekerjaan_ayah }}" disabled />
                                </div>
                                <div class="row">
                                    <x-adminlte-input name="penghasilan_ayah" label="Penghasilan Perbulan" placeholder="124155151" type="number" fgroup-class="col-md-6" value="{{ $walisiswa->penghasilan_ayah }}" disabled />
                                    <x-adminlte-select2 name="pendidikan_ayah" fgroup-class="col-md-6" label="Pendidikan Terakhir" disabled>
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
                                </div>
                                <div class="row">
                                    <x-adminlte-input name="no_hp_ayah" label="Nomor Handphone/Telp" placeholder="08123456789" type="number" fgroup-class="col-md-6" value="{{ $walisiswa->no_hp_ayah }}" disabled />
                                    <x-adminlte-textarea name="alamat_ayah" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat" disabled>
                                        {{ $walisiswa->alamat_ayah }}
                                    </x-adminlte-textarea>
                                </div>
                            </x-adminlte-card>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-card theme="lightblue" theme-mode="outline" title="Biodata Diri Ibu">
                                <div class="row">
                                    <x-adminlte-input name="nama_ibu" label="Nama Wali" placeholder="Alfa" fgroup-class="col-md-6" value="{{ $walisiswa->nama_ibu }}" disabled />
                                    <x-adminlte-input-file name="file_kk_ibu" igroup-size="md" placeholder="Pilih file..." label="File KK Ibu" value="{{ $walisiswa->file_kk_ibu }}" fgroup-class="col-md-6" disabled />
                                </div>
                                <div class="row">
                                    <x-adminlte-input name="nik_ibu" value="{{$walisiswa->nik_ibu}}" label="NIK" placeholder="1234567890123456" fgroup-class="col-md-6" type="number" value="{{ $walisiswa->nik_ibu }}" disabled />
                                    <x-adminlte-input-date name="tanggal_lahir_ibu" :config="$config_date" label="Tanggal Lahir" placeholder="Choose a time..." fgroup-class="col-md-6" value="{{ $walisiswa->tanggal_lahir_ibu }}" disabled>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-date>
                                </div>
                                <div class="row">
                                    <x-adminlte-input name="tempat_lahir_ibu" label="Tempat Lahir" placeholder="Semarang" fgroup-class="col-md-6" value="{{ $walisiswa->tempat_lahir_ibu }}" disabled />
                                    <x-adminlte-select2 name="status_keluarga_ibu" fgroup-class="col-md-6" label="Status Ibu" disabled>
                                        <x-slot name="prependSlot_ibu">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-school"></i>
                                            </div>
                                        </x-slot>
                                        <option {{old('pendidikan',$walisiswa->status_keluarga_ibu)=="Kandung"? 'selected':''}} value="Kandung">Kandung</option>
                                        <option {{old('pendidikan',$walisiswa->status_keluarga_ibu)=="Tiri"? 'selected':''}} value="Tiri">Tiri</option>
                                    </x-adminlte-select2>
                                    <x-adminlte-select2 name="status_hidup_ibu" fgroup-class="col-md-6" label="Status" disabled>
                                        <x-slot name="prependSlot_ibu">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-school"></i>
                                            </div>
                                        </x-slot>
                                        <option {{old('pendidikan',$walisiswa->status_hidup_ibu)=="Masih Hidup"? 'selected':''}} value="Masih Hidup">Masih Hidup</option>
                                        <option {{old('pendidikan',$walisiswa->status_hidup_ibu)=="Meninggal Dunia"? 'selected':''}} value="Meninggal Dunia">Meninggal Dunia</option>
                                        <option {{old('pendidikan',$walisiswa->status_hidup_ibu)=="Tidak Diketahui"? 'selected':''}} value="Tidak Diketahui">Tidak Diketahui</option>
                                    </x-adminlte-select2>
                                    <x-adminlte-input name="pekerjaan_ibu" label="Pekerjaan" placeholder="PNS" fgroup-class="col-md-6" value="{{ $walisiswa->pekerjaan_ibu }}" disabled />
                                </div>
                                <div class="row">
                                    <x-adminlte-select2 name="pendidikan_ibu" fgroup-class="col-md-6" label="Pendidikan Terakhir" disabled>
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
                                    <x-adminlte-input name="penghasilan_ibu" label="Penghasilan Perbulan" placeholder="124155151" type="number" fgroup-class="col-md-6" value="{{ $walisiswa->penghasilan_ibu }}" disabled />

                                </div>
                                <div class="row">
                                    <x-adminlte-input name="no_hp_ibu" label="Nomor Handphone/Telp" placeholder="08123456789" type="number" fgroup-class="col-md-6" value="{{ $walisiswa->no_hp_ibu }}" disabled />
                                    <x-adminlte-textarea name="alamat_ibu" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat" disabled>
                                        {{ $walisiswa->alamat_ibu }}
                                    </x-adminlte-textarea>
                                </div>
                            </x-adminlte-card>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-card theme="lightblue" theme-mode="outline" title="Biodata Diri Wali">
                                <div class="row">
                                    <x-adminlte-select2 name="jeniswali" fgroup-class="col-md-6" label="Jenis Wali" disabled>
                                        <x-slot name="prependSlot_ibu">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-school"></i>
                                            </div>
                                        </x-slot>
                                        <option {{old('pendidikan',$siswa->jenis_wali)=="Ayah Kandung"? 'selected':''}} value="Ayah Kandung">Ayah Kandung</option>
                                        <option {{old('pendidikan',$siswa->jenis_wali)=="Ibu Kandung"? 'selected':''}} value="Ibu Kandung">Ibu Kandung</option>
                                        <option {{old('pendidikan',$siswa->jenis_wali)=="Lainnya"? 'selected':''}} value="Lainnya">Lainnya</option>
                                    </x-adminlte-select2>
                                    <x-adminlte-input name="nama_wali" label="Nama Wali" placeholder="Alfa"
                                                      fgroup-class="col-md-6" value="{{ $walisiswa->nama_wali }}" readonly/>
                                </div>
                                <div class="row">
                                    <x-adminlte-textarea name="keterangan" fgroup-class="col-md-6" label="Keterangan" placeholder="Keterangan" readonly>{{ $walisiswa->keterangan }}</x-adminlte-textarea>
                                    <x-adminlte-textarea name="alamat_wali" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat" readonly>
                                        {{ $walisiswa->alamat_wali }}
                                    </x-adminlte-textarea>
                                </div>
{{--                                <div class="row">--}}
{{--                                    <x-adminlte-input name="tempat_lahir_wali" label="Tempat Lahir" placeholder="Semarang"--}}
{{--                                                      fgroup-class="col-md-6" value="{{ $walisiswa->tempat_lahir_wali }}" readonly/>--}}
{{--                                    <x-adminlte-input-date name="tanggal_lahir_wali" :config="$config_date" label="Tanggal Lahir"--}}
{{--                                                           placeholder="Choose a time..." fgroup-class="col-md-6" value="{{ $walisiswa->tanggal_lahir_wali }}" disabled>--}}
{{--                                        <x-slot name="prependSlot">--}}
{{--                                            <div class="input-group-text bg-gradient-info">--}}
{{--                                                <i class="fas fa-clock"></i>--}}
{{--                                            </div>--}}
{{--                                        </x-slot>--}}
{{--                                    </x-adminlte-input-date>--}}
{{--                                </div>--}}
{{--                                <div class="row">--}}
{{--                                    <x-adminlte-select2 name="pendidikan_wali" fgroup-class="col-md-6" label="Pendidikan Terakhir" disabled>--}}
{{--                                        <x-slot name="prependSlot">--}}
{{--                                            <div class="input-group-text bg-gradient-info">--}}
{{--                                                <i class="fas fa-school"></i>--}}
{{--                                            </div>--}}
{{--                                        </x-slot>--}}
{{--                                        <option {{old('pendidikan',$walisiswa->pendidikan_wali)=="SD"? 'selected':''}} value="SD">SD</option>--}}
{{--                                        <option {{old('pendidikan',$walisiswa->pendidikan_wali)=="SMP"? 'selected':''}} value="SMP">SMP</option>--}}
{{--                                        <option {{old('pendidikan',$walisiswa->pendidikan_wali)=="SMA"? 'selected':''}} value="SMA">SMA</option>--}}
{{--                                        <option {{old('pendidikan',$walisiswa->pendidikan_wali)=="Sarjana"? 'selected':''}} value="Sarjana">Sarjana</option>--}}
{{--                                        <option {{old('pendidikan',$walisiswa->pendidikan_wali)=="Master"? 'selected':''}} value="Master">Master</option>--}}
{{--                                        <option {{old('pendidikan',$walisiswa->pendidikan_wali)=="Doktor"? 'selected':''}} value="Doktor">Doktor</option>--}}
{{--                                    </x-adminlte-select2>--}}
{{--                                    <x-adminlte-input name="pekerjaan_wali" label="Pekerjaan" placeholder="PNS"--}}
{{--                                                      fgroup-class="col-md-6" value="{{ $walisiswa->pekerjaan_wali }}" readonly/>--}}
{{--                                </div>--}}
{{--                                <div class="row">--}}
{{--                                    <x-adminlte-input name="penghasilan_wali" label="Penghasilan Perbulan" placeholder="124155151" type="number"--}}
{{--                                                      fgroup-class="col-md-4" value="{{ $walisiswa->penghasilan_wali }}" readonly/>--}}
{{--                                </div>--}}
                                <div class="row">
                                    <x-adminlte-input name="no_hp_wali" label="Nomor Handphone/Telp" placeholder="08123456789" type="number"
                                                      fgroup-class="col-md-6" value="{{ $walisiswa->no_hp_wali }}" readonly/>
                                </div>
                            </x-adminlte-card>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-card theme="lightblue" theme-mode="outline" title="No KKS/PKH">
                                <div class="row">
                                    <x-adminlte-input name="nomor_kks_ayah" label="Nomor KKS" placeholder="124155151" type="number"
                                                      fgroup-class="col-md-6" value="{{ $siswa->nomor_kks }}" readonly/>
                                    <x-adminlte-input name="nomor_pkh_ayah" label="Nomor PKH" placeholder="124155151" type="number"
                                                      fgroup-class="col-md-6" value="{{ $siswa->nomor_pkh }}" readonly/>
                                </div>
                            </x-adminlte-card>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>

</x-app-layout>
