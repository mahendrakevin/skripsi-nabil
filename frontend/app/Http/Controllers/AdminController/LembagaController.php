<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LembagaController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'lembaga/1');
        $result = json_decode($resp->getBody());

        $resp = $client->request('GET', 'lembaga/suratketerangan/1');
        $sk = json_decode($resp->getBody());

        if (property_exists($result, 'data') && property_exists($sk, 'data')){
            $sk = $sk->data;
            // dd($sk);
            $result = $result->data;
            $client = new Client(['base_uri' => env('API_HOST')]);
            $resp = $client->request('GET', 'lembaga/sarpras/');
            $sarpras = json_decode($resp->getBody());

            if (property_exists($sarpras, 'data')){

                $sarpras = $sarpras->data;
                $subjectdata = array();

                foreach ($sarpras as $resp){
                    $btnEdit = view('components.Button', [
                        'method' => 'GET',
                        'action' => route('admin.sarpras.edit', $resp->id),
                        'title' => 'Edit',
                        'icon' => 'fa fa-lg fa-fw fa-pen',
                        'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                    $btnDelete = view('components.Button', [
                        'method' => 'GET',
                        'action' => route('admin.sarpras.destroy', $resp->id),
                        'title' => 'Delete',
                        'icon' => 'fa fa-lg fa-fw fa-trash',
                        'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);


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

                $heads_sarpras = [
                    ['label' => 'No', 'no-export' => false, 'width' => 10],
                    'Nama Lembaga',
                    'Luas Lahan',
                    'Luas Bangunan',
                    'Nama Pemilik',
                    'No Sertifikat',
                    ['label' => 'Actions', 'no-export' => false, 'width' => 10]
                ];

                $config_sarpras = [
                    'data' => $subjectdata,
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null],
                    'paging' => true,
                    'lengthMenu' => [ 10, 50, 100, 500]
                ];

                return view('lembaga.index')->with(compact('result', 'config_sarpras', 'heads_sarpras', 'sk'));
            } else {
                $heads_sarpras = [
                    ['label' => 'No', 'no-export' => false, 'width' => 10],
                    'Nama Lembaga',
                    'Luas Lahan',
                    'Luas Bangunan',
                    'Nama Pemilik',
                    'No Sertifikat',
                    ['label' => 'Actions', 'no-export' => false, 'width' => 10],
                ];

                $config_sarpras = [
                    'data' => [],
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null, ['orderable' => false]],
                    'paging' => true,
                    'lengthMenu' => [10, 50, 100, 500]
                ];

                return view('lembaga.index')->with(compact('heads_sarpras', 'config_sarpras', 'result', 'sk'));

            }
        } else {

            return view('lembaga.index')->with(compact('result', 'sk'));
        }
    }

    public function create(){
        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('lembaga.create')->with(compact('config_date'));
    }

    public function store(Request $request){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'lembaga/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nama_lembaga' => $request->nama_lembaga,
                    'tahun_berdiri' => $request->tahun_berdiri,
                    'no_telp' => (int)$request->no_telp,
                    'alamat' => $request->alamat,
                    'email' => $request->email,
                    'npsn' => (int)$request->npsn,
                    'nsm' => (int)$request->nsm,
                ]
            ]
        );
        $lembaga = json_decode($resp->getBody());
        if ($lembaga->message_id == '00'){
            return redirect(route('admin.lembaga.index'))->with('alert', $lembaga->status);
        }
        else {
            return redirect(route('admin.lembaga.index'))->with('alert-failed', $lembaga->status);
        }
    }

    public function edit($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $lembaga = $client->request('GET', 'lembaga/'.$id);
        $lembaga = json_decode($lembaga->getBody());

        if($lembaga->message_id == '00'){
            $lembaga = $lembaga->data;
            $config_date = ['format' => 'YYYY-MM-DD'];
            return view('lembaga.edit')->with(compact( 'lembaga', 'config_date'));
        }
        else {
            return redirect(route('admin.lembaga.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('PUT', 'lembaga/edit?id_lembaga='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nama_lembaga' => $request->nama_lembaga,
                    'akreditasi' => $request->akreditasi,
                    'tahun_berdiri' => $request->tahun_berdiri,
                    'no_telp' => (int)$request->no_telp,
                    'alamat' => $request->alamat,
                    'email' => $request->email,
                    'npsn' => (int)$request->npsn,
                    'nsm' => (int)$request->nsm,
                ]
            ]
        );
        $lembaga = json_decode($resp->getBody());
        if ($lembaga->message_id == '00'){
            return redirect(route('admin.lembaga.index'))->with('alert', $lembaga->status);
        }
        else {
            return redirect(route('admin.lembaga.index'))->with('alert-failed', $lembaga->status);
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'lembaga/hapus/'.$id);
        $resp = $client->request('DELETE', 'lembaga/sarpras/hapus_lembaga/'.$id);
        return redirect(route('admin.lembaga.index'))->with('alert',  'Data terhapus');
    }
}
