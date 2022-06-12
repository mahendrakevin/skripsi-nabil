<x-app-layout title="Data Arsip Surat">
    @if(session('alert'))
        <x-adminlte-alert theme="success" title="Sukses">
            {{ session('alert') }}
        </x-adminlte-alert>
    @elseif(session('alert-failed'))
        <x-adminlte-alert theme="danger" title="Gagal">
            {{ session('alert-failed') }}
        </x-adminlte-alert>
    @endif
    <div class="row">
        <x-adminlte-card theme="cyan" theme-mode="outline" title="Arsip Surat Masuk">
            <div class="row">
                @if (Auth::user()->role == '1')
                    <x-submit-button method="POST" action="{{route('admin.arsip_surat.create')}}"
                                     theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>
                @endif
            </div>
            <br>
            <x-adminlte-datatable id="datasiswa" :heads="$heads" :config="$config"  striped hoverable with-footer beautify>
                @foreach($config['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                            <td> {!!  $cell !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </x-adminlte-card>
    </div>
    <div class="row">
        <x-adminlte-card theme="teal" theme-mode="outline" title="Arsip Surat Keluar">
            <x-adminlte-datatable id="datasiswa2" :heads="$heads_keluar" :config="$config_keluar"  striped hoverable with-footer beautify>
                @foreach($config['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                            <td> {!!  $cell !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </x-adminlte-card>
    </div>
</x-app-layout>
