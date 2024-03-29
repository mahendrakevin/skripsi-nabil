@section('plugins.Select2', true)
<x-app-layout title="Detail Dana Keluar">
    @if (Auth::user()->role == '1')
        <x-form method="GET" enctype="multipart/form-data" action="{{ route('admin.alokasi_dana.update_keluar', $danakeluar->id) }}">
            <x-adminlte-card theme="lime" theme-mode="outline" title="Isi Dana Keluar">
                <div class="row">
                    <x-adminlte-input-date name="tanggal" :config="$config_date" label="Tanggal"
                                           value="{{ $danakeluar->tanggal }}" placeholder="Choose a time..." fgroup-class="col-md-6" required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-clock"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                    <x-adminlte-select2 name="id_jenispengeluaran" fgroup-class="col-md-6" label="Pilih Jenis Pengeluaran">
                        @foreach($jenispengeluaran as $jp)
                            <option {{old('id_sumberdana',$danakeluar->id_jenispengeluaran)==$jp->id? 'selected':''}} value="{{ $jp->id }}">{{$jp->jenis_pengeluaran}}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
                <div class="row">
                    <x-adminlte-textarea name="detail_pengeluaran" fgroup-class="col-md-6" label="Keterangan" placeholder="Masukkan Keperluan Pengeluaran">
                        {{ $danakeluar->detail_pengeluaran }}
                    </x-adminlte-textarea>
                </div>
                <div class="row">
                    <x-adminlte-input name="diserahkan_kepada" value="{{ $danakeluar->diserahkan_kepada }}" label="Diserahkan Kepada" placeholder="Alfalah"
                                      fgroup-class="col-md-6" required/>
                    <x-adminlte-input name="dikeluarkan_oleh" value="{{ $danakeluar->dikeluarkan_oleh }}" label="Dikeluarkan Oleh" placeholder="Annisa"
                                      fgroup-class="col-md-6" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="nominal_pengeluaran" value="{{ $danakeluar->nominal_pengeluaran }}" label="Nominal" placeholder="1234567890123456"
                                      fgroup-class="col-md-12" type="number" required/>
                </div>
            </x-adminlte-card>
            <x-adminlte-button class="btn-flat" type="submit" label="Simpan" theme="success" icon="fas fa-lg fa-save"/>

        </x-form>
    @elseif(Auth::user()->role == '2' || Auth::user()->role == '3')
        <x-form method="GET" enctype="multipart/form-data" action="{{ route('bendahara.alokasi_dana.update_keluar', $danakeluar->id) }}">
            <x-adminlte-card theme="lime" theme-mode="outline" title="Detail Dana Keluar">
                <div class="row">
                    <x-adminlte-input-date name="tanggal" :config="$config_date" label="Tanggal"
                                           value="{{ $danakeluar->tanggal }}" placeholder="Choose a time..." fgroup-class="col-md-6" disabled>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-clock"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                    <x-adminlte-select2 name="id_jenispengeluaran" fgroup-class="col-md-6" label="Pilih Jenis Pengeluaran" disabled>
                        @foreach($jenispengeluaran as $jp)
                            <option {{old('id_sumberdana',$danakeluar->id_jenispengeluaran)==$jp->id? 'selected':''}} value="{{ $jp->id }}">{{$jp->jenis_pengeluaran}}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
                <div class="row">
                    <x-adminlte-textarea name="detail_pengeluaran" fgroup-class="col-md-6" label="Keterangan" placeholder="Masukkan Keperluan Pengeluaran" disabled>
                        {{ $danakeluar->detail_pengeluaran }}
                    </x-adminlte-textarea>
                    <x-adminlte-input name="nominal_pengeluaran" value="{{ $danakeluar->nominal_pengeluaran }}" label="Nominal" placeholder="1234567890123456"
                                      fgroup-class="col-md-6" type="number" disabled/>
                </div>
                <div class="row">
                    <x-adminlte-input name="dikeluarkan_oleh" value="{{ $danakeluar->dikeluarkan_oleh }}" label="Dikeluarkan Oleh" placeholder="Annisa"
                                      fgroup-class="col-md-6" disabled/>
                    <x-adminlte-input name="diserahkan_kepada" value="{{ $danakeluar->diserahkan_kepada }}" label="Diserahkan Kepada" placeholder="Alfalah"
                                      fgroup-class="col-md-6" disabled/>
                </div>
            </x-adminlte-card>

        </x-form>
    @endif
</x-app-layout>
