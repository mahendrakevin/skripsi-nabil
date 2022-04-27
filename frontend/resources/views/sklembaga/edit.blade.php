@section('plugins.Select2', true)
<x-app-layout title="Edit Sarpras">
    <x-form method="GET" action="{{ route('admin.surat_keterangan.update', $sklembaga->id) }}">
        <div class="col-md-6">
            <x-adminlte-card theme="info" theme-mode="info" title="Isi Data SK Lembaga">
                <div class="row">
                    <x-adminlte-input name="nomor_surat_operasional" label="Nomor SK Operasional" placeholder="F/240/JK/2022"
                                      fgroup-class="col-md-12" value="{{ $sklembaga->nomor_surat_operasional }}" type="text"/>
                </div>
                <x-adminlte-input-date name="tanggal_surat_operasional"  value="{{ $sklembaga->tanggal_surat_operasional }}"
                                       :config="$config_date" label="Tanggal SK Operasional"
                                       placeholder="Choose a time..." fgroup-class="col-md-12">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-clock"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
                <div class="row">
                    <x-adminlte-input name="nomor_surat_kemenkumham"  value="{{ $sklembaga->nomor_surat_kemenkumham }}"
                                      label="Nomor SK Kemenkumham" placeholder="F/240/JK/2022"
                                      fgroup-class="col-md-12" type="text"/>
                </div>
                <x-adminlte-input-date name="tanggal_surat_kemenkumham"  value="{{ $sklembaga->tanggal_surat_kemenkumham }}" :config="$config_date" label="Tanggal SK Kemenkumham"
                                       placeholder="Choose a time..." fgroup-class="col-md-12">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-clock"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
            </x-adminlte-card>
        </div>
        <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
        <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
        </div>
    </x-form>
</x-app-layout>
