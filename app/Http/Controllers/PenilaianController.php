<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Validator;
use App\PenilaianKp;
use App\PenilaianProposal;
use App\PenilaianHasil;
use App\PenilaianSidangSkripsi;
use App\HasilAkumulasiNilaiSkripsi;
use App\NilaiUjianSkripsi;
use App\NilaiUjianKp;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NilaiUjianExport;
use App\Exports\PengujianExport;

class PenilaianController extends Controller
{
    public function __construct(){
        $this->middleware('pimpinan', ['only' => [
            'indexKerjaPraktek', 'indexSkripsi', 'detailUjian', 'storeByAdmin', 'createByAdmin', 'detailByAdmin', 'indexSkripsiCari', 'indexSkripsiExport' 
        ]]);

        $this->middleware('dosenPimpinan', ['only' => [
            'updateProposal', 'updateHasil', 'updateSidangSkripsi', 'updateKerjaPraktek' 
        ]]);
        
        $this->middleware('dosen', ['only' => [
            'dosen', 'dosenCari', 'dosenExport', 'dosenByTanggal' 
        ]]);

        $this->middleware('mahasiswa', ['only' => [
            'mahasiswa', 
        ]]);

        $this->middleware('pengguna', ['only' => [
            'detail', 
        ]]);
    }

    // pimpinan
    public function indexSkripsi()
    {
        $daftar_nilai_skripsi = HasilAkumulasiNilaiSkripsi::orderBy('id', 'desc')->paginate(10);
        $total = HasilAkumulasiNilaiSkripsi::all()->count();
        $daftar_prodi = \App\Prodi::pluck('nama', 'id');
        $filter_ujian_skripsi = true;
        return view('penilaian.index-skripsi', compact('daftar_nilai_skripsi', 'total', 'daftar_prodi', 'filter_ujian_skripsi'));
    }

    // pimpinan
    public function indexSkripsiCari(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $id_prodi = trim($request->input('id_prodi'));

      if(!empty($nama) || !empty($nim) || !empty($angkatan) || !empty($id_prodi)){

          if(!empty($nama)){
            $query = HasilAkumulasiNilaiSkripsi::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('nama', 'like', '%' . $nama . '%');
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
          }elseif(!empty($nim)){
            $query = HasilAkumulasiNilaiSkripsi::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('nim', 'like', '%' . $nim . '%');
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
          }elseif(!empty($angkatan)){
            $query = HasilAkumulasiNilaiSkripsi::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('angkatan', $angkatan);
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
          }elseif(!empty($id_prodi)){
            $query = HasilAkumulasiNilaiSkripsi::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('id_prodi', $id_prodi);
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            });
          }

          $total = $query->count();
          $daftar_nilai_skripsi = $query->paginate(10);

          $pagination = (!empty($nama)) ? $daftar_nilai_skripsi->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_nilai_skripsi->appends(['nim' => $nim]) : '';
          $pagination = (!empty($angkatan)) ? $daftar_nilai_skripsi->appends(['angkatan' => $angkatan]) : '';
          $pagination = (!empty($id_prodi)) ? $daftar_nilai_skripsi->appends(['id_prodi' => $id_prodi]) : '';
          $pagination = $daftar_nilai_skripsi->appends($request->except('page'));

        $daftar_prodi = \App\Prodi::pluck('nama', 'id');
        
        $filter_ujian_skripsi = true;
        
