<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class JenisWaliController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'walisiswa/jeniswali/');
        $result = json_decode($resp->getBody());
        $result = $result->data;
        $subjectdata = array();

        foreach ($result as $resp){
            $btnEdit = view('components.Button', [
                'method' => 'GET',
                'action' => route('admin.jeniswali.edit', $resp->id),
                'title' => 'Edit',
                'icon' => 'fa fa-lg fa-fw fa-pen',
                'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

            $btnDelete = view('components.Button', [
                'method' => 'GET',
                'action' => route('admin.jeniswali.destroy', $resp->id),
                'title' => 'Delete',
                'icon' => 'fa fa-lg fa-fw fa-trash',
                'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

            $subjectdata[] = [
                $resp->id,
                $resp->jenis_wali,
                '<nobr>'.$btnEdit.$btnDelete.'</nobr>'
            ];
        }

        $heads = [
            ['label' => 'ID Jenis Wali', 'no-export' => false, 'width' => 10],
            'Nama Jenis Wali',
            ['label' => 'Actions', 'no-export' => false, 'width' => 10],
        ];

        $config = [
            'data' => $subjectdata,
            'order' => [[1, 'asc']],
            'columns' => [null, null, ['orderable' => false]],
            'paging' => true,
            'lengthMenu' => [ 10, 50, 100, 500]
        ];

        return view('jeniswali.index')->with(compact('heads', 'config', 'result'));
    }

    public function create(){
        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('jeniswali.create')->with(compact('config_date'));
    }

    public function store(Request $request){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'walisiswa/jeniswali/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'jenis_wali' => $request->jenis_wali,
                ]
            ]
        );
        $jeniswali = json_decode($resp->getBody());
        if ($jeniswali->message_id == '00'){
            return redirect(route('admin.jeniswali.index'))->with('alert', 'Data Berhasil Ditambahkan');
        }
        else {
            return redirect(route('admin.jeniswali.index'))->with('alert-failed', 'Data Gagal Ditambahkan');
        }
    }

    public function edit($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $jeniswali = $client->request('GET', 'walisiswa/jeniswali/'.$id);
        $jeniswali = json_decode($jeniswali->getBody());

        if($jeniswali->message_id == '00'){
            $jeniswali = $jeniswali->data;
//            dd($jabatan);
            return view('jeniswali.edit')->with(compact( 'jeniswali'));
        }
        else {
            return redirect(route('admin.jeniswali.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('PUT', 'walisiswa/jeniswali/edit?id_jeniswali='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'jenis_wali' => $request->jenis_wali,
                ]
            ]
        );
        $jeniswali = json_decode($resp->getBody());
        if ($jeniswali->message_id == '00'){
            return redirect(route('admin.jeniswali.index'))->with('alert', 'Data Berhasil Di Edit');
        }
        else {
            return redirect(route('admin.jeniswali.index'))->with('alert-failed', 'Data Gagal Di Edit');
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'walisiswa/jeniswali/hapus/'.$id);
        return redirect(route('admin.jeniswali.index'))->with('alert', 'Data Terhapus');
    }
}
