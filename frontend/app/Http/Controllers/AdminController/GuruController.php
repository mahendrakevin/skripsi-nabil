<?php

namespace App\Http\Controllers\AdminController;

use App\Exports\GuruExport;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'guru/');
        $result = json_decode($resp->getBody());
        if (property_exists($result, 'data')){
            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){
                $btnShow = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.guru.show', $resp->id),
                    'title' => 'Lihat',
                    'id' => 'lihat',
                    'onclick' => '',
                    'icon' => 'fa fa-lg fa-fw fa-eye',
                    'class' => 'btn btn-xs btn-default text-teal mx-1 shadow']);

                $btnEdit = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.guru.edit', $resp->id),
                    'title' => 'Edit',
                    'id' => 'edit',
                    'onclick' => '',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.guru.destroy', $resp->id),
                    'title' => 'Hapus',
                    'id' => 'hapus',
                    'onclick' => 'return confirm_delete()',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);


                $subjectdata[] = [
                    $resp->nip,
                    (string)$resp->nuptk,
                    $resp->nama_guru,
                    $resp->jenis_kelamin,
                    $resp->status_pegawai,
                    '<nobr>'.$btnShow.$btnEdit.$btnDelete.'</nobr>'
                ];
            }

            $heads = [
                'NIP',
                'NUPTK',
                'Nama Guru',
                'Jenis Kelamin',
                'Status Pegawai',
                ['label' => 'Actions', 'no-export' => true, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[4, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('guru.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                'NIP',
                'NUPTK',
                'Nama Guru',
                'Jenis Kelamin',
                'Status Pegawai',
                ['label' => 'Actions', 'no-export' => true, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[4, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('guru.index')->with(compact('heads', 'config', 'result'));
        }
    }

    public function create(){
        $client = new Client(['base_uri' => env('API_HOST')]);

        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('guru.create')->with(compact('config_date'));
    }

    public function cetak(){
//        $siswa = DB::Select("SELECT nisn, nis, nama_siswa, tempat_lahir, tanggal_lahir as tanggal_lahir_siswa, jenis_kelamin, nik AS nik_siswa,
//                                   nama_kelas, tingkat AS tingkat_kelas, status_siswa, nomor_kip, alamat, nomor_kk,
//                                   jenis_wali, nama_ayah, nik_ayah, tempat_lahir_ayah, tanggal_lahir_ayah, alamat_ayah, status_keluarga_ayah,
//                                   status_hidup_ayah as status_ayah, no_hp_ayah, pendidikan_ayah, pekerjaan_ayah, penghasilan_ayah,
//                                   nama_ibu, nik_ibu, tempat_lahir_ibu, tanggal_lahir_ibu, alamat_ibu, status_keluarga_ibu,
//                                   status_hidup_ibu as status_ibu, no_hp_ibu, pendidikan_ibu, pekerjaan_ibu, penghasilan_ibu,
//                                   nama_wali, keterangan, alamat as alamat_wali, no_hp_wali, nomor_kks, nomor_pkh FROM data_siswa ds
//                            INNER JOIN data_kelas dk on ds.id_kelas = dk.id
//                            INNER JOIN data_wali_siswa dws on ds.id = dws.id_siswa");


        return Excel::download(new GuruExport, 'guru.xlsx');
    }

    public function store(Request $request){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'guru/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nip' => (int)$request->nip,
                    'nuptk' => (int)$request->nuptk,
                    'nik' => (int)$request->nik,
                    'nama_guru' => $request->nama_guru,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'no_hp' => (int)$request->no_hp,
                    'email' => $request->email,
                    'status_perkawinan' => $request->status_perkawinan,
                    'status_pegawai' => $request->status_pegawai
                ]
            ]
        );
        $data_guru = json_decode($resp->getBody());
        if ($data_guru->message_id == '00'){
            $kepegawian = $client->request('POST', 'guru/kepegawaian/tambah',[
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept'     => 'application/json'
                    ],
                    'json' => [
                        'id_guru' => (int)$data_guru->data->id,
                        'no_sk' => $request->no_sk,
                        'no_sk_operator' => $request->no_sk_operator,
                        'isSKPengangkatan' => true,
                        'jabatan' => $request->jabatan
                    ]
                ]
            );
            return redirect(route('admin.guru.index'))->with('alert', 'Data Berhasil Ditambahkan');
        }
        else {
            return redirect(route('admin.guru.index'))->with('alert-failed', 'Data Gagal Ditambahkan');
        }
    }

    public function edit($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $guru = $client->request('GET', 'guru/'.$id);
        $guru = json_decode($guru->getBody());
        $config_date = ['format' => 'YYYY-MM-DD'];

        if($guru->message_id == '00'){
            $guru = $guru->data;
            $resp = $client->request('GET', 'guru/kepegawaian/?id_guru='.(int)$id);
            $result = json_decode($resp->getBody());
            if (property_exists($result, 'data')) {
                $result = $result->data;
                $subjectdata = array();
                foreach ($result as $resp) {
                    $btnEdit = view('components.Button', [
                        'method' => 'GET',
                        'action' => route('admin.kepegawaian.edit', $resp->id),
                        'title' => 'Edit',
                        'id' => 'edit',
                        'onclick' => '',
                        'icon' => 'fa fa-lg fa-fw fa-pen',
                        'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                    $btnDelete = view('components.Button', [
                        'method' => 'GET',
                        'action' => route('admin.kepegawaian.destroy', $resp->id),
                        'title' => 'Hapus',
                        'id' => 'hapus',
                        'onclick' => 'return confirm_delete()',
                        'icon' => 'fa fa-lg fa-fw fa-trash',
                        'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                    $guru = $client->request('GET', 'guru/' . $resp->id_guru);
                    $guru = json_decode($guru->getBody());
                    $guru = $guru->data;

                    if ($resp->isskpengangkatan == true){
                        $kategori_sk = 'SK Pengangkatan';
                        $btnDelete = '';
                    } else {
                        $kategori_sk = $resp->kategori_sk;
                    }

                    $subjectdata[] = [
                        $resp->tanggal,
                        $guru->nama_guru,
                        $guru->nuptk,
                        $kategori_sk,
                        $resp->jabatan,
                        $resp->no_sk,
                        '<nobr>' . $btnEdit . $btnDelete . '</nobr>'
                    ];
                }

                $heads = [
                    'Tanggal SK',
                    'Nama Guru',
                    'NUPTK',
                    'Kategori SK',
                    'Jabatan',
                    'No SK',
                    ['label' => 'Actions', 'no-export' => false, 'width' => 10],
                ];

                $config = [
                    'data' => $subjectdata,
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null, ['orderable' => false]],
                    'paging' => true,
                    'lengthMenu' => [10, 50, 100, 500]
                ];
            } else {
                $heads = [
                    'Tanggal SK',
                    'Nama Guru',
                    'NUPTK',
                    'Kategori SK',
                    'Jabatan',
                    'No SK',
                    ['label' => 'Actions', 'no-export' => false, 'width' => 10],
                ];

                $config = [
                    'data' => [],
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null, ['orderable' => false]],
                    'paging' => true,
                    'lengthMenu' => [10, 50, 100, 500]
                ];
            }
            return view('guru.edit')->with(compact( 'guru', 'heads', 'config', 'result', 'config_date'));
        }
        else {
            return redirect(route('admin.guru.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function show($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $guru = $client->request('GET', 'guru/'.$id);
        $guru = json_decode($guru->getBody());
        $config_date = ['format' => 'YYYY-MM-DD'];

        if($guru->message_id == '00'){
            $guru = $guru->data;
            $resp = $client->request('GET', 'guru/kepegawaian/?id_guru='.(int)$id);
            $result = json_decode($resp->getBody());
            if (property_exists($result, 'data')) {
                $result = $result->data;
                $subjectdata = array();
                foreach ($result as $resp) {

                    $guru = $client->request('GET', 'guru/' . $resp->id_guru);
                    $guru = json_decode($guru->getBody());
                    $guru = $guru->data;

                    if ($resp->isskpengangkatan == true){
                        $kategori_sk = 'SK Pengangkatan';
                    } else {
                        $kategori_sk = $resp->kategori_sk;
                    }

                    $subjectdata[] = [
                        $resp->no_sk,
                        $resp->tanggal,
                        $kategori_sk,
                        $guru->nuptk,
                        $resp->jabatan,
                    ];
                }

                $heads = [
                    'No SK',
                    'Tanggal SK',
                    'Kategori SK',
                    'NUPTK',
                    'Jabatan',
                ];

                $config = [
                    'data' => $subjectdata,
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null],
                    'paging' => true,
                    'lengthMenu' => [10, 50, 100, 500]
                ];
            } else {
                $heads = [
                    'No SK',
                    'Tanggal SK',
                    'Kategori SK',
                    'NUPTK',
                    'Jabatan',
                ];

                $config = [
                    'data' => [],
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null],
                    'paging' => true,
                    'lengthMenu' => [10, 50, 100, 500]
                ];
            }
            return view('guru.show')->with(compact( 'guru', 'heads', 'config', 'result', 'config_date'));
        }
        else {
            return redirect(route('admin.guru.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('PUT', 'guru/edit?id_guru='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nip' => (int)$request->nip,
                    'nuptk' => (int)$request->nuptk,
                    'nik' => (int)$request->nik,
                    'nama_guru' => $request->nama_guru,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'no_hp' => (int)$request->no_hp,
                    'email' => $request->email,
                    'status_perkawinan' => $request->status_perkawinan,
                    'status_pegawai' => $request->status_pegawai
                ]
            ]
        );
        $data_guru = json_decode($resp->getBody());
        if ($data_guru->message_id == '00'){
            return redirect(route('admin.guru.index'))->with('alert', 'Data Berhasil Di Edit');
        }
        else {
            return redirect(route('admin.guru.index'))->with('alert-failed', 'Data Gagal Di Edit');
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'guru/hapus/'.(int)$id);
        $resp = $client->request('DELETE', 'guru/kepegawaian/hapus/'.(int)$id);
        return redirect(route('admin.guru.index'))->with('alert', 'Data Terhapus');
    }
}
