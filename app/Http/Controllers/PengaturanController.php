<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Prodi;
use App\Kaprodi;
use App\Kajur;
use App\Pengaturan;
use App\Dosen;
use App\ProdiKp;
use App\IndikatorPenilaian;
use Validator;

class PengaturanController extends Controller
{
    public function __construct(){
        $this->middleware('pimpinan');
    }

    public function indexUmum()
    {
        $pengaturan = Pengaturan::first();
        $bottom_detail = true;

        return view('pengaturan.index-umum', compact(
            'pengaturan', 'bottom_detail'
        ));
    }

    public function indexPimpinan()
    {
        $kajur = Kajur::first() or null;
        $bottom_detail = true;

        $daftar_kaprodi = Kaprodi::all();

        return view('pengaturan.index-pimpinan', compact(
            'kajur', 'daftar_kaprodi', 'bottom_detail'
        ));
    }

    public function indexProdi()
    {
        $daftar_prodi = Prodi::all();
        $bottom_detail = true;

        $daftar_prodi_kp = ProdiKp::all();
        
        return view('pengaturan.index-prodi', compact(
            'daftar_prodi', 'daftar_prodi_kp', 'bottom_detail'
        ));
    }

    public function indexPenilaian()
    {
        $daftar_penilaian = IndikatorPenilaian::all();
        $bottom_detail = true;

        return view('pengaturan.index-penilaian', compact(
            'daftar_penilaian', 'bottom_detail'
        ));
    }

    // program Studi
    public function createProdi()
    {
        $bottom_detail = true;
        return view('pengaturan.create-prodi', compact('bottom_detail'));
    }

