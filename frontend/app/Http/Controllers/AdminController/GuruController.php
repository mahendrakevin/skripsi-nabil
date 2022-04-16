<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

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
                    'title' => 'Detail',
                    'icon' => 'fa fa-lg fa-fw fa-eye',
                    'class' => 'btn btn-xs btn-default text-teal mx-1 shadow']);

                $btnEdit = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.guru.edit', $resp->id),
                    'title' => 'Edit',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.guru.destroy', $resp->id),
                    'title' => 'Delete',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                $subjectdata[] = [
                    $resp->nip,
                    $resp->nuptk,
                    $resp->nama_guru,
                    $resp->jenis_kelamin,
                    '<nobr>'.$btnShow.$btnEdit.$btnDelete.'</nobr>'
                ];
            }

            $heads = [
                'NIP',
                'NUPTK',
                'Nama Guru',
                'Jenis Kelamin',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('guru.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                'NIP',
                'NUPTK',
                'Nama Guru',
                'Jenis Kelamin',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('guru.index')->with(compact('heads', 'config', 'result'));
        }
    }

    public function create(){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $jabatan = $client->request('GET', 'guru/jabatan/');
        $jabatan = json_decode($jabatan->getBody());
        $jabatan = $jabatan->data;

        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('guru.create')->with(compact('jabatan', 'config_date'));
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
                    'status_perkawinan' => $request->status_perkawinan
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
                        'no_sk_ypmnu' => $request->no_sk_ypmnu,
                        'no_sk_operator' => $request->no_sk_operator,
                        'id_jabatan' => (int)$request->id_jabatan,
                        'status_kepegawaian' => $request->status_kepegawaian,
                        'alasan_tidak_aktif' => $request->alasan_tidak_aktif,
                        'surat_mutasi' => 'test',
                        'jumlah_ajar' => (int)$request->jumlah_ajar
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
                        'icon' => 'fa fa-lg fa-fw fa-pen',
                        'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                    $btnDelete = view('components.Button', [
                        'method' => 'GET',
                        'action' => route('admin.kepegawaian.destroy', $resp->id),
                        'title' => 'Delete',
                        'icon' => 'fa fa-lg fa-fw fa-trash',
                        'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                    $guru = $client->request('GET', 'guru/' . $resp->id_guru);
                    $guru = json_decode($guru->getBody());
                    $guru = $guru->data;

                    $jabatan = $client->request('GET', 'guru/jabatan/' . $resp->id_jabatan);
                    $jabatan = json_decode($jabatan->getBody());
                    $jabatan = $jabatan->data;

                    $subjectdata[] = [
                        $resp->tanggal,
                        $guru->nama_guru,
                        $guru->nuptk,
                        $jabatan->nama_jabatan,
                        $resp->status_kepegawaian,
                        $resp->no_sk,
                        '<nobr>' . $btnEdit . $btnDelete . '</nobr>'
                    ];
                }

                $heads = [
                    'Tanggal SK',
                    'Nama Guru',
                    'NUPTK',
                    'Jabatan',
                    'Status',
                    'No SK',
                    ['label' => 'Actions', 'no-export' => false, 'width' => 10],
                ];

                $config = [
                    'data' => $subjectdata,
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, ['orderable' => false]],
                    'paging' => true,
                    'lengthMenu' => [10, 50, 100, 500]
                ];
            } else {
                $heads = [
                    'Tanggal SK',
                    'Nama Guru',
                    'NUPTK',
                    'Jabatan',
                    'Status',
                    'No SK',
                    ['label' => 'Actions', 'no-export' => false, 'width' => 10],
                ];

                $config = [
                    'data' => [],
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, ['orderable' => false]],
                    'paging' => true,
                    'lengthMenu' => [10, 50, 100, 500]
                ];
            }
            return view('guru.edit')->with(compact( 'guru', 'heads', 'config', 'result','jabatan', 'config_date'));
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

                    $jabatan = $client->request('GET', 'guru/jabatan/' . $resp->id_jabatan);
                    $jabatan = json_decode($jabatan->getBody());
                    $jabatan = $jabatan->data;

                    $subjectdata[] = [
                        $resp->tanggal,
                        $guru->nuptk,
                        $jabatan->nama_jabatan,
                        $resp->no_sk,
                        $resp->no_sk_ypmnu,
                        $resp->no_sk_operator,
                        $resp->status_kepegawaian,
                        $resp->alasan_tidak_aktif,
                        $resp->surat_mutasi

                    ];
                }

                $heads = [
                    'Tanggal SK',
                    'NUPTK',
                    'Jabatan',
                    'No SK',
                    'No SK YPMNU',
                    'No SK Operator',
                    'Status',
                    'Alasan Tidak Aktif',
                    'Surat Mutasi'
                ];

                $config = [
                    'data' => $subjectdata,
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, ['orderable' => false]],
                    'paging' => true,
                    'lengthMenu' => [10, 50, 100, 500]
                ];
            } else {
                $heads = [
                    'Tanggal SK',
                    'NUPTK',
                    'Jabatan',
                    'No SK',
                    'No SK YPMNU',
                    'No SK Operator',
                    'Status',
                    'Alasan Tidak Aktif',
                    'Surat Mutasi'
                ];

                $config = [
                    'data' => [],
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, ['orderable' => false]],
                    'paging' => true,
                    'lengthMenu' => [10, 50, 100, 500]
                ];
            }
            return view('guru.show')->with(compact( 'guru', 'heads', 'config', 'result', 'jabatan', 'config_date'));
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
                    'status_perkawinan' => $request->status_perkawinan
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
