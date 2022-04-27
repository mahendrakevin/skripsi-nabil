<x-app-layout title="Data Lembaga">
    @if(session('alert'))
        <x-adminlte-alert theme="success" title="Success">
            {{ session('alert') }}
        </x-adminlte-alert>
    @elseif(session('alert-failed'))
        <x-adminlte-alert theme="danger" title="Gagal">
            {{ session('alert-failed') }}
        </x-adminlte-alert>
    @endif
{{--    <x-adminlte-card theme="lime" theme-mode="outline">--}}
{{--        @if (Auth::user()->role == '1')--}}
{{--            <x-submit-button method="POST" action="{{route('admin.lembaga.create')}}"--}}
{{--                         theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>--}}
{{--        @endif--}}
{{--        <x-adminlte-datatable id="datakelas" :heads="$heads" :config="$config"  striped hoverable with-footer beautify>--}}
{{--            @foreach($config['data'] as $row)--}}
{{--                <tr>--}}
{{--                    @foreach($row as $cell)--}}
{{--                        <td> {!!  $cell !!}</td>--}}
{{--                    @endforeach--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--        </x-adminlte-datatable>--}}
{{--    </x-adminlte-card>--}}
        <div class="row">
            <div class="col-md-3">
                <x-adminlte-card theme="lime" theme-mode="outline">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Lembaga</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-solid fa-school"></i> Nama Lembaga</strong>

                        <p class="text-muted">
                            {{ $result->nama_lembaga }}
                        </p>

                        <hr>

                        <strong><i class="fas fa-solid fa-lightbulb"></i> NPSN</strong>

                        <p class="text-muted">{{ $result->npsn }}</p>

                        <hr>

                        <strong><i class="fas fa-solid fa-id-badge"></i> NSM</strong>

                        <p class="text-muted">{{ $result->nsm }}</p>

                        <hr>

                        <strong><i class="fas fa-solid fa-star"></i> Akreditasi {{ $result->akreditasi }}</strong>

{{--                        <p class="text-muted">Akreditasi {{ $result->akreditasi }}</p>--}}

                        <hr>

                        <strong><i class="far fa-light fa-calendar-check"></i> Tanggal Berdiri</strong>

                        <p class="text-muted">{{ $result->created_format }}</p>

                        <hr>

                        <strong><i class="fas fa-light fa-phone"></i></i> No Telp</strong>

                        <p class="text-muted">{{ $result->no_telp }}</p>

                        <hr>

                        <strong><i class="fas fa-solid fa-at"></i> Email</strong>

                        <p class="text-muted">{{ $result->email }}</p>

                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>

                        <p class="text-muted">{{ $result->alamat }}</p>

                        <hr>
                        @if (Auth::user()->role == '1')
                            <x-submit-button method="GET" action="{{route('admin.lembaga.edit', $result->id)}}"
                                             theme="warning" label="Edit Data Lembaga" icon="fas fa-pencil" type="submit"></x-submit-button>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </x-adminlte-card>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#sklembaga" data-toggle="tab"><i class="fas fa-copy"></i>
                                    SK Lembaga</a></li>
                            <li class="nav-item"><a class="nav-link"
                                                    href="#sarpras" data-toggle="tab"><i class="fas fa-solid fa-building"></i> Sarana Prasarana</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane" id="sarpras">
                                @if (Auth::user()->role == '1')
                                    <x-submit-button method="POST" action="{{route('admin.sarpras.create')}}"
                                                     theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>
                                @endif
                                <x-adminlte-datatable id="datakelas" :heads="$heads_sarpras" :config="$config_sarpras"  striped hoverable with-footer beautify>
                                    @foreach($config_sarpras['data'] as $row)
                                        <tr>
                                            @foreach($row as $cell)
                                                <td> {!!  $cell !!}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </x-adminlte-datatable>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="active tab-pane" id="sklembaga">
                                <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                                    <h3 class="text-primary"><i class="fas fa-pager"></i> SK Lembaga {{ $result->nama_lembaga }}</h3>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6 text-muted">
                                            <p class="text-sm">Nomor SK Operasional
                                                <b class="d-block">{{ $sk->nomor_surat_operasional }}</b>
                                            </p>
                                            <p class="text-sm">Tanggal SK Operasional
                                                <b class="d-block">{{ $sk->tanggal_surat_operasional }}</b>
                                            </p>
                                        </div>
                                        <div class="col-md-6 text-muted">
                                            <p class="text-sm">Nomor SK Kemenkumham
                                                <b class="d-block">{{ $sk->nomor_surat_kemenkumham }}</b>
                                            </p>
                                            <p class="text-sm">Tanggal SK Kemenkumham
                                                <b class="d-block">{{ $sk->tanggal_surat_kemenkumham }}</b>
                                            </p>
                                        </div>
                                    </div>
                                    @if (Auth::user()->role == '1')
                                        <x-submit-button method="GET" action="{{route('admin.surat_keterangan.edit', $sk->id)}}"
                                                         theme="warning" label="Edit SK Lembaga" icon="fas fa-pencil" type="submit"></x-submit-button>
                                    @endif

                                </div>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

</x-app-layout>
