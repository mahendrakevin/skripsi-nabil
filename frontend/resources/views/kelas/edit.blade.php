@section('plugins.Select2', true)
<x-app-layout title="Edit Rombel">
    <x-form method="GET" action="{{ route('admin.kelas.update', $kelas->id) }}">
        <x-adminlte-card theme="info" theme-mode="info" title="Isi Data Rombel">
            <div class="row">
                <x-adminlte-input name="nama_kelas" label="Nama Rombel" placeholder="Sunan Kalijaga"
                                  fgroup-class="col-md-4" value="{{ $kelas->nama_kelas }}" type="text" required/>
            </div>
            <div class="row">
                <x-adminlte-input name="tingkat" label="Tingkat" placeholder="A"
                                  fgroup-class="col-md-4" value="{{ $kelas->tingkat }}" type="text" required/>
            </div>
            <div class="row">
                <x-adminlte-input name="kapasitas_kelas" label="Kapasitas Rombel" placeholder="40"
                                  fgroup-class="col-md-4" value="{{ $kelas->kapasitas_kelas }}" type="number" required/>
            </div>
            <div class="row">
                <x-adminlte-select2 name="id_wali_kelas" fgroup-class="col-md-4" label="Pilih Wali Rombel" required>
                    @foreach($guru as $gr)
                        <option {{old('id_wali_kelas',$kelas->id_wali_kelas)==$gr->id? 'selected':''}} value="{{ $gr->id }}">{{$gr->nama_guru}}</option>
                    @endforeach
                </x-adminlte-select2>
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
