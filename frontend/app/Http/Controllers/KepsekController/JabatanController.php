<?php

namespace App\Http\Controllers\KepsekController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'guru/jabatan/');
        $result = json_decode($resp->getBody());
        if (property_exists($result, 'data')){
            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){

                $subjectdata[] = [
                    $resp->id,
                    $resp->nama_jabatan
                ];
            }

            $heads = [
                ['label' => 'ID Jabatan', 'no-export' => false, 'width' => 10],
                'Nama Jabatan',
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('jabatan.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                ['label' => 'ID Jabatan', 'no-export' => false, 'width' => 10],
                'Nama Jabatan'
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('jabatan.index')->with(compact('heads', 'config', 'result'));
        }

    }
}
