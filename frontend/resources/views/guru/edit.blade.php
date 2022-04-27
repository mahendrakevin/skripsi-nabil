@section('plugins.Select2', true)
<x-app-layout title="Tambah Guru">
    <x-form method="GET" action="{{ route('admin.guru.update', $guru->id) }}">
        <x-adminlte-card theme="lime" theme-mode="outline" title="Isi Data Guru">
            <div class="row">
                <x-adminlte-input name="nip" label="Nomor Induk Pegawai" placeholder="1277471818"
                                  fgroup-class="col-md-4" type="number" value="{{ $guru->nip }}" required/>
                <x-adminlte-input name="nuptk" label="NUPTK" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" value="{{ $guru->nuptk }}"/>
                <x-adminlte-input name="nik" label="No Induk Kependudukan" value="{{ $guru->nik }}" placeholder="1234567890123456"
                                  fgroup-class="col-md-4" type="number" required/>
            </div>
            <div class="row">
                <x-adminlte-input name="nama_guru" label="Nama Guru" placeholder="Annisa"
                                  fgroup-class="col-md-12" value="{{ $guru->nama_guru }}" required/>
            </div>
            <div class="row">
                <x-adminlte-input name="tempat_lahir" label="Tempat Lahir" placeholder="Semarang"
                                  fgroup-class="col-md-6" value="{{ $guru->tempat_lahir }}" required/>
                <x-adminlte-input-date name="tanggal_lahir" :config="$config_date" label="Tanggal Lahir"
                                       placeholder="Choose a time..." value="{{ $guru->tanggal_lahir }}" fgroup-class="col-md-6" required>
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
                    <option {{old('pendidikan',$guru->status_perkawinan)=="Belum Menikah"? 'selected':''}} value="Belum Menikah">Belum Menikah</option>
                    <option {{old('pendidikan',$guru->status_perkawinan)=="Menikah"? 'selected':''}} value="Menikah">Menikah</option>
                    <option {{old('pendidikan',$guru->status_perkawinan)=="Cerai Hidup"? 'selected':''}} value="Cerai Hidup">Cerai Hidup</option>
                    <option {{old('pendidikan',$guru->status_perkawinan)=="Cerai Mati"? 'selected':''}} value="Cerai Mati">Cerai Mati</option>
                </x-adminlte-select2>
                <x-adminlte-select2 name="jenis_kelamin" fgroup-class="col-md-6" label="Jenis Kelamin">
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
                                  fgroup-class="col-md-6" value="{{ $guru->no_hp }}" required/>
                <x-adminlte-input name="email" label="Email" placeholder="Annisa@gmail.com" type="email"
                                  fgroup-class="col-md-6" value="{{ $guru->email }}" required/>
            </div>
            <div class="row">
                <x-adminlte-select2 name="status_pegawai" fgroup-class="col-md-6" label="Status Kepegawaian">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-school"></i>
                        </div>
                    </x-slot>
                    <option {{old('status',$guru->status_pegawai)=="Aktif"? 'selected':''}} value="Aktif">Aktif</option>
                    <option {{old('status',$guru->status_pegawai)=="Tidak Aktif"? 'selected':''}} value="Tidak Aktif">Tidak Aktif</option>
                </x-adminlte-select2>
                <x-adminlte-textarea name="alamat" fgroup-class="col-md-6" label="Alamat" placeholder="Masukkan alamat">
                    {{ $guru->alamat }}
                </x-adminlte-textarea>
            </div>
            <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
            <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
        </x-adminlte-card>
    </x-form>
    <x-adminlte-card theme="lightblue" theme-mode="outline" title="Data Kepegawaian">
        <x-submit-button method="POST" action="{{route('admin.kepegawaian.create')}}"
                         theme="success" label="Tambah Data Kepegawaian" icon="fas fa-plus" type="submit"></x-submit-button>
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
</x-app-layout>
