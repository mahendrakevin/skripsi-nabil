@section('plugins.Select2', true)
<x-app-layout title="Lihat Guru">
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
        <x-adminlte-card theme="lightblue" theme-mode="outline" title="Data Kepegawaian">
            <x-adminlte-datatable id="datasiswa" :heads="$heads" :config="$config"  striped hoverable with-footer beautify>
                @foreach($config['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                            <td> {!!  $cell !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </x-adminlte-card>
    </x-form>
</x-app-layout>
