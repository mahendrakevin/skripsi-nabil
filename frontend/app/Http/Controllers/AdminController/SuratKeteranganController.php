<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SuratKeteranganController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'lembaga/suratketerangan/');
        $result = json_decode($resp->getBody());

        if (property_exists($result, 'data')){

            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){
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

                $lembaga = $client->request('GET', 'lembaga/'.$resp->id_lembaga);
                $lembaga = json_decode($lembaga->getBody());
                $lembaga = $lembaga->data;

                $subjectdata[] = [
                    $resp->id,
                    $lembaga->nama_lembaga,
                    $resp->nama_surat_keterangan,
                    $resp->nomor_surat_keterangan,
                    $resp->tanggal_surat_keterangan,
                    '<nobr>'.$btnEdit.$btnDelete.'</nobr>'
                ];
            }

            $heads = [
                ['label' => 'No', 'no-export' => false, 'width' => 10],
                'Nama Lembaga',
                'Surat Keterangan',
                'Nomor Surat',
                'Tanggal Surat',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('sklembaga.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                ['label' => 'No', 'no-export' => false, 'width' => 10],
                'Nama Lembaga',
                'Surat Keterangan',
                'Nomor Surat',
                'Tanggal Surat',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('sklembaga.index')->with(compact('heads', 'config', 'result'));
        }
    }

    public function create(){
        $config_date = ['format' => 'YYYY-MM-DD'];
        $client = new Client(['base_uri' => env('API_HOST')]);
        $lembaga = $client->request('GET', 'lembaga/');
        $lembaga = json_decode($lembaga->getBody());
        if (property_exists($lembaga, 'data')){
            $lembaga = $lembaga->data;
            return view('sklembaga.create')->with(compact('config_date', 'lembaga'));
        } else {
            return redirect(route('admin.surat_keterangan.index'))->with('alert-failed', 'Silahkan isi data lembaga terlebih dahulu');
        }

    }

    public function store(Request $request){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'lembaga/suratketerangan/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'id_lembaga' => (int)$request->id_lembaga,
                    'nama_surat_keterangan' => $request->nama_surat_keterangan,
                    'nomor_surat_keterangan' => $request->nomor_surat_keterangan,
                    'tanggal_surat_keterangan' => $request->tanggal_surat_keterangan,
                ]
            ]
        );
        $sarpras = json_decode($resp->getBody());
        if ($sarpras->message_id == '00'){
            return redirect(route('admin.surat_keterangan.index'))->with('alert', $sarpras->status);
        }
        else {
            return redirect(route('admin.surat_keterangan.index'))->with('alert-failed', $sarpras->status);
        }
    }

    public function edit($id){
        $config_date = ['format' => 'YYYY-MM-DD'];
        $client = new Client(['base_uri' => env('API_HOST')]);
        $sklembaga = $client->request('GET', 'lembaga/suratketerangan/'.$id);
        $sklembaga = json_decode($sklembaga->getBody());
        $sklembaga = $sklembaga->data;
        $lembaga = $client->request('GET', 'lembaga/');
        $lembaga = json_decode($lembaga->getBody());
        if (property_exists($lembaga, 'data')){
            $lembaga = $lembaga->data;
            return view('sklembaga.edit')->with(compact('config_date', 'lembaga', 'sklembaga'));
        } else {
            return redirect(route('admin.surat_keterangan.index'))->with('alert-failed', 'Silahkan isi data lembaga terlebih dahulu');
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
                    'id_lembaga' => (int)$request->id_lembaga,
                    'luas_lahan' => (int)$request->luas_lahan,
                    'luas_bangunan' => (int)$request->luas_bangunan,
                    'nama_pemilik' => $request->nama_pemilik,
                    'no_sertifikat' => $request->no_sertifikat,
                ]
            ]
        );
        $sarpras = json_decode($resp->getBody());
        if ($sarpras->message_id == '00'){
            return redirect(route('admin.sarpras.index'))->with('alert', $sarpras->status);
        }
        else {
            return redirect(route('admin.sarpras.index'))->with('alert-failed', $sarpras->status);
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'lembaga/sarpras/hapus/'.$id);
        $resp = json_decode($resp->getBody());
        return redirect(route('admin.lembaga.index'))->with('alert',  $resp->status);
    }
}
