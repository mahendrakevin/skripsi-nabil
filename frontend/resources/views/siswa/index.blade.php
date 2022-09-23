<x-app-layout title="Data Siswa">
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
		<div class="row">
			<div class="col-md-12">
				<x-submit-button method="POST" action="{{route('admin.siswa.create')}}" theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>
				<x-submit-button method="GET" action="{{route('admin.siswa.naikkelas')}}" theme="info" label="Naik/Luluskan Siswa" icon="fas fa-plus" type="submit"></x-submit-button>
                <x-submit-button method="POST" action="{{route('admin.siswa.cetak')}}" theme="success" label="Export Excel" icon="fas fa-download" type="submit"></x-submit-button>
            </div>
		</div>
		<br>
		@endif
		<x-adminlte-datatable id="datasiswa" :heads="$heads" :config="$config" with-buttons striped hoverable with-footer beautify>
			@foreach($config['data'] as $row)
			<tr>
				@foreach($row as $cell)
				<td> {!! $cell !!}</td>
				@endforeach
			</tr>
			@endforeach
		</x-adminlte-datatable>
	</x-adminlte-card>
</x-app-layout>
