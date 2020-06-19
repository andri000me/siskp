<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\PesertaUjian;

class PesertaUjianController extends Controller
{
    public function __construct(){
        $this->middleware('mahasiswaPimpinan', ['only' => [
            'index' 
        ]]);

        $this->middleware('pimpinan', ['except' => [
            'index' 
        ]]);
    }

    // mahasiswa & pimpinan
    public function index()
    {
        if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi')){
            $daftar_mahasiswa = \App\Mahasiswa::where('kontrak_skripsi', 'ya')->orderBy('nama', 'asc')->paginate(10);
            $bottom_detail = true;
            return view('peserta-ujian.index', compact('daftar_mahasiswa', 'bottom_detail'));
        }elseif(Session::has('mahasiswa')){
            $peserta_ujian = \App\PesertaUjian::where('id_mahasiswa', Session::get('id'))->get();
            $peserta_ujian_lama = \App\PesertaUjianLama::where('id_mahasiswa', Session::get('id'))->get();
            $bottom_detail = true;
            return view('peserta-ujian.index', compact('peserta_ujian', 'peserta_ujian_lama', 'bottom_detail'));
        }
    }

    // pimpinan
    public function createPesertaLama($id)
    {
        $mahasiswa = \App\Mahasiswa::find($id);
        $bottom_detail = true;
        return view('peserta-ujian.create', compact('mahasiswa', 'bottom_detail'));
    }

    // pimpinan
    public function store(Request $request)
    {
        foreach($request->post('mahasiswa') as $mahasiswa){
            $mhs = new \App\PesertaUjianLama;
            if(!empty($mahasiswa['nama'])){
                $mhs->id_mahasiswa = $request->post('id_mahasiswa'); 
                $mhs->ujian = $mahasiswa['ujian'];
                $mhs->nim = $mahasiswa['nim'];
                $mhs->nama = $mahasiswa['nama'];
                $mhs->tanggal = $mahasiswa['tanggal'];
                $mhs->save();
            }
        }
        Session::flash('pesan', 'Berhasil Mendaftarkan Beberapa Peserta Ujian Lama');
        return redirect('peserta-ujian');
    }

    // pimpinan
    public function show($id)
    {
        $mahasiswa = \App\Mahasiswa::find($id);
        $peserta_ujian = \App\PesertaUjian::where('id_mahasiswa', $id)->get();
        $peserta_ujian_lama = \App\PesertaUjianLama::where('id_mahasiswa', $id)->get();
        $bottom_detail = true;
        return view('peserta-ujian.detail', compact('peserta_ujian', 'peserta_ujian_lama', 'mahasiswa', 'bottom_detail'));
    }
    
}
