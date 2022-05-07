<?php

namespace App\Http\Controllers\KepsekController;

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

        if (property_exists($result, 'data')){

            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){
                $btnShow = view('components.button', [
                    'method' => 'GET',
                    'action' => route('kepsek.siswa.show', $resp->id),
                    'title' => 'Detail',
                    'icon' => 'fa fa-lg fa-fw fa-eye',
                    'class' => 'btn btn-xs btn-default text-teal mx-1 shadow']);

                $subjectdata[] = [
                    $resp->nis,
                    $resp->nisn,
                    $resp->nama_siswa,
                    $resp->jenis_kelamin,
                    $resp->status_siswa,
                    '<nobr>'.$btnShow.'</nobr>'
                ];
            }

            $heads = [
                'NIS',
                'NISN',
                'Nama',
                'Jenis Kelamin',
                'Status Siswa',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('siswa.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                'NIS',
                'NISN',
                'Nama',
                'Jenis Kelamin',
                'Status Siswa',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('siswa.index')->with(compact('heads', 'config', 'result'));
        }
    }
    public function index_alumni()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'siswa/alumni/');
        $result = json_decode($resp->getBody());

        if (property_exists($result, 'data')){

            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){

                $subjectdata[] = [
                    $resp->nis,
                    $resp->nisn,
                    $resp->nama_siswa,
                    $resp->jenis_kelamin,
                    $resp->status_siswa
                ];
            }

            $heads = [
                'NIS',
                'NISN',
                'Nama',
                'Jenis Kelamin',
                'Status Siswa'
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('alumni.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                'NIS',
                'NISN',
                'Nama',
                'Jenis Kelamin',
                'Status Siswa'
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('alumni.index')->with(compact('heads', 'config', 'result'));
        }
    }

    public function show($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $siswa = $client->request('GET', 'siswa/'.$id);
        $siswa = json_decode($siswa->getBody());

        $walisiswa = $client->request('GET', 'walisiswa/'.$id);
        $walisiswa = json_decode($walisiswa->getBody());

        $kelas = $client->request('GET', 'kelas/');
        $kelas = json_decode($kelas->getBody());
        $kelas = $kelas->data;

        $jeniswali = $client->request('GET', 'walisiswa/jeniswali/');
        $jeniswali = json_decode($jeniswali->getBody());
        $jeniswali = $jeniswali->data;

        $config_date = ['format' => 'YYYY-MM-DD'];

        if($siswa->message_id == '00'){
            $siswa = $siswa->data;
            $walisiswa = $walisiswa->data;
            $resp = $client->request('GET', 'pembayaransiswa/?id_siswa='.(int)$siswa->id);
            $result = json_decode($resp->getBody());

            if (property_exists($result, 'data')){

                $result = $result->data;
                $subjectdata = array();

                foreach ($result as $resp){

                    $btnEdit = view('components.button', [
                        'method' => 'GET',
                        'action' => route('admin.laporan_pembayaran.edit', $resp->id),
                        'title' => 'Edit',
                        'icon' => 'fa fa-lg fa-fw fa-pen',
                        'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                    $btnDelete = view('components.button', [
                        'method' => 'GET',
                        'action' => route('admin.laporan_pembayaran.destroy', $resp->id),
                        'title' => 'Delete',
                        'icon' => 'fa fa-lg fa-fw fa-trash',
                        'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                    $siswa = $client->request('GET', 'siswa/'.$resp->id_siswa);
                    $siswa = json_decode($siswa->getBody());
                    $siswa = $siswa->data;

                    $jenis_pembayaran = $client->request('GET', 'pembayaransiswa/jenispembayaran/'.$resp->id_jenispembayaran);
                    $jenis_pembayaran = json_decode($jenis_pembayaran->getBody());
                    $jenis_pembayaran = $jenis_pembayaran->data;

                    $subjectdata[] = [
                        $resp->created_format,
                        $siswa->nama_siswa,
                        $jenis_pembayaran->jenis_pembayaran,
                        $jenis_pembayaran->nominal_pembayaran,
                        $resp->nominal_pembayaran,
                        $resp->status_pembayaran
                    ];
                }

                $heads = [
                    'Tanggal Pembayaran',
                    'Nama Siswa',
                    'Jenis',
                    'Nominal Tagihan',
                    'Nominal Terbayar',
                    'Status Pembayaran',
                ];

                $config = [
                    'data' => $subjectdata,
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null],
                    'paging' => true,
                    'lengthMenu' => [ 10, 50, 100, 500]
                ];
            } else {
                $heads = [
                    'Tanggal Pembayaran',
                    'Nama Siswa',
                    'Jenis',
                    'Nominal Tagihan',
                    'Nominal Terbayar',
                    'Status Pembayaran'
                ];

                $config = [
                    'data' => [],
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null],
                    'paging' => true,
                    'lengthMenu' => [ 10, 50, 100, 500]
                ];
            }

            return view('siswa.show')->with(compact('siswa', 'config', 'heads', 'walisiswa', 'kelas', 'jeniswali', 'config_date'));
        }
        else {
            return redirect(route('kepsek.siswa.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

}
