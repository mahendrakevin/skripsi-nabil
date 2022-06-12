<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AsetController extends Controller

{
    public function create(){
        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('aset.create')->with(compact('config_date'));

    }

    public function store(Request $request){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'lembaga/aset/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'jenis_ruangan' => $request->jenis_ruangan,
                    'nama_ruangan' => $request->nama_ruangan,
                    'tahun' => (int)$request->tahun,
                    'panjang' => (int)$request->panjang,
                    'lebar' => (int)$request->lebar,
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
        $sarpras = $client->request('GET', 'lembaga/aset/'.$id);
        $sarpras = json_decode($sarpras->getBody());
        if (property_exists($sarpras, 'data')){
            $sarpras = $sarpras->data;
            return view('aset.edit')->with(compact('config_date', 'sarpras'));
        } else {
            return redirect(route('admin.lembaga.index'))->with('alert-failed', 'Silahkan isi data lembaga terlebih dahulu');
        }
    }

    public function update(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('PUT', 'lembaga/aset/edit?id_aset='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'jenis_ruangan' => $request->jenis_ruangan,
                    'nama_ruangan' => $request->nama_ruangan,
                    'tahun' => (int)$request->tahun,
                    'panjang' => (int)$request->panjang,
                    'lebar' => (int)$request->lebar,
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
        $resp = $client->request('DELETE', 'lembaga/aset/hapus/'.$id);
        $resp = json_decode($resp->getBody());
        return redirect(route('admin.lembaga.index'))->with('alert',  $resp->status);
    }
}
