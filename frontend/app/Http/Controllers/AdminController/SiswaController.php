<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'siswa/');
        $result = json_decode($resp->getBody());

        if (property_exists($result, 'data')){

            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){
                $btnShow = view('components.button', [
                    'method' => 'GET',
                    'action' => route('admin.siswa.show', $resp->id),
                    'title' => 'Lihat',
                    'id' => 'lihat',
                    'onclick' => '',
                    'icon' => 'fa fa-lg fa-fw fa-eye',
                    'class' => 'btn btn-xs btn-default text-teal mx-1 shadow']);

                $btnEdit = view('components.button', [
                    'method' => 'GET',
                    'action' => route('admin.siswa.edit', $resp->id),
                    'title' => 'Edit',
                    'id' => 'edit',
                    'onclick' => '',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete = view('components.button', [
                    'method' => 'GET',
                    'action' => route('admin.siswa.destroy', $resp->id),
                    'title' => 'Hapus',
                    'id' => 'hapus',
                    'onclick' => 'return confirm_delete()',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                $subjectdata[] = [
                    $resp->nis,
                    $resp->nisn,
                    $resp->nama_siswa,
                    $resp->jenis_kelamin,
                    $resp->status_siswa,
                    '<nobr>'.$btnShow.$btnEdit.$btnDelete.'</nobr>'
                ];
            }

            $heads = [
                'NIS',
                'NISN',
                'Nama',
                'Jenis Kelamin',
                'Status Siswa',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('siswa.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                'NIS',
                'NISN',
                'Nama',
                'Jenis Kelamin',
                'Status Siswa',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('siswa.index')->with(compact('heads', 'config', 'result'));
        }
    }
    public function index_alumni()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'siswa/alumni/');
        $result = json_decode($resp->getBody());

        if (property_exists($result, 'data')){

            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){

                $btnEdit = view('components.button', [
                    'method' => 'GET',
                    'action' => route('admin.siswa.edit', $resp->id),
                    'title' => 'Edit',
                    'id' => 'edit',
                    'onclick' => '',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete = view('components.button', [
                    'method' => 'GET',
                    'action' => route('admin.siswa.destroy', $resp->id),
                    'title' => 'Hapus',
                    'id' => 'hapus',
                    'onclick' => 'return confirm_delete()',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                $subjectdata[] = [
                    $resp->nis,
                    $resp->nisn,
                    $resp->nama_siswa,
                    $resp->jenis_kelamin,
                    $resp->status_siswa,
                    '<nobr>'.$btnEdit.$btnDelete.'</nobr>'
                ];
            }

            $heads = [
                'NIS',
                'NISN',
                'Nama',
                'Jenis Kelamin',
                'Status Siswa',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('alumni.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                'NIS',
                'NISN',
                'Nama',
                'Jenis Kelamin',
                'Status Siswa',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('alumni.index')->with(compact('heads', 'config', 'result'));
        }
    }
    public function naikkelas(){
        {
            $client = new Client(['base_uri' => env('API_HOST')]);
            $resp = $client->request('GET', 'kelas/');
            $result = json_decode($resp->getBody());

            if (property_exists($result, 'data')){
                $result = $result->data;
                $subjectdata = array();

                foreach ($result as $resp){
                    $choosesiswa = view('components.Button', [
                        'method' => 'GET',
                        'action' => route('admin.siswa.siswanaik', $resp->id),
                        'title' => 'Pilih Siswa',
                        'icon' => 'fa fa-lg fa-fw fa-user',
                        'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                    $jumlah_siswa = DB::Select("SELECT COUNT(1) AS jml_siswa FROM data_siswa WHERE status_siswa NOT IN ('Lulus', 'Tidak Aktif') AND id_kelas = " . (int)$resp->id);

                    $subjectdata[] = [
                        $resp->id,
                        $resp->nama_kelas,
                        $resp->tingkat,
                        $jumlah_siswa[0]->jml_siswa.'/'.$resp->kapasitas_kelas,
                        '<nobr>'.$choosesiswa.'</nobr>'
                    ];
                }

                $heads = [
                    ['label' => 'ID Rombel', 'no-export' => false, 'width' => 10],
                    'Nama Rombel',
                    'Tingkat Rombel',
                    'Kapasitas Rombel',
                    ['label' => 'Pilih Siswa', 'no-export' => false, 'width' => 10],
                ];

                $config = [
                    'data' => $subjectdata,
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, ['orderable' => false]],
                    'paging' => true,
                    'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
                ];

                return view('siswa.naikkelas.index')->with(compact('heads', 'config', 'result'));
            } else {
                $heads = [
                    ['label' => 'ID Rombel', 'no-export' => false, 'width' => 10],
                    'Nama Rombel',
                    'Tingkat Rombel',
                    'Kapasitas Rombel',
                    ['label' => 'Pilih Siswa', 'no-export' => false, 'width' => 10],
                ];

                $config = [
                    'data' => [],
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, ['orderable' => false]],
                    'paging' => true,
                    'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
                ];

                return view('siswa.naikkelas.index')->with(compact('heads', 'config', 'result'));
            }

        }
    }

    public function siswanaik($id_kelas){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'siswa/kelas/'.$id_kelas);
        $result = json_decode($resp->getBody());

        $kelas = $client->request('GET', 'kelas/'.$id_kelas);
        $kelas = json_decode($kelas->getBody());
        $kelas = $kelas->data;

        $list_kelas = $client->request('GET', 'kelas/');
        $list_kelas = json_decode($list_kelas->getBody());
        $list_kelas = $list_kelas->data;

        if (property_exists($result, 'data')){

            $result = $result->data;
            $subjectdata = array();
            $datasiswa = $result;

            foreach ($result as $resp){
                $btnShow = view('components.button', [
                    'method' => 'GET',
                    'action' => route('admin.siswa.show', $resp->id),
                    'title' => 'Lihat',
                    'id' => 'lihat',
                    'onclick' => '',
                    'icon' => 'fa fa-lg fa-fw fa-eye',
                    'class' => 'btn btn-xs btn-default text-teal mx-1 shadow']);

                $btnEdit = view('components.button', [
                    'method' => 'GET',
                    'action' => route('admin.siswa.edit', $resp->id),
                    'title' => 'Edit',
                    'id' => 'edit',
                    'onclick' => '',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete = view('components.button', [
                    'method' => 'GET',
                    'action' => route('admin.siswa.destroy', $resp->id),
                    'title' => 'Hapus',
                    'id' => 'hapus',
                    'onclick' => 'return confirm_delete()',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                $subjectdata[] = [
                    $resp->nis,
                    $resp->nisn,
                    $resp->nama_siswa,
                    $kelas->tingkat,
                    $kelas->nama_kelas,
                    '<nobr>'.$btnShow.$btnEdit.$btnDelete.'</nobr>'
                ];
            }

            $heads = [
                'NIS',
                'NISN',
                'Nama',
                'Tingkat Rombel',
                'Nama Rombel',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('siswa.naikkelas.choose')->with(compact('heads', 'config', 'result', 'kelas', 'list_kelas', 'datasiswa'));
        } else {
            $heads = [
                'NIS',
                'NISN',
                'Nama',
                'Tingkat Rombel',
                'Nama Rombel',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];
            $datasiswa = null;

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('siswa.naikkelas.choose')->with(compact('heads', 'config', 'result', 'kelas', 'list_kelas', 'datasiswa'));
        }
    }

    public function naik(Request $request) {
        $client = new Client(['base_uri' => env('API_HOST')]);

        $resp = $client->request('POST', 'siswa/naik',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'id_kelas' => (int)$request->id_kelas,
                    'daftar_siswa' => (array)$request->daftar_siswa
                ]
            ]
        );

        return redirect()->back()->with('alert', 'Data Berhasil Ditambahkan');
    }

    public function lulus(Request $request) {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'siswa/lulus',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'daftar_siswa' => (array)$request->daftar_siswa,
                ]
            ]
        );

        return redirect()->back()->with('alert', 'Data Berhasil Ditambahkan');
    }

    public function create(){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $kelas = $client->request('GET', 'kelas/');
        $kelas = json_decode($kelas->getBody());

        if (property_exists($kelas, 'data')) {
            $kelas = $kelas->data;
            foreach ($kelas as $resp) {
                $jumlah_siswa = DB::Select("SELECT COUNT(1) AS jml_siswa FROM data_siswa WHERE status_siswa NOT IN ('Lulus', 'Tidak Aktif') AND id_kelas = " . (int)$resp->id);
            }
        }
        $config_date = ['format' => 'YYYY-MM-DD'];
        $tahun = 3;
        $tahunpelajaran = array();

        for($i=0;$i<=$tahun;$i++){
            $result = DB::Select("SELECT CONCAT(extract('year' FROM CURRENT_DATE - INTERVAL '1 YEAR' + INTERVAL '".$i." YEAR'),'/',EXTRACT('year' FROM CURRENT_DATE + INTERVAL '".$i." YEAR')) AS TAHUN");
            $tahunpelajaran[] = $result[0]->tahun;
        }
//        dd($tahunpelajaran);
        return view('siswa.create')->with(compact('kelas', 'config_date', 'tahunpelajaran', 'jumlah_siswa'));
    }

    public function store(Request $request){
        $client = new Client(['base_uri' => env('API_HOST')]);

        $resp = $client->request('POST', 'siswa/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nisn' => (int)$request->nisn,
                    'nis' => (int)$request->nis,
                    'nama_siswa' => $request->nama_siswa,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'nik' => (int)$request->nik,
                    'id_kelas' => (int)$request->id_kelas,
                    'status_siswa' => $request->status_siswa,
                    'nomor_kip' => (int)$request->nomor_kip,
                    'alamat' => $request->alamat,
                    'nomor_kk' => (int)$request->nomor_kk,
                    'file_kk' => 'string',
                    'jenis_wali' => $request->jeniswali,
                    'nomor_kks' => (int)$request->nomor_kks,
                    'nomor_pkh' => (int)$request->nomor_pkh,
                    'current_state' => $request->current_state
                ]
            ]
        );
        $data_siswa = json_decode($resp->getBody());
//        dd($data_siswa);
        if ($data_siswa->message_id == '00'){
            $walisiswa = $client->request('POST', 'walisiswa/tambah',[
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept'     => 'application/json'
                    ],
                    'json' => [
                        'nama_ayah' => $request->nama_ayah,
                        'file_kk_ayah' => 'string',
                        'tempat_lahir_ayah' => $request->tempat_lahir_ayah,
                        'tanggal_lahir_ayah' => $request->tanggal_lahir_ayah,
                        'alamat_ayah' => $request->alamat_ayah,
                        'status_keluarga_ayah' => $request->status_keluarga_ayah,
                        'status_hidup_ayah' => $request->status_hidup_ayah,
                        'no_hp_ayah' => (int)$request->no_hp_ayah,
                        'pendidikan_ayah' => (int)$request->pendidikan_ayah,
                        'pekerjaan_ayah' => (int)$request->pekerjaan_ayah,
                        'penghasilan_ayah' => (int)$request->penghasilan_ayah,
                        'nama_ibu' => $request->nama_ibu,
                        'file_kk_ibu' => 'string',
                        'tempat_lahir_ibu' => $request->tempat_lahir_ibu,
                        'tanggal_lahir_ibu' => $request->tanggal_lahir_ibu,
                        'alamat_ibu' => $request->alamat_ibu,
                        'status_keluarga_ibu' => $request->status_keluarga_ibu,
                        'status_hidup_ibu' => $request->status_hidup_ibu,
                        'no_hp_ibu' => (int)$request->no_hp_ibu,
                        'pendidikan_ibu' => $request->pendidikan_ibu,
                        'pekerjaan_ibu' => $request->pekerjaan_ibu,
                        'penghasilan_ibu' => (int)$request->penghasilan_ibu,
                        'nama_wali' => $request->nama_wali,
                        'tempat_lahir_wali' => $request->tempat_lahir_wali,
                        'tanggal_lahir_wali' => $request->tanggal_lahir_wali,
                        'alamat_wali' => $request->alamat_wali,
                        'no_hp_wali' => (int)$request->no_hp_wali,
                        'pendidikan_wali' => $request->pendidikan_wali,
                        'pekerjaan_wali' => $request->pekerjaan_wali,
                        'penghasilan_wali' => (int)$request->penghasilan_wali,
                        'keterangan' => $request->keterangan,
                        'id_siswa' => $data_siswa->data->id
                    ]
                ]
            );
            return redirect(route('admin.siswa.index'))->with('alert', 'Data Berhasil Ditambahkan');
        }
        else {
            return redirect(route('admin.siswa.index'))->with('alert-failed', 'Data Gagal Ditambahkan');
        }
    }

    public function edit($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $siswa = $client->request('GET', 'siswa/'.$id);
        $siswa = json_decode($siswa->getBody());

        $walisiswa = $client->request('GET', 'walisiswa/'.$id);
        $walisiswa = json_decode($walisiswa->getBody());

        $kelas = $client->request('GET', 'kelas/');
        $kelas = json_decode($kelas->getBody());
        if (property_exists($kelas, 'data')) {
            $kelas = $kelas->data;
            foreach ($kelas as $resp) {
                $jumlah_siswa = DB::Select("SELECT COUNT(1) AS jml_siswa FROM data_siswa WHERE status_siswa NOT IN ('Lulus', 'Tidak Aktif') AND id_kelas = ".(int)$resp->id);
            }
        }


        $config_date = ['format' => 'YYYY-MM-DD'];

        $tahun = 3;
        $tahunpelajaran = array();

        for($i=0;$i<=$tahun;$i++){
            $result = DB::Select("SELECT CONCAT(extract('year' FROM CURRENT_DATE - INTERVAL '1 YEAR' + INTERVAL '".$i." YEAR'),'/',EXTRACT('year' FROM CURRENT_DATE + INTERVAL '".$i." YEAR')) AS TAHUN");
            $tahunpelajaran[] = $result[0]->tahun;
        }

        if($siswa->message_id == '00'){
            $siswa = $siswa->data;
            $walisiswa = $walisiswa->data;
            return view('siswa.edit')->with(compact('siswa', 'walisiswa', 'kelas', 'config_date', 'tahunpelajaran', 'jumlah_siswa'));
        }
        else {
            return redirect(route('admin.siswa.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function change_status($id, $status){
        $client = new Client(['base_uri' => env('API_HOST')]);

        $siswa = $client->request('GET', 'siswa/'.$id);
        $siswa = json_decode($siswa->getBody());
        $siswa = $siswa->data;
        $resp = $client->request('PUT', 'siswa/edit?id_siswa='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nisn' => (int)$siswa->nisn,
                    'nis' => (int)$siswa->nis,
                    'nama_siswa' => $siswa->nama_siswa,
                    'tempat_lahir' => $siswa->tempat_lahir,
                    'tanggal_lahir' => $siswa->tanggal_lahir,
                    'jenis_kelamin' => $siswa->jenis_kelamin,
                    'nik' => (int)$siswa->nik,
                    'id_kelas' => (int)$siswa->id_kelas,
                    'status_siswa' => $status,
                    'nomor_kip' => (int)$siswa->nomor_kip,
                    'alamat' => $siswa->alamat,
                    'nomor_kk' => (int)$siswa->nomor_kk,
                    'file_kk' => $siswa->file_kk,
                    'nomor_kks' => (int)$siswa->nomor_kks,
                    'nomor_pkh' => (int)$siswa->nomor_pkh,
                    'jenis_wali' => $siswa->jeniswali,
                ]
            ]
        );
        $data_siswa = json_decode($resp->getBody());
        return redirect(route('admin.siswa.index'))->with('alert', $data_siswa->status);
    }

    public function show($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $siswa = $client->request('GET', 'siswa/'.$id);
        $siswa = json_decode($siswa->getBody());

        $walisiswa = $client->request('GET', 'walisiswa/'.$id);
        $walisiswa = json_decode($walisiswa->getBody());

        $kelas = $client->request('GET', 'kelas/');
        $kelas = json_decode($kelas->getBody());
        $kelas = $kelas->data;


        $config_date = ['format' => 'YYYY-MM-DD'];

        if($siswa->message_id == '00'){
            $siswa = $siswa->data;
            $walisiswa = $walisiswa->data;
            $resp = $client->request('GET', 'pembayaransiswa/?id_siswa='.(int)$siswa->id);
            $result = json_decode($resp->getBody());

            if (property_exists($result, 'data')){

                $result = $result->data;
                $subjectdata = array();

                $tahun = 3;
                $tahunpelajaran = array();

                for($i=0;$i<=$tahun;$i++){
                    $result = DB::Select("SELECT CONCAT(extract('year' FROM CURRENT_DATE - INTERVAL '1 YEAR' + INTERVAL '".$i." YEAR'),'/',EXTRACT('year' FROM CURRENT_DATE + INTERVAL '".$i." YEAR')) AS TAHUN");
                    $tahunpelajaran[] = $result[0]->tahun;
                }

                foreach ($result as $resp){

                    $btnEdit = view('components.button', [
                        'method' => 'GET',
                        'action' => route('admin.laporan_pembayaran.edit', $resp->id),
                        'title' => 'Edit',
                    'id' => 'edit',
                    'onclick' => '',
                        'icon' => 'fa fa-lg fa-fw fa-pen',
                        'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                    $btnDelete = view('components.button', [
                        'method' => 'GET',
                        'action' => route('admin.laporan_pembayaran.destroy', $resp->id),
                        'title' => 'Hapus',
                    'id' => 'hapus',
                    'onclick' => 'return confirm_delete()',
                        'icon' => 'fa fa-lg fa-fw fa-trash',
                        'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                    $siswa = $client->request('GET', 'siswa/'.$resp->id_siswa);
                    $siswa = json_decode($siswa->getBody());
                    $siswa = $siswa->data;

                    $jenis_pembayaran = $client->request('GET', 'pembayaransiswa/jenispembayaran/'.$resp->id_jenispembayaran);
                    $jenis_pembayaran = json_decode($jenis_pembayaran->getBody());
                    $jenis_pembayaran = $jenis_pembayaran->data;

                    $subjectdata[] = [
                        $resp->created_format,
                        $siswa->nama_siswa,
                        $jenis_pembayaran->jenis_pembayaran,
                        $jenis_pembayaran->nominal_pembayaran,
                        $resp->nominal_pembayaran,
                        $resp->status_pembayaran,
                        '<nobr>'.$btnEdit.$btnDelete.'</nobr>'
                    ];
                }

                $heads = [
                    'Tanggal Pembayaran',
                    'Nama Siswa',
                    'Jenis',
                    'Nominal Tagihan',
                    'Nominal Terbayar',
                    'Status Pembayaran',
                    ['label' => 'Actions', 'no-export' => false, 'width' => 10],
                ];

                $config = [
                    'data' => $subjectdata,
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null, ['orderable' => false]],
                    'paging' => true,
                    'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
                ];
            } else {
                $heads = [
                    'Tanggal Pembayaran',
                    'Nama Siswa',
                    'Jenis',
                    'Nominal Tagihan',
                    'Nominal Terbayar',
                    'Status Pembayaran',
                    ['label' => 'Actions', 'no-export' => false, 'width' => 10],
                ];

                $config = [
                    'data' => [],
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null, ['orderable' => false]],
                    'paging' => true,
                    'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
                ];
            }

            return view('siswa.show')->with(compact('siswa', 'config', 'heads', 'walisiswa', 'kelas', 'config_date', 'tahunpelajaran'));
        }
        else {
            return redirect(route('admin.siswa.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('PUT', 'siswa/edit?id_siswa='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nisn' => (int)$request->nisn,
                    'nis' => (int)$request->nis,
                    'nama_siswa' => $request->nama_siswa,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'nik' => (int)$request->nik,
                    'id_kelas' => (int)$request->id_kelas,
                    'status_siswa' => $request->status_siswa,
                    'nomor_kip' => (int)$request->nomor_kip,
                    'alamat' => $request->alamat,
                    'nomor_kk' => (int)$request->nomor_kk,
                    'file_kk' => $request->file_kk,
                    'nomor_kks' => (int)$request->nomor_kks,
                    'nomor_pkh' => (int)$request->nomor_pkh,
                    'jenis_wali' => $request->jeniswali,
                    'current_state' => $request->current_state
                ]
            ]
        );
        $data_siswa = json_decode($resp->getBody());
        if ($data_siswa->message_id == '00'){
            $walisiswa = $client->request('PUT', 'walisiswa/edit?id_siswa='.$id,[
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept'     => 'application/json'
                    ],
                    'json' => [
                        'nama_ayah' => $request->nama_ayah,
                        'file_kk' => (int)$request->file_kk,
                        'tempat_lahir_ayah' => $request->tempat_lahir_ayah,
                        'tanggal_lahir_ayah' => $request->tanggal_lahir_ayah,
                        'alamat_ayah' => $request->alamat_ayah,
                        'status_keluarga_ayah' => $request->status_keluarga_ayah,
                        'status_hidup_ayah' => $request->status_hidup_ayah,
                        'no_hp_ayah' => (int)$request->no_hp_ayah,
                        'pendidikan_ayah' => (int)$request->pendidikan_ayah,
                        'pekerjaan_ayah' => (int)$request->pekerjaan_ayah,
                        'penghasilan_ayah' => (int)$request->penghasilan_ayah,
                        'nama_ibu' => $request->nama_ibu,
                        'tempat_lahir_ibu' => $request->tempat_lahir_ibu,
                        'tanggal_lahir_ibu' => $request->tanggal_lahir_ibu,
                        'alamat_ibu' => $request->alamat_ibu,
                        'status_keluarga_ibu' => $request->status_keluarga_ibu,
                        'status_hidup_ibu' => $request->status_hidup_ibu,
                        'no_hp_ibu' => (int)$request->no_hp_ibu,
                        'pendidikan_ibu' => $request->pendidikan_ibu,
                        'pekerjaan_ibu' => $request->pekerjaan_ibu,
                        'penghasilan_ibu' => (int)$request->penghasilan_ibu,
                        'nomor_kks_ibu' => (int)$request->nomor_kks_ibu,
                        'nomor_pkh_ibu' => (int)$request->nomor_pkh_ibu,
                        'nama_wali' => $request->nama_wali,
                        'tempat_lahir_wali' => $request->tempat_lahir_wali,
                        'tanggal_lahir_wali' => $request->tanggal_lahir_wali,
                        'alamat_wali' => $request->alamat_wali,
                        'no_hp_wali' => (int)$request->no_hp_wali,
                        'pendidikan_wali' => $request->pendidikan_wali,
                        'pekerjaan_wali' => $request->pekerjaan_wali,
                        'penghasilan_wali' => (int)$request->penghasilan_wali,
                        'keterangan' => $request->keterangan,
                    ]
                ]
            );
            return redirect(route('admin.siswa.index'))->with('alert', 'Data Berhasil Di Edit');
        }
        else {
            return redirect(route('admin.siswa.index'))->with('alert-failed', 'Data Gagal Di Edit');
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'siswa/hapus/'.(int)$id);
        $resp = $client->request('DELETE', 'walisiswa/hapus/'.(int)$id);
        return redirect(route('admin.siswa.index'))->with('alert', 'Data Terhapus');
    }
}
