<x-app-layout title="Data Alokasi Dana">
    @if(session('alert'))
        <x-adminlte-alert theme="success" title="Success">
            {{ session('alert') }}
        </x-adminlte-alert>
    @elseif(session('alert-failed'))
        <x-adminlte-alert theme="danger" title="Gagal">
            {{ session('alert-failed') }}
        </x-adminlte-alert>
    @endif
    <x-adminlte-card theme="lime" theme-mode="outline" title="Dana Masuk">
        @if (Auth::user()->role == '1')
            <x-submit-button method="POST" action="{{route('admin.alokasi_dana.create_masuk')}}"
                             theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>
        @elseif(Auth::user()->role == '2')
            <x-submit-button method="POST" action="{{route('bendahara.alokasi_dana.create_masuk')}}"
                             theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>
        @endif
        <x-adminlte-datatable id="dana_masuk" :heads="$heads_masuk" :config="$config_masuk" with-buttons striped hoverable with-footer beautify>
            @foreach($config_masuk['data'] as $row)
                <tr>
                    @foreach($row as $cell)
                        <td> {!!  $cell !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </x-adminlte-card>
    <x-adminlte-card theme="lightblue" theme-mode="outline" title="Dana Keluar">
        @if (Auth::user()->role == '1')
            <x-submit-button method="POST" action="{{route('admin.alokasi_dana.create_keluar')}}"
                             theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>
        @elseif(Auth::user()->role == '2')
            <x-submit-button method="POST" action="{{route('bendahara.alokasi_dana.create_keluar')}}"
                             theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>
        @endif
        <x-adminlte-datatable id="dana_keluar" :heads="$heads_keluar" :config="$config_keluar" with-buttons striped hoverable with-footer beautify>
            @foreach($config_masuk['data'] as $row)
                <tr>
                    @foreach($row as $cell)
                        <td> {!!  $cell !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </x-adminlte-card>
</x-app-layout>
