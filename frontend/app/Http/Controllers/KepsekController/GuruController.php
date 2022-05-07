<?php

namespace App\Http\Controllers\KepsekController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'guru/');
        $result = json_decode($resp->getBody());
        if (property_exists($result, 'data')){
            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){
                $btnShow = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('kepsek.guru.show', $resp->id),
                    'title' => 'Detail',
                    'icon' => 'fa fa-lg fa-fw fa-eye',
                    'class' => 'btn btn-xs btn-default text-teal mx-1 shadow']);

                $subjectdata[] = [
                    $resp->nip,
                    $resp->nuptk,
                    $resp->nama_guru,
                    $resp->jenis_kelamin,
                    '<nobr>'.$btnShow.'</nobr>'
                ];
            }

            $heads = [
                'NIP',
                'NUPTK',
                'Nama Guru',
                'Jenis Kelamin',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('guru.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                'NIP',
                'NUPTK',
                'Nama Guru',
                'Jenis Kelamin',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('guru.index')->with(compact('heads', 'config', 'result'));
        }
    }

    public function show($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $guru = $client->request('GET', 'guru/'.$id);
        $guru = json_decode($guru->getBody());
        $config_date = ['format' => 'YYYY-MM-DD'];

        if($guru->message_id == '00'){
            $guru = $guru->data;
            $resp = $client->request('GET', 'guru/kepegawaian/?id_guru='.(int)$id);
            $result = json_decode($resp->getBody());
            if (property_exists($result, 'data')) {
                $result = $result->data;
                $subjectdata = array();
                foreach ($result as $resp) {

                    $guru = $client->request('GET', 'guru/' . $resp->id_guru);
                    $guru = json_decode($guru->getBody());
                    $guru = $guru->data;

                    $jabatan = $client->request('GET', 'guru/jabatan/' . $resp->id_jabatan);
                    $jabatan = json_decode($jabatan->getBody());
                    $jabatan = $jabatan->data;

                    $subjectdata[] = [
                        $resp->tanggal,
                        $guru->nuptk,
                        $jabatan->nama_jabatan,
                        $resp->no_sk,
                        $resp->kategori_sk,
                        $resp->jumlah_ajar
                    ];
                }

                $heads = [
                    'Tanggal SK',
                    'NUPTK',
                    'Jabatan',
                    'No SK',
                    'Kategori SK',
                    'Jumlah Ajar'
                ];

                $config = [
                    'data' => $subjectdata,
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null],
                    'paging' => true,
                    'lengthMenu' => [10, 50, 100, 500]
                ];
            } else {
                $heads = [
                    'Tanggal SK',
                    'NUPTK',
                    'Jabatan',
                    'No SK',
                    'Kategori SK',
                    'Jumlah Ajr'
                ];

                $config = [
                    'data' => [],
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null],
                    'paging' => true,
                    'lengthMenu' => [10, 50, 100, 500]
                ];
            }
            return view('guru.show')->with(compact( 'guru', 'heads', 'config', 'result', 'jabatan', 'config_date'));
        }
        else {
            return redirect(route('kepsek.guru.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

}
