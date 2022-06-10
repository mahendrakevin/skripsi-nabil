<?php

namespace App\Http\Controllers\KepsekController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LaporanPembayaranController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'pembayaransiswa/');
        $result = json_decode($resp->getBody());

        if (property_exists($result, 'data')){

            $result = $result->data;
            $subjectdata = array();

            foreach ($result as $resp){
                $btnShow = view('components.button', [
                    'method' => 'GET',
                    'action' => route('kepsek.siswa.show', $resp->id_siswa),
                    'title' => 'Lihat',
                    'id' => 'lihat',
                    'onclick' => '',
                    'icon' => 'fa fa-lg fa-fw fa-eye',
                    'class' => 'btn btn-xs btn-default text-teal mx-1 shadow']);

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
                    $resp->status_pembayaran,
                    '<nobr>'.$btnShow.'</nobr>'
                ];
            }

            $heads = [
                'Tanggal Pembayaran',
                'Nama Siswa',
                'Jenis',
                'Nominal Tagihan',
                'Nominal Terbayar',
                'Status Pembayaran',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('laporanpembayaran.index')->with(compact('heads', 'config', 'result'));
        } else {
            $heads = [
                'Tanggal Pembayaran',
                'Nama Siswa',
                'Jenis',
                'Nominal Tagihan',
                'Nominal Terbayar',
                'Status Pembayaran',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('laporanpembayaran.index')->with(compact('heads', 'config', 'result'));
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
            return view('siswa.show')->with(compact('siswa', 'walisiswa', 'kelas', 'jeniswali', 'config_date'));
        }
        else {
            return redirect(route('kepsek.siswa.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }
}
