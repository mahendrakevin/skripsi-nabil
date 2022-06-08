<x-app-layout title="Daftar Siswa Rombel {{ $kelas->nama_kelas.' '.$kelas->tingkat }}">
    @if(session('alert'))
    <x-adminlte-alert theme="success" title="Success">
        {{ session('alert') }}
    </x-adminlte-alert>
    @elseif(session('alert-failed'))
    <x-adminlte-alert theme="danger" title="Gagal">
        {{ session('alert-failed') }}
    </x-adminlte-alert>
    @endif
    <x-adminlte-card theme="lime" theme-mode="outline">
        @if($datasiswa != null)
            <x-form method="POST" action="{{ route('admin.siswa.naik') }}">
                <x-adminlte-modal id="naikkelas" title="Naik Rombel" size="lg" theme="teal"
                                  icon="fas fa-bell" v-centered static-backdrop scrollable>
                            <div class="row">
                                <x-adminlte-select2 name="id_kelas" fgroup-class="col-md-3" label="Kelas">
                                    @foreach($list_kelas as $kls)
                                        @if($kls->tingkat != 'A')
                                            <option value="{{ $kls->id }}">{{$kls->nama_kelas.' '.$kls->tingkat}}</option>
                                        @endif
                                    @endforeach
                                </x-adminlte-select2>
                                <x-adminlte-select2 id="selUser" name="daftar_siswa[]" label="Pilih Siswa" fgroup-class="col-md-6" label-class="text-danger" multiple>
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text bg-gradient-red">
                                            <i class="fas fa-lg fa-user"></i>
                                        </div>
                                    </x-slot>
                                    @foreach($datasiswa as $ds)
                                        <option value="{{ $ds->id }}">{{ $ds->nis.'-'.$ds->nama_siswa }}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                        <x-slot name="footerSlot">
                            <x-adminlte-button theme="danger" label="Batal" data-dismiss="modal"/>
                            <x-adminlte-button label="Naikkan Siswa" data-toggle="modal" theme="info" data-target="#naik" class="btn-flat"/>
                        </x-slot>
                </x-adminlte-modal>
                <x-adminlte-modal id="naik" title="Naik Siswa" size="lg" theme="cyan"
                                  icon="fas fa-bell" v-centered static-backdrop scrollable>
                    <div>Apakah Anda yakin untuk menyimpan data?</div>
                    <x-slot name="footerSlot">
                        <x-adminlte-button theme="danger" label="Tidak" data-dismiss="modal"/>
                        <x-adminlte-button class="btn-flat" type="submit" label="Ya" theme="success"/>
                    </x-slot>
                </x-adminlte-modal>
            </x-form>

            <x-form method="POST" action="{{ route('admin.siswa.lulus') }}">
                <x-adminlte-modal id="lulus" title="Luluskan Siswa" size="lg" theme="teal"
                                  icon="fas fa-bell" v-centered static-backdrop scrollable>
                    <div class="row">
                        <x-adminlte-select2 id="selUser2" name="daftar_siswa[]" label="Pilih Siswa" fgroup-class="col-md-12" label-class="text-danger" multiple>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-red">
                                    <i class="fas fa-lg fa-user"></i>
                                </div>
                            </x-slot>
                            @foreach($datasiswa as $ds)
                                <option value="{{ $ds->id }}">{{ $ds->nis.'-'.$ds->nama_siswa }}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <x-slot name="footerSlot">
                        <x-adminlte-button theme="danger" label="Batal" data-dismiss="modal"/>
                        <x-adminlte-button label="Luluskan Siswa" data-toggle="modal" theme="info" data-target="#lulussiswa" class="btn-flat"/>
                    </x-slot>
                </x-adminlte-modal>
                <x-adminlte-modal id="lulussiswa" title="Luluskan Siswa" size="lg" theme="cyan"
                                  icon="fas fa-bell" v-centered static-backdrop scrollable>
                    <div>Apakah Anda yakin untuk menyimpan data?</div>
                    <x-slot name="footerSlot">
                        <x-adminlte-button theme="danger" label="Tidak" data-dismiss="modal"/>
                        <x-adminlte-button class="btn-flat" type="submit" label="Ya" theme="success"/>
                    </x-slot>
                </x-adminlte-modal>
            </x-form>
            <div class="row">
                <div class="col-md-12">
                    @if($kelas->tingkat != 'B')
                        <x-adminlte-button label="Naikkan Rombel Siswa" data-toggle="modal" theme="info" data-target="#naikkelas" class="btn-flat"/>
                    @endif
                    <x-adminlte-button label="Luluskan Siswa" data-toggle="modal" theme="success" data-target="#lulus" class="btn-flat"/>
                </div>
            </div>
            <br>
        @endif
        <x-adminlte-datatable id="datasiswa" :heads="$heads" :config="$config" with-buttons striped hoverable with-footer beautify>
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