        return view('penilaian.index-skripsi', compact('daftar_nilai_skripsi', 'daftar_prodi', 'total', 'pagination', 'nama', 'nim', 'angkatan', 'id_prodi', 'filter_ujian_skripsi'));
      }
        return redirect('nilai-ujian/skripsi/');
    }

    // pengguna
    public function indexSkripsiExport(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $id_prodi = trim($request->input('id_prodi'));

      return Excel::download(new NilaiUjianExport($nama, $nim, $angkatan, $id_prodi), 'SISKP - Export Nilai Skripsi.xlsx');
    }

    // pimpinan
    public function indexKerjaPraktek()
    {
        $daftar_nilai_kp = NilaiUjianKp::orderBy('id', 'desc')->paginate(10);
        $total = NilaiUjianKp::all()->count();
        $daftar_prodi = \App\Prodi::pluck('nama', 'id');
        $bottom_detail = true;

        return view('penilaian.index-kerja-praktek', compact('daftar_nilai_kp', 'total', 'daftar_prodi', 'bottom_detail'));
    }

    // dosen
    public function dosen()
    {
        $daftar_pengujian = \App\DosenPenguji::where('id_dosen', Session::get('id'))->selectRaw('MONTH(created_at) bulan, YEAR(created_at) tahun, count(*) total')->groupBy('bulan', 'tahun')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->limit(24)->get();

        $bottom_detail = true;

        return view('penilaian.dosen', compact('daftar_pengujian', 'bottom_detail'));
    }

    // dosen
    public function dosenByTanggal($tanggal)
    {
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        
        $daftar_pengujian = \App\DosenPenguji::where('id_dosen', Session::get('id'))->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->orderBy('created_at', 'ASC')->get();

        $bottom_detail = true;
        
        return view('penilaian.jadwal-tanggal', compact('daftar_pengujian', 'bulan', 'tahun', 'tanggal', 'bottom_detail'));
    }

    // dosen
    public function dosenCari(Request $request)
    {
        $waktu = trim($request->input('waktu'));
        $ujian = trim($request->input('ujian'));

      if(!empty($waktu) || !empty($ujian)){

          if(!empty($waktu)){
            $query = \App\DosenPenguji::with('jadwalUjian')->where('id_dosen', Session::get('id'))->whereHas('jadwalUjian', function ($query) use ($waktu, $ujian){
                $query->where('waktu_mulai', 'like', '%' . $waktu . '%');
                (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
              });
          }elseif(!empty($ujian)){
            $query = \App\DosenPenguji::with('jadwalUjian')->where('id_dosen', Session::get('id'))->whereHas('jadwalUjian', function ($query) use ($waktu, $ujian){
              $query->where('ujian', $ujian);
              (!empty($waktu)) ? $query->where('waktu_mulai', 'like', '%' . $waktu . '%') : '';
              });
          }

          $total = $query->count();
          $daftar_penilaian = $query->paginate(10);

          $pagination = (!empty($waktu)) ? $daftar_penilaian->appends(['waktu' => $waktu]) : '';
          $pagination = (!empty($ujian)) ? $daftar_penilaian->appends(['ujian' => $ujian]) : '';
          $pagination = $daftar_penilaian->appends($request->except('page'));

        return view('penilaian.dosen', compact('daftar_penilaian', 'total', 'pagination', 'waktu', 'ujian'));
      }
        return redirect('nilai-ujian/dosen');
    }

    // dosen
    public function dosenExport(Request $request)
    {
        $waktu = trim($request->input('waktu'));
        $ujian = trim($request->input('ujian'));
        $id_dosen = Session::get('id');

      return Excel::download(new PengujianExport($id_dosen, $waktu, $ujian), 'SISKP - Export Mahasiswa Pengujian '. Session::get('nama') .'.xlsx');
    }

    // mahasiswa
    public function mahasiswa()
    {
        $hasil_akumulasi_nilai = \App\HasilAkumulasiNilaiSkripsi::where('id_mahasiswa', Session::get('id'))->get();
        $nilai_ujian_kp = \App\NilaiUjianKp::whereHas('jadwalUjian', function ($query) {
            $query->where('id_mahasiswa', Session::get('id'));
        })->get();
        return view('penilaian.detail-mahasiswa', compact('hasil_akumulasi_nilai', 'nilai_ujian_kp'));
    }

    // pimpinan & dosen
    public function updateProposal(Request $request, $id)
    {
        $jadwal = \App\JadwalUjian::find($id);

        // validasi form
        $indikator = \App\IndikatorPenilaian::where('ujian', $jadwal->ujian)->first();
        $validasi = Validator::make($request->all(), [
            'nilai.*.nilai_dospeng_satu' => 'sometimes|integer|between:0,' . $indikator->nilai_max,
            'nilai.*.nilai_dospeng_dua' => 'sometimes|integer|between:0,' . $indikator->nilai_max,
            'nilai.*.nilai_dospeng_tiga' => 'sometimes|integer|between:0,' . $indikator->nilai_max,
            'nilai.*.nilai_dospeng_empat' => 'sometimes|integer|between:0,' . $indikator->nilai_max,
            'nilai.*.id' => 'required|integer',
        ]);
        if($validasi->fails()){
            return redirect()->back()->withInput()->withErrors($validasi);
        }

        // perbaharui nilai
        foreach($request->post('nilai') as $nilai){
            $penilaianProposal = PenilaianProposal::findOrFail($nilai['id']);
            if(!empty($nilai['nilai_dospeng_satu'])) $penilaianProposal->nilai_dospeng_satu = $nilai['nilai_dospeng_satu']; 
            if(!empty($nilai['nilai_dospeng_dua'])) $penilaianProposal->nilai_dospeng_dua = $nilai['nilai_dospeng_dua']; 
            if(!empty($nilai['nilai_dospeng_tiga'])) $penilaianProposal->nilai_dospeng_tiga = $nilai['nilai_dospeng_tiga']; 
            if(!empty($nilai['nilai_dospeng_empat'])) $penilaianProposal->nilai_dospeng_empat = $nilai['nilai_dospeng_empat'];
            $penilaianProposal->save(); 
        }

        // hitung & simpan nilai rerata & rerata x bobot
        $daftar_penilaian = PenilaianProposal::where('id_jadwal_ujian', $jadwal->id)->get();
        foreach($daftar_penilaian as $hitung){
            $penilaianProposal = PenilaianProposal::findOrFail($hitung->id);
            $total = $hitung->nilai_dospeng_satu + $hitung->nilai_dospeng_dua + $hitung->nilai_dospeng_tiga + $hitung->nilai_dospeng_empat;

            $rerata = $total / 4;
            $rerata_x_bobot = $rerata * $penilaianProposal->indikatorPenilaian->bobot;
            
            $penilaianProposal->nilai_rerata = $rerata;
            $penilaianProposal->nilai_rerata_x_bobot = $rerata_x_bobot;
            $penilaianProposal->save();
        }

        // hitung & simpan jumlah & nilai akhir
        $daftar_penilaian = PenilaianProposal::where('id_jadwal_ujian', $jadwal->id)->get();
        $jumlah_nilai = $daftar_penilaian->sum('nilai_rerata_x_bobot');
        $nilai_akhir = $jumlah_nilai / 500 * 100;

        if($nilai_akhir >= 60) $status = 'lulus';
        else $status = 'tidak-lulus';

        // input nilai ujian skripsi
        NilaiUjianSkripsi::where('id_jadwal_ujian', $id)->update([
            'jumlah_nilai' => $jumlah_nilai,
            'nilai_akhir' => $nilai_akhir,
            'status' => $status
        ]);

        // input hasil akumulasi nilai skripsi
        HasilAkumulasiNilaiSkripsi::where('id_mahasiswa', $jadwal->id_mahasiswa)->update([
            'seminar_proposal' => $nilai_akhir
        ]);
        
        // hitung ulang hasil akumulasi nilai
        $hasil_akumulasi_nilai = HasilAkumulasiNilaiSkripsi::where('id_mahasiswa', $jadwal->id_mahasiswa)->first();
        $seminar_proposal = 25 * $hasil_akumulasi_nilai->seminar_proposal / 100;
        $seminar_hasil = 25 * $hasil_akumulasi_nilai->seminar_hasil / 100;
        $sidang_skripsi = 50 * $hasil_akumulasi_nilai->sidang_skripsi / 100;

        $total_hasil_akumulasi_nilai = $seminar_proposal + $seminar_hasil + $sidang_skripsi;
        switch($total_hasil_akumulasi_nilai){
            case $total_hasil_akumulasi_nilai >= 90:
                $nilai_huruf = 'A';
            break;

            case $total_hasil_akumulasi_nilai >= 85 && $total_hasil_akumulasi_nilai < 90:
                $nilai_huruf = 'A-';
            break;

            case $total_hasil_akumulasi_nilai >= 80 && $total_hasil_akumulasi_nilai < 85:
                $nilai_huruf = 'B+';
            break;

            case $total_hasil_akumulasi_nilai >= 75 && $total_hasil_akumulasi_nilai < 80:
                $nilai_huruf = 'B';
            break;

            case $total_hasil_akumulasi_nilai >= 70 && $total_hasil_akumulasi_nilai < 75:
                $nilai_huruf = 'B-';
            break;

            case $total_hasil_akumulasi_nilai >= 65 && $total_hasil_akumulasi_nilai < 70:
                $nilai_huruf = 'C+';
            break;

            case $total_hasil_akumulasi_nilai >= 60 && $total_hasil_akumulasi_nilai < 65:
                $nilai_huruf = 'C';
            break;

            case $total_hasil_akumulasi_nilai >= 50 && $total_hasil_akumulasi_nilai < 60:
                $nilai_huruf = 'D';
            break;
            
            case $total_hasil_akumulasi_nilai >= 0 && $total_hasil_akumulasi_nilai < 50:
                $nilai_huruf = 'E';
            break;
        }

        // input ulang hasil akumulasi nilai skripsi
        HasilAkumulasiNilaiSkripsi::where('id_mahasiswa', $jadwal->id_mahasiswa)->update([
            'total' => $total_hasil_akumulasi_nilai,
            'nilai_huruf' => $nilai_huruf
        ]);

        // perbaharui tahapan skripsi mahasiswa
        $mahasiswa = \App\Mahasiswa::findOrFail($jadwal->id_mahasiswa);
        $mahasiswa->tahapan_skripsi = 'penulisan_skripsi';
        $mahasiswa->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $jadwal->id_mahasiswa;
        $notifikasiMahasiswa->link = 'nilai-ujian/' . $jadwal->id . '/detail';
        $notifikasiMahasiswa->jenis = 'nilai-ujian';
        $notifikasiMahasiswa->deskripsi = 'Salah satu dosen penguji telah menginputkan Nilai ujian <strong> ' . ucwords(str_replace('-', ' ', $jadwal->ujian)) . '</strong> anda';
        $notifikasiMahasiswa->save();

        Session::flash('pesan', 'Penilaian Proposal Berhasil Diperbaharui');
        return redirect('nilai-ujian/'.$jadwal->id.'/detail');
    }

    // pimpinan & dosen
    public function updateHasil(Request $request, $id)
    {
        $jadwal = \App\JadwalUjian::find($id);

        // validasi form
        $indikator = \App\IndikatorPenilaian::where('ujian', $jadwal->ujian)->first();
        $validasi = Validator::make($request->all(), [
            'nilai.*.nilai_dospeng_satu' => 'sometimes|integer|between:0,' . $indikator->nilai_max,
            'nilai.*.nilai_dospeng_dua' => 'sometimes|integer|between:0,' . $indikator->nilai_max,
            'nilai.*.nilai_dospeng_tiga' => 'sometimes|integer|between:0,' . $indikator->nilai_max,
            'nilai.*.nilai_dospeng_empat' => 'sometimes|integer|between:0,' . $indikator->nilai_max,
            'nilai.*.id' => 'required|integer',
        ]);
        if($validasi->fails()){
            return redirect()->back()->withInput()->withErrors($validasi);
        }

        // perbaharui nilai
        foreach($request->post('nilai') as $nilai){
            $penilaianHasil = PenilaianHasil::findOrFail($nilai['id']);
            if(!empty($nilai['nilai_dospeng_satu'])) $penilaianHasil->nilai_dospeng_satu = $nilai['nilai_dospeng_satu']; 
            if(!empty($nilai['nilai_dospeng_dua'])) $penilaianHasil->nilai_dospeng_dua = $nilai['nilai_dospeng_dua']; 
            if(!empty($nilai['nilai_dospeng_tiga'])) $penilaianHasil->nilai_dospeng_tiga = $nilai['nilai_dospeng_tiga']; 
            if(!empty($nilai['nilai_dospeng_empat'])) $penilaianHasil->nilai_dospeng_empat = $nilai['nilai_dospeng_empat'];
            $penilaianHasil->save(); 
        }

        // hitung & simpan nilai rerata & rerata x bobot
        $daftar_penilaian = PenilaianHasil::where('id_jadwal_ujian', $jadwal->id)->get();
        foreach($daftar_penilaian as $hitung){
            $penilaianHasil = PenilaianHasil::findOrFail($hitung->id);
            $total = $hitung->nilai_dospeng_satu + $hitung->nilai_dospeng_dua + $hitung->nilai_dospeng_tiga + $hitung->nilai_dospeng_empat;

            $rerata = $total / 4;
            $rerata_x_bobot = $rerata * $penilaianHasil->indikatorPenilaian->bobot;
            
            $penilaianHasil->nilai_rerata = $rerata;
            $penilaianHasil->nilai_rerata_x_bobot = $rerata_x_bobot;
            $penilaianHasil->save();
        }

        // hitung & simpan jumlah & nilai akhir
        $daftar_penilaian = PenilaianHasil::where('id_jadwal_ujian', $jadwal->id)->get();
        $jumlah_nilai = $daftar_penilaian->sum('nilai_rerata_x_bobot');
        $nilai_akhir = $jumlah_nilai / 500 * 100;

        if($nilai_akhir >= 60) $status = 'lulus';
        else $status = 'tidak-lulus';

        // input nilai ujian skripsi
        NilaiUjianSkripsi::where('id_jadwal_ujian', $id)->update([
            'jumlah_nilai' => $jumlah_nilai,
            'nilai_akhir' => $nilai_akhir,
            'status' => $status
        ]);

        // input hasil akumulasi nilai skripsi
        HasilAkumulasiNilaiSkripsi::where('id_mahasiswa', $jadwal->id_mahasiswa)->update([
            'seminar_hasil' => $nilai_akhir
        ]);
        
        // hitung ulang hasil akumulasi nilai
        $hasil_akumulasi_nilai = HasilAkumulasiNilaiSkripsi::where('id_mahasiswa', $jadwal->id_mahasiswa)->first();
        $seminar_proposal = 25 * $hasil_akumulasi_nilai->seminar_proposal / 100;
        $seminar_hasil = 25 * $hasil_akumulasi_nilai->seminar_hasil / 100;
        $sidang_skripsi = 50 * $hasil_akumulasi_nilai->sidang_skripsi / 100;

        $total_hasil_akumulasi_nilai = $seminar_proposal + $seminar_hasil + $sidang_skripsi;
        switch($total_hasil_akumulasi_nilai){
            case $total_hasil_akumulasi_nilai >= 90:
                $nilai_huruf = 'A';
            break;

            case $total_hasil_akumulasi_nilai >= 85 && $total_hasil_akumulasi_nilai < 90:
                $nilai_huruf = 'A-';
            break;

            case $total_hasil_akumulasi_nilai >= 80 && $total_hasil_akumulasi_nilai < 85:
                $nilai_huruf = 'B+';
            break;

            case $total_hasil_akumulasi_nilai >= 75 && $total_hasil_akumulasi_nilai < 80:
                $nilai_huruf = 'B';
            break;

            case $total_hasil_akumulasi_nilai >= 70 && $total_hasil_akumulasi_nilai < 75:
                $nilai_huruf = 'B-';
            break;

            case $total_hasil_akumulasi_nilai >= 65 && $total_hasil_akumulasi_nilai < 70:
                $nilai_huruf = 'C+';
            break;

            case $total_hasil_akumulasi_nilai >= 60 && $total_hasil_akumulasi_nilai < 65:
                $nilai_huruf = 'C';
            break;
            
            case $total_hasil_akumulasi_nilai >= 50 && $total_hasil_akumulasi_nilai < 60:
                $nilai_huruf = 'D';
            break;
            
            case $total_hasil_akumulasi_nilai >= 0 && $total_hasil_akumulasi_nilai < 50:
                $nilai_huruf = 'E';
            break;
        }

        // input ulang hasil akumulasi nilai skripsi
        HasilAkumulasiNilaiSkripsi::where('id_mahasiswa', $jadwal->id_mahasiswa)->update([
            'total' => $total_hasil_akumulasi_nilai,
            'nilai_huruf' => $nilai_huruf
        ]);

        // perbaharui tahapan skripsi mahasiswa
        $mahasiswa = \App\Mahasiswa::findOrFail($jadwal->id_mahasiswa);
        $mahasiswa->tahapan_skripsi = 'revisi_skripsi';
        $mahasiswa->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $jadwal->id_mahasiswa;
        $notifikasiMahasiswa->link = 'nilai-ujian/' . $jadwal->id . '/detail';
        $notifikasiMahasiswa->jenis = 'nilai-ujian';
        $notifikasiMahasiswa->deskripsi = 'Salah satu dosen penguji telah menginputkan Nilai ujian <strong> ' . ucwords(str_replace('-', ' ', $jadwal->ujian)) . '</strong> anda';
        $notifikasiMahasiswa->save();

        Session::flash('pesan', 'Penilaian Hasil Berhasil Diperbaharui');
        return redirect('nilai-ujian/'.$jadwal->id.'/detail');
    }

    // pimpinan & dosen
    public function updateSidangSkripsi(Request $request, $id)
    {
        $jadwal = \App\JadwalUjian::find($id);

        // validasi form
        $indikator = \App\IndikatorPenilaian::where('ujian', $jadwal->ujian)->first();
        $validasi = Validator::make($request->all(), [
            'nilai.*.nilai_dospeng_satu' => 'sometimes|integer|between:0,' . $indikator->nilai_max,
            'nilai.*.nilai_dospeng_dua' => 'sometimes|integer|between:0,' . $indikator->nilai_max,
            'nilai.*.nilai_dospeng_tiga' => 'sometimes|integer|between:0,' . $indikator->nilai_max,
            'nilai.*.nilai_dospeng_empat' => 'sometimes|integer|between:0,' . $indikator->nilai_max,
            'nilai.*.id' => 'required|integer',
        ]);
        if($validasi->fails()){
            return redirect()->back()->withInput()->withErrors($validasi);
        }

        // perbaharui nilai
        foreach($request->post('nilai') as $nilai){
            $penilaianSidangSkripsi = PenilaianSidangSkripsi::findOrFail($nilai['id']);
            if(!empty($nilai['nilai_dospeng_satu'])) $penilaianSidangSkripsi->nilai_dospeng_satu = $nilai['nilai_dospeng_satu']; 
            if(!empty($nilai['nilai_dospeng_dua'])) $penilaianSidangSkripsi->nilai_dospeng_dua = $nilai['nilai_dospeng_dua']; 
            if(!empty($nilai['nilai_dospeng_tiga'])) $penilaianSidangSkripsi->nilai_dospeng_tiga = $nilai['nilai_dospeng_tiga']; 
            if(!empty($nilai['nilai_dospeng_empat'])) $penilaianSidangSkripsi->nilai_dospeng_empat = $nilai['nilai_dospeng_empat'];
            $penilaianSidangSkripsi->save(); 
        }

        // hitung & simpan nilai rerata & rerata x bobot
        $daftar_penilaian = PenilaianSidangSkripsi::where('id_jadwal_ujian', $jadwal->id)->get();
        foreach($daftar_penilaian as $hitung){
            $penilaianSidangSkripsi = PenilaianSidangSkripsi::findOrFail($hitung->id);
            $total = $hitung->nilai_dospeng_satu + $hitung->nilai_dospeng_dua + $hitung->nilai_dospeng_tiga + $hitung->nilai_dospeng_empat;

            $rerata = $total / 4;
            $rerata_x_bobot = $rerata * $penilaianSidangSkripsi->indikatorPenilaian->bobot;
            
            $penilaianSidangSkripsi->nilai_rerata = $rerata;
            $penilaianSidangSkripsi->nilai_rerata_x_bobot = $rerata_x_bobot;
            $penilaianSidangSkripsi->save();
        }

        // hitung & simpan jumlah & nilai akhir
        $daftar_penilaian = PenilaianSidangSkripsi::where('id_jadwal_ujian', $jadwal->id)->get();
        $jumlah_nilai = $daftar_penilaian->sum('nilai_rerata_x_bobot');
        $nilai_akhir = $jumlah_nilai / 500 * 100;

        if($nilai_akhir >= 60) $status = 'lulus';
        else $status = 'tidak-lulus';

        // input nilai ujian skripsi
        NilaiUjianSkripsi::where('id_jadwal_ujian', $id)->update([
            'jumlah_nilai' => $jumlah_nilai,
            'nilai_akhir' => $nilai_akhir,
            'status' => $status
        ]);

        // input hasil akumulasi nilai skripsi
        HasilAkumulasiNilaiSkripsi::where('id_mahasiswa', $jadwal->id_mahasiswa)->update([
            'sidang_skripsi' => $nilai_akhir
        ]);
        
        // hitung ulang hasil akumulasi nilai
        $hasil_akumulasi_nilai = HasilAkumulasiNilaiSkripsi::where('id_mahasiswa', $jadwal->id_mahasiswa)->first();
        $seminar_proposal = 25 * $hasil_akumulasi_nilai->seminar_proposal / 100;
        $seminar_hasil = 25 * $hasil_akumulasi_nilai->seminar_hasil / 100;
        $sidang_skripsi = 50 * $hasil_akumulasi_nilai->sidang_skripsi / 100;

        $total_hasil_akumulasi_nilai = $seminar_proposal + $seminar_hasil + $sidang_skripsi;
        switch($total_hasil_akumulasi_nilai){
            case $total_hasil_akumulasi_nilai >= 90:
                $nilai_huruf = 'A';
            break;

            case $total_hasil_akumulasi_nilai >= 85 && $total_hasil_akumulasi_nilai < 90:
                $nilai_huruf = 'A-';
            break;

            case $total_hasil_akumulasi_nilai >= 80 && $total_hasil_akumulasi_nilai < 85:
                $nilai_huruf = 'B+';
            break;

            case $total_hasil_akumulasi_nilai >= 75 && $total_hasil_akumulasi_nilai < 80:
                $nilai_huruf = 'B';
            break;

            case $total_hasil_akumulasi_nilai >= 70 && $total_hasil_akumulasi_nilai < 75:
                $nilai_huruf = 'B-';
            break;

            case $total_hasil_akumulasi_nilai >= 65 && $total_hasil_akumulasi_nilai < 70:
                $nilai_huruf = 'C+';
            break;

            case $total_hasil_akumulasi_nilai >= 60 && $total_hasil_akumulasi_nilai < 65:
                $nilai_huruf = 'C';
            break;
            
            case $total_hasil_akumulasi_nilai >= 50 && $total_hasil_akumulasi_nilai < 60:
                $nilai_huruf = 'D';
            break;
            
            case $total_hasil_akumulasi_nilai >= 0 && $total_hasil_akumulasi_nilai < 50:
                $nilai_huruf = 'E';
            break;
        }

        // input ulang hasil akumulasi nilai skripsi
        HasilAkumulasiNilaiSkripsi::where('id_mahasiswa', $jadwal->id_mahasiswa)->update([
            'total' => $total_hasil_akumulasi_nilai,
            'nilai_huruf' => $nilai_huruf
        ]);

        // perbaharui tahapan skripsi mahasiswa
        $mahasiswa = \App\Mahasiswa::findOrFail($jadwal->id_mahasiswa);
        $mahasiswa->tahapan_skripsi = 'lulus';
        $mahasiswa->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $jadwal->id_mahasiswa;
        $notifikasiMahasiswa->link = 'nilai-ujian/' . $jadwal->id . '/detail';
        $notifikasiMahasiswa->jenis = 'nilai-ujian';
        $notifikasiMahasiswa->deskripsi = 'Salah satu dosen penguji telah menginputkan Nilai ujian <strong> ' . ucwords(str_replace('-', ' ', $jadwal->ujian)) . '</strong> anda';
        $notifikasiMahasiswa->save();

        Session::flash('pesan', 'Penilaian Sidang Skripsi Berhasil Diperbaharui');
        return redirect('nilai-ujian/'.$jadwal->id.'/detail');
    }

    // pimpinan & dosen
    public function updateKerjaPraktek(Request $request, $id)
    {
        $jadwal = \App\JadwalUjian::find($id);

        // validasi form
        $indikator = \App\IndikatorPenilaian::where('ujian', $jadwal->ujian)->first();
        $validasi = Validator::make($request->all(), [
            'nilai.*.nilai' => 'required|integer|between:' . $indikator->nilai_min . ',' . $indikator->nilai_max,
            'nilai.*.id' => 'required|integer',
            'nilai.*.bobot' => 'required|integer'
        ]);
        if($validasi->fails()){
            return redirect()->back()->withInput()->withErrors($validasi);
        }

        // perbaharui nilai
        foreach($request->post('nilai') as $nilai){
            PenilaianKp::where('id', $nilai['id'])->update([
                'nilai' => $nilai['nilai']
            ]);
        }

        // siapkan variabel untuk menampung nilai tiap indikator penilaian
        for ($i=1; $i<=count($request->post('nilai')); $i++) { 
            $penilaian[$i] = 0;
        }

        // siapkan variabel untuk menampung total nilai tiap dosen
        for ($i=1; $i<=3; $i++) { 
            $nilai_penguji[$i] = 0;
        }

        // cari dosen penguji 
        $daftar_dosen = PenilaianKp::where('id_jadwal_ujian', $id)->get('id_dosen')->unique('id_dosen');

        // hitung total nilai tiap dosen
        $i=1;
        foreach($daftar_dosen as $dosen){
            $daftar_nilai = PenilaianKp::where('id_jadwal_ujian', $id)->where('id_dosen', $dosen->id_dosen)->get();
            
            $j=1;
            foreach($daftar_nilai as $nilai){
                $penilaian[$j] = $nilai->nilai * $nilai->indikatorPenilaian->bobot / 100;
                $j++;
            }
            $nilai_penguji[$i] = array_sum($penilaian);
            $i++;
        }

        // total nilai adalah rata-rata dari total nilai tiap dosen penguji
        $total_nilai = array_sum($nilai_penguji) / 3;

        if($total_nilai >= 55) $status = 'lulus';
        else $status = 'tidak-lulus';

        if($total_nilai >= 90 && $total_nilai <= 100) $nilai_huruf = 'A';
        elseif($total_nilai >= 85 && $total_nilai < 90) $nilai_huruf = 'A-';
        elseif($total_nilai >= 80 && $total_nilai < 85) $nilai_huruf = 'B+';
        elseif($total_nilai >= 75 && $total_nilai < 80) $nilai_huruf = 'B';
        elseif($total_nilai >= 70 && $total_nilai < 75) $nilai_huruf = 'B-';
        elseif($total_nilai >= 65 && $total_nilai < 70) $nilai_huruf = 'C+';
        elseif($total_nilai >= 60 && $total_nilai < 65) $nilai_huruf = 'C';
        elseif($total_nilai >= 50 && $total_nilai < 60) $nilai_huruf = 'D';
        else $nilai_huruf = 'E';

        // input nilai ujian kp
        NilaiUjianKp::where('id_jadwal_ujian', $id)->update([
            'total' => $total_nilai,
            'nilai_huruf' => $nilai_huruf,
            'status' => $status
        ]);

        // perbaharui tahapan kp mahasiswa
        $mahasiswa = \App\Mahasiswa::findOrFail($jadwal->id_mahasiswa);
        if($status === 'lulus') $mahasiswa->tahapan_kp = 'lulus';
        else $mahasiswa->tahapan_kp = 'revisi';
        $mahasiswa->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $jadwal->id_mahasiswa;
        $notifikasiMahasiswa->link = 'nilai-ujian/' . $jadwal->id . '/detail';
        $notifikasiMahasiswa->jenis = 'nilai-ujian';
        $notifikasiMahasiswa->deskripsi = 'Salah satu dosen penguji telah menginputkan Nilai ujian <strong> ' . ucwords(str_replace('-', ' ', $jadwal->ujian)) . '</strong> anda';
        $notifikasiMahasiswa->save();

        Session::flash('pesan', 'Penilaian Kerja Praktek Berhasil Diperbaharui');
        return redirect('nilai-ujian/'.$jadwal->id.'/detail');
    }

    // pengguna
    public function detail($id)
    {
        $jadwal = \App\JadwalUjian::findOrFail($id);
        
        if($jadwal->ujian === 'proposal'){
            $indikator = \App\IndikatorPenilaian::where('ujian', 'proposal')->first();
            $dosen = \App\PenilaianProposal::where('id_jadwal_ujian', $id)->first();
            $penilaian_ujian = \App\PenilaianProposal::where('id_jadwal_ujian', $id)->get();
            $dospeng = null;
        }elseif($jadwal->ujian === 'hasil'){
            $indikator = \App\IndikatorPenilaian::where('ujian', 'hasil')->first();
            $dosen = \App\PenilaianHasil::where('id_jadwal_ujian', $id)->first();
            $penilaian_ujian = \App\PenilaianHasil::where('id_jadwal_ujian', $id)->get();
            $dospeng = null;
        }elseif($jadwal->ujian === 'sidang-skripsi'){
            $indikator = \App\IndikatorPenilaian::where('ujian', 'sidang-skripsi')->first();
            $dosen = \App\PenilaianSidangSkripsi::where('id_jadwal_ujian', $id)->first();
            $penilaian_ujian = \App\PenilaianSidangSkripsi::where('id_jadwal_ujian', $id)->get();
            $dospeng = null;
        }elseif($jadwal->ujian === 'kerja-praktek'){
            $indikator = \App\IndikatorPenilaian::where('ujian', 'kerja-praktek')->first();
            $dospeng = $jadwal->penilaianKp->groupBy('id_dosen');
            $penilaian_ujian = null;
            $dosen = null;
        }

        if(Session::has('dosen')){
            $cek_dospeng = \App\DosenPenguji::where('id_jadwal_ujian', $jadwal->id)->where('id_dosen', Session::get('id'))->first();
            if($cek_dospeng) $penguji = $cek_dospeng->id_dosen;
            else $penguji = false;
        }else $penguji = false;
        
        $bottom_detail = true;
        return view('penilaian.detail', compact('jadwal', 'penguji', 'indikator', 'penilaian_ujian', 'dosen', 'dospeng', 'bottom_detail'));
    }

    // pimpinan
    public function detailUjian($id, Request $request)
    {
        $mahasiswa = \App\Mahasiswa::find($id);

        if($request->segment(3) === 'detail-proposal') $ujian = 'proposal';
        elseif($request->segment(3) === 'detail-hasil') $ujian = 'hasil';
        elseif($request->segment(3) === 'detail-sidang-skripsi') $ujian = 'sidang-skripsi';
        
        $jadwal = \App\JadwalUjian::where('id_mahasiswa', $id)->where('ujian', $ujian)->first();
        
        if(!$jadwal) return redirect()->back()->with('kesalahan', 'Detail Nilai Ujian Tidak Tersedia!');

        if($jadwal->ujian === 'proposal'){
            $indikator = \App\IndikatorPenilaian::where('ujian', 'proposal')->first();
            $dosen = \App\PenilaianProposal::where('id_jadwal_ujian', $jadwal->id)->first();
            $penilaian_ujian = \App\PenilaianProposal::where('id_jadwal_ujian', $jadwal->id)->get();
            $dospeng = null;
        }elseif($jadwal->ujian === 'hasil'){
            $indikator = \App\IndikatorPenilaian::where('ujian', 'hasil')->first();
            $dosen = \App\PenilaianHasil::where('id_jadwal_ujian', $jadwal->id)->first();
            $penilaian_ujian = \App\PenilaianHasil::where('id_jadwal_ujian', $jadwal->id)->get();
            $dospeng = null;
        }elseif($jadwal->ujian === 'sidang-skripsi'){
            $indikator = \App\IndikatorPenilaian::where('ujian', 'sidang-skripsi')->first();
            $dosen = \App\PenilaianSidangSkripsi::where('id_jadwal_ujian', $jadwal->id)->first();
            $penilaian_ujian = \App\PenilaianSidangSkripsi::where('id_jadwal_ujian', $jadwal->id)->get();
            $dospeng = null;
        }elseif($jadwal->ujian === 'kerja-praktek'){
            $indikator = \App\IndikatorPenilaian::where('ujian', 'kerja-praktek')->first();
            $dospeng = $jadwal->penilaianKp->groupBy('id_dosen');
            $penilaian_ujian = null;
            $dosen = null;
        }

        if(Session::has('dosen')){
            $cek_dospeng = \App\DosenPenguji::where('id_jadwal_ujian', $jadwal->id)->where('id_dosen', Session::get('id'))->first();
            if($cek_dospeng) $penguji = $cek_dospeng->id_dosen;
            else $penguji = false;
        }else $penguji = false;

        return view('penilaian.detail', compact('jadwal', 'penguji', 'indikator', 'penilaian_ujian', 'dosen', 'dospeng'));
    }

    // pimpinan
    public function detailByAdmin($id)
    {
        $nilai_skripsi = HasilAkumulasiNilaiSkripsi::where('id_mahasiswa', $id)->first();
        $bottom_detail = true;

        return view('penilaian.detail-by-admin', compact('nilai_skripsi', 'bottom_detail'));
    }

    // pimpinan
    public function createByAdmin($id)
    {
        $bottom_detail = true;
        $mahasiswa = \App\Mahasiswa::findOrFail($id);
        return view('penilaian.create-by-admin', compact('mahasiswa', 'bottom_detail'));
    }

    // pimpinan
    public function storeByAdmin(Request $request, $id)
    {
        // return $request->all();
        $validasi = Validator::make($request->all(), [
            'jenis_ujian' => 'required|string|in:proposal,hasil,sidang-skripsi',
            'nilai_ujian' => 'required|numeric|between:0,100.00'
        ]);

        if($validasi->fails()){
            return redirect()->back()->withInput()->withErrors($validasi);
        }

        if($request->post('jenis_ujian') === 'proposal'){
            \App\HasilAkumulasiNilaiSkripsi::updateOrCreate(
                ['id_mahasiswa' => $id], 
                ['seminar_proposal' => $request->post('nilai_ujian')]
            );
        }elseif($request->post('jenis_ujian') === 'hasil'){
            \App\HasilAkumulasiNilaiSkripsi::updateOrCreate(
                ['id_mahasiswa' => $id], 
                ['seminar_hasil' => $request->post('nilai_ujian')]
            );
        }elseif($request->post('jenis_ujian') === 'sidang-skripsi'){
            \App\HasilAkumulasiNilaiSkripsi::updateOrCreate(
                ['id_mahasiswa' => $id], 
                ['sidang_skripsi' => $request->post('nilai_ujian')]
            );
        }
        
        // hitung ulang hasil akumulasi nilai
        $hasil_akumulasi_nilai = \App\HasilAkumulasiNilaiSkripsi::where('id_mahasiswa', $id)->first();
        $seminar_proposal = 25 * $hasil_akumulasi_nilai->seminar_proposal / 100;
        $seminar_hasil = 25 * $hasil_akumulasi_nilai->seminar_hasil / 100;
        $sidang_skripsi = 50 * $hasil_akumulasi_nilai->sidang_skripsi / 100;

        $total_hasil_akumulasi_nilai = $seminar_proposal + $seminar_hasil + $sidang_skripsi;
        switch($total_hasil_akumulasi_nilai){
            case $total_hasil_akumulasi_nilai >= 90:
                $nilai_huruf = 'A';
            break;

            case $total_hasil_akumulasi_nilai >= 85 && $total_hasil_akumulasi_nilai < 90:
                $nilai_huruf = 'A-';
            break;

            case $total_hasil_akumulasi_nilai >= 80 && $total_hasil_akumulasi_nilai < 85:
                $nilai_huruf = 'B+';
            break;

            case $total_hasil_akumulasi_nilai >= 75 && $total_hasil_akumulasi_nilai < 80:
                $nilai_huruf = 'B';
            break;

            case $total_hasil_akumulasi_nilai >= 70 && $total_hasil_akumulasi_nilai < 75:
                $nilai_huruf = 'B-';
            break;

            case $total_hasil_akumulasi_nilai >= 65 && $total_hasil_akumulasi_nilai < 70:
                $nilai_huruf = 'C+';
            break;

            case $total_hasil_akumulasi_nilai >= 60 && $total_hasil_akumulasi_nilai < 65:
                $nilai_huruf = 'C';
            break;

            case $total_hasil_akumulasi_nilai >= 50 && $total_hasil_akumulasi_nilai < 60:
                $nilai_huruf = 'D';
            break;

            case $total_hasil_akumulasi_nilai >= 0 && $total_hasil_akumulasi_nilai < 50:
                $nilai_huruf = 'E';
            break;
        }

        // input ulang hasil akumulasi nilai skripsi
        \App\HasilAkumulasiNilaiSkripsi::where('id_mahasiswa', $id)->update([
            'total' => $total_hasil_akumulasi_nilai,
            'nilai_huruf' => $nilai_huruf
        ]);

        // perbaharui tahapan skripsi mahasiswa
        $mahasiswa = \App\Mahasiswa::findOrFail($id);
        
        if($request->post('jenis_ujian') === 'proposal'){
            $mahasiswa->tahapan_skripsi = 'penulisan_skripsi';
        }elseif($request->post('jenis_ujian') === 'hasil'){
            $mahasiswa->tahapan_skripsi = 'revisi_skripsi';
        }elseif($request->post('jenis_ujian') === 'sidang-skripsi'){
            $mahasiswa->tahapan_skripsi = 'lulus';
        }
        $mahasiswa->save();

        Session::flash('pesan', 'Nilai Ujian Berhasil Diinput');
        return redirect('nilai-ujian/skripsi');
    }

}
