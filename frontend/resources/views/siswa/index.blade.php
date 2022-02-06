<x-app-layout>
    <x-adminlte-card theme="lime" theme-mode="outline">
        <x-adminlte-datatable id="table1" :heads="$heads">
            @foreach($config['data'] as $row)
                <tr>
                    <td>{{ $row->nisn  }}</td>
                    <td>{{ $row->nama_siswa  }}</td>
                    <td>{{ $row->status_siswa  }}</td>
                    <td>
                        <nobr>
                            <x-button method="GET"
                                      action="{{ route('admin.siswa.show', $row->id) }}"
                                      class="btn btn-xs btn-default text-teal mx-1 shadow"
                                      icon="fa fa-lg fa-fw fa-eye"
                                      title="Lihat"
                            ></x-button>
                            <x-button method="GET"
                                      action="{{ route('admin.siswa.show', $row->id) }}"
                                      class="btn btn-xs btn-default text-warning mx-1 shadow"
                                      icon="fa fa-lg fa-fw fa-pen"
                                      title="Edit"
                            ></x-button>
                            <x-button method="GET"
                                      action="{{ route('admin.siswa.show', $row->id) }}"
                                      class="btn btn-xs btn-default text-danger mx-1 shadow"
                                      icon="fa fa-lg fa-fw fa-trash"
                                      title="Hapus"
                            ></x-button>
                        </nobr>
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </x-adminlte-card>
</x-app-layout>
