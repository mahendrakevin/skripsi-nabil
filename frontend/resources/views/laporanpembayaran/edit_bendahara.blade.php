@section('plugins.Select2', true)
<x-app-layout title="Edit Pembayaran">
    <x-form method="GET" action="{{ route('bendahara.laporan_pembayaran.update', $laporan_pembayaran->id)}}">
        <x-adminlte-card theme="lime" theme-mode="outline" title="Isi Data Siswa">
            <div class="row">
                <x-adminlte-select2 name="id_siswa" fgroup-class="col-md-6" label="Pilih Siswa" readonly>
                    @foreach($siswa as $sw)
                        <option {{old('id_siswa',$laporan_pembayaran->id_siswa)==$sw->id? 'selected':''}} value="{{ $sw->id }}">{{$sw->nis."-".$sw->nama_siswa}}</option>
                    @endforeach
                </x-adminlte-select2>
                <x-adminlte-select2 name="id_jenispembayaran" fgroup-class="col-md-6" label="Pilih Jenis Pembayaran">
                    @foreach($jenis_pembayaran as $jp)
                        <option value="{{ $jp->id }}">{{$jp->jenis_pembayaran.'-'.$jp->nominal_pembayaran}}</option>
                        <option {{old('id_jenispembayaran',$laporan_pembayaran->id_jenispembayaran)==$jp->id? 'selected':''}}
                                value="{{ $jp->id }}">{{$jp->jenis_pembayaran.'-'.$jp->nominal_pembayaran}}</option>
                    @endforeach
                </x-adminlte-select2>
            </div>
            <div class="row">
                <x-adminlte-input name="nominal_pembayaran" label="Nominal Pembayaran" type="number"
                                  placeholder="120000" value="{{ $laporan_pembayaran->nominal_pembayaran }}"
                                  fgroup-class="col-md-6" required/>
                <x-adminlte-input-date name="tanggal_pembayaran" value="{{ $laporan_pembayaran->tanggal_pembayaran }}"
                                       :config="$config_date" label="Tanggal Pembayaran" placeholder="Choose a time..." fgroup-class="col-md-6" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-clock"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
            </div>
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

    </x-form>
</x-app-layout>
