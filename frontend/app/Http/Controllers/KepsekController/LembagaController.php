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
        $resp = $client->request('GET', 'lembaga/');
        $result = json_decode($resp->getBody());

        if (property_exists($result, 'data')){

            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){

                $subjectdata[] = [
                    $resp->id,
                    $resp->nama_lembaga,
                    $resp->tahun_berdiri,
                    $resp->no_telp,
                    $resp->alamat,
                    $resp->email,
                    $resp->npsn,
                    $resp->nsm,
                    '<nobr></nobr>'
                ];
            }

            $heads = [
                ['label' => 'ID Jenis Pembayaran', 'no-export' => false, 'width' => 10],
                'Nama Lembaga',
                'Tanggal Berdiri',
                'No Telp',
                'Alamat',
                'Email',
                'NPSN',
                'NSM',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('lembaga.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                ['label' => 'ID Jenis Pembayaran', 'no-export' => false, 'width' => 10],
                'Nama Lembaga',
                'Tanggal Berdiri',
                'No Telp',
                'Alamat',
                'Email',
                'NPSN',
                'NSM',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('lembaga.index')->with(compact('heads', 'config', 'result'));
        }
    }
}
