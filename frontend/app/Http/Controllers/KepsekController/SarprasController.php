<?php

namespace App\Http\Controllers\KepsekController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SarprasController extends Controller

{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'lembaga/sarpras/');
        $result = json_decode($resp->getBody());

        if (property_exists($result, 'data')){

            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){

                $lembaga = $client->request('GET', 'lembaga/'.$resp->id_lembaga);
                $lembaga = json_decode($lembaga->getBody());
                $lembaga = $lembaga->data;

                $subjectdata[] = [
                    $resp->id,
                    $lembaga->nama_lembaga,
                    $resp->luas_lahan,
                    $resp->luas_bangunan,
                    $resp->nama_pemilik,
                    $resp->no_sertifikat,
                    '<nobr></nobr>'
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
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('sarpras.index')->with(compact('heads', 'config', 'result'));
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
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('sarpras.index')->with(compact('heads', 'config', 'result'));
        }
    }
}
