<?php

namespace App\Http\Controllers\KepsekController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use JeroenNoten\LaravelAdminLte\Components\Form\Select;

class KepsekDashboardController extends Controller
{
    public function index()
    {
        $jumlah_siswa = DB::Select("SELECT COUNT(1) FROM data_siswa WHERE status_siswa = 'Aktif'");
        $jumlah_alumni = DB::Select("SELECT COUNT(1) FROM data_siswa WHERE status_siswa IN ('Tidak Aktif', 'Lulus')");
        $jumlah_guru = DB::Select("SELECT COUNT(1) FROM data_guru WHERE status_pegawai = 'Aktif'");
        $jumlah_rombel = DB::Select("SELECT COUNT(1) FROM data_kelas");
        $dana_masuk = DB::Select("SELECT SUM(nominal_dana) FROM dana_masuk");
        $dana_keluar = DB::Select("SELECT SUM(nominal_pengeluaran) FROM dana_keluar");
        $laporan_pembayaran = DB::Select("SELECT COUNT(1) FROM laporan_pembayaran");
        $arsip_surat_masuk = DB::Select("SELECT COUNT(1) FROM arsip_surat WHERE jenis_surat = 'Masuk'");
        $arsip_surat_keluar = DB::Select("SELECT COUNT(1) FROM arsip_surat WHERE jenis_surat = 'Keluar'");
        $total_sarpras = DB::Select("SELECT COUNT(1) FROM sarana_prasarana");

        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('GET', 'lembaga/1');
        $result = json_decode($resp->getBody());

        $resp = $client->request('GET', 'lembaga/suratketerangan/1');
        $sk = json_decode($resp->getBody());

        if (property_exists($result, 'data') && property_exists($sk, 'data')){
            $sk = $sk->data;
            // dd($sk);
            $result = $result->data;
//            dd($result);
            $client = new Client(['base_uri' => env('API_HOST')]);
            $resp = $client->request('GET', 'lembaga/sarpras/');
            $sarpras = json_decode($resp->getBody());

            if (property_exists($sarpras, 'data')){

                $sarpras = $sarpras->data;
                $subjectdata = array();

                foreach ($sarpras as $resp){
                    $btnEdit = view('components.Button', [
                        'method' => 'GET',
                        'action' => route('admin.sarpras.edit', $resp->id),
                        'title' => 'Edit',
                        'icon' => 'fa fa-lg fa-fw fa-pen',
                        'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                    $btnDelete = view('components.Button', [
                        'method' => 'GET',
                        'action' => route('admin.sarpras.destroy', $resp->id),
                        'title' => 'Hapus',
                        'icon' => 'fa fa-lg fa-fw fa-trash',
                        'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);


                    $subjectdata[] = [
                        $resp->id,
                        $resp->nama_aset,
                        $resp->luas_lahan,
                        $resp->luas_bangunan,
                        $resp->nama_pemilik,
                        $resp->no_sertifikat,
                        '<nobr>'.$btnEdit.$btnDelete.'</nobr>'
                    ];
                }

                $heads_sarpras = [
                    ['label' => 'No', 'no-export' => false, 'width' => 10],
                    'Nama Lembaga',
                    'Luas Lahan',
                    'Luas Bangunan',
                    'Nama Pemilik',
                    'No Sertifikat',
                    ['label' => 'Actions', 'no-export' => false, 'width' => 10]
                ];

                $config_sarpras = [
                    'data' => $subjectdata,
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null],
                    'paging' => true,
                    'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
                ];

                return view('dashboard.index')->with(compact('result', 'config_sarpras', 'heads_sarpras', 'sk', 'jumlah_siswa','jumlah_alumni','jumlah_guru','jumlah_rombel','dana_masuk','dana_keluar','laporan_pembayaran','arsip_surat_masuk', 'arsip_surat_keluar', 'total_sarpras'));
            } else {
                $heads_sarpras = [
                    ['label' => 'No', 'no-export' => false, 'width' => 10],
                    'Nama Lembaga',
                    'Luas Lahan',
                    'Luas Bangunan',
                    'Nama Pemilik',
                    'No Sertifikat',
                    ['label' => 'Actions', 'no-export' => false, 'width' => 10],
                ];

                $config_sarpras = [
                    'data' => [],
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null, ['orderable' => false]],
                    'paging' => true,
                    'lengthMenu' => [10, 50, 100, 500]
                ];

                return view('dashboard.index')->with(compact('heads_sarpras', 'config_sarpras', 'result', 'sk', 'jumlah_siswa','jumlah_alumni','jumlah_guru','jumlah_rombel','dana_masuk','dana_keluar','laporan_pembayaran','arsip_surat_masuk', 'arsip_surat_keluar', 'total_sarpras'));

            }
        } else {

            return view('lembaga.index')->with(compact('result', 'sk'));
        }

        return view('dashboard.index');
    }
}
