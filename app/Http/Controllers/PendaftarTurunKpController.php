<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PeriodeDaftarTurunKp;
use App\PendaftarTurunKp;
use Session;
use PDF;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PendaftarTurunKpExport;

class PendaftarTurunKpController extends Controller
{
    public function __construct(){
        $this->middleware('mahasiswa', ['only' => [
            'index', 'create', 'store', 'edit', 'update'
        ]]);

        $this->middleware('mahasiswaPimpinan', ['only' => [
            'show', 'destroy' 
        ]]);

        $this->middleware('pimpinan', ['only' => [
            'semuaPendaftar', 'validasi', 'detailPeriode', 'detailPeriodeCari', 'detailPeriodeExport', 'createDosbing', 'setujuiSemua', 'formInputByAdmin', 'inputByAdmin'
        ]]);
    }

    // mahasiswa
    public function index()
    {
        $sub_menu = true;
        $total = 0;
        $daftar_turun_kp = PendaftarTurunKp::where('id_mahasiswa', Session::get('id'))->get();
        $periode_aktif = PeriodeDaftarTurunKp::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;
        if($periode_aktif)
        {
            $total = PendaftarTurunKp::where('id_periode_daftar_turun_kp', $periode_aktif->id)->count();
            $daftar_pendaftar = PendaftarTurunKp::where('id_periode_daftar_turun_kp', $periode_aktif->id)->paginate(10);
            return view('pendaftar-turun-kp.index', compact('periode_aktif', 'daftar_pendaftar', 'daftar_turun_kp', 'sub_menu', 'total'));
        }else{
            return view('pendaftar-turun-kp.index', compact('daftar_turun_kp', 'sub_menu', 'total'));
        }
    }

