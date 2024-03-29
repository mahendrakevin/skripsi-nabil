<x-app-layout title="Data Jenis Pengeluaran">
    @if(session('alert'))
        <x-adminlte-alert theme="success" title="Sukses">
            {{ session('alert') }}
        </x-adminlte-alert>
    @elseif(session('alert-failed'))
        <x-adminlte-alert theme="danger" title="Gagal">
            {{ session('alert-failed') }}
        </x-adminlte-alert>
    @endif
    <x-adminlte-card theme="lime" theme-mode="outline">
        @if (Auth::user()->role == '1')
            <x-submit-button method="POST" action="{{route('admin.jenis_pengeluaran.create')}}"
                             theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>
        @elseif(Auth::user()->role == '2')
            <x-submit-button method="POST" action="{{route('bendahara.jenis_pengeluaran.create')}}"
                             theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>
        @endif
        <x-adminlte-datatable id="datakelas" :heads="$heads" :config="$config"  striped hoverable with-footer beautify>
            @foreach($config['data'] as $row)
                <tr>
                    @foreach($row as $cell)
                        <td> {!!  $cell !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </x-adminlte-card>
</x-app-layout>
