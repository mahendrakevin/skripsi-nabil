@section('plugins.Select2', true)
<x-app-layout title="Tambah Pengguna">
    <x-form method="POST" action="{{ route('admin.users.store') }}">
        <div class="col-md-6">
            <x-adminlte-card theme="info" theme-mode="info" title="Isi Data Lembaga">
                <div class="row">
                    <x-adminlte-input name="name" label="Nama Lengkap" placeholder="RA ALFALAH WAHYUREJO"
                                      fgroup-class="col-md-12" type="text" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="email" label="Email" placeholder="admin@admin.com"
                                      fgroup-class="col-md-12" type="email" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="password" label="Password" placeholder="40"
                                      fgroup-class="col-md-12" type="password" required/>
                </div>
                <div class="row">
                    <x-adminlte-select2 name="role" fgroup-class="col-md-4" label="Pilih Jenis Pengguna">
                        <option value="1">Admin</option>
                        <option value="2">Bendahara</option>
                        <option value="3">Kepala Sekolah</option>
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

        </div>
    </x-form>
</x-app-layout>
