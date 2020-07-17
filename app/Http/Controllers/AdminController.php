<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use Session;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('pimpinan');
    }

    public function index()
    {
        $daftar_admin = Admin::paginate(10);
        $total = Admin::all()->count();

        return view('admin.index', compact('daftar_admin', 'total'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(AdminRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->input('password'));
        Admin::create($input);
        Session::flash('pesan', '1 Admin Berhasil Ditambahkan');
        return redirect('admin');
    }

    public function edit(Admin $admin)
    {
        return view('admin.edit', compact('admin'));
    }

    public function update(AdminRequest $request, Admin $admin)
    {
        if(!empty($request->post('password'))) $admin->password = Hash::make($request->post('password'));
        $admin->username = $request->post('username');
        $admin->nama = $request->post('nama');
        $admin->save();
        Session::flash('pesan', '1 Admin Berhasil Diupdate');
        return redirect('admin');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        Session::flash('pesan', '1 Admin Berhasil Dihapus');
        return redirect('admin');
    }
}
