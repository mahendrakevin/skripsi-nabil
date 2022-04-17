<?php

namespace App\Http\Controllers\AdminController;

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
                $btnEdit = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.users.edit', $resp->id),
                    'title' => 'Edit',
                    'icon' => 'fa fa-lg fa-fw fa-pen',
                    'class' => 'btn btn-xs btn-default text-warning mx-1 shadow']);

                $btnDelete = view('components.Button', [
                    'method' => 'GET',
                    'action' => route('admin.users.destroy', $resp->id),
                    'title' => 'Delete',
                    'icon' => 'fa fa-lg fa-fw fa-trash',
                    'class' => 'btn btn-xs btn-default text-danger mx-1 shadow']);

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
                    '<nobr>'.$btnEdit.$btnDelete.'</nobr>'
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
                'lengthMenu' => [ 10, 50, 100, 500]
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
                'lengthMenu' => [ 10, 50, 100, 500]
            ];

            return view('users.index')->with(compact('heads', 'config'));
        }

    }

    public function create(){
        $config_date = ['format' => 'YYYY-MM-DD'];

        return view('users.create')->with(compact('config_date'));
    }

    public function store(Request $request){
        $request->password = Hash::make($request->password);
        User::create($request->all());
        return redirect(route('admin.users.index'))->with('alert', 'Data Berhasil Ditambah');
    }

    public function edit($id){
        $user = User::where('id', '=', $id)->first();

        if($user){
            return view('users.edit')->with(compact( 'user'));
        }
        else {
            return redirect(route('admin.users.index'))->with('alert-failed', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);
        $user = User::where('id', '=', $id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password)
            $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();
        return redirect(route('admin.users.index'))->with('alert', 'Data Sukses Di Edit');
    }

    public function destroy($id){
        $user = User::where('id', '=', $id)->delete();
        return redirect(route('admin.users.index'))->with('alert', 'Data Terhapus');
    }
}
