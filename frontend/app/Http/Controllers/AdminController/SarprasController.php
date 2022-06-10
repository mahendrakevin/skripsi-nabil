<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SarprasController extends Controller

{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'lembaga/sarpras/');
        $result = json_decode($resp->getBody());

        if (property_exists($result, 'data')){

            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){
                $btnEdit = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.sarpras.edit', $resp->id),
                    'title' => 'Edit',
                    'id' => 'edit',
                    'onclick' => '',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.sarpras.destroy', $resp->id),
                    'title' => 'Hapus',
                    'id' => 'hapus',
                    'onclick' => 'return confirm_delete()',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                $lembaga = $client->request('GET', 'lembaga/'.$resp->id_lembaga);
                $lembaga = json_decode($lembaga->getBody());
                $lembaga = $lembaga->data;

                $subjectdata[] = [
                    $resp->id,
                    $resp->nama_aset,
                    $resp->luas_lahan,
                    $resp->luas_bangunan,
                    $resp->nama_pemilik,
                    $resp->no_sertifikat,
                    '<nobr>'.$btnEdit.$btnDelete.'</nobr>'
                ];
            }

            $heads = [
                ['label' => 'No', 'no-export' => false, 'width' => 10],
                'Nama Lembaga',
                'Luas Lahan',
                'Luas Bangunan',
                'Nama Pemilik',
                'No Sertifikat',
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

            return view('sarpras.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                ['label' => 'No', 'no-export' => false, 'width' => 10],
                'Nama Lembaga',
                'Luas Lahan',
                'Luas Bangunan',
                'Nama Pemilik',
                'No Sertifikat',
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

            return view('sarpras.index')->with(compact('heads', 'config', 'result'));
        }
    }

    public function create(){
        $config_date = ['format' => 'YYYY-MM-DD'];
        $client = new Client(['base_uri' => env('API_HOST')]);
        $lembaga = $client->request('GET', 'lembaga/');
        $lembaga = json_decode($lembaga->getBody());
        if (property_exists($lembaga, 'data')){
            $lembaga = $lembaga->data;
            return view('sarpras.create')->with(compact('config_date', 'lembaga'));
        } else {
            return redirect(route('admin.sarpras.index'))->with('alert-failed', 'Silahkan isi data lembaga terlebih dahulu');
        }

    }

    public function store(Request $request){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'lembaga/sarpras/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nama_lahan' => $request->nama_lahan,
                    'luas_lahan' => (int)$request->luas_lahan,
                    'luas_bangunan' => (int)$request->luas_bangunan,
                    'jumlah_lantai' => (int)$request->jumlah_lantai,
                    'tahun' => (int)$request->tahun,
                    'alamat' => $request->alamat
                ]
            ]
        );
        $sarpras = json_decode($resp->getBody());
        if ($sarpras->message_id == '00'){
            return redirect(route('admin.lembaga.index'))->with('alert', $sarpras->status);
        }
        else {
            return redirect(route('admin.lembaga.index'))->with('alert-failed', $sarpras->status);
        }
    }

    public function edit($id){
        $config_date = ['format' => 'YYYY-MM-DD'];
        $client = new Client(['base_uri' => env('API_HOST')]);
        $sarpras = $client->request('GET', 'lembaga/sarpras/'.$id);
        $sarpras = json_decode($sarpras->getBody());
        $sarpras = $sarpras->data;
        $lembaga = $client->request('GET', 'lembaga/');
        $lembaga = json_decode($lembaga->getBody());
        if (property_exists($lembaga, 'data')){
            $lembaga = $lembaga->data;
            return view('sarpras.edit')->with(compact('config_date', 'lembaga', 'sarpras'));
        } else {
            return redirect(route('admin.lembaga.index'))->with('alert-failed', 'Silahkan isi data lembaga terlebih dahulu');
        }
    }

    public function update(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('PUT', 'lembaga/sarpras/edit?id_sarpras='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nama_lahan' => $request->nama_lahan,
                    'luas_lahan' => (int)$request->luas_lahan,
                    'luas_bangunan' => (int)$request->luas_bangunan,
                    'jumlah_lantai' => (int)$request->jumlah_lantai,
                    'tahun' => (int)$request->tahun,
                    'alamat' => $request->alamat
                ]
            ]
        );
        $sarpras = json_decode($resp->getBody());
        if ($sarpras->message_id == '00'){
            return redirect(route('admin.lembaga.index'))->with('alert', $sarpras->status);
        }
        else {
            return redirect(route('admin.lembaga.index'))->with('alert-failed', $sarpras->status);
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'lembaga/sarpras/hapus/'.$id);
        $resp = json_decode($resp->getBody());
        return redirect(route('admin.lembaga.index'))->with('alert',  $resp->status);
    }
}
