<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AlokasiDanaController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => env('API_HOST')]);
        $dana_masuk = $client->request('GET', 'dana/masuk/');
        $result_masuk = json_decode($dana_masuk->getBody());
        $dana_keluar = $client->request('GET', 'dana/keluar/');
        $result_keluar = json_decode($dana_keluar->getBody());

        $heads_masuk = [
            ['label' => 'ID Dana Masuk', 'no-export' => false, 'width' => 10],
            'Tanggal',
            'Sumber Dana',
            'Nominal Dana',
            'Lampiran',
            ['label' => 'Actions', 'no-export' => false, 'width' => 10],
        ];

        $heads_keluar = [
            ['label' => 'ID Dana Keluar', 'no-export' => false, 'width' => 10],
            'Tanggal',
            'Keterangan',
            'Jenis',
            'Diserahkan Kepada',
            'Dikeluarkan Oleh',
            'Bukti Pengeluaran',
            'Nominal',
            ['label' => 'Actions', 'no-export' => false, 'width' => 10],
        ];

        $config_masuk = [
            'data' => [],
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, null, null, ['orderable' => false]],
            'paging' => true,
            'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
        ];


        $config_keluar = [
            'data' => [],
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, null, null, null, null, null, ['orderable' => false]],
            'paging' => true,
            'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
        ];

        if (property_exists($result_masuk, 'data')){
            $result_masuk = $result_masuk->data;
            $subjectdata_masuk = array();


            foreach ($result_masuk as $dm){
                $btnEdit_masuk = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.alokasi_dana.edit_masuk', $dm->id),
                    'title' => 'Edit',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete_masuk = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.alokasi_dana.destroy_masuk', $dm->id),
                    'title' => 'Hapus',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                $sumberdana = $client->request('GET', 'dana/sumberdana/'.$dm->id_sumberdana);
                $sumberdana = json_decode($sumberdana->getBody());
                $sumberdana = $sumberdana->data;

                $subjectdata_masuk[] = [
                    $dm->id,
                    $dm->tanggal,
                    $sumberdana->nama_dana,
                    $dm->nominal_dana,
                    $dm->lampiran,
                    '<nobr>'.$btnEdit_masuk.$btnDelete_masuk.'</nobr>'
                ];
            }

            $config_masuk = [
                'data' => $subjectdata_masuk,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];
        }
        if (property_exists($result_keluar, 'data')){
            $result_keluar = $result_keluar->data;
            $subjectdata_keluar = array();
            foreach ($result_keluar as $dk){
                $btnEdit_keluar = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.alokasi_dana.edit_keluar', $dk->id),
                    'title' => 'Edit',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete_keluar = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.alokasi_dana.destroy_keluar', $dk->id),
                    'title' => 'Hapus',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                $jenispengeluaran = $client->request('GET', 'dana/jenispengeluaran/'.$dk->id_jenispengeluaran);
                $jenispengeluaran = json_decode($jenispengeluaran->getBody());
                $jenispengeluaran = $jenispengeluaran->data;

                $subjectdata_keluar[] = [
                    $dk->id,
                    $dk->tanggal,
                    $dk->detail_pengeluaran,
                    $jenispengeluaran->jenis_pengeluaran,
                    $dk->diserahkan_kepada,
                    $dk->dikeluarkan_oleh,
                    $dk->bukti_pengeluaran,
                    $dk->nominal_pengeluaran,
                    '<nobr>'.$btnEdit_keluar.$btnDelete_keluar.'</nobr>'
                ];
                $config_keluar = [
                    'data' => $subjectdata_keluar,
                    'order' => [[1, 'asc']],
                    'columns' => [null, null, null, null, null, null, null, null, ['orderable' => false]],
                    'paging' => true,
                    'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
                ];
            }
        }
        return view('alokasidana.index')->with(compact('heads_masuk', 'config_masuk', 'result_masuk', 'heads_keluar', 'config_keluar', 'result_keluar'));
    }

    public function create_masuk(){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $sumberdana = $client->request('GET', 'dana/sumberdana/');
        $sumberdana = json_decode($sumberdana->getBody());
        $sumberdana = $sumberdana->data;
        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('alokasidana.danamasuk.create')->with(compact('config_date', 'sumberdana'));
    }

    public function store_masuk(Request $request){
        $validatedData = $request->validate([
            'lampiran' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
        ]);

        $path = $request->file('lampiran')->store('public/files');


        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'dana/masuk/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'tanggal' => $request->tanggal,
                    'id_sumberdana' => (int)$request->id_sumberdana,
                    'nominal_dana' => (int)$request->nominal_dana,
                    'lampiran' => $path
                ]
            ]
        );
        $danamasuk = json_decode($resp->getBody());
        if ($danamasuk->message_id == '00'){
            return redirect(route('admin.alokasi_dana.index'))->with('alert', 'Data Berhasil Ditambahkan');
        }
        else {
            return redirect(route('admin.alokasi_dana.index'))->with('alert-failed', 'Data Gagal Ditambahkan');
        }
    }

    public function edit_masuk($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $danamasuk = $client->request('GET', 'dana/masuk/'.$id);
        $danamasuk = json_decode($danamasuk->getBody());
        $sumberdana = $client->request('GET', 'dana/sumberdana/');
        $sumberdana = json_decode($sumberdana->getBody());
        $config_date = ['format' => 'YYYY-MM-DD'];

        if($danamasuk->message_id == '00'){
            $danamasuk = $danamasuk->data;
            $sumberdana = $sumberdana->data;
            return view('alokasidana.danamasuk.edit')->with(compact( 'sumberdana', 'danamasuk', 'config_date'));
        }
        else {
            return redirect(route('admin.alokasi_dana.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update_masuk(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $danamasuk = $client->request('GET', 'dana/masuk/'.$id);
        $danamasuk = json_decode($danamasuk->getBody());
        $danamasuk = $danamasuk->data;
        $resp = $client->request('PUT', 'dana/masuk/edit?id_danamasuk='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'tanggal' => $request->tanggal,
                    'id_sumberdana' => (int)$request->id_sumberdana,
                    'nominal_dana' => (int)$request->nominal_dana,
                    'lampiran' => $danamasuk->lampiran
                ]
            ]
        );
        $danamasuk = json_decode($resp->getBody());
        if ($danamasuk->message_id == '00'){
            return redirect(route('admin.alokasi_dana.index'))->with('alert', 'Data Berhasil Di Edit');
        }
        else {
            return redirect(route('admin.alokasi_dana.index'))->with('alert-failed', 'Data Gagal Di Edit');
        }
    }

    public function destroy_masuk($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'dana/masuk/hapus/'.$id);
        return redirect(route('admin.alokasi_dana.index'))->with('alert', 'Data Terhapus');
    }

    public function create_keluar(){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $jenispengeluaran = $client->request('GET', 'dana/jenispengeluaran/');
        $jenispengeluaran = json_decode($jenispengeluaran->getBody());
        $jenispengeluaran = $jenispengeluaran->data;
        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('alokasidana.danakeluar.create')->with(compact('config_date', 'jenispengeluaran'));
    }

    public function store_keluar(Request $request){
        $validatedData = $request->validate([
            'bukti_pengeluaran' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
        ]);

        $path = $request->file('bukti_pengeluaran')->store('public/files');

        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'dana/keluar/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'tanggal' => $request->tanggal,
                    'detail_pengeluaran' => $request->detail_pengeluaran,
                    'id_jenispengeluaran' => (int)$request->id_jenispengeluaran,
                    'diserahkan_kepada' => $request->diserahkan_kepada,
                    'dikeluarkan_oleh' => $request->dikeluarkan_oleh,
                    'bukti_pengeluaran' => $path,
                    'nominal_pengeluaran' => (int)$request->nominal_pengeluaran,
                ]
            ]
        );
        $danakeluar = json_decode($resp->getBody());
        if ($danakeluar->message_id == '00'){
            return redirect(route('admin.alokasi_dana.index'))->with('alert', 'Data Berhasil Ditambahkan');
        }
        else {
            return redirect(route('admin.alokasi_dana.index'))->with('alert-failed', 'Data Gagal Ditambahkan');
        }
    }

    public function edit_keluar($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $danakeluar = $client->request('GET', 'dana/keluar/'.$id);
        $danakeluar = json_decode($danakeluar->getBody());
        $jenispengeluaran = $client->request('GET', 'dana/jenispengeluaran/');
        $jenispengeluaran = json_decode($jenispengeluaran->getBody());
        $config_date = ['format' => 'YYYY-MM-DD'];

        if($danakeluar->message_id == '00'){
            $danakeluar = $danakeluar->data;
            $jenispengeluaran = $jenispengeluaran->data;
            return view('alokasidana.danakeluar.edit')->with(compact( 'jenispengeluaran', 'danakeluar', 'config_date'));
        }
        else {
            return redirect(route('admin.alokasi_dana.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update_keluar(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $danakeluar = $client->request('GET', 'dana/keluar/'.$id);
        $danakeluar = json_decode($danakeluar->getBody());
        $danakeluar = $danakeluar->data;
        $resp = $client->request('PUT', 'dana/keluar/edit?id_danakeluar='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'tanggal' => $request->tanggal,
                    'detail_pengeluaran' => $request->detail_pengeluaran,
                    'id_jenispengeluaran' => (int)$request->id_jenispengeluaran,
                    'diserahkan_kepada' => $request->diserahkan_kepada,
                    'dikeluarkan_oleh' => $request->dikeluarkan_oleh,
                    'bukti_pengeluaran' => $danakeluar->bukti_pengeluaran,
                    'nominal_pengeluaran' => (int)$request->nominal_pengeluaran,
                ]
            ]
        );
        $danakeluar = json_decode($resp->getBody());
        if ($danakeluar->message_id == '00'){
            return redirect(route('admin.alokasi_dana.index'))->with('alert', 'Data Berhasil Di Edit');
        }
        else {
            return redirect(route('admin.alokasi_dana.index'))->with('alert-failed', 'Data Gagal Di Edit');
        }
    }

    public function destroy_keluar($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'dana/keluar/hapus/'.$id);
        return redirect(route('admin.alokasi_dana.index'))->with('alert', 'Data Terhapus');
    }
}
