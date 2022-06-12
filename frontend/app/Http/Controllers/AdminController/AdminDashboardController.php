<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use JeroenNoten\LaravelAdminLte\Components\Form\Select;

class AdminDashboardController extends Controller
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


                return view('dashboard.index')->with(compact('result',  'sk', 'jumlah_siswa','jumlah_alumni','jumlah_guru','jumlah_rombel','dana_masuk','dana_keluar','laporan_pembayaran','arsip_surat_masuk', 'arsip_surat_keluar', 'total_sarpras'));
            } else {

                return view('dashboard.index')->with(compact( 'result', 'sk', 'jumlah_siswa','jumlah_alumni','jumlah_guru','jumlah_rombel','dana_masuk','dana_keluar','laporan_pembayaran','arsip_surat_masuk', 'arsip_surat_keluar', 'total_sarpras'));

            }
        } else {

            return view('lembaga.index')->with(compact('result', 'sk'));
        }

        return view('dashboard.index');
    }
}
