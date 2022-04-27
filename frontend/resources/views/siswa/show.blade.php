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
                        <x-adminlte-input name="nisn" label="Nomor Induk Siswa Nasional" placeholder="1277471818"
                                          fgroup-class="col-md-3" type="number" value="{{ $siswa->nisn }}" readonly/>
                        <x-adminlte-input name="nis" label="Nomor Induk Siswa" placeholder="1277471818"
                                          fgroup-class="col-md-3" type="number" value="{{ $siswa->nis }}" readonly/>
                        <x-adminlte-input name="nik" label="NIK" placeholder="1234567890123456"
                                          fgroup-class="col-md-3" type="number" value="{{ $siswa->nik }}" readonly/>
                        <x-adminlte-input name="nomor_kk" label="No Kartu Keluarga" placeholder="1234567890123456"
                                          fgroup-class="col-md-3" type="number" value="{{ $siswa->nomor_kk }}" readonly/>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="nama_siswa" label="Nama Siswa" placeholder="Alfalah"
                                          fgroup-class="col-md-8" value="{{ $siswa->nama_siswa }}"  readonly/>
                        <x-adminlte-input name="nomor_kip" label="No KIP" placeholder="1234567890123456"
                                          fgroup-class="col-md-4" type="number" value="{{ $siswa->nomor_kip }}"  readonly/>
                    </div>
                    <div class="row">
                        <x-adminlte-input name="tempat_lahir" label="Tempat Lahir" placeholder="Semarang"
                                          fgroup-class="col-md-6" value="{{ $siswa->tempat_lahir }}"  readonly/>
                        <x-adminlte-input-date name="tanggal_lahir" :config="$config_date" label="Tanggal Lahir"
                                               placeholder="Choose a time..." fgroup-class="col-md-6" value="{{ $siswa->tanggal_lahir }}"  disabled>
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
                        <x-adminlte-select2 name="id_jeniswali" fgroup-class="col-md-6" label="Pilih Jenis Wali" disabled>
                            @foreach($jeniswali as $jw)
                                <option {{old('id_jeniswali',$siswa->id_jeniswali)==$jw->id? 'selected':''}} value="{{ $jw->id }}">{{$jw->jenis_wali}}</option>
                            @endforeach
                        </x-adminlte-select2>
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
                            <x-adminlte-datatable id="datasiswa" :heads="$heads" :config="$config"  striped hoverable with-footer beautify>
                                @foreach($config['data'] as $row)
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
                                    <x-adminlte-input name="nama_ayah" label="Nama Wali" placeholder="Alfa"
                                                      fgroup-class="col-md-8" value="{{ $walisiswa->nama_ayah }}"  readonly/>
                                    <x-adminlte-input-file name="file_kk_ayah" igroup-size="sm" placeholder="Pilih file..." label="File Kartu Keluarga"
                                                           value="{{ $walisiswa->file_kk }}" fgroup-class="col-md-4" disabled>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-lightblue">
                                                <i class="fas fa-address-card"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-file>
                                </div>
                                <div class="row">
                                    <x-adminlte-input name="tempat_lahir_ayah" label="Tempat Lahir" placeholder="Semarang"
                                                      fgroup-class="col-md-6" value="{{ $walisiswa->tempat_lahir_ayah }}"  readonly/>
                                    <x-adminlte-input-date name="tanggal_lahir_ayah" :config="$config_date" label="Tanggal Lahir"
                                                           placeholder="Choose a time..." fgroup-class="col-md-6" value="{{ $walisiswa->tanggal_lahir_ayah }}" disabled>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-date>
                                </div>
                                <div class="row">
                                    <x-adminlte-select2 name="status_keluarga_ayah" fgroup-class="col-md-6" label="Status Ayah" disabled>
                                        <x-slot name="prependSlot_ibu">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-school"></i>
                                            </div>
                                        </x-slot>
                                        <option {{old('pendidikan',$walisiswa->status_keluarga_ayah)=="Kandung"? 'selected':''}} value="Kandung">Kandung</option>
                                        <option {{old('pendidikan',$walisiswa->status_keluarga_ayah)=="Tiri"? 'selected':''}} value="Tiri">Tiri</option>
                                    </x-adminlte-select2>
                                    <x-adminlte-select2 name="status_hidup_ayah" fgroup-class="col-md-6" label="Status Hidup Ayah" disabled>
                                        <x-slot name="prependSlot_ibu">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-school"></i>
                                            </div>
                                        </x-slot>
                                        <option {{old('pendidikan',$walisiswa->status_hidup_ayah)=="Hidup"? 'selected':''}} value="Hidup">Hidup</option>
                                        <option {{old('pendidikan',$walisiswa->status_hidup_ayah)=="Mati"? 'selected':''}} value="Mati">Mati</option>
                                    </x-adminlte-select2>
                                </div>
                                <div class="row">
                                    <x-adminlte-select2 name="pendidikan_ayah" fgroup-class="col-md-6" label="Pendidikan Terakhir" disabled>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-school"></i>
                                            </div>
                                        </x-slot>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_ayah)=="SD"? 'selected':''}} value="SD">SD</option>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_ayah)=="SMP"? 'selected':''}} value="SMP">SMP</option>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_ayah)=="SMA"? 'selected':''}} value="SMA">SMA</option>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_ayah)=="Sarjana"? 'selected':''}} value="Sarjana">Sarjana</option>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_ayah)=="Master"? 'selected':''}} value="Master">Master</option>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_ayah)=="Doktor"? 'selected':''}} value="Doktor">Doktor</option>
                                    </x-adminlte-select2>
                                    <x-adminlte-input name="pekerjaan_ayah" label="Pekerjaan" placeholder="PNS"
                                                      fgroup-class="col-md-6" value="{{ $walisiswa->pekerjaan_ayah }}" readonly/>
                                </div>
                                <div class="row">
                                    <x-adminlte-input name="penghasilan_ayah" label="Penghasilan Perbulan" placeholder="124155151" type="number"
                                                      fgroup-class="col-md-4" value="{{ $walisiswa->penghasilan_ayah }}" readonly/>
                                    <x-adminlte-input name="nomor_kks_ayah" label="Nomor KKS" placeholder="124155151" type="number"
                                                      fgroup-class="col-md-4" value="{{ $walisiswa->nomor_kks_ayah }}" readonly/>
                                    <x-adminlte-input name="nomor_pkh_ayah" label="Nomor PKH" placeholder="124155151" type="number"
                                                      fgroup-class="col-md-4" value="{{ $walisiswa->nomor_pkh_ayah }}" readonly/>
                                </div>
                                <div class="row">
                                    <x-adminlte-input name="no_hp_ayah" label="Nomor Handphone/Telp" placeholder="08123456789" type="number"
                                                      fgroup-class="col-md-6" value="{{ $walisiswa->no_hp_ayah }}"  readonly/>
                                    <x-adminlte-textarea name="alamat_ayah" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat" readonly>
                                        {{ $walisiswa->alamat_ayah }}
                                    </x-adminlte-textarea>
                                </div>
                            </x-adminlte-card>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-card theme="lightblue" theme-mode="outline" title="Biodata Diri Ibu">
                                <div class="row">
                                    <x-adminlte-input name="nama_ibu" label="Nama Wali" placeholder="Alfa"
                                                      fgroup-class="col-md-8" value="{{ $walisiswa->nama_ibu }}" readonly/>
                                </div>
                                <div class="row">
                                    <x-adminlte-input name="tempat_lahir_ibu" label="Tempat Lahir" placeholder="Semarang"
                                                      fgroup-class="col-md-6" value="{{ $walisiswa->tempat_lahir_ibu }}" readonly/>
                                    <x-adminlte-input-date name="tanggal_lahir_ibu" :config="$config_date" label="Tanggal Lahir"
                                                           placeholder="Choose a time..." fgroup-class="col-md-6" value="{{ $walisiswa->tanggal_lahir_ibu }}" disabled>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-date>
                                </div>
                                <div class="row">
                                    <x-adminlte-select2 name="status_keluarga_ibu" fgroup-class="col-md-6" label="Status Ibu" disabled>
                                        <x-slot name="prependSlot_ibu">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-school"></i>
                                            </div>
                                        </x-slot>
                                        <option {{old('pendidikan',$walisiswa->status_keluarga_ibu)=="Kandung"? 'selected':''}} value="Kandung">Kandung</option>
                                        <option {{old('pendidikan',$walisiswa->status_keluarga_ibu)=="Tiri"? 'selected':''}} value="Tiri">Tiri</option>
                                    </x-adminlte-select2>
                                    <x-adminlte-select2 name="status_hidup_ibu" fgroup-class="col-md-6" label="Status Hidup Ibu" disabled>
                                        <x-slot name="prependSlot_ibu">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-school"></i>
                                            </div>
                                        </x-slot>
                                        <option {{old('pendidikan',$walisiswa->status_hidup_ibu)=="Hidup"? 'selected':''}} value="Hidup">Hidup</option>
                                        <option {{old('pendidikan',$walisiswa->status_hidup_ibu)=="Mati"? 'selected':''}} value="Mati">Mati</option>
                                    </x-adminlte-select2>
                                </div>
                                <div class="row">
                                    <x-adminlte-select2 name="pendidikan_ibu" fgroup-class="col-md-6" label="Pendidikan Terakhir" disabled>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-school"></i>
                                            </div>
                                        </x-slot>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="SD"? 'selected':''}} value="SD">SD</option>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="SMP"? 'selected':''}} value="SMP">SMP</option>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="SMA"? 'selected':''}} value="SMA">SMA</option>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="Sarjana"? 'selected':''}} value="Sarjana">Sarjana</option>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="Master"? 'selected':''}} value="Master">Master</option>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_ibu)=="Doktor"? 'selected':''}} value="Doktor">Doktor</option>
                                    </x-adminlte-select2>
                                    <x-adminlte-input name="pekerjaan_ibu" label="Pekerjaan" placeholder="PNS"
                                                      fgroup-class="col-md-6" value="{{ $walisiswa->pekerjaan_ibu }}" readonly/>
                                </div>
                                <div class="row">
                                    <x-adminlte-input name="penghasilan_ibu" label="Penghasilan Perbulan" placeholder="124155151" type="number"
                                                      fgroup-class="col-md-4" value="{{ $walisiswa->penghasilan_ibu }}" readonly/>
                                    <x-adminlte-input name="nomor_kks_ibu" label="Nomor KKS" placeholder="124155151" type="number"
                                                      fgroup-class="col-md-4" value="{{ $walisiswa->nomor_kks_ibu }}" readonly/>
                                    <x-adminlte-input name="nomor_pkh_ibu" label="Nomor PKH" placeholder="124155151" type="number"
                                                      fgroup-class="col-md-4" value="{{ $walisiswa->nomor_pkh_ibu }}" readonly/>
                                </div>
                                <div class="row">
                                    <x-adminlte-input name="no_hp_ibu" label="Nomor Handphone/Telp" placeholder="08123456789" type="number"
                                                      fgroup-class="col-md-6" value="{{ $walisiswa->no_hp_ibu }}" readonly/>
                                    <x-adminlte-textarea name="alamat_ibu" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat" readonly>
                                        {{ $walisiswa->alamat_ibu }}
                                    </x-adminlte-textarea>
                                </div>
                            </x-adminlte-card>
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-card theme="lightblue" theme-mode="outline" title="Biodata Diri Wali">
                                <div class="row">
                                    <x-adminlte-input name="nama_wali" label="Nama Wali" placeholder="Alfa"
                                                      fgroup-class="col-md-8" value="{{ $walisiswa->nama_wali }}" readonly/>
                                </div>
                                <div class="row">
                                    <x-adminlte-input name="tempat_lahir_wali" label="Tempat Lahir" placeholder="Semarang"
                                                      fgroup-class="col-md-6" value="{{ $walisiswa->tempat_lahir_wali }}" readonly/>
                                    <x-adminlte-input-date name="tanggal_lahir_wali" :config="$config_date" label="Tanggal Lahir"
                                                           placeholder="Choose a time..." fgroup-class="col-md-6" value="{{ $walisiswa->tanggal_lahir_wali }}" disabled>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-date>
                                </div>
                                <div class="row">
                                    <x-adminlte-select2 name="pendidikan_wali" fgroup-class="col-md-6" label="Pendidikan Terakhir" disabled>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-school"></i>
                                            </div>
                                        </x-slot>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_wali)=="SD"? 'selected':''}} value="SD">SD</option>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_wali)=="SMP"? 'selected':''}} value="SMP">SMP</option>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_wali)=="SMA"? 'selected':''}} value="SMA">SMA</option>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_wali)=="Sarjana"? 'selected':''}} value="Sarjana">Sarjana</option>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_wali)=="Master"? 'selected':''}} value="Master">Master</option>
                                        <option {{old('pendidikan',$walisiswa->pendidikan_wali)=="Doktor"? 'selected':''}} value="Doktor">Doktor</option>
                                    </x-adminlte-select2>
                                    <x-adminlte-input name="pekerjaan_wali" label="Pekerjaan" placeholder="PNS"
                                                      fgroup-class="col-md-6" value="{{ $walisiswa->pekerjaan_wali }}" readonly/>
                                </div>
                                <div class="row">
                                    <x-adminlte-input name="penghasilan_wali" label="Penghasilan Perbulan" placeholder="124155151" type="number"
                                                      fgroup-class="col-md-4" value="{{ $walisiswa->penghasilan_wali }}" readonly/>
                                    <x-adminlte-input name="nomor_kks_wali" label="Nomor KKS" placeholder="124155151" type="number"
                                                      fgroup-class="col-md-4" value="{{ $walisiswa->nomor_kks_wali }}" readonly/>
                                    <x-adminlte-input name="nomor_pkh_wali" label="Nomor PKH" placeholder="124155151" type="number"
                                                      fgroup-class="col-md-4" value="{{ $walisiswa->nomor_pkh_wali }}" readonly/>
                                </div>
                                <div class="row">
                                    <x-adminlte-input name="no_hp_wali" label="Nomor Handphone/Telp" placeholder="08123456789" type="number"
                                                      fgroup-class="col-md-6" value="{{ $walisiswa->no_hp_wali }}" readonly/>
                                    <x-adminlte-textarea name="alamat_wali" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat" readonly>
                                        {{ $walisiswa->alamat_wali }}
                                    </x-adminlte-textarea>
                                </div>
                            </x-adminlte-card>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>

</x-app-layout>
