<?php

namespace App\Http\Controllers\KepsekController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class JenisPengeluaranController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'dana/jenispengeluaran/');
        $result = json_decode($resp->getBody());

        if (property_exists($result, 'data')){
            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){

                $subjectdata[] = [
                    $resp->id,
                    $resp->jenis_pengeluaran
                ];
            }

            $heads = [
                ['label' => 'ID Jenis Pengeluaran', 'no-export' => false, 'width' => 10],
                'Jenis Pengeluaran'
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('jenispengeluaran.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                ['label' => 'ID Jenis Pengeluaran', 'no-export' => false, 'width' => 10],
                'Jenis Pengeluaran'
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('jenispengeluaran.index')->with(compact('heads', 'config', 'result'));
        }

    }

    public function create(){
        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('jenispengeluaran.create')->with(compact('config_date'));
    }

    public function store(Request $request){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'dana/jenispengeluaran/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'jenis_pengeluaran' => $request->jenis_pengeluaran
                ]
            ]
        );
        $sumberadna = json_decode($resp->getBody());
        if ($sumberadna->message_id == '00'){
            return redirect(route('kepsek.jenis_pengeluaran.index'))->with('alert', 'Data Berhasil Ditambahkan');
        }
        else {
            return redirect(route('kepsek.jenis_pengeluaran.index'))->with('alert-failed', 'Data Gagal Ditambahkan');
        }
    }

    public function edit($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $jenispengeluaran = $client->request('GET', 'dana/jenispengeluaran/'.$id);
        $jenispengeluaran = json_decode($jenispengeluaran->getBody());

        if($jenispengeluaran->message_id == '00'){
            $jenispengeluaran = $jenispengeluaran->data;
            return view('jenispengeluaran.edit')->with(compact( 'jenispengeluaran'));
        }
        else {
            return redirect(route('kepsek.jenis_pengeluaran.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('PUT', 'dana/jenispengeluaran/edit?id_jenispengeluaran='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'jenis_pengeluaran' => $request->jenis_pengeluaran,
                ]
            ]
        );
        $jenispengeluaran = json_decode($resp->getBody());
        if ($jenispengeluaran->message_id == '00'){
            return redirect(route('kepsek.jenis_pengeluaran.index'))->with('alert', 'Data Berhasil Di Edit');
        }
        else {
            return redirect(route('kepsek.jenis_pengeluaran.index'))->with('alert-failed', 'Data Gagal Di Edit');
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'dana/jenispengeluaran/hapus/'.$id);
        return redirect(route('kepsek.jenis_pengeluaran.index'))->with('alert', 'Data Terhapus');
    }
}