    public function storeProdi(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:100',
        ]);

        Prodi::create($request->all());
        Session::flash('pesan', '1 Prodi berhasil ditambahkan');
        return redirect('pengaturan/prodi');
    }

    public function editProdi($id)
    {
        $bottom_detail = true;
        $prodi = Prodi::findOrFail($id);
        return view('pengaturan.edit-prodi', compact('prodi', 'bottom_detail'));
    }

    public function updateProdi(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:100',
        ]);

        $prodi = Prodi::findOrFail($id);
        $prodi->update($request->all());
        Session::flash('pesan', '1 Prodi berhasil diupdate');
        return redirect('pengaturan/prodi');
    }

    public function destroyProdi($id)
    {
        $prodi = Prodi::findOrFail($id);
        $prodi->delete();
        Session::flash('pesan', '1 Prodi berhasil dihapus');
        return redirect('pengaturan/prodi');
    }

    // kajur
    public function createKajur()
    {
        $daftar_dosen = Dosen::pluck('nama', 'id');
        $bottom_detail = true;

        return view('pengaturan.tambah-kajur', compact('daftar_dosen', 'bottom_detail'));
    }
    
    public function storeKajur(Request $request)
    {
        $validasi = Validator::make($request->all(), [
          'id_dosen' => 'required|integer',
          'tahun_selesai' => 'required|string|max:4',
          'tahun_awal' => 'required|string|max:4',
        ]);        

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        Kajur::create($request->all());
        Session::flash('pesan', 'Ketua Jurusan berhasil dipilih');
        return redirect('pengaturan/pimpinan');
    }

    public function editKajur($id)
    {
        $kajur = Kajur::findOrFail($id);
        $daftar_dosen = Dosen::pluck('nama', 'id');
        $bottom_detail = true;

        return view('pengaturan.edit-kajur', compact('kajur', 'daftar_dosen', 'bottom_detail'));
    }

    public function updateKajur(Request $request, $id)
    {
        $this->validate($request, [
            'tahun_awal' => 'required|string|max:4',
            'tahun_selesai' => 'required|string|max:4',
            'id_dosen' => 'required|integer',
        ]);

        $kajur = Kajur::findOrFail($id);
        $kajur->update($request->all());
        Session::flash('pesan', 'Ketua Jurusan berhasil diupdate');
        return redirect('pengaturan/pimpinan');
    }

    // kaprodi
    public function createKaprodi()
    {
        $daftar_dosen = Dosen::pluck('nama', 'id');
        $daftar_prodi = Prodi::pluck('nama', 'id');
        $bottom_detail = true;

        return view('pengaturan.create-kaprodi', compact('daftar_dosen', 'daftar_prodi', 'bottom_detail'));
    }

    public function storeKaprodi(Request $request)
    {
        $this->validate($request, [
            'tahun_awal' => 'required|string|max:4',
            'tahun_selesai' => 'required|string|max:4',
            'id_dosen' => 'required|integer',
            'id_prodi' => 'required|integer',
        ]);

        Kaprodi::create($request->all());
        Session::flash('pesan', '1 Kaprodi berhasil ditambahkan');
        return redirect('pengaturan/pimpinan');
    }

    public function editKaprodi($id)
    {
        $daftar_dosen = Dosen::pluck('nama', 'id');
        $daftar_prodi = Prodi::pluck('nama', 'id');
        $kaprodi = Kaprodi::findOrFail($id);
        $bottom_detail = true;

        return view('pengaturan.edit-kaprodi', compact('kaprodi', 'daftar_dosen', 'daftar_prodi', 'bottom_detail'));
    }

    public function updateKaprodi(Request $request, $id)
    {
        $this->validate($request, [
            'tahun_awal' => 'required|string|max:4',
            'tahun_selesai' => 'required|string|max:4',
            'id_dosen' => 'required|integer',
            'id_prodi' => 'required|integer',
        ]);
        
        $kaprodi = Kaprodi::findOrFail($id);
        $kaprodi->update($request->all());
        Session::flash('pesan', '1 Kaprodi berhasil diupdate');
        return redirect('pengaturan/pimpinan');
    }

    public function destroyKaprodi($id)
    {
        $kaprodi = Kaprodi::findOrFail($id);
        $kaprodi->delete();
        Session::flash('pesan', '1 Kaprodi berhasil dihapus');
        return redirect('pengaturan/pimpinan');
    }

    // prodi_kp
    public function createProdiKp()
    {
        $bottom_detail = true;
        $daftar_prodi = Prodi::pluck('nama', 'id');
        return view('pengaturan.create-prodi-kp', compact('daftar_prodi', 'bottom_detail'));
    }

    public function storeProdiKp(Request $request)
    {
        $this->validate($request, [
            'id_prodi' => 'required|integer',
        ]);

        ProdiKp::create($request->all());
        Session::flash('pesan', '1 Prodi Kerja Praktek berhasil ditambahkan');
        return redirect('pengaturan/prodi');
    }

    public function editProdiKp($id)
    {
        $daftar_prodi = Prodi::pluck('nama', 'id');
        $prodi_kp = ProdiKp::findOrFail($id);
        $bottom_detail = true;

        return view('pengaturan.edit-prodi-kp', compact('prodi_kp', 'daftar_prodi', 'bottom_detail'));
    }

    public function updateProdiKp(Request $request, $id)
    {
        $this->validate($request, [
            'id_prodi' => 'required|integer',
        ]);

        $prodi_kp = ProdiKp::findOrFail($id);
        $prodi_kp->update($request->all());
        Session::flash('pesan', '1 Prodi Kerja Praktek berhasil diupdate');
        return redirect('pengaturan/prodi');
    }

    public function destroyProdiKp($id)
    {
        $prodi_kp = ProdiKp::findOrFail($id);
        $prodi_kp->delete();
        Session::flash('pesan', '1 Prodi Kerja Praktek berhasil dihapus');
        return redirect('pengaturan/prodi');
    }

    // total referensi utama
    public function updateReferensiUtama(Request $request, $id)
    {
        $pengaturan = Pengaturan::findOrFail($id);
        $pengaturan->min_referensi_utama = $request->post('min_referensi_utama');
        $pengaturan->save();
        Session::flash('pesan', 'Minimal Referensi Utama berhasil diupdate');
        return redirect('pengaturan/umum');
    }

    // maximal file upload
    public function updateMaxFile(Request $request, $id)
    {
        $pengaturan = Pengaturan::findOrFail($id);
        $pengaturan->max_file_upload = $request->post('max_file_upload') * 1024;
        $pengaturan->save();
        Session::flash('pesan', 'Maximal File Upload berhasil diupdate');
        return redirect('pengaturan/umum');
    }

    // pimpinan
    public function updatePanduan(Request $request, $id)
    {
        $pengaturan = \App\Pengaturan::find($id);

        $validasi = Validator::make($request->all(), [
          'panduan_siskp' => 'required|mimes:pdf|max:' . $pengaturan->max_file_upload
        ]);        

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        $input = $request->all();
        
        if($request->hasFile('panduan_siskp')){
            $this->hapusPanduan($pengaturan);
            $input['panduan_siskp'] = $this->uploadPanduan($request);
        }

        $pengaturan->update($input);
        
        Session::flash('pesan', 'Panduan SISKP Berhasil Diperbaharui!');
        return redirect()->back();
    }

    private function uploadPanduan(Request $request){
        $file = $request->file('panduan_siskp');
        $ext = $file->getClientOriginalExtension();
        if($request->file('panduan_siskp')->isValid()){
          $file_name = 'Panduan-SISKP-' . date('F') . '-' . date('Y') . ".$ext";
          $upload_path = 'assets/panduan';
          $request->file('panduan_siskp')->move($upload_path, $file_name);
          return $file_name;
        }
        return false;
    }

    private function hapusPanduan($panduan){
      $file = 'assets/panduan/'.$panduan->panduan_siskp;
      if(file_exists($file) && isset($panduan->panduan_siskp)){
      $delete = unlink($file);
        if($delete){
          return true;
        }
        return false;
      }
    }

}
