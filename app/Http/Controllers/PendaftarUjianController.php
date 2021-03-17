<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PeriodeDaftarUjian;
use App\PendaftarUjian;
use Session;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PendaftarUjianExport;

class PendaftarUjianController extends Controller
{
    public function __construct(){
        $this->middleware('mahasiswa', ['only' => [
            'index', 'create', 'store', 'edit', 'update'
        ]]);

        $this->middleware('mahasiswaPimpinan', ['only' => [
            'show', 'destroy'
        ]]);

        $this->middleware('pimpinan', ['only' => [
            'semuaPendaftar', 'detailPeriode', 'validasi', 'uploadPlagiasi', 'destroyPlagiasi', 'detailPeriodeCari', 'detailPeriodeExport', 'createJadwal', 'setujuiSemua', 'formInputByAdmin', 'inputByAdmin'
        ]]);
    }

    // mahasiswa
    public function index()
    {
        $sub_menu = true;

        $pengaturan = \App\Pengaturan::find(1);

        $total = 0;
        $daftar_ujian = PendaftarUjian::where('id_mahasiswa', Session::get('id'))->get();

        $periode_aktif = PeriodeDaftarUjian::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;
        if($periode_aktif)
        {
            $total = PendaftarUjian::where('id_periode_daftar_ujian', $periode_aktif->id)->count();
            $daftar_pendaftar = PendaftarUjian::where('id_periode_daftar_ujian', $periode_aktif->id)->paginate(10);
            return view('pendaftar-ujian.index', compact('periode_aktif', 'daftar_pendaftar', 'daftar_ujian', 'pengaturan', 'sub_menu', 'total'));
        }else{
            return view('pendaftar-ujian.index', compact('daftar_ujian', 'pengaturan', 'sub_menu', 'total'));
        }
    }

