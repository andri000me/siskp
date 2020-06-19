<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\NotifikasiAdmin;
use App\NotifikasiDosen;
use App\NotifikasiMahasiswa;

class NotifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('pimpinan', ['only' => [
            'indexAdmin', 
        ]]);

        $this->middleware('dosen', ['only' => [
            'indexDosen', 
        ]]);

        $this->middleware('mahasiswa', ['only' => [
            'indexMahasiswa', 
        ]]);

        $this->middleware('pengguna', ['only' => [
            'hapusDibaca', 'hapusSemua', 'semuaDibaca' 
        ]]);
    }

    // pimpinan
    public function indexAdmin()
    {
        $daftar_notifikasi = NotifikasiAdmin::orderBy('id', 'desc')->paginate(10);
        
        return view('notifikasi.index', compact('daftar_notifikasi'));
    }

    // dosen
    public function indexDosen()
    {
        $daftar_notifikasi = NotifikasiDosen::where('id_dosen', Session::get('id'))->orderBy('id', 'desc')->paginate(10);
        
        return view('notifikasi.index', compact('daftar_notifikasi'));
    }

    // mahasiswa
    public function indexMahasiswa()
    {
        $daftar_notifikasi = NotifikasiMahasiswa::where('id_mahasiswa', Session::get('id'))->orderBy('id', 'desc')->paginate(10);
        return view('notifikasi.index', compact('daftar_notifikasi'));
    }

    // pengguna
    public function show($id)
    {
        if(Session::has('admin')) $notifikasi = NotifikasiAdmin::findOrFail($id);
        elseif(Session::has('dosen')) $notifikasi = NotifikasiDosen::findOrFail($id);
        elseif(Session::has('mahasiswa')) $notifikasi = NotifikasiMahasiswa::findOrFail($id);
        
        $notifikasi->dibaca = 'ya';
        $notifikasi->save();
        return redirect($notifikasi->link);
    }


    // pengguna
    public function semuaDibaca()
    {
        if(Session::has('dosen')){
            NotifikasiDosen::where('dibaca', 'tidak')->where('id_dosen', Session::get('id'))->update(['dibaca' => 'ya']);
            Session::flash('pesan', 'Semua Notifikasi Telah Ditandai Sudah Dibaca');
            return redirect('notifikasi/dosen');
        }elseif(Session::has('admin')){
            NotifikasiAdmin::where('dibaca', 'tidak')->update(['dibaca' => 'ya']);
            Session::flash('pesan', 'Semua Notifikasi Telah Ditandai Sudah Dibaca');
            return redirect('notifikasi/admin');            
        }elseif(Session::has('mahasiswa')){
            NotifikasiMahasiswa::where('dibaca', 'tidak')->where('id_mahasiswa', Session::get('id'))->update(['dibaca' => 'ya']);
            Session::flash('pesan', 'Semua Notifikasi Telah Ditandai Sudah Dibaca');
            return redirect('notifikasi/mahasiswa');
        }
    }
    
    // pengguna
    public function hapusDibaca()
    {
        if(Session::has('dosen')){
            NotifikasiDosen::where('dibaca', 'ya')->where('id_dosen', Session::get('id'))->delete();
            Session::flash('pesan', 'Semua Notifikasi Yang Sudah Dibaca Telah Dihapus');
            return redirect('notifikasi/dosen');
        }elseif(Session::has('admin')){
            NotifikasiAdmin::where('dibaca', 'ya')->delete();
            Session::flash('pesan', 'Semua Notifikasi Yang Sudah Dibaca Telah Dihapus');
            return redirect('notifikasi/admin');
        }elseif(Session::has('mahasiswa')){
            NotifikasiMahasiswa::where('dibaca', 'ya')->where('id_mahasiswa', Session::get('id'))->delete();
            Session::flash('pesan', 'Semua Notifikasi Yang Sudah Dibaca Telah Dihapus');
            return redirect('notifikasi/mahasiswa');
        }
    }

    // pengguna
    public function hapusSemua()
    {
        if(Session::has('dosen')){
            NotifikasiDosen::where('id_dosen', Session::get('id'))->delete();
            Session::flash('pesan', 'Semua Notifikasi Telah Dihapus');
            return redirect('notifikasi/dosen');
        }elseif(Session::has('admin')){
            NotifikasiAdmin::where('id', '>', 0)->delete();
            Session::flash('pesan', 'Semua Notifikasi Telah Dihapus');
            return redirect('notifikasi/admin');
        }elseif(Session::has('mahasiswa')){
            NotifikasiMahasiswa::where('id_mahasiswa', Session::get('id'))->delete();
            Session::flash('pesan', 'Semua Notifikasi Telah Dihapus');
            return redirect('notifikasi/mahasiswa');
        }
    }

}
