<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Bimbingan;
use Validator;

class BimbinganController extends Controller
{
    public function __construct(){
        $this->middleware('dosenPimpinan', ['only' => [
            'show'  
        ]]);
        $this->middleware('pengguna', ['only' => [
            'index' 
        ]]);
        $this->middleware('mahasiswa', ['only' => [
            'create', 'edit', 'store', 'update', 'destroy' 
        ]]);
    }

    // pengguna
    public function index(Request $request)
    {
        if($request->segment(2) === 'proposal') $jenis = 'proposal';
        elseif($request->segment(2) === 'hasil') $jenis = 'hasil';
        elseif($request->segment(2) === 'sidang-skripsi') $jenis = 'sidang-skripsi';
        else $jenis = 'kerja-praktek';
        
        if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi') || Session::has('dosen')){
            $daftar_bimbingan = Bimbingan::with('mahasiswa')->where('bimbingan', $jenis)->selectRaw('id_mahasiswa, count(*) AS total')->groupBy('id_mahasiswa')->paginate(10);
            if(Session::has('dosen')){
                $daftar_masbing = Bimbingan::with('mahasiswa')->where('bimbingan', $jenis)->where('id_dosen', Session::get('id'))->selectRaw('id_mahasiswa, count(*) AS total')->groupBy('id_mahasiswa')->paginate(10);
                return view('bimbingan.index', compact('daftar_bimbingan', 'daftar_masbing', 'jenis'));
            }
            return view('bimbingan.index', compact('daftar_bimbingan', 'jenis'));
        }elseif(Session::has('mahasiswa')){
            $daftar_bimbingan = Bimbingan::where('id_mahasiswa', Session::get('id'))->where('bimbingan', $jenis)->get();
            return view('bimbingan.index', compact('daftar_bimbingan', 'jenis'));
        }
    }

    // mahasiswa
    public function create(Request $request)
    {
        $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));

        if(empty($mahasiswa->id_dosen)){ 
            return redirect()->back()->with('kesalahan', 'Dosen Pendamping Akademik anda masih kosong, silahkan lengkapi Profil anda terlebih dahulu');
        }

        if(empty($mahasiswa->id_prodi)){
            return redirect()->back()->with('kesalahan', 'Program Studi anda masih kosong, silahkan lengkapi Profil anda terlebih dahulu');
        }

        if($request->segment(2) === 'create-proposal' || $request->segment(2) === 'create-hasil' || $request->segment(2) === 'create-sidang-skripsi'){
            if($mahasiswa->kontrak_skripsi === 'tidak'){
                return redirect()->back()->with('kesalahan', 'Anda belum mengontrak Mata Kuliah Skripsi');
            }

            $dosbing = \App\DosenPembimbingSkripsi::where('id_mahasiswa', Session::get('id'))->get()->last();
            if(!$dosbing){
                Session::flash('kesalahan', 'Dosen Pembimbing Skripsi anda belum tersedia!');
                return redirect()->back();
            }
            $daftar_dosen = \App\Dosen::whereIn('id', [$dosbing->dosbing_satu_skripsi, $dosbing->dosbing_dua_skripsi])->pluck('nama', 'id');
        }elseif($request->segment(2) === 'create-kerja-praktek'){
            if($mahasiswa->kontrak_kp === 'tidak'){
                return redirect()->back()->with('kesalahan', 'Anda belum mengontrak Mata Kuliah Kerja Praktek');
            }

            $dosbing = \App\DosenPembimbingKp::where('id_mahasiswa', Session::get('id'))->get()->last();
            if(!$dosbing){
                Session::flash('kesalahan', 'Dosen Pembimbing Kerja Praktek anda belum tersedia!');
                return redirect()->back();
            }
            $daftar_dosen = \App\Dosen::whereIn('id', [$dosbing->dosbing_satu_kp, $dosbing->dosbing_dua_kp])->pluck('nama', 'id');
        }

        return view('bimbingan.create', compact('daftar_dosen'));
    }

    // mahasiswa
    public function store(Request $request)
    {
        if($request->post('bimbingan') === 'proposal' || $request->post('bimbingan') === 'hasil' || $request->post('bimbingan') === 'sidang-skripsi'){
            $dosbing = \App\DosenPembimbingSkripsi::where('id_mahasiswa', Session::get('id'))->first();
        
            $validasi = Validator::make($request->all(), [
                'id_dosen' => 'required|in:' . $dosbing->dosbing_satu_skripsi .','.$dosbing->dosbing_dua_skripsi
            ]);

            if($validasi->fails()){
                return redirect()->back()->withInput()->withErrors($validasi);
            }
        }elseif($request->post('bimbingan') === 'kerja-praktek'){
            $dosbing = \App\DosenPembimbingKp::where('id_mahasiswa', Session::get('id'))->first();
        
            $validasi = Validator::make($request->all(), [
                'id_dosen' => 'required|in:' . $dosbing->dosbing_satu_kp .','.$dosbing->dosbing_dua_kp
            ]);

            if($validasi->fails()){
                return redirect()->back()->withInput()->withErrors($validasi);
            }
        }

        Bimbingan::create($request->all());
        Session::flash('pesan', '1 Progress Bimbingan Berhasil Ditambahkan');

        if($request->post('bimbingan') === 'proposal') return redirect('bimbingan/proposal');
        elseif($request->post('bimbingan') === 'hasil') return redirect('bimbingan/hasil');
        elseif($request->post('bimbingan') === 'sidang-skripsi') return redirect('bimbingan/sidang-skripsi');
        elseif($request->post('bimbingan') === 'kerja-praktek') return redirect('bimbingan/kerja-praktek');
    }

    // dosen & pimpinan
    public function show($id)
    {
        $bimbingan = Bimbingan::where('id_mahasiswa', $id)->first();

        $daftar_bimbingan_proposal = Bimbingan::where('id_mahasiswa', $id)->where('bimbingan', 'proposal')->orderBy('waktu', 'asc')->get();
        $daftar_bimbingan_hasil = Bimbingan::where('id_mahasiswa', $id)->where('bimbingan', 'hasil')->orderBy('waktu', 'asc')->get();
        $daftar_bimbingan_sidang_skripsi = Bimbingan::where('id_mahasiswa', $id)->where('bimbingan', 'sidang-skripsi')->orderBy('waktu', 'asc')->get();
        $daftar_bimbingan_kp = Bimbingan::where('id_mahasiswa', $id)->where('bimbingan', 'kerja-praktek')->orderBy('waktu', 'asc')->get();
        
        $total_proposal = Bimbingan::where('id_mahasiswa', $id)->where('bimbingan', 'proposal')->count();
        $total_hasil = Bimbingan::where('id_mahasiswa', $id)->where('bimbingan', 'hasil')->count();
        $total_sidang_skripsi = Bimbingan::where('id_mahasiswa', $id)->where('bimbingan', 'sidang-skripsi')->count();
        $total_kp = Bimbingan::where('id_mahasiswa', $id)->where('bimbingan', 'kerja-praktek')->count();

        return view('bimbingan.detail', compact('total_proposal', 'total_hasil', 'total_sidang_skripsi', 'total_kp', 'bimbingan', 'daftar_bimbingan_proposal', 'daftar_bimbingan_hasil', 'daftar_bimbingan_sidang_skripsi', 'daftar_bimbingan_kp'));
    }

    // mahasiswa
    public function edit($id, Request $request)
    {
        $bimbingan = Bimbingan::findOrFail($id);

        $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));

        if(empty($mahasiswa->id_dosen)){ 
            return redirect()->back()->with('kesalahan', 'Dosen Pendamping Akademik anda masih kosong, silahkan lengkapi Profil anda terlebih dahulu');
        }

        if(empty($mahasiswa->id_prodi)){
            return redirect()->back()->with('kesalahan', 'Program Studi anda masih kosong, silahkan lengkapi Profil anda terlebih dahulu');
        }

        if($request->segment(3) === 'edit-proposal' || $request->segment(3) === 'edit-hasil' || $request->segment(3) === 'edit-sidang-skripsi'){
            if($mahasiswa->kontrak_skripsi === 'tidak'){
                return redirect()->back()->with('kesalahan', 'Anda belum mengontrak Mata Kuliah Skripsi');
            }
            $dosbing = \App\DosenPembimbingSkripsi::where('id_mahasiswa', Session::get('id'))->get()->last();
            if(!$dosbing){
                Session::flash('kesalahan', 'Dosen Pembimbing Skripsi anda belum tersedia!');
                return redirect()->back();
            }
            $daftar_dosen = \App\Dosen::whereIn('id', [$dosbing->dosbing_satu_skripsi, $dosbing->dosbing_dua_skripsi])->pluck('nama', 'id');
        }elseif($request->segment(3) === 'edit-kerja-praktek'){
            if($mahasiswa->kontrak_kp === 'tidak'){
                return redirect()->back()->with('kesalahan', 'Anda belum mengontrak Mata Kuliah Kerja Praktek');
            }
            $dosbing = \App\DosenPembimbingKp::where('id_mahasiswa', Session::get('id'))->get()->last();
            if(!$dosbing){
                Session::flash('kesalahan', 'Dosen Pembimbing Kerja Praktek anda belum tersedia!');
                return redirect()->back();
            }
            $daftar_dosen = \App\Dosen::whereIn('id', [$dosbing->dosbing_satu_kp, $dosbing->dosbing_dua_kp])->pluck('nama', 'id');
        }
        return view('bimbingan.edit', compact('daftar_dosen', 'bimbingan'));
    }

    // mahasiswa
    public function update(Request $request, $id)
    {
        $bimbingan = Bimbingan::findOrFail($id);
        $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));

        if(empty($mahasiswa->id_dosen)){ 
            return redirect()->back()->with('kesalahan', 'Dosen Pendamping Akademik anda masih kosong, silahkan lengkapi Profil anda terlebih dahulu');
        }

        if(empty($mahasiswa->id_prodi)){
            return redirect()->back()->with('kesalahan', 'Program Studi anda masih kosong, silahkan lengkapi Profil anda terlebih dahulu');
        }

        if($bimbingan->bimbingan === 'proposal' || $bimbingan->bimbingan === 'hasil' || $bimbingan->bimbingan === 'sidang-skripsi'){
            if($mahasiswa->kontrak_skripsi === 'tidak'){
                return redirect()->back()->with('kesalahan', 'Anda belum mengontrak Mata Kuliah Skripsi');
            }
            $dosbing = \App\DosenPembimbingSkripsi::where('id_mahasiswa', Session::get('id'))->get()->last();
            if(!$dosbing){
                Session::flash('kesalahan', 'Dosen Pembimbing Skripsi anda belum tersedia!');
                return redirect()->back();
            }
            $validasi = Validator::make($request->all(), [
              'id_dosen' => 'required|in:' . $dosbing->dosbing_satu_skripsi .','.$dosbing->dosbing_dua_skripsi
            ]);
            if($validasi->fails()){
              return redirect()->back()->withInput()->withErrors($validasi);
            }
        }elseif($bimbingan->bimbingan === 'kerja-praktek'){
            if($mahasiswa->kontrak_kp === 'tidak'){
                return redirect()->back()->with('kesalahan', 'Anda belum mengontrak Mata Kuliah Kerja Praktek');
            }
            $dosbing = \App\DosenPembimbingKp::where('id_mahasiswa', Session::get('id'))->get()->last();
            if(!$dosbing){
                Session::flash('kesalahan', 'Dosen Pembimbing Kerja Praktek anda belum tersedia!');
                return redirect()->back();
            }
            $validasi = Validator::make($request->all(), [
              'id_dosen' => 'required|in:' . $dosbing->dosbing_satu_kp .','.$dosbing->dosbing_dua_kp
            ]);
            if($validasi->fails()){
              return redirect()->back()->withInput()->withErrors($validasi);
            }
        }

        $bimbingan->update($request->all());
        Session::flash('pesan', '1 Progress Bimbingan Berhasil Diupdate');
        
        if($bimbingan->bimbingan === 'proposal') return redirect('bimbingan/proposal');
        elseif($bimbingan->bimbingan === 'hasil') return redirect('bimbingan/hasil');
        elseif($bimbingan->bimbingan === 'sidang-skripsi') return redirect('bimbingan/sidang-skripsi');
        elseif($bimbingan->bimbingan === 'kerja-praktek') return redirect('bimbingan/kerja-praktek');
    }

    // mahasiswa
    public function destroy($id)
    {
        $bimbingan = Bimbingan::findOrFail($id);
        $bimbingan->delete();
        Session::flash('pesan', '1 Progress Bimbingan Berhasil Dihapus');
        
        if($bimbingan->bimbingan === 'proposal') return redirect('bimbingan/proposal');
        elseif($bimbingan->bimbingan === 'hasil') return redirect('bimbingan/hasil');
        elseif($bimbingan->bimbingan === 'sidang-skripsi') return redirect('bimbingan/sidang-skripsi');
        elseif($bimbingan->bimbingan === 'kerja-praktek') return redirect('bimbingan/kerja-praktek');
    }
}
