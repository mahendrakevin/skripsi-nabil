<?php

namespace App\Http\Controllers\KepsekController;

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

                $subjectdata[] = [
                    $resp->id,
                    $resp->nama_kelas,
                    $resp->tingkat,
                    $resp->kapasitas_kelas
                ];
            }

            $heads = [
                ['label' => 'ID Kelas', 'no-export' => false, 'width' => 10],
                'Nama Kelas',
                'Tingkat',
                'Kapasitas Kelas'
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('kelas.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                ['label' => 'ID Kelas', 'no-export' => false, 'width' => 10],
                'Nama Kelas',
                'Tingkat',
                'Kapasitas Kelas',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('kelas.index')->with(compact('heads', 'config', 'result'));
        }

    }

}
