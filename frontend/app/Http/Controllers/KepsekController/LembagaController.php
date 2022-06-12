<?php

namespace App\Http\Controllers\KepsekController;

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
            $resp = $client->request('GET', 'lembaga/sarpras/1');
            $sarpras = json_decode($resp->getBody());
            $aset = $client->request('GET', 'lembaga/aset/');
            $aset = json_decode($aset->getBody());
            $sarpras = $sarpras->data;
            if (property_exists($aset, 'data')){
                $aset = $aset->data;

                $subjectdata = array();
                foreach ($aset as $resp){
                    $btnEdit = view('components.Button', [
                        'method' => 'GET',
                        'action' => route('admin.aset.edit', $resp->id),
                        'title' => 'Edit',
                    'id' => 'edit',
                    'onclick' => '',
                        'icon' => 'fa fa-lg fa-fw fa-pen',
                        'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                    $btnDelete = view('components.Button', [
                        'method' => 'GET',
                        'action' => route('admin.aset.destroy', $resp->id),
                        'title' => 'Hapus',
                    'id' => 'hapus',
                    'onclick' => 'return confirm_delete()',
                        'icon' => 'fa fa-lg fa-fw fa-trash',
                        'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                    $subjectdata[] = [
                        $resp->id,
                        $resp->jenis_ruangan,
                        $resp->nama_ruangan,
                        $resp->tahun,
                        $resp->panjang,
                        $resp->lebar,
                        '<nobr>'.$btnEdit.$btnDelete.'</nobr>'
                    ];
                }

                $heads = [
                    ['label' => 'No', 'no-export' => false, 'width' => 10],
                    'Nama Lembaga',
                    'Luas Lahan',
                    'Luas Bangunan',
                    'Nama Pemilik',
                    'No Sertifikat',
                    ['label' => 'Actions', 'no-export' => false, 'width' => 10],
                ];

                $config = [
                    'data' => $subjectdata,
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null, ['orderable' => false]],
                    'paging' => true,
                    'lengthMenu' => [ 10, 50, 100, 500],
                    'language' => ['search' => 'Cari Data']
                ];

                return view('lembaga.index')->with(compact('result', 'sk', 'sarpras', 'heads', 'config'));
            } else {
                $heads = [
                    ['label' => 'No', 'no-export' => false, 'width' => 10],
                    'Nama Lembaga',
                    'Luas Lahan',
                    'Luas Bangunan',
                    'Nama Pemilik',
                    'No Sertifikat',
                    ['label' => 'Actions', 'no-export' => false, 'width' => 10],
                ];

                $config = [
                    'data' => [],
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null, ['orderable' => false]],
                    'paging' => true,
                    'lengthMenu' => [ 10, 50, 100, 500],
                    'language' => ['search' => 'Cari Data']
                ];

                return view('lembaga.index')->with(compact('result', 'sk', 'heads', 'config', 'sarpras'));

            }
        } else {

            return view('lembaga.index')->with(compact('result', 'sk'));
        }
    }
}
