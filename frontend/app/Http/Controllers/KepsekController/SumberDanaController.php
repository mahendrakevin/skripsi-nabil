<?php

namespace App\Http\Controllers\KepsekController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SumberDanaController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'dana/sumberdana/');
        $result = json_decode($resp->getBody());

        if (property_exists($result, 'data')){
            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){

                $subjectdata[] = [
                    $resp->id,
                    $resp->nama_dana,
                    '<nobr></nobr>'
                ];
            }

            $heads = [
                ['label' => 'ID Sumber Dana', 'no-export' => false, 'width' => 10],
                'Sumber Dana',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('sumberdana.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                ['label' => 'ID Sumber Dana', 'no-export' => false, 'width' => 10],
                'Sumber Dana',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('sumberdana.index')->with(compact('heads', 'config', 'result'));
        }

    }

    public function create(){
        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('sumberdana.create')->with(compact('config_date'));
    }

    public function store(Request $request){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'dana/sumberdana/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nama_dana' => $request->nama_dana
                ]
            ]
        );
        $sumberadna = json_decode($resp->getBody());
        if ($sumberadna->message_id == '00'){
            return redirect(route('kepsek.sumber_dana.index'))->with('alert', 'Data Berhasil Ditambahkan');
        }
        else {
            return redirect(route('kepsek.sumber_dana.index'))->with('alert-failed', 'Data Gagal Ditambahkan');
        }
    }

    public function edit($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $sumberdana = $client->request('GET', 'dana/sumberdana/'.$id);
        $sumberdana = json_decode($sumberdana->getBody());

        if($sumberdana->message_id == '00'){
            $sumberdana = $sumberdana->data;
            return view('sumberdana.edit')->with(compact( 'sumberdana'));
        }
        else {
            return redirect(route('kepsek.sumber_dana.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('PUT', 'dana/sumberdana/edit?id_sumberdana='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nama_dana' => $request->nama_dana,
                ]
            ]
        );
        $sumberdana = json_decode($resp->getBody());
        if ($sumberdana->message_id == '00'){
            return redirect(route('kepsek.sumber_dana.index'))->with('alert', 'Data Berhasil Di Edit');
        }
        else {
            return redirect(route('kepsek.sumber_dana.index'))->with('alert-failed', 'Data Gagal Di Edit');
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'dana/sumberdana/hapus/'.$id);
        return redirect(route('kepsek.sumber_dana.index'))->with('alert', 'Data Terhapus');
    }
}
