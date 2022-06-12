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
        $resp = $client->request('GET', 'arsipsurat/masuk/');
        $result = json_decode($resp->getBody());

        $keluar = $client->request('GET', 'arsipsurat/keluar/');
        $keluar = json_decode($keluar->getBody());

        $heads = [
            ['label' => 'ID Jenis Pembayaran', 'no-export' => false, 'width' => 10],
            'Judul Surat',
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

        $heads_keluar = [
            ['label' => 'ID Jenis Pembayaran', 'no-export' => false, 'width' => 10],
            'Judul Surat',
            'Nomor Surat',
            'Tanggal',
            'Jenis Surat',
            'Keterangan',
            'Lampiran'
        ];

        $config_keluar = [
            'data' => [],
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, null, null, null, ['orderable' => false]],
            'paging' => true,
            'lengthMenu' => [ 10, 50, 100, 500],
            'language' => ['search' => 'Cari Data']
        ];

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
                ['label' => 'ID Arsip Surat', 'no-export' => false, 'width' => 10],
                'Judul Surat',
                'Nomor Surat',
                'Tanggal',
                'Jenis Surat',
                'Keterangan',
                'Lampiran'
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];
        }
        if (property_exists($keluar, 'data')) {

            $keluar = $keluar->data;
            $subjectdata2 = array();

            foreach ($keluar as $resp){

                $subjectdata2[] = [
                    $resp->id,
                    $resp->nama_surat,
                    $resp->nomor_surat,
                    $resp->tanggal_surat,
                    $resp->jenis_surat,
                    $resp->keterangan,
                    $resp->lampiran
                ];
            }
            $heads_keluar = [
                ['label' => 'ID Arsip Surat', 'no-export' => false, 'width' => 10],
                'Judul Surat',
                'Nomor Surat',
                'Tanggal',
                'Jenis Surat',
                'Keterangan',
                'Lampiran'
            ];

            $config_keluar = [
                'data' => $subjectdata2,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

        }

        return view('arsipsurat.index')->with(compact('heads', 'config', 'result', 'heads_keluar', 'config_keluar'));
    }
}
