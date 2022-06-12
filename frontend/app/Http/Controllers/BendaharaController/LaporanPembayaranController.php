<?php

namespace App\Http\Controllers\BendaharaController;

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

                $btnEdit = view('components.button', [
                    'method' => 'GET',
                    'action' => route('bendahara.laporan_pembayaran.edit', $resp->id),
                    'title' => 'Edit',
                    'id' => 'edit',
                    'onclick' => '',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete = view('components.button', [
                    'method' => 'GET',
                    'action' => route('bendahara.laporan_pembayaran.destroy', $resp->id),
                    'title' => 'Hapus',
                    'id' => 'hapus',
                    'onclick' => 'return confirm_delete()',
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
                    $resp->status_pembayaran,
                    '<nobr>'.$btnEdit.$btnDelete.'</nobr>'
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

    public function create(){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $siswa = $client->request('GET', 'siswa/');
        $siswa = json_decode($siswa->getBody());
        $siswa = $siswa->data;

        $jenis_pembayaran = $client->request('GET', 'pembayaransiswa/jenispembayaran/');
        $jenis_pembayaran = json_decode($jenis_pembayaran->getBody());
        $jenis_pembayaran = $jenis_pembayaran->data;
        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('laporanpembayaran.create_bendahara')->with(compact('siswa', 'jenis_pembayaran', 'config_date'));
    }

    public function store(Request $request){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $jenis_pembayaran = $client->request('GET', 'pembayaransiswa/jenispembayaran/'.(int)$request->id_jenispembayaran);
        $jenis_pembayaran = json_decode($jenis_pembayaran->getBody());
        $jenis_pembayaran = $jenis_pembayaran->data;
        if ((int)$request->nominal_pembayaran == (int)$jenis_pembayaran->nominal_pembayaran){
            $status_pembayaran = 'Lunas';
        }
        else if ((int)$jenis_pembayaran->nominal_pembayaran < (int)$request->nominal_pembayaran){
            $status_pembayaran = 'Lebih';
        }
        else {
            $status_pembayaran = 'Belum Lunas';
        }


        $resp = $client->request('POST', 'pembayaransiswa/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],

                'json' => [
                    'id_siswa' => (int)$request->id_siswa,
                    'id_jenispembayaran' => (int)$request->id_jenispembayaran,
                    'nominal_pembayaran' => (int)$request->nominal_pembayaran,
                    'status_pembayaran' => $status_pembayaran,
                    'tanggal_pembayaran' => $request->tanggal_pembayaran
                ]
            ]
        );
        $data_pembayaran = json_decode($resp->getBody());
        if ($data_pembayaran->message_id == '00'){
            return redirect(route('bendahara.laporan_pembayaran.index'))->with('alert', $data_pembayaran->status);
        }
        else {
            return redirect(route('bendahara.laporan_pembayaran.index'))->with('alert-failed', $data_pembayaran->status);
        }
    }

    public function edit($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $laporan_pembayaran = $client->request('GET', 'pembayaransiswa/laporan/'.(int)$id);
        $laporan_pembayaran = json_decode($laporan_pembayaran->getBody());

        $siswa = $client->request('GET', 'siswa/' );
        $siswa = json_decode($siswa->getBody());

        $jenis_pembayaran = $client->request('GET', 'pembayaransiswa/jenispembayaran/');
        $jenis_pembayaran = json_decode($jenis_pembayaran->getBody());
        $config_date = ['format' => 'YYYY-MM-DD'];

        if($laporan_pembayaran->message_id == '00'){
            $laporan_pembayaran = $laporan_pembayaran->data;
            $siswa = $siswa->data;
            $jenis_pembayaran = $jenis_pembayaran->data;
            return view('laporanpembayaran.edit_bendahara')->with(compact('siswa', 'jenis_pembayaran', 'laporan_pembayaran', 'config_date'));
        }
        else {
            return redirect(route('bendahara.laporan_pembayaran.index'))->with('alert-failed', 'Data tidak ditemukan');
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
            return redirect(route('bendahara.siswa.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $jenis_pembayaran = $client->request('GET', 'pembayaransiswa/jenispembayaran/'.(int)$request->id_jenispembayaran);
        $jenis_pembayaran = json_decode($jenis_pembayaran->getBody());
        $jenis_pembayaran = $jenis_pembayaran->data;

        if ((int)$request->nominal_pembayaran == (int)$jenis_pembayaran->nominal_pembayaran){
            $status_pembayaran = 'Lunas';
        }
        else if ((int)$jenis_pembayaran->nominal_pembayaran < (int)$request->nominal_pembayaran){
            $status_pembayaran = 'Lebih';
        }
        else {
            $status_pembayaran = 'Belum Lunas';
        }

        $resp = $client->request('PUT', 'pembayaransiswa/edit?id_laporanpembayaran='.(int)$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],

                'json' => [
                    'id_siswa' => (int)$request->id_siswa,
                    'id_jenispembayaran' => (int)$request->id_jenispembayaran,
                    'nominal_pembayaran' => (int)$request->nominal_pembayaran,
                    'status_pembayaran' => $status_pembayaran,
                    'tanggal_pembayaran' => $request->tanggal_pembayaran
                ]
            ]
        );
        $data_pembayaran = json_decode($resp->getBody());
        if ($data_pembayaran->message_id == '00'){
            return redirect(route('bendahara.laporan_pembayaran.index'))->with('alert', $data_pembayaran->status);
        }
        else {
            return redirect(route('bendahara.laporan_pembayaran.index'))->with('alert-failed', $data_pembayaran->status);
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'pembayaransiswa/hapus/pembayaran/'.(int)$id);
        return redirect(route('bendahara.laporan_pembayaran.index'))->with('alert', 'Data Terhapus');
    }
}
