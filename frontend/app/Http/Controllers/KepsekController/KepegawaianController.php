<?php

namespace App\Http\Controllers\KepsekController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class KepegawaianController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'guru/kepegawaian/');
        $result = json_decode($resp->getBody());
        if (property_exists($result, 'data')){
            $result = $result->data;
            $subjectdata = array();
            foreach ($result as $resp){
                $btnShow = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('kepsek.guru.show', $resp->id_guru),
                    'title' => 'Lihat',
                    'id' => 'lihat',
                    'onclick' => '',
                    'icon' => 'fa fa-lg fa-fw fa-eye',
                    'class' => 'btn btn-xs btn-default text-teal mx-1 shadow']);

                $guru = $client->request('GET', 'guru/'.$resp->id_guru);
                $guru = json_decode($guru->getBody());
                $guru = $guru->data;

                $jabatan = $client->request('GET', 'guru/jabatan/'.$resp->id_jabatan);
                $jabatan = json_decode($jabatan->getBody());
                $jabatan = $jabatan->data;

                $subjectdata[] = [
                    $guru->nama_guru,
                    $guru->nuptk,
                    $jabatan->nama_jabatan,
                    $resp->no_sk,
                    $resp->kategori_sk,
                    '<nobr>'.$btnShow.'</nobr>'
                ];
            }

            $heads = [
                'Nama Guru',
                'NUPTK',
                'Jabatan',
                'No SK',
                'Kategori SK',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('skguru.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                'Nama Guru',
                'NUPTK',
                'Jabatan',
                'No SK',
                'Kategori SK',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('skguru.index')->with(compact('heads', 'config', 'result'));
        }
    }

    public function show($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $guru = $client->request('GET', 'guru/'.$id);
        $guru = json_decode($guru->getBody());

        $kepegawaian = $client->request('GET', 'guru/kepegawaian/'.$id);
        $kepegawaian = json_decode($kepegawaian->getBody());

        $jabatan = $client->request('GET', 'guru/jabatan/');
        $jabatan = json_decode($jabatan->getBody());
        $jabatan = $jabatan->data;
        $config_date = ['format' => 'YYYY-MM-DD'];

        if($guru->message_id == '00'){
            $guru = $guru->data;
            $kepegawaian = $kepegawaian->data;
            return view('guru.show')->with(compact( 'guru', 'kepegawaian', 'jabatan', 'config_date'));
        }
        else {
            return redirect(route('kepsek.guru.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }
}
