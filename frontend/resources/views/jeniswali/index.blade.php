<x-app-layout title="Data Jenis Wali">
    @if(session('alert'))
        <x-adminlte-alert theme="success" title="Success">
            {{ session('alert') }}
        </x-adminlte-alert>
    @elseif(session('alert-failed'))
        <x-adminlte-alert theme="danger" title="Gagal">
            {{ session('alert-failed') }}
        </x-adminlte-alert>
    @endif
    <x-adminlte-card theme="lime" theme-mode="outline">
        <x-submit-button method="POST" action="{{route('admin.jeniswali.create')}}"
                         theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>
        <x-adminlte-datatable id="datajeniswali" :heads="$heads" :config="$config" with-buttons striped hoverable with-footer beautify>
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
