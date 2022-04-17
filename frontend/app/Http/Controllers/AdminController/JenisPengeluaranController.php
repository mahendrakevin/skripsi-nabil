<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class JenisPengeluaranController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'dana/jen/');
        $result = json_decode($resp->getBody());

        if (property_exists($result, 'data')){
            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){
                $btnEdit = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.sumber_dana.edit', $resp->id),
                    'title' => 'Edit',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.sumber_dana.destroy', $resp->id),
                    'title' => 'Delete',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                $subjectdata[] = [
                    $resp->id,
                    $resp->nama_dana,
                    '<nobr>'.$btnEdit.$btnDelete.'</nobr>'
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

            return view('jen.index')->with(compact('heads', 'config', 'result'));
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

            return view('jen.index')->with(compact('heads', 'config', 'result'));
        }

    }

    public function create(){
        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('jen.create')->with(compact('config_date'));
    }

    public function store(Request $request){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'dana/jen/tambah',[
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
            return redirect(route('admin.sumber_dana.index'))->with('alert', 'Data Berhasil Ditambahkan');
        }
        else {
            return redirect(route('admin.sumber_dana.index'))->with('alert-failed', 'Data Gagal Ditambahkan');
        }
    }

    public function edit($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $jen = $client->request('GET', 'dana/jen/'.$id);
        $jen = json_decode($jen->getBody());

        if($jen->message_id == '00'){
            $jen = $jen->data;
            return view('jen.edit')->with(compact( 'jen'));
        }
        else {
            return redirect(route('admin.sumber_dana.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('PUT', 'dana/jen/edit?id_jen='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nama_dana' => $request->nama_dana,
                ]
            ]
        );
        $jen = json_decode($resp->getBody());
        if ($jen->message_id == '00'){
            return redirect(route('admin.sumber_dana.index'))->with('alert', 'Data Berhasil Di Edit');
        }
        else {
            return redirect(route('admin.sumber_dana.index'))->with('alert-failed', 'Data Gagal Di Edit');
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'dana/jen/hapus/'.$id);
        return redirect(route('admin.sumber_dana.index'))->with('alert', 'Data Terhapus');
    }
}
