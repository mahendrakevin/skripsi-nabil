@section('plugins.Select2', true)
<x-app-layout title="Edit Jenis Pengeluaran">
    @if (Auth::user()->role == '1')
        <x-form method="GET" action="{{ route('admin.jenis_pengeluaran.update', $jenispengeluaran->id) }}">
            <x-adminlte-card theme="info" theme-mode="info" title="Edit Jenis Pengeluaran">
                <div class="row">
                    <x-adminlte-input name="jenis_pengeluaran" label="Jenis Pengeluaran" value="{{ $jenispengeluaran->jenis_pengeluaran }}" placeholder="Alat Tulis"
                                      fgroup-class="col-md-4" type="text" required/>
                </div>
            </x-adminlte-card>
            <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
            <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
        </x-form>
    @elseif(Auth::user()->role == '2')
        <x-form method="GET" action="{{ route('bendahara.jenis_pengeluaran.update', $jenispengeluaran->id) }}">
            <x-adminlte-card theme="info" theme-mode="info" title="Edit Jenis Pengeluaran">
                <div class="row">
                    <x-adminlte-input name="jenis_pengeluaran" label="Jenis Pengeluaran" value="{{ $jenispengeluaran->jenis_pengeluaran }}" placeholder="Alat Tulis"
                                      fgroup-class="col-md-4" type="text" required/>
                </div>
            </x-adminlte-card>
            <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
            <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="danger" icon="fas fa-lg fa-trash"/>
        </x-form>
    @endif

</x-app-layout>
