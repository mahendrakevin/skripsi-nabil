<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class KepegawaianController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'guru/kepegawaian/');
        $result = json_decode($resp->getBody());
        if (property_exists($result, 'data')){
            $result = $result->data;
            $subjectdata = array();
            foreach ($result as $resp){
                $btnShow = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.guru.show', $resp->id_guru),
                    'title' => 'Lihat',
                    'icon' => 'fa fa-lg fa-fw fa-eye',
                    'class' => 'btn btn-xs btn-default text-teal mx-1 shadow']);

                $btnEdit = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.kepegawaian.edit', $resp->id),
                    'title' => 'Edit',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.kepegawaian.destroy', $resp->id),
                    'title' => 'Hapus',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                $guru = $client->request('GET', 'guru/'.$resp->id_guru);
                $guru = json_decode($guru->getBody());
                $guru = $guru->data;

                if ($resp->isskpengangkatan == true){
                    $kategori_sk = 'SK Pengangkatan';
                    $btnDelete = '';
                } else {
                    $kategori_sk = $resp->kategori_sk;
                }

                $subjectdata[] = [
                    $resp->no_sk,
                    $kategori_sk,
                    $guru->nama_guru,
                    $guru->nuptk,
                    $resp->jabatan,
                    '<nobr>'.$btnShow.$btnEdit.$btnDelete.'</nobr>'
                ];
            }

            $heads = [
                'No SK',
                'Kategori SK',
                'Nama Guru',
                'NUPTK',
                'Jabatan',
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

            return view('skguru.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                'No SK',
                'Kategori SK',
                'Nama Guru',
                'NUPTK',
                'Jabatan',
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

            return view('skguru.index')->with(compact('heads', 'config', 'result'));
        }
    }

    public function create(){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $guru = $client->request('GET', 'guru/');
        $guru = json_decode($guru->getBody());
        $guru = $guru->data;

        $jabatan = $client->request('GET', 'guru/jabatan/');
        $jabatan = json_decode($jabatan->getBody());
        $jabatan = $jabatan->data;

        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('skguru.create')->with(compact('config_date', 'guru', 'jabatan'));
    }

    public function store(Request $request){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $kepegawaian = $client->request('POST', 'guru/kepegawaian/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'id_guru' => (int)$request->id_guru,
                    'tanggal' =>$request->tanggal,
                    'no_sk' => $request->no_sk,
                    'kategori_sk' => $request->kategori_sk,
                    'jabatan' => $request->jabatan
                ]
            ]
        );
        $kepegawaian = json_decode($kepegawaian->getBody());
        if ($kepegawaian->message_id == '00'){
            return redirect(route('admin.guru.index'))->with('alert', 'Data Berhasil Ditambahkan');
        }
        else {
            return redirect(route('admin.guru.index'))->with('alert-failed', $kepegawaian->status);
        }
    }

    public function edit($id){
        $client = new Client(['base_uri' => env('API_HOST')]);

        $kepegawaian = $client->request('GET', 'guru/kepegawaian/detail/'.$id);
        $kepegawaian = json_decode($kepegawaian->getBody());
        $jabatan = $client->request('GET', 'guru/jabatan/');
        $jabatan = json_decode($jabatan->getBody());
        $jabatan = $jabatan->data;

        $guru = $client->request('GET', 'guru/'.$kepegawaian->data->id_guru);
        $guru = json_decode($guru->getBody());

        $config_date = ['format' => 'YYYY-MM-DD'];

        if($kepegawaian->message_id == '00'){
            $guru = $guru->data;
            $kepegawaian = $kepegawaian->data;
            return view('skguru.edit')->with(compact( 'guru', 'kepegawaian', 'config_date', 'jabatan'));
        }
        else {
            return redirect(route('admin.kepegawaian.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function show($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $guru = $client->request('GET', 'guru/'.$id);
        $guru = json_decode($guru->getBody());

        $kepegawaian = $client->request('GET', 'guru/kepegawaian/'.$id);
        $kepegawaian = json_decode($kepegawaian->getBody());

        $jabatan = $client->request('GET', 'guru/jabatan/');
        $jabatan = json_decode($jabatan->getBody());
        $jabatan = $jabatan->data;
        $config_date = ['format' => 'YYYY-MM-DD'];

        if($guru->message_id == '00'){
            $guru = $guru->data;
            $kepegawaian = $kepegawaian->data;
            return view('guru.show')->with(compact( 'guru', 'kepegawaian', 'jabatan', 'config_date'));
        }
        else {
            return redirect(route('admin.guru.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $kepegawian = $client->request('PUT', 'guru/kepegawaian/pegawai/edit?id_kepegawaian='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'id_guru' => (int)$request->id_guru,
                    'tanggal' =>$request->tanggal,
                    'no_sk' => $request->no_sk,
                    'kategori_sk' => $request->kategori_sk,
                    'jabatan' => $request->jabatan
                ]
            ]
        );
        $kepegawian = json_decode($kepegawian->getBody());
        if ($kepegawian->message_id == '00'){
            return redirect(route('admin.kepegawaian.index'))->with('alert', 'Data Berhasil Di Edit');
        }
        else {
            return redirect(route('admin.kepegawaian.index'))->with('alert-failed', 'Data Gagal Di Edit');
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'guru/kepegawaian/hapus/pegawai/'.(int)$id);
        return redirect(route('admin.kepegawaian.index'))->with('alert', 'Data Terhapus');
    }
}
