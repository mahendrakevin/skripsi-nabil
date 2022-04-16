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
                    'title' => 'Detail',
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
                    'title' => 'Delete',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                $guru = $client->request('GET', 'guru/'.$resp->id_guru);
                $guru = json_decode($guru->getBody());
                $guru = $guru->data;

                $jabatan = $client->request('GET', 'guru/jabatan/'.$resp->id_jabatan);
                $jabatan = json_decode($jabatan->getBody());
                $jabatan = $jabatan->data;

                $subjectdata[] = [
                    $guru->nama_guru,
                    $guru->nuptk,
                    $jabatan->nama_jabatan,
                    $resp->status_kepegawaian,
                    $resp->no_sk,
                    '<nobr>'.$btnShow.$btnEdit.$btnDelete.'</nobr>'
                ];
            }

            $heads = [
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
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('skguru.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
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
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('skguru.index')->with(compact('heads', 'config', 'result'));
        }
    }

    public function create(){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $jabatan = $client->request('GET', 'guru/jabatan/');
        $jabatan = json_decode($jabatan->getBody());
        $jabatan = $jabatan->data;
        $guru = $client->request('GET', 'guru/');
        $guru = json_decode($guru->getBody());
        $guru = $guru->data;

        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('skguru.create')->with(compact('jabatan', 'config_date', 'guru'));
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


        $guru = $client->request('GET', 'guru/'.$kepegawaian->data->id_guru);
        $guru = json_decode($guru->getBody());


        $jabatan = $client->request('GET', 'guru/jabatan/');
        $jabatan = json_decode($jabatan->getBody());
        $jabatan = $jabatan->data;
        $config_date = ['format' => 'YYYY-MM-DD'];

        if($kepegawaian->message_id == '00'){
            $guru = $guru->data;
            $kepegawaian = $kepegawaian->data;
            return view('skguru.edit')->with(compact( 'guru', 'kepegawaian', 'jabatan', 'config_date'));
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
