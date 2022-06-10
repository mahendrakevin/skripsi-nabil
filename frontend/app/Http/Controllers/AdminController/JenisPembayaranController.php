<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class JenisPembayaranController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'pembayaransiswa/jenispembayaran/');
        $result = json_decode($resp->getBody());
        if (property_exists($result, 'data')){
            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){
                $btnEdit = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.jenispembayaran.edit', $resp->id),
                    'title' => 'Edit',
                    'id' => 'edit',
                    'onclick' => '',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.jenispembayaran.destroy', $resp->id),
                    'title' => 'Hapus',
                    'id' => 'hapus',
                    'onclick' => 'return confirm_delete()',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                $subjectdata[] = [
                    $resp->id,
                    $resp->jenis_pembayaran,
                    $resp->nominal_pembayaran,
                    '<nobr>'.$btnEdit.$btnDelete.'</nobr>'
                ];
            }

            $heads = [
                ['label' => 'ID Jenis Pembayaran', 'no-export' => false, 'width' => 10],
                'Jenis Pembayaran',
                'Nominal Pembayaran',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('jenispembayaran.index')->with(compact('heads', 'config', 'result'));
        }
        else {
            $heads = [
                ['label' => 'ID Jenis Pembayaran', 'no-export' => false, 'width' => 10],
                'Jenis Pembayaran',
                'Nominal Pembayaran',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];
            return view('jenispembayaran.index')->with(compact('heads', 'config', 'result'));
        }
    }

    public function create(){
        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('jenispembayaran.create')->with(compact('config_date'));
    }

    public function store(Request $request){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'pembayaransiswa/jenispembayaran/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'jenis_pembayaran' => $request->jenis_pembayaran,
                    'nominal_pembayaran' => (int)$request->nominal_pembayaran
                ]
            ]
        );
        $jenispembayaran = json_decode($resp->getBody());
        if ($jenispembayaran->message_id == '00'){
            return redirect(route('admin.jenispembayaran.index'))->with('alert', $jenispembayaran->status);
        }
        else {
            return redirect(route('admin.jenispembayaran.index'))->with('alert-failed', $jenispembayaran->status);
        }
    }

    public function edit($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $jenispembayaran = $client->request('GET', 'pembayaransiswa/jenispembayaran/'.$id);
        $jenispembayaran = json_decode($jenispembayaran->getBody());

        if($jenispembayaran->message_id == '00'){
            $jenispembayaran = $jenispembayaran->data;
            return view('jenispembayaran.edit')->with(compact( 'jenispembayaran'));
        }
        else {
            return redirect(route('admin.kelas.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('PUT', 'pembayaransiswa/jenispembayaran/edit?id_jenispembayaran='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'jenis_pembayaran' => $request->jenis_pembayaran,
                    'nominal_pembayaran' => (int)$request->nominal_pembayaran,
                ]
            ]
        );
        $jenispembayaran = json_decode($resp->getBody());
        if ($jenispembayaran->message_id == '00'){
            return redirect(route('admin.jenispembayaran.index'))->with('alert', $jenispembayaran->status);
        }
        else {
            return redirect(route('admin.jenispembayaran.index'))->with('alert-failed', $jenispembayaran->status);
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'pembayaransiswa/jenispembayaran/hapus/'.$id);
        return redirect(route('admin.jenispembayaran.index'))->with('alert',  'Data terhapus');
    }
}
