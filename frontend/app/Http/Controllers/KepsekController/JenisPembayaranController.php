<?php

namespace App\Http\Controllers\KepsekController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class JenisPembayaranController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'pembayaransiswa/jenispembayaran/');
        $result = json_decode($resp->getBody());
        if (property_exists($result, 'data')){
            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){

                $subjectdata[] = [
                    $resp->id,
                    $resp->jenis_pembayaran,
                    $resp->nominal_pembayaran
                ];
            }

            $heads = [
                ['label' => 'ID Jenis Pembayaran', 'no-export' => false, 'width' => 10],
                'Jenis Pembayaran',
                'Nominal Pembayaran'
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('jenispembayaran.index')->with(compact('heads', 'config', 'result'));
        }
        else {
            $heads = [
                ['label' => 'ID Jenis Pembayaran', 'no-export' => false, 'width' => 10],
                'Jenis Pembayaran',
                'Nominal Pembayaran'
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];
            return view('jenispembayaran.index')->with(compact('heads', 'config', 'result'));
        }
    }
}
