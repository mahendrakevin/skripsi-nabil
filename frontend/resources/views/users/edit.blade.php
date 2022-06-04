@section('plugins.Select2', true)
<x-app-layout title="Edit Pengguna">
    <x-form method="GET" action="{{ route('admin.users.update', $user->id) }}">
        <div class="col-md-6">
            <x-adminlte-card theme="info" theme-mode="info" title="Edit Data Pengguna">
                <div class="row">
                    <x-adminlte-input name="name" value="{{ $user->name }}" label="Nama Lengkap" placeholder="RA ALFALAH WAHYUREJO"
                                      fgroup-class="col-md-12" type="text" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="email" value="{{ $user->email }}" label="Email" placeholder="admin@admin.com"
                                      fgroup-class="col-md-12" type="email" required/>
                </div>
                <div class="row">
                    <x-adminlte-input name="password" label="Password" placeholder="40"
                                      fgroup-class="col-md-12" type="password"/>
                </div>
                <div class="row">
                    <x-adminlte-select2 name="role" fgroup-class="col-md-4" label="Pilih Jenis Pengguna">
                        <option {{ old('role', $user->role)==1?'selected':'' }} value="1">Admin</option>
                        <option {{ old('role', $user->role)==2?'selected':'' }} value="2">Bendahara</option>
                        <option {{ old('role', $user->role)==3?'selected':'' }} value="3">Kepala Sekolah</option>
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
