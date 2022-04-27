<x-app-layout title="Dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-child"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Jumlah Siswa</span>
                                <span class="info-box-number">{{ $jumlah_siswa[0]->count }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Jumlah Alumni</span>
                                <span class="info-box-number">{{ $jumlah_alumni[0]->count }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Jumlah GTK/Guru</span>
                                <span class="info-box-number">{{ $jumlah_guru[0]->count }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Jumlah Rombel</span>
                                <span class="info-box-number">{{ $jumlah_rombel[0]->count }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </div><!-- /.container-fluid -->
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $dana_masuk[0]->sum }}</h3>

                            <p>Total Dana Masuk</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $dana_keluar[0]->sum }}</h3>

                            <p>Total Dana Keluar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $laporan_pembayaran[0]->count }}</h3>

                            <p>Jumlah Laporan Pembayaran</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $arsip_surat[0]->count }}</h3>

                            <p>Jumlah Arsip Surat</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </div>
    </div>
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
