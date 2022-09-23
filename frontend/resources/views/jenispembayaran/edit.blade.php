@section('plugins.Select2', true)
<x-app-layout title="Edit Jenis Pembayaran">
    <x-form method="GET" action="{{ route('admin.jenispembayaran.update', $jenispembayaran->id) }}">
        <x-adminlte-card theme="info" theme-mode="info" title="Isi Data Jenis Pembayaran">
            <div class="row">
                <x-adminlte-input name="jenis_pembayaran" label="Jenis Pembayaran" placeholder="Kelas A"
                                  fgroup-class="col-md-4" value="{{ $jenispembayaran->jenis_pembayaran }}" type="text" required/>
            </div>
            <div class="row">
                <x-adminlte-input name="nominal_pembayaran" label="Nominal Pembayaran" placeholder="40"
                                  fgroup-class="col-md-4" value="{{ $jenispembayaran->nominal_pembayaran }}" type="number" required/>
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
