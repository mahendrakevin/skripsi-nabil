@section('plugins.Select2', true)
<x-app-layout title="Tambah Dana Keluar">
    @if (Auth::user()->role == '1')
        <x-form method="POST" enctype="multipart/form-data" action="{{ route('admin.alokasi_dana.store_keluar') }}">
            <x-adminlte-card theme="lime" theme-mode="outline" title="Isi Dana Keluar">
                <div class="row">
                    <x-adminlte-input-date name="tanggal" :config="$config_date" label="Tanggal" placeholder="Choose a time..." fgroup-class="col-md-6" required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-clock"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                    <x-adminlte-select2 name="id_jenispengeluaran" fgroup-class="col-md-6" label="Pilih Jenis Pengeluaran">
                        @foreach($jenispengeluaran as $jp)
                            <option value="{{ $jp->id }}">{{$jp->jenis_pengeluaran}}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
                <div class="row">
                    <x-adminlte-textarea name="detail_pengeluaran" fgroup-class="col-md-6" label="Keterangan" placeholder="Masukkan Keperluan Pengeluaran"/>
                </div>
                <div class="row">
                    <x-adminlte-input name="diserahkan_kepada" label="Diserahkan Kepada" placeholder="Alfalah"
                                      fgroup-class="col-md-8" required/>
                    <x-adminlte-input name="dikeluarkan_oleh" label="Dikeluarkan Oleh" placeholder="Annisa"
                                      fgroup-class="col-md-8" required/>
                </div>
                <div class="row">
                    <x-adminlte-input-file name="bukti_pengeluaran" igroup-size="sm" placeholder="Pilih file..." label="Bukti Pengeluaran" fgroup-class="col-md-4">
                        <x-slot name="prependSlot_lampiran">
                            <div class="input-group-text bg-lightblue">
                                <i class="fas fa-address-card"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-file>
                    <x-adminlte-input name="nominal_pengeluaran" label="Nominal" placeholder="1234567890123456"
                                      fgroup-class="col-md-4" type="number" required/>
                </div>
            </x-adminlte-card>
            <x-adminlte-button class="btn-flat" type="submit" label="Simpan" theme="success" icon="fas fa-lg fa-save"/>

        </x-form>
    @elseif(Auth::user()->role == '2')
        <x-form method="POST" enctype="multipart/form-data" action="{{ route('bendahara.alokasi_dana.store_keluar') }}">
            <x-adminlte-card theme="lime" theme-mode="outline" title="Isi Dana Keluar">
                <div class="row">
                    <x-adminlte-input-date name="tanggal" :config="$config_date" label="Tanggal" placeholder="Choose a time..." fgroup-class="col-md-6" required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-clock"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-date>
                    <x-adminlte-select2 name="id_jenispengeluaran" fgroup-class="col-md-6" label="Pilih Jenis Pengeluaran">
                        @foreach($jenispengeluaran as $jp)
                            <option value="{{ $jp->id }}">{{$jp->jenis_pengeluaran}}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
                <div class="row">
                    <x-adminlte-textarea name="detail_pengeluaran" fgroup-class="col-md-6" label="Keterangan" placeholder="Masukkan Keperluan Pengeluaran"/>
                    <x-adminlte-input name="diserahkan_kepada" label="Diserahkan Kepada" placeholder="Alfalah"
                                      fgroup-class="col-md-6" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="nominal_pengeluaran" label="Nominal" placeholder="1234567890123456"
                                      fgroup-class="col-md-6" type="number" required/>
                    <x-adminlte-input-file name="bukti_pengeluaran" igroup-size="sm" placeholder="Pilih file..." label="Bukti Pengeluaran" fgroup-class="col-md-6">
                        <x-slot name="prependSlot_lampiran">
                            <div class="input-group-text bg-lightblue">
                                <i class="fas fa-address-card"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input-file>
                </div>
                <div class="row">
                    <x-adminlte-input name="dikeluarkan_oleh" label="Dikeluarkan Oleh" placeholder="Annisa"
                                      fgroup-class="col-md-6" required/>
                </div>
            </x-adminlte-card>
            <x-adminlte-modal id="modalCustom" title="Konfirmasi Simpan" size="lg" theme="teal" icon="fas fa-bell" v-centered static-backdrop scrollable>
                <div>Apakah Anda yakin untuk menyimpan data?</div>
                <x-slot name="footerSlot">
                    <x-adminlte-button theme="danger" label="Tidak" data-dismiss="modal" />
                    <x-adminlte-button class="btn-flat" type="submit" label="Ya" theme="success" />
                </x-slot>
            </x-adminlte-modal>
            <div class="row">
                <div class="col-lg-12" style="text-align: right;">
                    <x-adminlte-button label="Simpan" data-toggle="modal" theme="success" data-target="#modalCustom" class="btn-flat" />
                </div>
            </div>

        </x-form>
    @endif
</x-app-layout>
