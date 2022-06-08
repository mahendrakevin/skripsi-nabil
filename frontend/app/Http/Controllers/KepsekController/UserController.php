<?php

namespace App\Http\Controllers\KepsekController;

use App\Models\User;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        if ($users){
            $subjectdata = array();

            foreach ($users as $resp){

                if ($resp->role==1){
                    $role_name = 'Admin';
                }
                else if ($resp->role==2){
                    $role_name = 'Bendahara';
                }
                else if ($resp->role==3){
                    $role_name = 'Kepala Sekolah';
                }
                else {
                    $role_name = null;
                }

                $subjectdata[] = [
                    $resp->id,
                    $resp->name,
                    $resp->email,
                    $role_name,
                    '<nobr></nobr>'
                ];
            }

            $heads = [
                ['label' => 'ID User', 'no-export' => false, 'width' => 10],
                'Nama Lengkap',
                'Email',
                'Jenis User',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => $subjectdata,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('users.index')->with(compact('heads', 'config'));
        } else {
            $heads = [
                ['label' => 'ID Kelas', 'no-export' => false, 'width' => 10],
                'Nama Kelas',
                'Kapasitas Kelas',
                ['label' => 'Actions', 'no-export' => false, 'width' => 10],
            ];

            $config = [
                'data' => [],
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, ['orderable' => false]],
                'paging' => true,
                'lengthMenu' => [ 10, 50, 100, 500],
                'language' => ['search' => 'Cari Data']
            ];

            return view('users.index')->with(compact('heads', 'config'));
        }

    }
}
