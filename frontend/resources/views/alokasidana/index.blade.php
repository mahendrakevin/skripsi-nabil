<x-app-layout title="Data Alokasi Dana">
    <div class="row">
            <div class="col-md-12">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3">
                            <!-- small card -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>@convert($total_dana)</h3>

                                    <p>Total Dana</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-wallet"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- ./col -->
                            <div class="col-lg-3">
                                <!-- small card -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>@convert($dana_masuk[0]->total)</h3>

                                        <p>Total Dana Masuk</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-money-bill"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">
                                        Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <!-- small card -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>@convert($dana_keluar[0]->total)</h3>

                                        <p>Total Pengeluaran</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-coins"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">
                                        Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <!-- small card -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>@convert($total_laporan_pembayaran[0]->total)</h3>

                                        <p>Laporan Pembayaran Siswa</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-flag"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">
                                        Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- ./col -->
                    <!-- ./col -->
                    </div>

                </div><!-- /.container-fluid -->
            </div>

    </div>
    @if(session('alert'))
        <x-adminlte-alert theme="success" title="Sukses">
            {{ session('alert') }}
        </x-adminlte-alert>
    @elseif(session('alert-failed'))
        <x-adminlte-alert theme="danger" title="Gagal">
            {{ session('alert-failed') }}
        </x-adminlte-alert>
    @endif
    <x-adminlte-card theme="lime" theme-mode="outline" title="Pengelolaan Dana">
        <div class="row">

            @if (Auth::user()->role == '1')
                    <x-submit-button method="POST" action="{{route('admin.alokasi_dana.create_masuk')}}"
                                     theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>
                    <x-submit-button method="POST" action="{{route('admin.alokasi_dana.create_keluar')}}"
                                     theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>
            @elseif(Auth::user()->role == '2')
                <div class="col-md-12">
                    <x-submit-button method="POST" action="{{route('bendahara.alokasi_dana.create_masuk')}}"
                                     theme="success" label="Tambah Dana Masuk" icon="fas fa-plus" type="submit"></x-submit-button>
                    <x-submit-button method="POST" action="{{route('bendahara.alokasi_dana.create_keluar')}}"
                                     theme="danger" label="Tambah Dana Keluar" icon="fas fa-plus" type="submit"></x-submit-button>
                </div>
            @endif
        </div>
        <br>
        <div class="row">
            <x-adminlte-datatable id="dana_masuk" :heads="$heads_keluar" :config="$config_keluar"  striped hoverable with-footer beautify>
                @foreach($config_keluar['data'] as $row)
                    <tr>
                        @foreach($row as $cell)
                            <td> {!!  $cell !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </x-adminlte-card>
{{--    <x-adminlte-card theme="lightblue" theme-mode="outline" title="Dana Keluar">--}}
{{--        @if (Auth::user()->role == '1')--}}
{{--            <x-submit-button method="POST" action="{{route('admin.alokasi_dana.create_keluar')}}"--}}
{{--                             theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>--}}
{{--        @elseif(Auth::user()->role == '2')--}}
{{--            <x-submit-button method="POST" action="{{route('bendahara.alokasi_dana.create_keluar')}}"--}}
{{--                             theme="success" label="Tambah Data" icon="fas fa-plus" type="submit"></x-submit-button>--}}
{{--        @endif--}}
{{--        <x-adminlte-datatable id="dana_keluar" :heads="$heads_keluar" :config="$config_keluar"  striped hoverable with-footer beautify>--}}
{{--            @foreach($config_masuk['data'] as $row)--}}
{{--                <tr>--}}
{{--                    @foreach($row as $cell)--}}
{{--                        <td> {!!  $cell !!}</td>--}}
{{--                    @endforeach--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--        </x-adminlte-datatable>--}}
{{--    </x-adminlte-card>--}}
</x-app-layout>
