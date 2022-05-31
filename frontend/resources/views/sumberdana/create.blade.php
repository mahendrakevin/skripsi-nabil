@section('plugins.Select2', true)
<x-app-layout title="Tambah Sumber Dana">
@if (Auth::user()->role == '1')
    <x-form method="POST" action="{{ route('admin.sumber_dana.store') }}">
        <x-adminlte-card theme="info" theme-mode="info" title="Isi Sumber Dana">
            <div class="row">
                <x-adminlte-input name="nama_dana" label="Sumber Dana" placeholder="Dana BOS"
                                  fgroup-class="col-md-4" type="text" required/>
            </div>
        </x-adminlte-card>

    </x-form>
@elseif(Auth::user()->role == '2')
    <x-form method="POST" action="{{ route('bendahara.sumber_dana.store') }}">
        <x-adminlte-card theme="info" theme-mode="info" title="Isi Sumber Dana">
            <div class="row">
                <x-adminlte-input name="nama_dana" label="Sumber Dana" placeholder="Dana BOS"
                                  fgroup-class="col-md-4" type="text" required/>
            </div>
        </x-adminlte-card>

    </x-form>
@endif
</x-app-layout>
