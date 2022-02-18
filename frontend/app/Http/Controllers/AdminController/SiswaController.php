<?php

namespace App\Http\Controllers\AdminController;

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
                    'action' => route('admin.siswa.show', $resp->id),
                    'title' => 'Detail',
                    'icon' => 'fa fa-lg fa-fw fa-eye',
                    'class' => 'btn btn-xs btn-default text-teal mx-1 shadow']);

                $btnEdit = view('components.button', [
                    'method' => 'GET',
                    'action' => route('admin.siswa.edit', $resp->id),
                    'title' => 'Edit',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete = view('components.button', [
                    'method' => 'GET',
                    'action' => route('admin.siswa.destroy', $resp->id),
                    'title' => 'Delete',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

                $subjectdata[] = [
                    $resp->nis,
                    $resp->nisn,
                    $resp->nama_siswa,
                    $resp->jenis_kelamin,
                    $resp->status_siswa,
                    '<nobr>'.$btnShow.$btnEdit.$btnDelete.'</nobr>'
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

    public function create(){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $kelas = $client->request('GET', 'kelas/');
        $kelas = json_decode($kelas->getBody());
        $kelas = $kelas->data;

        $jeniswali = $client->request('GET', 'walisiswa/jeniswali/');
        $jeniswali = json_decode($jeniswali->getBody());
        $jeniswali = $jeniswali->data;
        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('siswa.create')->with(compact('kelas', 'jeniswali', 'config_date'));
    }

    public function store(Request $request){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('POST', 'siswa/tambah',[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nisn' => (int)$request->nisn,
                    'nama_siswa' => $request->nama_siswa,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'nik' => (int)$request->nik,
                    'id_kelas' => (int)$request->id_kelas,
                    'status_siswa' => $request->status_siswa,
                    'nomor_kip' => (int)$request->nomor_kip,
                    'alamat' => $request->alamat,
                    'nomor_kk' => (int)$request->nomor_kk,
                ]
            ]
        );
        $data_siswa = json_decode($resp->getBody());
        if ($data_siswa->message_id == '00'){
            $walisiswa = $client->request('POST', 'walisiswa/tambah',[
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept'     => 'application/json'
                    ],
                    'json' => [
                        'id_jeniswali' => (int)$request->id_jeniswali,
                        'nama_wali' => $request->nama_wali,
                        'file_kk' => 'test',
                        'tempat_lahir' => $request->tempat_lahir_wali,
                        'tanggal_lahir' => $request->tanggal_lahir_wali,
                        'alamat' => $request->alamat_wali,
                        'no_hp' => (int)$request->no_hp,
                        'pendidikan' => $request->pendidikan,
                        'pekerjaan' => $request->pekerjaan,
                        'penghasilan' => (int)$request->penghasilan,
                        'nomor_kks' => (int)$request->nomor_kks,
                        'nomor_pkh' => (int)$request->nomor_pkh,
                        'id_siswa' => $data_siswa->data->id
                    ]
                ]
            );
            return redirect(route('admin.siswa.index'))->with('alert', 'Data Berhasil Ditambahkan');
        }
        else {
            return redirect(route('admin.siswa.index'))->with('alert-failed', 'Data Gagal Terhapus');
        }
    }

    public function edit($id){
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
            return view('siswa.edit')->with(compact('siswa', 'walisiswa', 'kelas', 'jeniswali', 'config_date'));
        }
        else {
            return redirect(route('admin.siswa.index'))->with('alert-failed', 'Data tidak ditemukan');
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
            return redirect(route('admin.siswa.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('PUT', 'siswa/edit?id_siswa='.$id,[
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept'     => 'application/json'
                ],
                'json' => [
                    'nisn' => (int)$request->nisn,
                    'nama_siswa' => $request->nama_siswa,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'nik' => (int)$request->nik,
                    'id_kelas' => (int)$request->id_kelas,
                    'status_siswa' => $request->status_siswa,
                    'nomor_kip' => (int)$request->nomor_kip,
                    'alamat' => $request->alamat,
                    'nomor_kk' => (int)$request->nomor_kk,
                ]
            ]
        );
        $data_siswa = json_decode($resp->getBody());
        if ($data_siswa->message_id == '00'){
            $walisiswa = $client->request('PUT', 'walisiswa/edit?id_siswa='.$id,[
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept'     => 'application/json'
                    ],
                    'json' => [
                        'id_siswa' => $id,
                        'id_jeniswali' => (int)$request->id_jeniswali,
                        'nama_wali' => $request->nama_wali,
                        'file_kk' => 'test',
                        'tempat_lahir' => $request->tempat_lahir_wali,
                        'tanggal_lahir' => $request->tanggal_lahir_wali,
                        'alamat' => $request->alamat_wali,
                        'no_hp' => (int)$request->no_hp,
                        'pendidikan' => $request->pendidikan,
                        'pekerjaan' => $request->pekerjaan,
                        'penghasilan' => (int)$request->penghasilan,
                        'nomor_kks' => (int)$request->nomor_kks,
                        'nomor_pkh' => (int)$request->nomor_pkh
                    ]
                ]
            );
            return redirect(route('admin.siswa.index'))->with('alert', 'Data Berhasil Di Edit');
        }
        else {
            return redirect(route('admin.siswa.index'))->with('alert-failed', 'Data Gagal Di Edit');
        }
    }

    public function destroy($id){
        $client = new Client(['base_uri' => env('API_HOST')]);
        $resp = $client->request('DELETE', 'siswa/hapus/'.(int)$id);
        $resp = $client->request('DELETE', 'walisiswa/hapus/'.(int)$id);
        return redirect(route('admin.siswa.index'))->with('alert', 'Data Terhapus');
    }
}
