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
            $resp = $client->request('GET', 'lembaga/sarpras/');
            $sarpras = json_decode($resp->getBody());

            if (property_exists($sarpras, 'data')){

                $sarpras = $sarpras->data;
                $subjectdata = array();

                foreach ($sarpras as $resp){

                    $subjectdata[] = [
                        $resp->id,
                        $resp->nama_aset,
                        $resp->luas_lahan,
                        $resp->luas_bangunan,
                        $resp->nama_pemilik,
                        $resp->no_sertifikat,
                    ];
                }

                $heads_sarpras = [
                    ['label' => 'No', 'no-export' => false, 'width' => 10],
                    'Nama Lembaga',
                    'Luas Lahan',
                    'Luas Bangunan',
                    'Nama Pemilik',
                    'No Sertifikat'
                ];

                $config_sarpras = [
                    'data' => $subjectdata,
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null],
                    'paging' => true,
                    'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
                ];

                return view('lembaga.index')->with(compact('result', 'config_sarpras', 'heads_sarpras', 'sk'));
            } else {
                $heads_sarpras = [
                    ['label' => 'No', 'no-export' => false, 'width' => 10],
                    'Nama Lembaga',
                    'Luas Lahan',
                    'Luas Bangunan',
                    'Nama Pemilik',
                    'No Sertifikat'
                ];

                $config_sarpras = [
                    'data' => [],
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null],
                    'paging' => true,
                    'lengthMenu' => [10, 50, 100, 500]
                ];

                return view('lembaga.index')->with(compact('heads_sarpras', 'config_sarpras', 'result', 'sk'));

            }
        } else {

            return view('lembaga.index')->with(compact('result', 'sk'));
        }
    }
}
