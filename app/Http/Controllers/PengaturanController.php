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

        return view('pengaturan.index-umum', compact(
            'pengaturan'
        ));
    }

    public function indexPimpinan()
    {
        $daftar_kajur = Kajur::latest()->get();
        $daftar_kaprodi = Kaprodi::latest()->get();

        return view('pengaturan.index-pimpinan', compact(
            'daftar_kajur', 'daftar_kaprodi'
        ));
    }

    public function indexProdi()
    {
        $daftar_prodi = Prodi::all();
        $daftar_prodi_kp = ProdiKp::all();
        
        return view('pengaturan.index-prodi', compact(
            'daftar_prodi', 'daftar_prodi_kp'
        ));
    }

    public function indexPenilaian()
    {
        $daftar_penilaian = IndikatorPenilaian::all();
        return view('pengaturan.index-penilaian', compact(
            'daftar_penilaian'
        ));
    }

    // program Studi
    public function createProdi()
    {
        return view('pengaturan.create-prodi');
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
        $prodi = Prodi::findOrFail($id);
        return view('pengaturan.edit-prodi', compact('prodi'));
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

        return view('pengaturan.tambah-kajur', compact('daftar_dosen'));
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

        return view('pengaturan.edit-kajur', compact('kajur', 'daftar_dosen'));
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
        return view('pengaturan.create-kaprodi', compact('daftar_dosen', 'daftar_prodi'));
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

        return view('pengaturan.edit-kaprodi', compact('kaprodi', 'daftar_dosen', 'daftar_prodi'));
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

    public function destroyKajur($id)
    {
        $kajur = Kajur::findOrFail($id);
        $kajur->delete();
        Session::flash('pesan', '1 Kajur berhasil dihapus');
        return redirect('pengaturan/pimpinan');
    }

    // prodi_kp
    public function createProdiKp()
    {
        $daftar_prodi = Prodi::pluck('nama', 'id');
        return view('pengaturan.create-prodi-kp', compact('daftar_prodi'));
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

        return view('pengaturan.edit-prodi-kp', compact('prodi_kp', 'daftar_prodi'));
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

    // usulan topik
    public function updateUsulanTopik(Request $request, $id)
    {
        $pengaturan = Pengaturan::findOrFail($id);
        $pengaturan->min_referensi_utama = $request->post('min_referensi_utama');
        $pengaturan->skor_sertifikat_kompetensi = $request->post('skor_sertifikat_kompetensi');
        $pengaturan->save();
        Session::flash('pesan', 'Pengaturan Usulan Topik berhasil diupdate');
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
    public function updateTurunKp(Request $request, $id)
    {
        $pengaturan = Pengaturan::findOrFail($id);
        $pengaturan->scan_persetujuan_kantor = $request->post('scan_persetujuan_kantor');
        $pengaturan->save();
        Session::flash('pesan', 'Pengaturan Turun Kerja Praktek berhasil diupdate');
        return redirect('pengaturan/umum');
    }

    // pimpinan
    public function updateUjian(Request $request, $id)
    {
        $pengaturan = Pengaturan::findOrFail($id);
        $pengaturan->skor_sertifikat_toefl = $request->post('skor_sertifikat_toefl');
        $pengaturan->file_laporan = $request->post('file_laporan');
        $pengaturan->persetujuan_ujian = $request->post('persetujuan_ujian');
        $pengaturan->save();
        Session::flash('pesan', 'Pengaturan Ujian berhasil diupdate');
        return redirect('pengaturan/umum');
    }


}
