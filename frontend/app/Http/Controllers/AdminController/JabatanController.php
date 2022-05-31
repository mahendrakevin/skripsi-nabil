<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'guru/jabatan/');
        $result = json_decode($resp->getBody());
        if (property_exists($result, 'data')){
            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){
                $btnEdit = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.jabatan.edit', $resp->id),
                    'title' => 'Edit',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.jabatan.destroy', $resp->id),
                    'title' => 'Hapus',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                $subjectdata[] = [
                    $resp->id,
                    $resp->nama_jabatan,
                    '<nobr>'.$btnEdit.$btnDelete.'</nobr>'
                ];
            }

            $heads = [
                ['label' => 'ID Jabatan', 'no-export' => false, 'width' => 10],
                'Nama Jabatan',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('jabatan.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                ['label' => 'ID Jabatan', 'no-export' => false, 'width' => 10],
                'Nama Jabatan',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('jabatan.index')->with(compact('heads', 'config', 'result'));
        }

    }

    public function create(){

        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('jabatan.create')->with(compact('config_date'));
    }

    public function store(Request $request){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'guru/jabatan/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nama_jabatan' => $request->nama_jabatan,
                ]
            ]
        );
        $data_jabatan = json_decode($resp->getBody());
        if ($data_jabatan->message_id == '00'){
            return redirect(route('admin.jabatan.index'))->with('alert', 'Data Berhasil Ditambahkan');
        }
        else {
            return redirect(route('admin.jabatan.index'))->with('alert-failed', 'Data Gagal Ditambahkan');
        }
    }

    public function edit($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $jabatan = $client->request('GET', 'guru/jabatan/'.$id);
        $jabatan = json_decode($jabatan->getBody());

        if($jabatan->message_id == '00'){
            $jabatan = $jabatan->data;
//            dd($jabatan);
            return view('jabatan.edit')->with(compact( 'jabatan'));
        }
        else {
            return redirect(route('admin.jabatan.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('PUT', 'guru/jabatan/edit?id_jabatan='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nama_jabatan' => $request->nama_jabatan,
                ]
            ]
        );
        $data_jabatan = json_decode($resp->getBody());
        if ($data_jabatan->message_id == '00'){
            return redirect(route('admin.jabatan.index'))->with('alert', 'Data Berhasil Di Edit');
        }
        else {
            return redirect(route('admin.jabatan.index'))->with('alert-failed', 'Data Gagal Di Edit');
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'guru/jabatan/hapus/'.$id);
        return redirect(route('admin.jabatan.index'))->with('alert', 'Data Terhapus');
    }
}
