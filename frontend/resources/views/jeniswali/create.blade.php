@section('plugins.Select2', true)
<x-app-layout title="Tambah Jenis Wali">
    <x-form method="POST" action="{{ route('admin.jeniswali.store') }}">
        <x-adminlte-card theme="info" theme-mode="info" title="Isi Data Jenis Wali">
            <div class="row">
                <x-adminlte-input name="jenis_wali" label="Nama Jenis Wali" placeholder="Ayah"
                                  fgroup-class="col-md-4" type="text" required/>
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
