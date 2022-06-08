<?php

namespace App\Http\Controllers\KepsekController;

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

                $subjectdata[] = [
                    $resp->id,
                    $resp->nama_surat,
                    $resp->nomor_surat,
                    $resp->tanggal_surat,
                    $resp->jenis_surat,
                    $resp->keterangan,
                    $resp->lampiran
                ];
            }

            $heads = [
                ['label' => 'ID Jenis Pembayaran', 'no-export' => false, 'width' => 10],
                'Nama Surat',
                'Nomor Surat',
                'Tanggal',
                'Jenis Surat',
                'Keterangan',
                'Lampiran'
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, null, null],
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
                'Lampiran'
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, null, null, null],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('arsipsurat.index')->with(compact('heads', 'config', 'result'));
        }
    }
}
