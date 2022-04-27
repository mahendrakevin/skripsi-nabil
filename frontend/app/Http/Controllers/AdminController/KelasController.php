<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'kelas/');
        $result = json_decode($resp->getBody());

        if (property_exists($result, 'data')){
            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){
                $btnEdit = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.kelas.edit', $resp->id),
                    'title' => 'Edit',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.kelas.destroy', $resp->id),
                    'title' => 'Delete',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                $guru = $client->request('GET', 'guru/'.$resp->id_wali_kelas);
                $guru = json_decode($guru->getBody());
                $guru = $guru->data;

                $subjectdata[] = [
                    $resp->id,
                    $resp->nama_kelas,
                    $resp->tingkat,
                    $resp->kapasitas_kelas,
                    $guru->nama_guru,
                    '<nobr>'.$btnEdit.$btnDelete.'</nobr>'
                ];
            }

            $heads = [
                ['label' => 'ID Rombel', 'no-export' => false, 'width' => 10],
                'Nama Rombel',
                'Tingkat Rombel',
                'Kapasitas Rombel',
                'Wali Rombel',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('kelas.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                ['label' => 'ID Rombel', 'no-export' => false, 'width' => 10],
                'Nama Rombel',
                'Tingkat Rombel',
                'Kapasitas Rombel',
                'Wali Rombel',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('kelas.index')->with(compact('heads', 'config', 'result'));
        }

    }

    public function create(){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'guru/');
        $result = json_decode($resp->getBody());
        $guru = $result->data;
        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('kelas.create')->with(compact('config_date', 'guru'));
    }

    public function store(Request $request){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'kelas/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nama_kelas' => $request->nama_kelas,
                    'tingkat' => $request->tingkat,
                    'kapasitas_kelas' => (int)$request->kapasitas_kelas,
                    'id_wali_kelas' => (int)$request->id_wali_kelas
                ]
            ]
        );
        $kelas = json_decode($resp->getBody());
        if ($kelas->message_id == '00'){
            return redirect(route('admin.kelas.index'))->with('alert', 'Data Berhasil Ditambahkan');
        }
        else {
            return redirect(route('admin.kelas.index'))->with('alert-failed', 'Data Gagal Ditambahkan');
        }
    }

    public function edit($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $kelas = $client->request('GET', 'kelas/'.$id);
        $kelas = json_decode($kelas->getBody());
        $resp = $client->request('GET', 'guru/');
        $result = json_decode($resp->getBody());
        $guru = $result->data;

        if($kelas->message_id == '00'){
            $kelas = $kelas->data;
            return view('kelas.edit')->with(compact( 'kelas', 'guru'));
        }
        else {
            return redirect(route('admin.kelas.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('PUT', 'kelas/edit?id_kelas='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nama_kelas' => $request->nama_kelas,
                    'tingkat' => $request->tingkat,
                    'kapasitas_kelas' => (int)$request->kapasitas_kelas,
                    'id_wali_kelas' => (int)$request->id_wali_kelas
                ]
            ]
        );
        $kapasitas_kelas = json_decode($resp->getBody());
        if ($kapasitas_kelas->message_id == '00'){
            return redirect(route('admin.kelas.index'))->with('alert', 'Data Berhasil Di Edit');
        }
        else {
            return redirect(route('admin.kelas.index'))->with('alert-failed', 'Data Gagal Di Edit');
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'kelas/hapus/'.$id);
        return redirect(route('admin.kelas.index'))->with('alert', 'Data Terhapus');
    }
}
