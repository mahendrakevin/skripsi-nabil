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
            <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
            <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
        </div>
    </x-form>
</x-app-layout>
