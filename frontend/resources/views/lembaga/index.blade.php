<x-app-layout title="Data Lembaga">
    @if(session('alert'))
        <x-adminlte-alert theme="success" title="Sukses">
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#sklembaga" data-toggle="tab"><i class="fas fa-copy"></i>
                                    Informasi Sekolah</a></li>
                            <li class="nav-item"><a class="nav-link"
                                                    href="#sarpras" data-toggle="tab"><i class="fas fa-solid fa-building"></i> Sarana Prasarana</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane" id="sarpras">
                                    <x-form method="GET" action="{{ route('admin.sarpras.update', $sarpras->id) }}">
                                        <div class="col-md-6">
                                            <x-adminlte-card theme="info" theme-mode="info" title="Informasi Lahan dan Bangunan">
                                                <div class="row">
                                                    <x-adminlte-input name="nama_lahan" label="Nama Lahan" placeholder="Gedung"
                                                                      fgroup-class="col-md-4" value="{{ $sarpras->nama_lahan }}" type="text" required/>
                                                    <x-adminlte-input name="luas_bangunan" label="Luas Bangunan (meter persegi)" placeholder="120"
                                                                      fgroup-class="col-md-4" type="number" value="{{ $sarpras->luas_lahan }}" required/>
                                                    <x-adminlte-input name="luas_lahan" label="Luas Lahan (meter persegi)" placeholder="200"
                                                                      fgroup-class="col-md-4" type="number" value="{{ $sarpras->luas_bangunan }}" required/>
                                                </div>
                                                <div class="row">
                                                    <x-adminlte-input name="jumlah_lantai" label="Jumlah Lantai" placeholder="2"
                                                                      fgroup-class="col-md-6" type="number" value="{{ $sarpras->jumlah_lantai }}" required/>
                                                    <x-adminlte-input name="tahun" label="Tahun" placeholder="2017"
                                                                      fgroup-class="col-md-6" type="text" value="{{ $sarpras->tahun }}" required/>
                                                </div>
                                                <div class="row">
                                                    <x-adminlte-textarea name="alamat" fgroup-class="col-md-12" label="Alamat" placeholder="Masukkan alamat">
                                                        {{ $sarpras->alamat }}
                                                    </x-adminlte-textarea>
                                                </div>
                                                @if (Auth::user()->role == '1')
                                                    <div class="row">
                                                        <x-adminlte-button class="btn-flat" type="submit" label="Simpan" theme="success" icon="fas fa-lg fa-save"/>
                                                    </div>
                                                @endif
                                            </x-adminlte-card>
                                        </div>
                                    </x-form>
                                <hr>
                                    <div class="row">
                                        @if (Auth::user()->role == '1')
                                            <x-submit-button method="POST" action=""
                                                             theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>
                                        @endif
                                    </div>
                                <br>
                                    <div class="row">
                                        <x-adminlte-datatable id="datakelas" :heads="$heads" :config="$config"  striped hoverable with-footer beautify>
                                            @foreach($config['data'] as $row)
                                                <tr>
                                                    @foreach($row as $cell)
                                                        <td> {!!  $cell !!}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </x-adminlte-datatable>
                                    </div>
                                </div>
                                <br>

                            <!-- /.tab-pane -->
                            <div class="active tab-pane" id="sklembaga">
                                <div class="col-12 col-md-12 col-lg-12 order-1 order-md-2">
{{--                                    <h3 class="text-primary"><i class="fas fa-pager"></i> SK Lembaga {{ $result->nama_lembaga }}</h3>--}}
                                    <br>
                                    <div class="row">
                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-4">
                                            <img src="{{URL::asset('vendor/adminlte/dist/img/logo.png')}}" width="200">
                                        </div>
                                        <div class="col-md-4">
                                            <p class="text-lg"><i class="fas fa-solid fa-school"></i> Nama Sekolah
                                            <h3 class="text-lg text-muted"> <b class="d-block">{{ $result->nama_lembaga }}</b>
                                            </h3>
                                        </div>
                                        <div class="col-md-2">

                                        </div>
                                    </div>
                                    <br><br>

                                    <br>
                                    <div class="row">
                                        <div class="col-md-12 text-muted">
                                            <div class="card-body text-center">
                                                <strong><i class="fas fa-solid fa-star"></i> Akreditasi</strong>

                                                <p class="text-lg text-muted">{{ $result->akreditasi }}</p>

                                                <hr>

                                                <strong><i class="fas fa-solid fa-lightbulb"></i> NPSN</strong>

                                                <p class="text-lg text-muted">{{ $result->npsn }}</p>

                                                <hr>

                                                <strong><i class="fas fa-solid fa-id-badge"></i> NSM</strong>

                                                <p class="text-lg text-muted">{{ $result->nsm }}</p>

                                                <hr>

                                                <strong><i class="far fa-light fa-calendar-check"></i> Tanggal Berdiri</strong>

                                                <p class="text-lg text-muted">{{ $result->created_format }}</p>

                                                <hr>

                                                <strong><i class="fas fa-light fa-phone"></i></i> No Telp</strong>

                                                <p class="text-lg text-muted">{{ $result->no_telp }}</p>

                                                <hr>

                                                <strong><i class="fas fa-solid fa-at"></i> Email</strong>

                                                <p class="text-lg text-muted">{{ $result->email }}</p>

                                                <hr>

                                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>

                                                <p class="text-lg text-muted">{{ $result->alamat }}</p>

                                                <hr>

                                                @if (Auth::user()->role == '1')
                                                    <x-submit-button method="GET" action="{{route('admin.lembaga.edit', $result->id)}}"
                                                                     theme="warning" label="Edit Data Lembaga" icon="fas fa-pencil" type="submit"></x-submit-button>
                                                @endif
                                            </div>
                                        </div>
{{--                                        <div class="col-md-3 text-muted">--}}
{{--                                            <table style="border: 1px solid">--}}
{{--                                                <tr>--}}
{{--                                                    <td style="padding: 10px"><strong><i class="fas fa-solid fa-star"></i> Akreditasi {{ $result->akreditasi }}</strong>--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
{{--                                            </table>--}}
{{--                                        </div>--}}
                                    </div>

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
