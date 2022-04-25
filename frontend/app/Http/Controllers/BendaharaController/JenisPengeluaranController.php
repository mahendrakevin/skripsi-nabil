<?php

namespace App\Http\Controllers\BendaharaController;

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
                $btnEdit = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('bendahara.jenis_pengeluaran.edit', $resp->id),
                    'title' => 'Edit',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('bendahara.jenis_pengeluaran.destroy', $resp->id),
                    'title' => 'Delete',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                $subjectdata[] = [
                    $resp->id,
                    $resp->jenis_pengeluaran,
                    '<nobr>'.$btnEdit.$btnDelete.'</nobr>'
                ];
            }

            $heads = [
                ['label' => 'ID Jenis Pengeluaran', 'no-export' => false, 'width' => 10],
                'Jenis Pengeluaran',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('jenispengeluaran.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                ['label' => 'ID Jenis Pengeluaran', 'no-export' => false, 'width' => 10],
                'Jenis Pengeluaran',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
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
            return redirect(route('bendahara.jenis_pengeluaran.index'))->with('alert', 'Data Berhasil Ditambahkan');
        }
        else {
            return redirect(route('bendahara.jenis_pengeluaran.index'))->with('alert-failed', 'Data Gagal Ditambahkan');
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
            return redirect(route('bendahara.jenis_pengeluaran.index'))->with('alert-failed', 'Data tidak ditemukan');
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
            return redirect(route('bendahara.jenis_pengeluaran.index'))->with('alert', 'Data Berhasil Di Edit');
        }
        else {
            return redirect(route('bendahara.jenis_pengeluaran.index'))->with('alert-failed', 'Data Gagal Di Edit');
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'dana/jenispengeluaran/hapus/'.$id);
        return redirect(route('bendahara.jenis_pengeluaran.index'))->with('alert', 'Data Terhapus');
    }
}