    // mahasiswa
    public function create()
    {
        $periode_aktif = PeriodeDaftarUjian::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;
        if(!$periode_aktif){
            Session::flash('kesalahan', 'Pendaftaran Ujian Belum Dibuka');
            return redirect()->back();
        }

        $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));

        // validasi dosen PA
        if(empty($mahasiswa->id_dosen)){
            return redirect()->back()->with('kesalahan', 'Anda belum memasukan Dosen Pendamping Akademik');
        }

        // validasi Prodi
        if(empty($mahasiswa->id_prodi)){
            return redirect()->back()->with('kesalahan', 'Anda belum memasukan Program Studi');
        }

        $pengaturan = \App\Pengaturan::find(1);

        // validasi mahasiswa kontrak skripsi
        if($mahasiswa->kontrak_skripsi === 'ya' || $mahasiswa->kontrak_kp === 'ya'){
            return view('pendaftar-ujian.create', compact('pengaturan'));
        }else{
            return redirect()->back()->with('kesalahan', 'Anda belum mengontrak Mata Kuliah Skripsi dan/atau Kerja Praktek');
        }
    }

    // mahasiswa
    public function store(Request $request)
    {
        $pengaturan = \App\Pengaturan::find(1);
        $id_periode = $request->get('id');

        if($pengaturan->file_laporan === 'wajib') $validasi_file_laporan = 'required';
        elseif($pengaturan->file_laporan === 'tidak-wajib' || $pengaturan->file_laporan === 'hilangkan'){
          $validasi_file_laporan = 'sometimes';
        }

        if($pengaturan->persetujuan_ujian === 'wajib') $validasi_persetujuan_ujian = 'required';
        elseif($pengaturan->persetujuan_ujian === 'tidak-wajib' || $pengaturan->persetujuan_ujian === 'hilangkan'){
          $validasi_persetujuan_ujian = 'sometimes';
        }

        $validasi = Validator::make($request->all(), [
          'ujian' => 'required|in:proposal,hasil,kerja-praktek,sidang-skripsi',
          'file_laporan' => $validasi_file_laporan . '|mimes:pdf|max:' . $pengaturan->max_file_upload,
          'file_lembar_persetujuan' => $validasi_persetujuan_ujian . '|mimes:pdf|max:' . $pengaturan->max_file_upload,
        ]);

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        if($request->post('ujian') === 'sidang-skripsi'){
            if($pengaturan->skor_sertifikat_toefl === 'wajib') $validasi_skor_sertifikat_toefl = 'required';
            elseif($pengaturan->skor_sertifikat_toefl === 'tidak-wajib' || $pengaturan->skor_sertifikat_toefl === 'hilangkan'){
                $validasi_skor_sertifikat_toefl = 'sometimes';
            }

            $validasi = Validator::make($request->all(), [
                'file_sertifikat_toefl' => $validasi_skor_sertifikat_toefl . '|mimes:pdf|max:' . $pengaturan->max_file_upload,
                'skor_toefl' => $validasi_skor_sertifikat_toefl . '|string'
            ]);

            if($validasi->fails()){
                return redirect()->back()->withInput()->withErrors($validasi);
            }
        }

        if($request->post('ujian') === 'kerja-praktek' && empty($request->post('judul_laporan_kp'))){
            return redirect()->back()->with('kesalahan', 'Untuk mendaftar ujian kerja praktek, wajib memasukan judul laporan kerja praktek!');
        }

        $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));

        // validasi dosen PA
        if(empty($mahasiswa->id_dosen)){
            return redirect()->back()->withInput()->with('kesalahan', 'Dosen Pendamping Akademik anda masih kosong, silahkan lengkapi Profil anda terlebih dahulu');
        }

        // validasi Prodi
        if(empty($mahasiswa->id_prodi)){
            return redirect()->back()->withInput()->with('kesalahan', 'Program Studi anda masih kosong, silahkan lengkapi Profil anda terlebih dahulu');
        }

        if($request->post('ujian') === 'proposal' || $request->post('ujian') === 'hasil' || $request->post('ujian') === 'sidang-skripsi'){

            // validasi mahasiswa kontrak skripsi
            if($mahasiswa->kontrak_skripsi === 'tidak'){
                return redirect()->back()->withInput()->with('kesalahan', 'Anda belum mengontrak Mata Kuliah Skripsi');
            }

            // validasi usulan topik diterima
            $usulan_topik_diterima = \App\PendaftarUsulanTopik::where('id_mahasiswa', Session::get('id'))->where('tahapan', 'diterima')->first() or null;
            if(empty($usulan_topik_diterima)) return redirect()->back()->withInput()->with('kesalahan', 'Judul skripsi anda masih kosong, silahkan minta Admin untuk memasukannya!');

            // validasi dosbing skripsi
            $dosbing = \App\DosenPembimbingSkripsi::where('id_mahasiswa', Session::get('id'))->get()->last();
            if(empty($dosbing)) return redirect()->back()->withInput()->with('kesalahan', 'Dosen Pembimbing Skripsi masih kosong, Silahkan minta Admin untuk memasukannya!');

            if($request->post('ujian') === 'proposal'){

                // perbaharui tahapan skripsi mahasiswa
                $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));
                $mahasiswa->tahapan_skripsi = 'pendaftaran_proposal';
                $mahasiswa->save();

                // perbaharui riwayat tahapan
                $riwayatTahapan = \App\RiwayatTahapan::where('id_mahasiswa', Session::get('id'))->where('tahapan', 'pendaftaran_seminar_proposal')->first();
                if($riwayatTahapan){
                    $riwayatTahapan->created_at = now();
                    $riwayatTahapan->save();
                }else{
                    $riwayat =  new \App\RiwayatTahapan;
                    $riwayat->tahapan =  'pendaftaran_seminar_proposal';
                    $riwayat->id_mahasiswa =  Session::get('id');
                    $riwayat->save();
                }

            }elseif($request->post('ujian') === 'hasil'){

                // perbaharui tahapan skripsi mahasiswa
                $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));
                $mahasiswa->tahapan_skripsi = 'pendaftaran_hasil';
                $mahasiswa->save();

                // perbaharui riwayat tahapan
                $riwayatTahapan = \App\RiwayatTahapan::where('id_mahasiswa', Session::get('id'))->where('tahapan', 'pendaftaran_seminar_hasil')->first();
                if($riwayatTahapan){
                    $riwayatTahapan->created_at = now();
                    $riwayatTahapan->save();
                }else{
                    $riwayat =  new \App\RiwayatTahapan;
                    $riwayat->tahapan =  'pendaftaran_seminar_hasil';
                    $riwayat->id_mahasiswa =  Session::get('id');
                    $riwayat->save();
                }

            }elseif($request->post('ujian') === 'sidang-skripsi'){

                // perbaharui tahapan skripsi mahasiswa
                $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));
                $mahasiswa->tahapan_skripsi = 'pendaftaran_sidang_skripsi';
                $mahasiswa->save();

                // perbaharui riwayat tahapan
                $riwayatTahapan = \App\RiwayatTahapan::where('id_mahasiswa', Session::get('id'))->where('tahapan', 'pendaftaran_sidang_skripsi')->first();
                if($riwayatTahapan){
                    $riwayatTahapan->created_at = now();
                    $riwayatTahapan->save();
                }else{
                    $riwayat =  new \App\RiwayatTahapan;
                    $riwayat->tahapan =  'pendaftaran_sidang_skripsi';
                    $riwayat->id_mahasiswa =  Session::get('id');
                    $riwayat->save();
                }

            }

        }elseif($request->post('ujian') === 'kerja-praktek'){
            // validasi mahasiswa kontrak KP
            if($mahasiswa->kontrak_kp === 'tidak'){
                return redirect()->back()->withInput()->with('kesalahan', 'Anda belum mengontrak Mata Kuliah Kerja Praktek');
            }

            // validasi dosbing kp
            $dosbing = \App\DosenPembimbingKp::where('id_mahasiswa', Session::get('id'))->get()->last();
            if(empty($dosbing)) return redirect()->back()->withInput()->with('kesalahan', 'Dosen Pembimbing Kerja Praktek Anda masih kosong, Silahkan minta Admin untuk memasukannya!');

            // perbaharui tahapan skripsi mahasiswa
            $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));
            $mahasiswa->tahapan_kp = 'pendaftaran';
            $mahasiswa->save();

            // perbaharui riwayat tahapan
            $riwayatTahapan = \App\RiwayatTahapan::where('id_mahasiswa', Session::get('id'))->where('tahapan', 'pendaftaran_seminar_kp')->first();
            if($riwayatTahapan){
                $riwayatTahapan->created_at = now();
                $riwayatTahapan->save();
            }else{
                $riwayat =  new \App\RiwayatTahapan;
                $riwayat->tahapan =  'pendaftaran_seminar_kp';
                $riwayat->id_mahasiswa =  Session::get('id');
                $riwayat->save();
            }

        }

        $input = $request->all();

        $input['id_mahasiswa'] = Session::get('id');

        if($request->hasFile('file_laporan')){
            $input['file_laporan'] = $this->uploadFile($request);
        }
        if($request->hasFile('file_lembar_persetujuan')){
            $input['file_lembar_persetujuan'] = $this->uploadPersetujuan($request);
        }
        if($request->hasFile('file_sertifikat_toefl')){
            $input['file_sertifikat_toefl'] = $this->uploadSertifikat($request);
        }

        $pendaftar = new PendaftarUjian;
        $pendaftar->ujian = $request->post('ujian');
        if($request->hasFile('file_lembar_persetujuan')) $pendaftar->file_lembar_persetujuan = $input['file_lembar_persetujuan'];
        if($request->hasFile('file_laporan')) $pendaftar->file_laporan = $input['file_laporan'];
        if($request->hasFile('file_sertifikat_toefl')) $pendaftar->file_sertifikat_toefl = $input['file_sertifikat_toefl'];
        if($request->post('skor_toefl')) $pendaftar->skor_toefl = $request->post('skor_toefl');
        if($request->post('ujian') === 'kerja-praktek') $pendaftar->judul_laporan_kp = $request->post('judul_laporan_kp');
        $pendaftar->id_periode_daftar_ujian = $request->post('id_periode_daftar_ujian');
        $pendaftar->id_mahasiswa = $input['id_mahasiswa'];
        $pendaftar->save();

        // notifikasi admin
        $notifikasiAdmin = new \App\NotifikasiAdmin;
        $notifikasiAdmin->link = 'pendaftaran/ujian/' . $pendaftar->id;
        $notifikasiAdmin->jenis = 'pendaftaran';
        $notifikasiAdmin->deskripsi = Session::get('nama') . ' mendaftar ujian : <strong>'. ucwords(str_replace('-', ' ', $pendaftar->ujian)) .'</strong>. Silahkan validasi berkas ujiannya';
        $notifikasiAdmin->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = Session::get('id');
        $notifikasiMahasiswa->link = 'pendaftaran/ujian/' . $pendaftar->id;
        $notifikasiMahasiswa->jenis = 'pendaftaran';
        $notifikasiMahasiswa->deskripsi = 'Berkas ujian : <strong> '. ucwords(str_replace('-', ' ', $pendaftar->ujian)) .' </strong> anda sedang <strong>DIPERIKSA</strong>. Silahkan menunggu!';
        $notifikasiMahasiswa->save();

        Session::flash('pesan', 'Anda Berhasil Mendaftar Ujian!');
        return redirect('pendaftaran/ujian');
    }

    // mahasiswa & pimpinan
    public function show($id)
    {
        $pengaturan = \App\Pengaturan::find(1);
        $pendaftar = PendaftarUjian::findOrFail($id);
        $usulan_topik = \App\PendaftarUsulanTopik::where('id_mahasiswa', $pendaftar->id_mahasiswa)->first();
        $plagiasi = \App\HasilPlagiasi::where('id_pendaftar_ujian', $pendaftar->id)->first();
        return view('pendaftar-ujian.detail', compact('pendaftar', 'usulan_topik', 'plagiasi', 'pengaturan'));
    }

    // mahasiswa
    public function edit($id)
    {
        $pengaturan = \App\Pengaturan::find(1);
        $pendaftar = PendaftarUjian::findOrFail($id);

        $mahasiswa = \App\Mahasiswa::findOrFail($pendaftar->id_mahasiswa);

        if(empty($mahasiswa->id_dosen)){
            return redirect()->back()->with('kesalahan', 'Anda belum memasukan Dosen Pendamping Akademik');
        }

        if(empty($mahasiswa->id_prodi)){
            return redirect()->back()->with('kesalahan', 'Anda belum memasukan Program Studi');
        }

        if(Session::get('id') !== $pendaftar->id_mahasiswa){
          return redirect()->back()->with('kesalahan', 'Anda Tidak Boleh Mengedit Berkas Ujian Mahasiswa Lain!');
        }

        return view('pendaftar-ujian.edit', compact('pendaftar', 'pengaturan'));
    }

    // mahasiswa
    public function update(Request $request, $id)
    {
        $pengaturan = \App\Pengaturan::find(1);

        if($pengaturan->file_laporan === 'wajib') $validasi_file_laporan = 'required';
        elseif($pengaturan->file_laporan === 'tidak-wajib' || $pengaturan->file_laporan === 'hilangkan'){
          $validasi_file_laporan = 'sometimes';
        }

        if($pengaturan->persetujuan_ujian === 'wajib') $validasi_persetujuan_ujian = 'required';
        elseif($pengaturan->persetujuan_ujian === 'tidak-wajib' || $pengaturan->persetujuan_ujian === 'hilangkan'){
          $validasi_persetujuan_ujian = 'sometimes';
        }

        $validasi = Validator::make($request->all(), [
          'ujian' => 'required|in:proposal,hasil,kerja-praktek,sidang-skripsi',
          'file_laporan' => $validasi_file_laporan . '|mimes:pdf|max:'. $pengaturan->max_file_upload,
          'file_lembar_persetujuan' => $validasi_persetujuan_ujian . '|mimes:pdf|max:'. $pengaturan->max_file_upload
        ]);

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        if($request->post('ujian') === 'sidang-skripsi'){
            if($pengaturan->skor_sertifikat_toefl === 'wajib') $validasi_skor_sertifikat_toefl = 'required';
            elseif($pengaturan->skor_sertifikat_toefl === 'tidak-wajib' || $pengaturan->skor_sertifikat_toefl === 'hilangkan'){
                $validasi_skor_sertifikat_toefl = 'sometimes';
            }

            $validasi = Validator::make($request->all(), [
                'file_sertifikat_toefl' => $validasi_skor_sertifikat_toefl . '|mimes:pdf|max:' . $pengaturan->max_file_upload,
                'skor_toefl' => $validasi_skor_sertifikat_toefl . '|string'
            ]);

            if($validasi->fails()){
                return redirect()->back()->withInput()->withErrors($validasi);
            }
        }

        if($request->post('ujian') === 'kerja-praktek' && empty($request->post('judul_laporan_kp'))){
            return redirect()->back()->with('kesalahan', 'Untuk mendaftar ujian kerja praktek, wajib memasukan judul laporan kerja praktek!');
        }

        $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));

        // validasi dosen PA
        if(empty($mahasiswa->id_dosen)){
            return redirect()->back()->withInput()->with('kesalahan', 'Dosen Pendamping Akademik anda masih kosong, silahkan lengkapi Profil anda');
        }

        // validasi Prodi
        if(empty($mahasiswa->id_prodi)){
            return redirect()->back()->withInput()->with('kesalahan', 'Program Studi anda masih kosong, silahkan lengkapi Profil anda');
        }

        if($request->post('ujian') === 'proposal' || $request->post('ujian') === 'hasil' || $request->post('ujian') === 'sidang-skripsi'){

            // validasi mahasiswa kontrak skripsi
            if($mahasiswa->kontrak_skripsi === 'tidak'){
                return redirect()->back()->withInput()->with('kesalahan', 'Anda belum mengontrak Mata Kuliah Skripsi');
            }

            // validasi usulan topik diterima
            $usulan_topik_diterima = \App\PendaftarUsulanTopik::where('id_mahasiswa', Session::get('id'))->where('tahapan', 'diterima')->first() or null;
            if(empty($usulan_topik_diterima)) return redirect()->back()->withInput()->with('kesalahan', 'Judul skripsi anda masih kosong, silahkan minta Admin untuk memasukannya!');

            // cek dosen pembimbing skripsi
            $dosbing = \App\DosenPembimbingSkripsi::where('id_mahasiswa', Session::get('id'))->get()->last();
            if(empty($dosbing)) return redirect()->back()->withInput()->with('kesalahan', 'Dosen Pembimbing Skripsi Anda masih kosong, Silahkan minta Admin untuk memasukannya');

        }elseif($request->post('ujian') === 'kerja-praktek'){

            // validasi mahasiswa kontrak KP
            if($mahasiswa->kontrak_kp === 'tidak'){
                return redirect()->back()->withInput()->with('kesalahan', 'Anda belum Mengontrak Mata Kuliah Kerja Praktek');
            }

            // cek dosen pembimbing kp
            $dosbing = \App\DosenPembimbingKp::where('id_mahasiswa', Session::get('id'))->get()->last();
            if(empty($dosbing)) return redirect()->back()->withInput()->with('kesalahan', 'Dosen Pembimbing Kerja Praktek Anda masih kosong, Silahkan minta Admin untuk memasukannya');
        }

        $input = $request->all();

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        $input['id_mahasiswa'] = Session::get('id');

        $pendaftar = PendaftarUjian::findOrFail($id);

        if(Session::get('id') !== $pendaftar->id_mahasiswa){
          return redirect()->back()->with('kesalahan', 'Anda Tidak Boleh Memperbaharui Berkas Ujian Mahasiswa Lain!');
        }

        if($request->hasFile('file_laporan')){
          $this->hapusFile($pendaftar);
          $input['file_laporan'] = $this->uploadFile($request);
        }
        if($request->hasFile('file_lembar_persetujuan')){
          $this->hapusPersetujuan($pendaftar);
          $input['file_lembar_persetujuan'] = $this->uploadPersetujuan($request);
        }
        if($request->hasFile('file_sertifikat_toefl')){
            $this->hapusSertifikat($pendaftar);
            $input['file_sertifikat_toefl'] = $this->uploadSertifikat($request);
        }
        if($request->post('skor_toefl')) $input['skor_toefl'] = $request->post('skor_toefl');
        if($request->post('ujian') === 'kerja-praktek') $input['judul_laporan_kp'] = $request->post('judul_laporan_kp');

        $pendaftar->update($input);

        Session::flash('pesan', 'Pendaftar Ujian Berhasil Diperbaharui!');
        return redirect('pendaftaran/ujian');
    }

    // mahasiswa & pimpinan
    public function destroy($id)
    {
        $pendaftar = PendaftarUjian::findOrFail($id);

        if(Session::has('mahasiswa') && Session::get('id') !== $pendaftar->id_mahasiswa){
          return redirect()->back()->with('kesalahan', 'Anda Tidak Boleh Menghapus Berkas Ujian Mahasiswa Lain!');
        }

        $id_periode = $pendaftar->id_periode_daftar_ujian;

        $this->hapusFile($pendaftar);
        $this->hapusPersetujuan($pendaftar);
        $this->hapusSertifikat($pendaftar);

        $pendaftar->delete();
        Session::flash('pesan', 'Pendaftaran Ujian Berhasil Dihapus');
        if(Session::has('mahasiswa')) return redirect('pendaftaran/ujian');
        else return redirect('pendaftaran/ujian/periode/' . $id_periode);
    }

    // pimpinan
    public function semuaPendaftar()
    {
        $sub_menu = true;

        $daftar_periode_ujian = PeriodeDaftarUjian::with('pendaftarUjian')->orderBy('waktu_tutup', 'desc')->paginate(10);
        $total = PeriodeDaftarUjian::with('pendaftarUjian')->orderBy('waktu_tutup', 'desc')->count();
        return view('pendaftar-ujian.semua', compact('daftar_periode_ujian', 'total', 'sub_menu'));
    }

    // pimpinan
    public function detailPeriode($id)
    {
        $filter_ujian = true;

        $periode = PeriodeDaftarUjian::find($id);
        $daftar_ujian = PendaftarUjian::where('id_periode_daftar_ujian', $id)->orderBy('created_at', 'DESC')->paginate(10);
        $total_berkas = PendaftarUjian::where('id_periode_daftar_ujian', $id)->where('tahapan', 'diperiksa')->count();
        $total = PendaftarUjian::where('id_periode_daftar_ujian', $id)->count();
        $daftar_prodi = \App\Prodi::pluck('nama', 'id');

        return view('pendaftar-ujian.daftar-periode', compact('daftar_ujian', 'periode', 'total_berkas', 'daftar_prodi', 'total', 'id', 'filter_ujian'));
    }

    // pimpinan
    public function detailPeriodeCari(Request $request)
    {
        $nama = trim($request->input('nama'));
        $ujian = trim($request->input('ujian'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $id_prodi = trim($request->input('id_prodi'));
        $id_periode_daftar_ujian = trim($request->input('id_periode_daftar_ujian'));

      if(!empty($nama) || !empty($nim) || !empty($angkatan) || !empty($ujian) || !empty($id_prodi)){

          if(!empty($nama)){
            $query = PendaftarUjian::with('mahasiswa')->where('id_periode_daftar_ujian', $id_periode_daftar_ujian)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('nama', 'like', '%' . $nama . '%');
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
          }elseif(!empty($nim)){
            $query = PendaftarUjian::with('mahasiswa')->where('id_periode_daftar_ujian', $id_periode_daftar_ujian)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('nim', 'like', '%' . $nim . '%');
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
          }elseif(!empty($angkatan)){
            $query = PendaftarUjian::with('mahasiswa')->where('id_periode_daftar_ujian', $id_periode_daftar_ujian)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('angkatan', $angkatan);
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
          }elseif(!empty($id_prodi)){
            $query = PendaftarUjian::with('mahasiswa')->where('id_periode_daftar_ujian', $id_periode_daftar_ujian)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('id_prodi', $id_prodi);
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            });
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
          }elseif(!empty($ujian)){
            $query = PendaftarUjian::with('mahasiswa')->where('ujian', $ujian)->where('id_periode_daftar_ujian', $id_periode_daftar_ujian)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            });
          }

          $total = $query->count();
          $daftar_ujian = $query->paginate(10);

          $pagination = (!empty($nama)) ? $daftar_ujian->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_ujian->appends(['nim' => $nim]) : '';
          $pagination = (!empty($angkatan)) ? $daftar_ujian->appends(['angkatan' => $angkatan]) : '';
          $pagination = (!empty($id_prodi)) ? $daftar_ujian->appends(['id_prodi' => $id_prodi]) : '';
          $pagination = (!empty($id_periode_daftar_ujian)) ? $daftar_ujian->appends(['id_periode_daftar_ujian' => $id_periode_daftar_ujian]) : '';
          $pagination = (!empty($ujian)) ? $daftar_ujian->appends(['ujian' => $ujian]) : '';
          $pagination = $daftar_ujian->appends($request->except('page'));

        $total_berkas = PendaftarUjian::where('id_periode_daftar_ujian', $id_periode_daftar_ujian)->where('tahapan', 'diperiksa')->count();
        $id = $id_periode_daftar_ujian;
        $daftar_prodi = \App\Prodi::pluck('nama', 'id');

        $periode = PeriodeDaftarUjian::find($id_periode_daftar_ujian);

        $filter_ujian = true;

        return view('pendaftar-ujian.daftar-periode', compact('daftar_ujian', 'daftar_prodi', 'total', 'pagination', 'nama', 'id_prodi', 'nim', 'angkatan', 'ujian', 'id_periode_daftar_ujian', 'id', 'total_berkas', 'periode', 'filter_ujian'));
      }
        return redirect('pendaftaran/ujian/periode/' . $id_periode_daftar_ujian);
    }

    // pimpinan
    public function detailPeriodeExport(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $ujian = trim($request->input('ujian'));
        $id_prodi = trim($request->input('id_prodi'));
        $id_periode_daftar_ujian = trim($request->input('id_periode_daftar_ujian'));

      return Excel::download(new PendaftarUjianExport($nama, $nim, $angkatan, $ujian, $id_prodi, $id_periode_daftar_ujian), 'SISKP - Export Pendaftar Ujian.xlsx');
    }

    private function uploadFile(Request $request){
        $file = $request->file('file_laporan');
        $ext = $file->getClientOriginalExtension();
        if($request->file('file_laporan')->isValid()){
          $file_name = date('YmdHis').".$ext";
          $upload_path = 'assets/laporan';
          $request->file('file_laporan')->move($upload_path, $file_name);
          return $file_name;
        }
        return false;
    }

    private function uploadPersetujuan(Request $request){
        $file = $request->file('file_lembar_persetujuan');
        $ext = $file->getClientOriginalExtension();
        if($request->file('file_lembar_persetujuan')->isValid()){
          $file_name = date('YmdHis').".$ext";
          $upload_path = 'assets/persetujuan-ujian';
          $request->file('file_lembar_persetujuan')->move($upload_path, $file_name);
          return $file_name;
        }
        return false;
    }

    private function hapusFile($pendaftar){
      $file = 'assets/laporan/'.$pendaftar->file_laporan;
      if(file_exists($file) && isset($pendaftar->file_laporan)){
      $delete = unlink($file);
        if($delete){
          return true;
        }
        return false;
      }
    }

    private function hapusPersetujuan($pendaftar){
      $file = 'assets/persetujuan-ujian/'.$pendaftar->file_lembar_persetujuan;
      if(file_exists($file) && isset($pendaftar->file_lembar_persetujuan)){
      $delete = unlink($file);
        if($delete){
          return true;
        }
        return false;
      }
    }

    private function uploadSertifikat(Request $request){
        $file = $request->file('file_sertifikat_toefl');
        $ext = $file->getClientOriginalExtension();
        if($request->file('file_sertifikat_toefl')->isValid()){
          $file_name = date('YmdHis').".$ext";
          $upload_path = 'assets/sertifikat-toefl';
          $request->file('file_sertifikat_toefl')->move($upload_path, $file_name);
          return $file_name;
        }
        return false;
    }

    private function hapusSertifikat($pendaftar){
      $file = 'assets/sertifikat-toefl/'.$pendaftar->file_sertifikat_toefl;
      if(file_exists($file) && isset($pendaftar->file_sertifikat_toefl)){
      $delete = unlink($file);
        if($delete){
          return true;
        }
        return false;
      }
    }

    // pimpinan
    public function validasi(Request $request)
    {
        // validasi berkas ujian
        $ujian = PendaftarUjian::findOrFail($request->post('id'));
        $ujian->tahapan = $request->post('tahapan');
        $ujian->keterangan = $request->post('keterangan');
        $ujian->save();

        if($request->post('tahapan') === 'ditolak' || $request->post('tahapan') === 'diterima'){
            // notifikasi mahasiswa
            $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
            $notifikasiMahasiswa->id_mahasiswa = $ujian->id_mahasiswa;
            $notifikasiMahasiswa->link = 'pendaftaran/ujian/' . $ujian->id;
            $notifikasiMahasiswa->jenis = 'pendaftaran';

            if($request->post('tahapan') === 'ditolak'){
                $notifikasiMahasiswa->deskripsi = 'Berkas Ujian : <strong> '. ucwords(str_replace('-', ' ', $ujian->ujian)) .' </strong> anda telah <strong>'. ucwords($request->post('tahapan')) .'</strong> dengan keterangan : <strong><em>'. $request->post('keterangan') .'</em></strong>. Silahkan mendaftar kembali!';
            }else{
                $notifikasiMahasiswa->deskripsi = 'Berkas Ujian : <strong> '. ucwords(str_replace('-', ' ', $ujian->ujian)) .' </strong> anda telah <strong>'. ucwords($request->post('tahapan')) .'</strong> dengan keterangan : <strong><em>'. $request->post('keterangan') .'</em></strong>. Silahkan menunggu Jadwal Ujian & Dosen Penguji!';
            }
            $notifikasiMahasiswa->save();
        }

        Session::flash('pesan', 'Pendaftar Ujian Berhasil Divalidasi');
        return redirect('pendaftaran/ujian/'.$ujian->id);
    }

    // pimpinan
    public function uploadPlagiasi(Request $request)
    {
        $pengaturan = \App\Pengaturan::find(1);

        $validasi = Validator::make($request->all(), [
          'persentasi_plagiasi' => 'required|string|max:5',
          'file_hasil_plagiasi' => 'required|mimes:pdf|max:' . $pengaturan->max_file_upload
        ]);

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        $input = $request->all();

        $input['id_pendaftar_ujian'] = $request->post('id_pendaftar_ujian');
        if($request->hasFile('file_hasil_plagiasi')){
            $input['file_hasil_plagiasi'] = $this->uploadFilePlagiasi($request);
        }

        \App\HasilPlagiasi::create($input);

        $pendaftar = PendaftarUjian::find($request->post('id_pendaftar_ujian'));

        Session::flash('pesan', 'Hasil Plagiasi Berhasil Ditambahkan!');
        return redirect()->back();
    }

    private function uploadFilePlagiasi(Request $request){
        $file = $request->file('file_hasil_plagiasi');
        $ext = $file->getClientOriginalExtension();
        if($request->file('file_hasil_plagiasi')->isValid()){
          $file_name = date('YmdHis').".$ext";
          $upload_path = 'assets/plagiasi';
          $request->file('file_hasil_plagiasi')->move($upload_path, $file_name);
          return $file_name;
        }
        return false;
    }

    private function hapusPlagiasi($plagiasi){
      $file = 'assets/plagiasi/'.$plagiasi->file_hasil_plagiasi;
      if(file_exists($file) && isset($plagiasi->file_hasil_plagiasi)){
      $delete = unlink($file);
        if($delete){
          return true;
        }
        return false;
      }
    }

    // pimpinan
    public function destroyPlagiasi($id)
    {
        $plagiasi = \App\HasilPlagiasi::findOrFail($id);
        $id_pendaftar_ujian = $plagiasi->id_pendaftar_ujian;
        $this->hapusPlagiasi($plagiasi);
        $plagiasi->delete();
        Session::flash('pesan', 'Hasil Plagiasi Ujian Berhasil Dihapus');
        return redirect('pendaftaran/ujian/'.$id_pendaftar_ujian);
    }

    // pimpinan
    public function createJadwal($id)
    {
      $pendaftar = PendaftarUjian::findOrFail($id);
      $pengaturan = \App\Pengaturan::find(1);
      if($pendaftar->ujian === 'proposal' || $pendaftar->ujian === 'hasil' || $pendaftar->ujian === 'sidang-skripsi'){
        $dosbing = \App\DosenPembimbingSkripsi::where('id_mahasiswa', $pendaftar->id_mahasiswa)->orderBy('id', 'desc')->first();
        $jadwal = \App\JadwalUjian::whereIn('ujian', ['sidang-skripsi', 'hasil', 'proposal'])->where('id_mahasiswa', $pendaftar->id_mahasiswa)->orderBy('id', 'desc')->first();
        $total_penguji = 5;
      }else{
        $dosbing = \App\DosenPembimbingKp::where('id_mahasiswa', $pendaftar->id_mahasiswa)->orderBy('id', 'desc')->first();
        $jadwal = \App\JadwalUjian::where('ujian', 'kerja-praktek')->where('id_mahasiswa', $pendaftar->id_mahasiswa)->orderBy('id', 'desc')->first();
        $total_penguji = 3;
      }

      $daftar_dosen = \App\Dosen::where('status', 'aktif')->where('bisa_membimbing', 'ya')->pluck('nama', 'id');

      return view('jadwal-ujian.insert-by-pendaftar', compact('pendaftar', 'daftar_dosen', 'dosbing', 'jadwal', 'total_penguji'));
    }

    // pimpinan
    public function setujuiSemua(Request $request)
    {
        PendaftarUjian::where('id_periode_daftar_ujian', $request->post('id_periode_daftar_ujian'))->update([
          'tahapan' => 'diterima'
        ]);

        Session::flash('pesan', 'Semua Berkas Ujian Di Periode Ini berhasil Disetujui');
        return redirect('pendaftaran/ujian/periode/' . $request->post('id_periode_daftar_ujian'));
    }

    // admin
    public function formInputByAdmin($id)
    {
        $periode = PeriodeDaftarUjian::findOrFail($id);
        $daftar_mahasiswa = \App\Mahasiswa::where('kontrak_skripsi', 'ya')->pluck('nama', 'id');
        return view('pendaftar-ujian.input-by-admin', compact('periode', 'daftar_mahasiswa', 'id'));
    }

    // admin
    public function inputByAdmin(Request $request)
    {
        $mahasiswa = \App\Mahasiswa::findOrFail($request->post('id_mahasiswa'));

        if($request->post('ujian') === 'proposal' || $request->post('ujian') === 'hasil' || $request->post('ujian') === 'sidang-skripsi'){

            $mahasiswa->kontrak_skripsi = 'ya';
            $mahasiswa->save();

            // validasi usulan topik diterima
            $usulan_topik_diterima = \App\PendaftarUsulanTopik::where('id_mahasiswa', $mahasiswa->id)->where('tahapan', 'diterima')->first() or null;
            if(empty($usulan_topik_diterima)) return redirect()->back()->withInput()->with('kesalahan', 'Judul skripsinya masih kosong!');

            // validasi dosbing skripsi
            $dosbing = \App\DosenPembimbingSkripsi::where('id_mahasiswa', $mahasiswa->id)->first();
            if(empty($dosbing)) return redirect()->back()->withInput()->with('kesalahan', 'Dosen Pembimbing Skripsi masih kosong!');

            if($request->post('ujian') === 'proposal'){

                // perbaharui tahapan skripsi mahasiswa
                $mahasiswa->tahapan_skripsi = 'pendaftaran_proposal';
                $mahasiswa->save();

                // perbaharui riwayat tahapan
                $riwayatTahapan = \App\RiwayatTahapan::where('id_mahasiswa', $mahasiswa->id)->where('tahapan', 'pendaftaran_seminar_proposal')->first();
                if($riwayatTahapan){
                    $riwayatTahapan->created_at = now();
                    $riwayatTahapan->save();
                }else{
                    $riwayat =  new \App\RiwayatTahapan;
                    $riwayat->tahapan =  'pendaftaran_seminar_proposal';
                    $riwayat->id_mahasiswa =  $mahasiswa->id;
                    $riwayat->save();
                }

            }elseif($request->post('ujian') === 'hasil'){

                // perbaharui tahapan skripsi mahasiswa
                $mahasiswa->tahapan_skripsi = 'pendaftaran_hasil';
                $mahasiswa->save();

                // perbaharui riwayat tahapan
                $riwayatTahapan = \App\RiwayatTahapan::where('id_mahasiswa', $mahasiswa->id)->where('tahapan', 'pendaftaran_seminar_hasil')->first();
                if($riwayatTahapan){
                    $riwayatTahapan->created_at = now();
                    $riwayatTahapan->save();
                }else{
                    $riwayat =  new \App\RiwayatTahapan;
                    $riwayat->tahapan =  'pendaftaran_seminar_hasil';
                    $riwayat->id_mahasiswa =  $mahasiswa->id;
                    $riwayat->save();
                }

            }elseif($request->post('ujian') === 'sidang-skripsi'){

                // perbaharui tahapan skripsi mahasiswa
                $mahasiswa->tahapan_skripsi = 'pendaftaran_sidang_skripsi';
                $mahasiswa->save();

                // perbaharui riwayat tahapan
                $riwayatTahapan = \App\RiwayatTahapan::where('id_mahasiswa', $mahasiswa->id)->where('tahapan', 'pendaftaran_sidang_skripsi')->first();
                if($riwayatTahapan){
                    $riwayatTahapan->created_at = now();
                    $riwayatTahapan->save();
                }else{
                    $riwayat =  new \App\RiwayatTahapan;
                    $riwayat->tahapan =  'pendaftaran_sidang_skripsi';
                    $riwayat->id_mahasiswa =  $mahasiswa->id;
                    $riwayat->save();
                }

            }

        }elseif($request->post('ujian') === 'kerja-praktek'){

            $mahasiswa->kontrak_kp = 'ya';
            $mahasiswa->save();

            // validasi dosbing kp
            $dosbing = \App\DosenPembimbingKp::where('id_mahasiswa', $mahasiswa->id)->first();
            if(empty($dosbing)) return redirect()->back()->withInput()->with('kesalahan', 'Dosen Pembimbing Kerja Prakteknya masih kosong!');

            // perbaharui tahapan skripsi mahasiswa
            $mahasiswa->tahapan_kp = 'pendaftaran';
            $mahasiswa->save();

            // perbaharui riwayat tahapan
            $riwayatTahapan = \App\RiwayatTahapan::where('id_mahasiswa', $mahasiswa->id)->where('tahapan', 'pendaftaran_seminar_kp')->first();
            if($riwayatTahapan){
                $riwayatTahapan->created_at = now();
                $riwayatTahapan->save();
            }else{
                $riwayat =  new \App\RiwayatTahapan;
                $riwayat->tahapan =  'pendaftaran_seminar_kp';
                $riwayat->id_mahasiswa =  $mahasiswa->id;
                $riwayat->save();
            }

        }

        $pendaftar = new PendaftarUjian;
        $pendaftar->id_periode_daftar_ujian = $request->post('id_periode_daftar_ujian');
        $pendaftar->id_mahasiswa = $request->post('id_mahasiswa');
        $pendaftar->ujian = $request->post('ujian');
        $pendaftar->save();

        // notifikasi admin
        $notifikasiAdmin = new \App\NotifikasiAdmin;
        $notifikasiAdmin->link = 'pendaftaran/ujian/' . $pendaftar->id;
        $notifikasiAdmin->jenis = 'pendaftaran';
        $notifikasiAdmin->deskripsi = $mahasiswa->nama . ' mendaftar ujian : <strong>'. ucwords(str_replace('-', ' ', $pendaftar->ujian)) .'</strong>. Silahkan validasi berkas ujiannya';
        $notifikasiAdmin->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $mahasiswa->id;
        $notifikasiMahasiswa->link = 'pendaftaran/ujian/' . $pendaftar->id;
        $notifikasiMahasiswa->jenis = 'pendaftaran';
        $notifikasiMahasiswa->deskripsi = 'Berkas ujian : <strong> '. ucwords(str_replace('-', ' ', $pendaftar->ujian)) .' </strong> anda sedang <strong>DIPERIKSA</strong>. Silahkan menunggu!';
        $notifikasiMahasiswa->save();

        Session::flash('pesan', 'Anda berhasil menginput 1 mahasiswa');
        return redirect('pendaftaran/ujian/periode/' . $request->post('id_periode_daftar_ujian'));
    }

}
