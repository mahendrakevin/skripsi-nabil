@section('plugins.Select2', true)
<x-app-layout title="Edit Sumber Dana">
    @if (Auth::user()->role == '1')
        <x-form method="GET" action="{{ route('admin.sumber_dana.update', $sumberdana->id) }}">
            <x-adminlte-card theme="info" theme-mode="info" title="Edit Sumber Dana">
                <div class="row">
                    <x-adminlte-input name="nama_dana" label="Sumber Dana" value="{{ $sumberdana->nama_dana }}" placeholder="Dana BOS"
                                      fgroup-class="col-md-4" type="text" required/>
                </div>
            </x-adminlte-card>
            <x-adminlte-button class="btn-flat" type="submit" label="Simpan" theme="success" icon="fas fa-lg fa-save"/>

        </x-form>
    @elseif(Auth::user()->role == '2')
            <x-form method="GET" action="{{ route('bendahara.sumber_dana.update', $sumberdana->id) }}">
                <x-adminlte-card theme="info" theme-mode="info" title="Edit Sumber Dana">
                    <div class="row">
                        <x-adminlte-input name="nama_dana" label="Sumber Dana" value="{{ $sumberdana->nama_dana }}" placeholder="Dana BOS"
                                          fgroup-class="col-md-4" type="text" required/>
                    </div>
                </x-adminlte-card>
                <x-adminlte-button class="btn-flat" type="submit" label="Simpan" theme="success" icon="fas fa-lg fa-save"/>

            </x-form>
    @endif

</x-app-layout>