    // mahasiswa
    public function create()
    {
        if(!Session::has('bisa_kp')){
          return redirect()->back()->with('kesalahan', 'Tidak Ada Mata Kuliah Kerja Praktek di Program Studi Anda!');
        }

        $periode_aktif = PeriodeDaftarTurunKp::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;

        if(!$periode_aktif){
            Session::flash('kesalahan', 'Pendaftaran Turun Kerja Praktek Belum Dibuka');
            return redirect()->back();
        }

        $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));

        // validasi dosen PA
        if(empty($mahasiswa->id_dosen)){ 
            return redirect('pendaftaran/turun-kp')->with('kesalahan', 'Anda belum memasukan Dosen Pendamping Akademik');
        }

        // validasi Prodi
        if(empty($mahasiswa->id_prodi)){
            return redirect('pendaftaran/turun-kp')->with('kesalahan', 'Anda belum memasukan Program Studi');
        }

        // validasi mahasiswa kontrak kerja praktek
        if($mahasiswa->kontrak_kp === 'tidak'){
            return redirect('pendaftaran/turun-kp')->with('kesalahan', 'Anda belum mengontrak Mata Kuliah Kerja Praktek');
        }

        // validasi turun kp diterima
        $turun_kp_diterima = PendaftarTurunKp::where('id_mahasiswa', Session::get('id'))->where('tahapan', 'diterima')->first() or null;
        if(!empty($turun_kp_diterima)) return redirect('pendaftaran/turun-kp')->with('kesalahan', 'Berkas Turun Kerja Praktek anda sebelumnya sudah diterima, silahkan dilanjutkan!');

        // validasi turun kp diperiksa
        $turun_kp_diperiksa = PendaftarTurunKp::where('id_mahasiswa', Session::get('id'))->where('tahapan', 'diperiksa')->first() or null;
        if(!empty($turun_kp_diperiksa)) return redirect('pendaftaran/turun-kp')->with('kesalahan', 'Berkas Turun Kerja Praktek anda sebelumnya sedang diperiksa, dimohon untuk menunggu!');

        $pengaturan = \App\Pengaturan::find(1);
        $bottom_detail = true;

        return view('pendaftar-turun-kp.create', compact('pengaturan', 'bottom_detail'));
    }

    // mahasiswa
    public function store(Request $request)
    {
        if(!Session::has('bisa_kp')){
          return redirect()->back()->with('kesalahan', 'Tidak Ada Mata Kuliah Kerja Praktek di Program Studi Anda!');
        }

        $pengaturan = \App\Pengaturan::find(1);

        $validasi = Validator::make($request->all(), [
            'instansi' => 'required|string',
            'alamat' => 'required|string',
            'file_lembar_persetujuan' => 'sometimes|mimes:pdf|max:' . $pengaturan->max_file_upload
        ]);

        if($validasi->fails()){
            return redirect()->back()->withInput()->withErrors($validasi);
        }

        $input = $request->all();

        $input['id_mahasiswa'] = Session::get('id');
        if($request->hasFile('file_lembar_persetujuan')){
            $input['file_lembar_persetujuan'] = $this->uploadFile($request);
        }

        $pendaftar = new PendaftarTurunKp;
        $pendaftar->instansi = $request->post('instansi');
        $pendaftar->alamat = $request->post('alamat');
        if($request->hasFile('file_lembar_persetujuan')) $pendaftar->file_lembar_persetujuan = $input['file_lembar_persetujuan'];
        $pendaftar->id_periode_daftar_turun_kp = $request->post('id_periode_daftar_turun_kp');
        $pendaftar->id_mahasiswa = $input['id_mahasiswa'];
        $pendaftar->save();

        // perbaharui riwayat tahapan
        $riwayatTahapan = \App\RiwayatTahapan::where('id_mahasiswa', Session::get('id'))->where('tahapan', 'pendaftaran_turun_kp')->first();
        if($riwayatTahapan){
            $riwayatTahapan->created_at = now();
            $riwayatTahapan->save();
        }else{
            $riwayat =  new \App\RiwayatTahapan;
            $riwayat->tahapan =  'pendaftaran_turun_kp';
            $riwayat->id_mahasiswa =  Session::get('id');
            $riwayat->save();
        }

        // notifikasi admin
        $notifikasiAdmin = new \App\NotifikasiAdmin;
        $notifikasiAdmin->link = 'pendaftaran/turun-kp/' . $pendaftar->id;
        $notifikasiAdmin->jenis = 'pendaftaran';
        $notifikasiAdmin->deskripsi = Session::get('nama') . ' mendaftar turun kerja praktek di instansi : <strong>'. $pendaftar->instansi .'</strong>. Silahkan validasi berkas turun kerja prakteknya';
        $notifikasiAdmin->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = Session::get('id');
        $notifikasiMahasiswa->link = 'pendaftaran/turun-kp/' . $pendaftar->id;
        $notifikasiMahasiswa->jenis = 'pendaftaran';
        $notifikasiMahasiswa->deskripsi = 'Berkas turun kerja praktek anda di instansi : <strong> '. $pendaftar->instansi .' </strong> sedang <strong>DIPERIKSA</strong>. Silahkan menunggu!';
        $notifikasiMahasiswa->save();

        Session::flash('pesan', 'Berhasil Mendaftar Turun Kerja Praktek');
        return redirect('pendaftaran/turun-kp');
    }

    // mahasiswa
    public function edit($id)
    {
        if(!Session::has('bisa_kp')){
          return redirect()->back()->with('kesalahan', 'Tidak Ada Mata Kuliah Kerja Praktek di Program Studi Anda!');
        }

        $pengaturan = \App\Pengaturan::find(1);
        $pendaftar = PendaftarTurunKp::findOrFail($id);
        if(Session::get('id') !== $pendaftar->id_mahasiswa){
          return redirect()->back()->with('kesalahan', 'Anda Tidak Boleh Mengedit Berkas Turun Kerja Praktek Mahasiswa Lain!');
        }
        $bottom_detail = true;

        return view('pendaftar-turun-kp.edit', compact('pendaftar', 'pengaturan', 'bottom_detail'));
    }

    // mahasiswa
    public function update(Request $request, $id)
    {
        if(!Session::has('bisa_kp')){
          return redirect()->back()->with('kesalahan', 'Tidak Ada Mata Kuliah Kerja Praktek di Program Studi Anda!');
        }

        $pengaturan = \App\Pengaturan::find(1);

        $validasi = Validator::make($request->all(), [
            'instansi' => 'required|string',
            'alamat' => 'required|string',
            'file_lembar_persetujuan' => 'sometimes|mimes:pdf|max:' . $pengaturan->max_file_upload
        ]);

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));

        // validasi dosen PA
        if(empty($mahasiswa->id_dosen)){ 
            return redirect()->back()->withInput()->with('kesalahan', 'Anda belum memasukan Dosen Pendamping Akademik');
        }

        // validasi Prodi
        if(empty($mahasiswa->id_prodi)){
            return redirect()->back()->withInput()->with('kesalahan', 'Anda belum memasukan Program Studi');
        }

        $input = $request->all();

        $input['id_mahasiswa'] = Session::get('id');

        $pendaftar = PendaftarTurunKp::findOrFail($id);
        
        if(Session::get('id') !== $pendaftar->id_mahasiswa){
          return redirect()->back()->with('kesalahan', 'Anda Tidak Boleh Memperbaharui Berkas Turun Kerja Praktek Mahasiswa Lain!');
        }

        if($request->hasFile('file_lembar_persetujuan')){
          $this->hapusFile($pendaftar);
          $input['file_lembar_persetujuan'] = $this->uploadFile($request);
        }
        $pendaftar->update($input);

        Session::flash('pesan', 'Pendaftar Turun Kerja Praktek Berhasil Diperbaharui!');
        return redirect('pendaftaran/turun-kp');
    }

    // mahasiswa & pimpinan
    public function show($id)
    {
        $bottom_detail = true;
        $pendaftar = PendaftarTurunKp::findOrFail($id);
        return view('pendaftar-turun-kp.detail', compact('pendaftar', 'bottom_detail'));
    }

    // mahasiswa & pimpinan
    public function destroy($id)
    {
        $pendaftar = PendaftarTurunKp::findOrFail($id);
        
        if(Session::has('mahasiswa') && Session::get('id') !== $pendaftar->id_mahasiswa){
          return redirect()->back()->with('kesalahan', 'Anda Tidak Boleh Menghapus Berkas Turun Kerja Praktek Mahasiswa Lain!');
        }

        $id_periode = $pendaftar->id_periode_daftar_turun_kp;

        $this->hapusFile($pendaftar);
        $pendaftar->delete();
        Session::flash('pesan', 'Pendaftaran Turun Kerja Praktek Berhasil Dihapus');
        if(Session::has('mahasiswa')) return redirect('pendaftaran/turun-kp');
        else return redirect('pendaftaran/turun-kp/periode/' . $id_periode);
    }

    // pimpinan
    public function semuaPendaftar()
    {
        $sub_menu = true;
        $daftar_periode_turun_kp = PeriodeDaftarTurunKp::orderBy('waktu_tutup', 'desc')->paginate(10);
        $total = PeriodeDaftarTurunKp::orderBy('waktu_tutup', 'desc')->count();
        return view('pendaftar-turun-kp.semua', compact('daftar_periode_turun_kp', 'total', 'sub_menu'));
    }

    // pimpinan
    public function detailPeriode($id)
    {
        $filter_turun_kp = true;

        $periode = PeriodeDaftarTurunKp::find($id);
        $daftar_turun_kp = PendaftarTurunKp::where('id_periode_daftar_turun_kp', $id)->orderBy('created_at', 'DESC')->paginate(10);
        $total_berkas = PendaftarTurunKp::where('id_periode_daftar_turun_kp', $id)->where('tahapan', 'diperiksa')->count();
        $total = PendaftarTurunKp::where('id_periode_daftar_turun_kp', $id)->count();
        $daftar_prodi = \App\Prodi::pluck('nama', 'id');

        return view('pendaftar-turun-kp.daftar-periode', compact('daftar_turun_kp', 'periode', 'total_berkas', 'daftar_prodi', 'id', 'total', 'filter_turun_kp'));
    }

    // pimpinan
    public function detailPeriodeCari(Request $request)
    {
        $nama = trim($request->input('nama'));
        $instansi = trim($request->input('instansi'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $id_prodi = trim($request->input('id_prodi'));
        $id_periode_daftar_turun_kp = trim($request->input('id_periode_daftar_turun_kp'));

      if(!empty($nama) || !empty($nim) || !empty($angkatan) || !empty($instansi) || !empty($id_prodi)){

          if(!empty($nama)){
            $query = PendaftarTurunKp::with('mahasiswa')->where('id_periode_daftar_turun_kp', $id_periode_daftar_turun_kp)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('nama', 'like', '%' . $nama . '%');
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($instansi)) ? $query->where('instansi', 'like', '%' . $instansi . '%') : '';
          }elseif(!empty($nim)){
            $query = PendaftarTurunKp::with('mahasiswa')->where('id_periode_daftar_turun_kp', $id_periode_daftar_turun_kp)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('nim', 'like', '%' . $nim . '%');
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($instansi)) ? $query->where('instansi', 'like', '%' . $instansi . '%') : '';
          }elseif(!empty($angkatan)){
            $query = PendaftarTurunKp::with('mahasiswa')->where('id_periode_daftar_turun_kp', $id_periode_daftar_turun_kp)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('angkatan', $angkatan);
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($instansi)) ? $query->where('instansi', 'like', '%' . $instansi . '%') : '';
          }elseif(!empty($id_prodi)){
            $query = PendaftarTurunKp::with('mahasiswa')->where('id_periode_daftar_turun_kp', $id_periode_daftar_turun_kp)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('id_prodi', $id_prodi);
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            });
            (!empty($instansi)) ? $query->where('instansi', 'like', '%' . $instansi . '%') : '';
          }elseif(!empty($ujian)){
            $query = PendaftarTurunKp::with('mahasiswa')->where('instansi', 'like', '%' . $instansi . '%')->where('id_periode_daftar_turun_kp', $id_periode_daftar_turun_kp)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            });
          }

          $total = $query->count();
          $daftar_turun_kp = $query->paginate(10);

          $pagination = (!empty($nama)) ? $daftar_turun_kp->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_turun_kp->appends(['nim' => $nim]) : '';
          $pagination = (!empty($angkatan)) ? $daftar_turun_kp->appends(['angkatan' => $angkatan]) : '';
          $pagination = (!empty($id_prodi)) ? $daftar_turun_kp->appends(['id_prodi' => $id_prodi]) : '';
          $pagination = (!empty($id_periode_daftar_turun_kp)) ? $daftar_turun_kp->appends(['id_periode_daftar_turun_kp' => $id_periode_daftar_turun_kp]) : '';
          $pagination = (!empty($instansi)) ? $daftar_turun_kp->appends(['instansi' => $instansi]) : '';
          $pagination = $daftar_turun_kp->appends($request->except('page'));

        $total_berkas = PendaftarTurunKp::where('id_periode_daftar_turun_kp', $id_periode_daftar_turun_kp)->where('tahapan', 'diperiksa')->count();
        $id = $id_periode_daftar_turun_kp;
        $daftar_prodi = \App\Prodi::pluck('nama', 'id');
        
        $periode = PeriodeDaftarTurunKp::find($id_periode_daftar_turun_kp);
        
        $filter_turun_kp = true;
        
        return view('pendaftar-turun-kp.daftar-periode', compact('daftar_turun_kp', 'daftar_prodi', 'total', 'pagination', 'nama', 'id_prodi', 'nim', 'angkatan', 'instansi', 'id_periode_daftar_turun_kp', 'id', 'total_berkas', 'periode', 'filter_turun_kp'));
      }
        return redirect('pendaftaran/turun-kp/periode/' . $id_periode_daftar_turun_kp);
    }

    // pimpinan
    public function detailPeriodeExport(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $instansi = trim($request->input('instansi'));
        $id_prodi = trim($request->input('id_prodi'));
        $id_periode_daftar_turun_kp = trim($request->input('id_periode_daftar_turun_kp'));

      return Excel::download(new PendaftarTurunKpExport($nama, $nim, $angkatan, $instansi, $id_prodi, $id_periode_daftar_turun_kp), 'SISKP - Export Pendaftar Turun Kerja Praktek.xlsx');
    }

    private function uploadFile(Request $request){
        $file = $request->file('file_lembar_persetujuan');
        $ext = $file->getClientOriginalExtension();
        if($request->file('file_lembar_persetujuan')->isValid()){
          $file_name = date('YmdHis').".$ext";
          $upload_path = 'assets/persetujuan-kp';
          $request->file('file_lembar_persetujuan')->move($upload_path, $file_name);
          return $file_name;
        }
        return false;
    }

    private function hapusFile($pendaftar){
      $file = 'assets/persetujuan-kp/'.$pendaftar->file_lembar_persetujuan;
      if(file_exists($file) && isset($pendaftar->file_lembar_persetujuan)){
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
        $pendaftar = PendaftarTurunKp::findOrFail($request->post('id'));
        $pendaftar->tahapan = $request->post('tahapan');
        $pendaftar->keterangan = $request->post('keterangan');
        $pendaftar->save();

        if($request->post('tahapan') === 'ditolak' || $request->post('tahapan') === 'dibatalkan' || $request->post('tahapan') === 'diterima'){
            // notifikasi mahasiswa
            $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
            $notifikasiMahasiswa->id_mahasiswa = $pendaftar->id_mahasiswa;
            $notifikasiMahasiswa->link = 'pendaftaran/turun-kp/' . $pendaftar->id;
            $notifikasiMahasiswa->jenis = 'pendaftaran';

            if($request->post('tahapan') === 'ditolak' || $request->post('tahapan') === 'dibatalkan'){
                $notifikasiMahasiswa->deskripsi = 'Berkas turun kerja praktek anda di instansi : <strong> '. $pendaftar->instansi .' </strong> telah <strong>'. strtoupper($request->post('tahapan')) .'</strong> dengan keterangan : <strong><em>'. $request->post('keterangan') .'</em></strong>. Silahkan mendaftar turun kerja praktek yang baru!';
            }else{
                $notifikasiMahasiswa->deskripsi = 'Berkas turun kerja praktek anda di instansi : <strong> '. $pendaftar->instansi .' </strong> telah <strong>'. strtoupper($request->post('tahapan')) .'</strong> dengan keterangan : <strong><em>'. $request->post('keterangan') .'</em></strong>. Silahkan menunggu dosen pembimbing Kerja Praktek!';
            }
            $notifikasiMahasiswa->save();
        }

        Session::flash('pesan', 'Pendaftar Turun Kerja Praktek Berhasil Divalidasi');
        return redirect('pendaftaran/turun-kp/'.$pendaftar->id);
    }

    // pimpinan
    public function createDosbing($id)
    {
      $pendaftar = PendaftarTurunKp::findOrFail($id);
      $daftar_dosen = \App\Dosen::where('status', 'aktif')->where('bisa_membimbing', 'ya')->pluck('nama', 'id');
      $daftar_semester = \App\Semester::pluck('nama', 'id');
      $bottom_detail = true;
      return view('dosbing.insert-by-turun-kp', compact('pendaftar', 'daftar_semester', 'daftar_dosen', 'bottom_detail'));
    }

    // pimpinan
    public function setujuiSemua(Request $request)
    {
        PendaftarTurunKp::where('id_periode_daftar_turun_kp', $request->post('id_periode_daftar_turun_kp'))->update([
          'tahapan' => 'diterima' 
        ]);

        Session::flash('pesan', 'Semua Berkas Turun Kerja Praktek Di Periode Ini berhasil Disetujui');
        return redirect('pendaftaran/turun-kp/periode/' . $request->post('id_periode_daftar_turun_kp'));
    }

    // admin
    public function formInputByAdmin($id)
    {
        $periode = PeriodeDaftarTurunKp::findOrFail($id);
        $daftar_mahasiswa = \App\Mahasiswa::where('kontrak_kp', 'ya')->pluck('nama', 'id');
        $bottom_detail = true;
        return view('pendaftar-turun-kp.input-by-admin', compact('periode', 'bottom_detail', 'daftar_mahasiswa', 'id'));
    }

    // admin
    public function inputByAdmin(Request $request)
    {
        $mahasiswa = \App\Mahasiswa::findOrFail($request->post('id_mahasiswa'));
        
        $pendaftar = new PendaftarTurunKp;
        $pendaftar->id_periode_daftar_turun_kp = $request->post('id_periode_daftar_turun_kp');
        $pendaftar->id_mahasiswa = $request->post('id_mahasiswa');
        $pendaftar->instansi = $request->post('instansi');
        $pendaftar->alamat = $request->post('alamat');
        $pendaftar->save();

        // notifikasi admin
        $notifikasiAdmin = new \App\NotifikasiAdmin;
        $notifikasiAdmin->link = 'pendaftaran/turun-kp/' . $pendaftar->id;
        $notifikasiAdmin->jenis = 'pendaftaran';
        $notifikasiAdmin->deskripsi = $mahasiswa->nama . ' mendaftar turun kerja praktek di instansi : <strong>'. $pendaftar->instansi .'</strong>. Silahkan validasi berkas turun kerja prakteknya';
        $notifikasiAdmin->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $mahasiswa->id;
        $notifikasiMahasiswa->link = 'pendaftaran/turun-kp/' . $pendaftar->id;
        $notifikasiMahasiswa->jenis = 'pendaftaran';
        $notifikasiMahasiswa->deskripsi = 'Berkas turun kerja praktek anda di instansi : <strong> '. $pendaftar->instansi .' </strong> sedang <strong>DIPERIKSA</strong>. Silahkan menunggu!';
        $notifikasiMahasiswa->save();

        // perbaharui riwayat tahapan
        $riwayatTahapan = \App\RiwayatTahapan::where('id_mahasiswa', $mahasiswa->id)->where('tahapan', 'pendaftaran_turun_kp')->first();
        if($riwayatTahapan){
            $riwayatTahapan->created_at = now();
            $riwayatTahapan->save();
        }else{
            $riwayat =  new \App\RiwayatTahapan;
            $riwayat->tahapan =  'pendaftaran_turun_kp';
            $riwayat->id_mahasiswa =  $mahasiswa->id;
            $riwayat->save();
        }

        $mahasiswa->kontrak_kp = 'ya';
        $mahasiswa->save();

        Session::flash('pesan', 'Anda berhasil menginput 1 mahasiswa');
        return redirect('pendaftaran/turun-kp/periode/' . $request->post('id_periode_daftar_turun_kp'));
    }
}
