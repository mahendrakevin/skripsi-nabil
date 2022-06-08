<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ArsipSuratController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'arsipsurat/');
        $result = json_decode($resp->getBody());

        if (property_exists($result, 'data')){

            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){
                $btnEdit = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.arsip_surat.edit', $resp->id),
                    'title' => 'Edit',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.arsip_surat.destroy', $resp->id),
                    'title' => 'Hapus',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                $subjectdata[] = [
                    $resp->id,
                    $resp->nama_surat,
                    $resp->nomor_surat,
                    $resp->tanggal_surat,
                    $resp->jenis_surat,
                    $resp->keterangan,
                    $resp->lampiran,
                    '<nobr>'.$btnEdit.$btnDelete.'</nobr>'
                ];
            }

            $heads = [
                ['label' => 'ID Jenis Pembayaran', 'no-export' => false, 'width' => 10],
                'Nama Surat',
                'Nomor Surat',
                'Tanggal',
                'Jenis Surat',
                'Keterangan',
                'Lampiran',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('arsipsurat.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                ['label' => 'ID Jenis Pembayaran', 'no-export' => false, 'width' => 10],
                'Nama Surat',
                'Nomor Surat',
                'Tanggal',
                'Jenis Surat',
                'Keterangan',
                'Lampiran',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('arsipsurat.index')->with(compact('heads', 'config', 'result'));
        }
    }

    public function create(){
        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('arsipsurat.create')->with(compact('config_date'));
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'lampiran' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
        ]);

        $path = $request->file('lampiran')->store('public/files');
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'arsipsurat/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nama_surat' => $request->nama_surat,
                    'nomor_surat' => $request->nomor_surat,
                    'tanggal_surat' => $request->tanggal_surat,
                    'jenis_surat' => $request->jenis_surat,
                    'keterangan' => $request->keterangan,
                    'lampiran' => $path
                ]
            ]
        );
        $arsipsurat = json_decode($resp->getBody());
        if ($arsipsurat->message_id == '00'){
            return redirect(route('admin.arsip_surat.index'))->with('alert', $arsipsurat->status);
        }
        else {
            return redirect(route('admin.arsip_surat.index'))->with('alert-failed', $arsipsurat->status);
        }
    }

    public function edit($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $arsipsurat = $client->request('GET', 'arsipsurat/'.$id);
        $arsipsurat = json_decode($arsipsurat->getBody());

        if($arsipsurat->message_id == '00'){
            $arsipsurat = $arsipsurat->data;
            $config_date = ['format' => 'YYYY-MM-DD'];
            return view('arsipsurat.edit')->with(compact( 'arsipsurat', 'config_date'));
        }
        else {
            return redirect(route('admin.arsip_surat.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $arsipsurat = $client->request('GET', 'arsipsurat/'.$id);
        $arsipsurat = json_decode($arsipsurat->getBody());
        $arsipsurat = $arsipsurat->data;
        $resp = $client->request('PUT', 'arsipsurat/edit?id_arsipsurat='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nama_surat' => $request->nama_surat,
                    'nomor_surat' => $request->nomor_surat,
                    'tanggal_surat' => $request->tanggal_surat,
                    'jenis_surat' => $request->jenis_surat,
                    'keterangan' => $request->keterangan,
                    'lampiran' => $arsipsurat->lampiran
                ]
            ]
        );
        $arsipsurat = json_decode($resp->getBody());
        if ($arsipsurat->message_id == '00'){
            return redirect(route('admin.arsip_surat.index'))->with('alert', $arsipsurat->status);
        }
        else {
            return redirect(route('admin.arsip_surat.index'))->with('alert-failed', $arsipsurat->status);
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'arsipsurat/hapus/'.$id);
        return redirect(route('admin.arsip_surat.index'))->with('alert',  'Data terhapus');
    }
}
