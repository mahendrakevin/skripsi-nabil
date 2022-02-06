<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'siswa/');
        $result = json_decode($resp->getBody());
        $result = $result->data;

        $heads = [
            'NISN',
            'Nama',
            'Status Siswa',
            ['label' => 'Actions', 'no-export' => false, 'width' => 10],
        ];

        $config = [
            'data' => $result,
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, ['orderable' => false]],
        ];

        return view('siswa.index')->with(compact('heads', 'config', 'result'));
    }
}
