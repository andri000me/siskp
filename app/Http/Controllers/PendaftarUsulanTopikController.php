<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PendaftarUsulanTopikRequest;
use App\PeriodeDaftarUsulanTopik;
use App\PendaftarUsulanTopik;
use Session;
use PDF;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PendaftarUsulanTopikExport;

class PendaftarUsulanTopikController extends Controller
{
    public function __construct(){
        $this->middleware('mahasiswa', ['only' => [
            'index', 'create', 'store', 'edit', 'update', 'perubahan', 'updatePerubahan' 
        ]]);

        $this->middleware('mahasiswaPimpinan', ['only' => [
            'show', 'destroy' 
        ]]);

        $this->middleware('pimpinan', ['only' => [
            'semuaPendaftar', 'validasi', 'detailPeriode', 'cetak', 'createByAdmin', 'storeByAdmin', 'periodeKosong', 'detailPeriodeCari', 'detailPeriodeExport', 'createDosbing', 'setujuiSemua', 'formInputByAdmin', 'inputByAdmin' 
        ]]);
    }

    // mahasiswa
    public function index()
    {
        $sub_menu = true;

        $total = 0;
        $daftar_usulan_topik = PendaftarUsulanTopik::where('id_mahasiswa', Session::get('id'))->get();
        $periode_aktif = PeriodeDaftarUsulanTopik::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;
        if($periode_aktif)
        {
            $total = PendaftarUsulanTopik::where('id_periode_daftar_usulan_topik', $periode_aktif->id)->count();
            $daftar_pendaftar = PendaftarUsulanTopik::where('id_periode_daftar_usulan_topik', $periode_aktif->id)->paginate(10);
            return view('pendaftar-usulan-topik.index', compact('periode_aktif', 'daftar_pendaftar', 'daftar_usulan_topik', 'sub_menu', 'total'));
        }else{
            return view('pendaftar-usulan-topik.index', compact('daftar_usulan_topik', 'sub_menu', 'total'));
        }
    }

    // mahasiswa
    public function create()
    {
        $periode_aktif = PeriodeDaftarUsulanTopik::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;

        if(!$periode_aktif){
            Session::flash('kesalahan', 'Pendaftaran Usulan Topik Belum Dibuka');
            return redirect()->back();
        }

        $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));

        // validasi dosen PA
        if(empty($mahasiswa->id_dosen)){ 
            return redirect('pendaftaran/usulan-topik')->with('kesalahan', 'Anda belum memasukan Dosen Pendamping Akademik');
        }

        // validasi Prodi
        if(empty($mahasiswa->id_prodi)){
            return redirect('pendaftaran/usulan-topik')->with('kesalahan', 'Anda belum memasukan Program Studi');
        }

        // validasi mahasiswa kontrak skripsi
        if($mahasiswa->kontrak_skripsi === 'tidak'){
            return redirect('pendaftaran/usulan-topik')->with('kesalahan', 'Anda belum mengontrak Mata Kuliah Skripsi');
        }

        // validasi usulan topik diterima
        $usulan_topik_diterima = PendaftarUsulanTopik::where('id_mahasiswa', Session::get('id'))->where('tahapan', 'diterima')->first() or null;
        if(!empty($usulan_topik_diterima)) return redirect('pendaftaran/usulan-topik')->with('kesalahan', 'Usulan topik anda sebelumnya sudah diterima, silahkan dilanjutkan!');

        // validasi usulan topik diterima
        $usulan_topik_diperiksa = PendaftarUsulanTopik::where('id_mahasiswa', Session::get('id'))->where('tahapan', 'diperiksa')->first() or null;
        if(!empty($usulan_topik_diperiksa)) return redirect('pendaftaran/usulan-topik')->with('kesalahan', 'Usulan topik anda sebelumnya sedang diperiksa oleh Pengelola, dimohon untuk menunggu!');


        $pengaturan = \App\Pengaturan::findOrFail(1);

        return view('pendaftar-usulan-topik.create', compact('pengaturan'));
    }

    // mahasiswa
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'usulan_topik' => 'required|string',
            'usulan_judul' => 'required|string',
            'alternatif_judul' => 'required|string',
            'permasalahan' => 'required|string',
            'tujuan' => 'required|string',
            'manfaat' => 'required|string',
            'metode_penelitian' => 'required|string',
            'metode_pengembangan_sistem' => 'required|string',
            'tahapan_penelitian' => 'required|string',
            'id_periode_daftar_usulan_topik' => 'required|integer',

            'referensi.*.nama_penulis' => 'required|string',
            'referensi.*.judul_artikel' => 'required|string',
            'referensi.*.jurnal_ilmiah' => 'required|string',
            'referensi.*.keterkaitan' => 'required|string'
        ]);

        if($validasi->fails()){
            return redirect()->back()->withInput()->withErrors($validasi);
        }

        // simpan usulan topik
        $pendaftar = new PendaftarUsulanTopik;
        $pendaftar->usulan_topik = $request->post('usulan_topik');
        $pendaftar->usulan_judul = $request->post('usulan_judul');
        $pendaftar->alternatif_judul = $request->post('alternatif_judul');
        $pendaftar->permasalahan = $request->post('permasalahan');
        $pendaftar->tujuan = $request->post('tujuan');
        $pendaftar->manfaat = $request->post('manfaat');
        $pendaftar->tahapan = 'diperiksa';
        $pendaftar->metode_penelitian = $request->post('metode_penelitian');
        $pendaftar->metode_pengembangan_sistem = $request->post('metode_pengembangan_sistem');
        $pendaftar->tahapan_penelitian = $request->post('tahapan_penelitian');
        $pendaftar->id_periode_daftar_usulan_topik = $request->post('id_periode_daftar_usulan_topik');
        $pendaftar->id_mahasiswa = Session::get('id');
        $pendaftar->save();
        
        // simpan referensi utama
        foreach($request->post('referensi') as $reff){
          $referensi[] = new \App\ReferensiUtama([
            'nama_penulis' => $reff['nama_penulis'],
            'judul_artikel' => $reff['judul_artikel'],
            'jurnal_ilmiah' => $reff['jurnal_ilmiah'],
            'keterkaitan' => $reff['keterkaitan']
          ]);
        }
        $pendaftar->referensiUtama()->saveMany($referensi);

        // perbaharui tahapan skripsi mahasiswa
        $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));
        $mahasiswa->tahapan_skripsi = 'pendaftaran_topik';
        $mahasiswa->save();

        // perbaharui riwayat tahapan
        $riwayatTahapan = \App\RiwayatTahapan::where('id_mahasiswa', Session::get('id'))->where('tahapan', 'pendaftaran_usulan_topik')->first();
        if($riwayatTahapan){
            $riwayatTahapan->created_at = now();
            $riwayatTahapan->save();
        }else{
            $riwayat =  new \App\RiwayatTahapan;
            $riwayat->tahapan =  'pendaftaran_usulan_topik';
            $riwayat->id_mahasiswa =  Session::get('id');
            $riwayat->save();
        }
        
        // notifikasi admin
        $notifikasiAdmin = new \App\NotifikasiAdmin;
        $notifikasiAdmin->link = 'pendaftaran/usulan-topik/' . $pendaftar->id;
        $notifikasiAdmin->jenis = 'pendaftaran';
        $notifikasiAdmin->deskripsi = Session::get('nama') . ' mendaftar usulan topik skripsi dengan judul : <strong>'. $pendaftar->usulan_judul .'</strong>. Silahkan validasi usulan topiknya';
        $notifikasiAdmin->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = Session::get('id');
        $notifikasiMahasiswa->link = 'pendaftaran/usulan-topik/' . $pendaftar->id;
        $notifikasiMahasiswa->jenis = 'pendaftaran';
        $notifikasiMahasiswa->deskripsi = 'Usulan topik skripsi anda dengan judul : <strong> '. $pendaftar->usulan_judul .' </strong> sedang <strong>DIPERIKSA</strong>. Silahkan menunggu!';
        $notifikasiMahasiswa->save();

        Session::flash('pesan', 'Berhasil Mendaftarkan 1 Usulan Topik');
        return redirect('pendaftaran/usulan-topik');
    }

    // mahasiswa & pimpinan
    public function show(PendaftarUsulanTopik $usulan_topik)
    {
        return view('pendaftar-usulan-topik.detail', compact('usulan_topik'));
    }

    // mahasiswa
    public function edit(PendaftarUsulanTopik $usulan_topik)
    {
        if(Session::get('id') !== $usulan_topik->id_mahasiswa){
          return redirect()->back()->with('kesalahan', 'Anda Tidak Boleh Mengedit Berkas Usulan Topik Mahasiswa Lain!');
        }

        $pengaturan = \App\Pengaturan::findOrFail(1);

        return view('pendaftar-usulan-topik.edit', compact('usulan_topik', 'pengaturan'));
    }

    // mahasiswa
    public function update(Request $request, PendaftarUsulanTopik $usulan_topik)
    {
        if(Session::get('id') !== $usulan_topik->id_mahasiswa){
          return redirect()->back()->with('kesalahan', 'Anda Tidak Boleh Memperbaharui Berkas Usulan Topik Mahasiswa Lain!');
        }

        $validasi = Validator::make($request->all(), [
            'usulan_topik' => 'required|string',
            'usulan_judul' => 'required|string',
            'alternatif_judul' => 'required|string',
            'permasalahan' => 'required|string',
            'tujuan' => 'required|string',
            'manfaat' => 'required|string',
            'metode_penelitian' => 'required|string',
            'metode_pengembangan_sistem' => 'required|string',
            'tahapan_penelitian' => 'required|string',
            'id_periode_daftar_usulan_topik' => 'required|integer',

            'referensi.*.nama_penulis' => 'required|string',
            'referensi.*.judul_artikel' => 'required|string',
            'referensi.*.jurnal_ilmiah' => 'required|string',
            'referensi.*.keterkaitan' => 'required|string'
        ]);

        if($validasi->fails()){
            return redirect()->back()->withInput()->withErrors($validasi);
        }

        $usulan_topik->usulan_topik = $request->post('usulan_topik');
        $usulan_topik->usulan_judul = $request->post('usulan_judul');
        $usulan_topik->alternatif_judul = $request->post('alternatif_judul');
        $usulan_topik->permasalahan = $request->post('permasalahan');
        $usulan_topik->tujuan = $request->post('tujuan');
        $usulan_topik->manfaat = $request->post('manfaat');
        $usulan_topik->id_mahasiswa = Session::get('id');
        $usulan_topik->tahapan = 'diperiksa';
        $usulan_topik->id_periode_daftar_usulan_topik = $request->post('id_periode_daftar_usulan_topik');
        $usulan_topik->metode_penelitian = $request->post('metode_penelitian');
        $usulan_topik->metode_pengembangan_sistem = $request->post('metode_pengembangan_sistem');
        $usulan_topik->tahapan_penelitian = $request->post('tahapan_penelitian');
        $usulan_topik->save();

        foreach($request->post('referensi') as $reff){
          $referensi = \App\ReferensiUtama::findOrFail($reff['id']);
          $referensi->nama_penulis = $reff['nama_penulis'];
          $referensi->judul_artikel = $reff['judul_artikel'];
          $referensi->jurnal_ilmiah = $reff['jurnal_ilmiah'];
          $referensi->keterkaitan = $reff['keterkaitan'];
          $referensi->save();
        }

        Session::flash('pesan', 'Pendaftar Usulan Topik Berhasil Diupdate');
        return redirect('pendaftaran/usulan-topik');
    }

    // mahasiswa & pimpinan
    public function destroy(PendaftarUsulanTopik $usulan_topik)
    {
        if(Session::has('mahasiswa') && Session::get('id') !== $usulan_topik->id_mahasiswa){
          return redirect()->back()->with('kesalahan', 'Anda Tidak Boleh Menghapus Berkas Usulan Topik Mahasiswa Lain!');
        }

        $mahasiswa = \App\Mahasiswa::findOrFail($usulan_topik->id_mahasiswa);
        $mahasiswa->tahapan_skripsi = 'persiapan';
        $mahasiswa->save();

        $id_periode = $usulan_topik->id_periode_daftar_usulan_topik;

        $usulan_topik->delete();
        Session::flash('pesan', '1 Pendaftar Usulan Topik Berhasil Dihapus');
        if(Session::has('mahasiswa')) return redirect('pendaftaran/usulan-topik');
        elseif($id_periode) return redirect('pendaftaran/usulan-topik/periode/' . $id_periode);
        else return redirect('pendaftaran/usulan-topik/periode/tidak-diketahui');
    }

    // pimpinan
    public function semuaPendaftar()
    {
        $sub_menu = true;

        $total_periode_kosong = PendaftarUsulanTopik::whereNull('id_periode_daftar_usulan_topik')->count();
        $daftar_periode_usulan_topik = PeriodeDaftarUsulanTopik::with('pendaftarUsulanTopik')->orderBy('waktu_tutup', 'desc')->paginate(10);
        $total = PeriodeDaftarUsulanTopik::with('pendaftarUsulanTopik')->orderBy('waktu_tutup', 'desc')->count();
        return view('pendaftar-usulan-topik.semua', compact('daftar_periode_usulan_topik', 'total_periode_kosong', 'total', 'sub_menu'));
    }

    // pimpinan
    public function validasi(Request $request)
    {
        // validasi usulan topik
        $usulan_topik = PendaftarUsulanTopik::findOrFail($request->post('id'));
        $usulan_topik->tahapan = $request->post('tahapan');
        $usulan_topik->keterangan = $request->post('keterangan');
        $usulan_topik->save();

        // atur tahapan skripsi jika usulan topik ditolak atau dibatalkan
        if($request->post('tahapan') === 'ditolak' || $request->post('tahapan') === 'dibatalkan'){
            $mahasiswa = \App\Mahasiswa::findOrFail($usulan_topik->id_mahasiswa);
            $mahasiswa->tahapan_skripsi = 'pendaftaran_topik';
            $mahasiswa->save();
        }

        if($request->post('tahapan') === 'ditolak' || $request->post('tahapan') === 'dibatalkan' || $request->post('tahapan') === 'diterima'){
            // notifikasi mahasiswa
            $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
            $notifikasiMahasiswa->id_mahasiswa = $usulan_topik->id_mahasiswa;
            $notifikasiMahasiswa->link = 'pendaftaran/usulan-topik/' . $usulan_topik->id;
            $notifikasiMahasiswa->jenis = 'pendaftaran';

            if($request->post('tahapan') === 'ditolak' || $request->post('tahapan') === 'dibatalkan'){
                $notifikasiMahasiswa->deskripsi = 'Usulan topik skripsi anda dengan judul : <strong> '. $usulan_topik->usulan_judul .' </strong> telah <strong>'. ucwords($request->post('tahapan')) .'</strong> dengan keterangan : <strong><em>'. $request->post('keterangan') .'</em></strong>. Silahkan memasukan usulan topik yang baru!';
            }else{
                $notifikasiMahasiswa->deskripsi = 'Usulan topik skripsi anda dengan judul : <strong> '. $usulan_topik->usulan_judul .' </strong> telah <strong>'. ucwords($request->post('tahapan')) .'</strong> dengan keterangan : <strong><em>'. $request->post('keterangan') .'</em></strong>. Silahkan menunggu dosen pembimbing Skripsi!';
            }
            $notifikasiMahasiswa->save();
        }

        Session::flash('pesan', 'Pendaftar Usulan Topik Berhasil Divalidasi');
        return redirect('pendaftaran/usulan-topik/'.$usulan_topik->id);
    }

    // pimpinan
    public function detailPeriode($id)
    {
        $filter_usulan_topik = true;

        $periode = PeriodeDaftarUsulanTopik::find($id);
        
        $daftar_usulan_topik = PendaftarUsulanTopik::where('id_periode_daftar_usulan_topik', $id)->orderBy('created_at', 'desc')->paginate(10);

        $total_berkas = PendaftarUsulanTopik::where('id_periode_daftar_usulan_topik', $id)->where('tahapan', 'diperiksa')->count();
        
        $total = PendaftarUsulanTopik::where('id_periode_daftar_usulan_topik', $id)->count();
        
        $daftar_prodi = \App\Prodi::pluck('nama', 'id');

        return view('pendaftar-usulan-topik.daftar-periode', compact('daftar_usulan_topik', 'periode', 'total_berkas', 'id', 'total', 'daftar_prodi', 'filter_usulan_topik'));
    }

    // pimpinan
    public function detailPeriodeCari(Request $request)
    {
        $nama = trim($request->input('nama'));
        $usulan_judul = trim($request->input('usulan_judul'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $id_prodi = trim($request->input('id_prodi'));
        $id_periode_daftar_usulan_topik = trim($request->input('id_periode_daftar_usulan_topik'));

      if(!empty($nama) || !empty($nim) || !empty($angkatan) || !empty($usulan_judul) || !empty($id_prodi)){

          if(!empty($nama)){
            $query = PendaftarUsulanTopik::with('mahasiswa')->where('id_periode_daftar_usulan_topik', $id_periode_daftar_usulan_topik)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('nama', 'like', '%' . $nama . '%');
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($usulan_judul)) ? $query->where('usulan_judul', 'like', '%' . $usulan_judul . '%') : '';
          }elseif(!empty($nim)){
            $query = PendaftarUsulanTopik::with('mahasiswa')->where('id_periode_daftar_usulan_topik', $id_periode_daftar_usulan_topik)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('nim', 'like', '%' . $nim . '%');
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($usulan_judul)) ? $query->where('usulan_judul', 'like', '%' . $usulan_judul . '%') : '';
          }elseif(!empty($angkatan)){
            $query = PendaftarUsulanTopik::with('mahasiswa')->where('id_periode_daftar_usulan_topik', $id_periode_daftar_usulan_topik)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('angkatan', $angkatan);
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($usulan_judul)) ? $query->where('usulan_judul', 'like', '%' . $usulan_judul . '%') : '';
          }elseif(!empty($id_prodi)){
            $query = PendaftarUsulanTopik::with('mahasiswa')->where('id_periode_daftar_usulan_topik', $id_periode_daftar_usulan_topik)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('id_prodi', $id_prodi);
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            });
            (!empty($usulan_judul)) ? $query->where('usulan_judul', 'like', '%' . $usulan_judul . '%') : '';
          }elseif(!empty($usulan_judul)){
            $query = PendaftarUsulanTopik::with('mahasiswa')->where('usulan_judul', 'like', '%' . $usulan_judul . '%')->where('id_periode_daftar_usulan_topik', $id_periode_daftar_usulan_topik)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            });
          }

          $total = $query->count();
          $daftar_usulan_topik = $query->paginate(10);

          $pagination = (!empty($nama)) ? $daftar_usulan_topik->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_usulan_topik->appends(['nim' => $nim]) : '';
          $pagination = (!empty($angkatan)) ? $daftar_usulan_topik->appends(['angkatan' => $angkatan]) : '';
          $pagination = (!empty($id_prodi)) ? $daftar_usulan_topik->appends(['id_prodi' => $id_prodi]) : '';
          $pagination = (!empty($id_periode_daftar_usulan_topik)) ? $daftar_usulan_topik->appends(['id_periode_daftar_usulan_topik' => $id_periode_daftar_usulan_topik]) : '';
          $pagination = (!empty($usulan_judul)) ? $daftar_usulan_topik->appends(['usulan_judul' => $usulan_judul]) : '';
          $pagination = $daftar_usulan_topik->appends($request->except('page'));

        $total_berkas = PendaftarUsulanTopik::where('id_periode_daftar_usulan_topik', $id_periode_daftar_usulan_topik)->where('tahapan', 'diperiksa')->count();
        $id = $id_periode_daftar_usulan_topik;
        $daftar_prodi = \App\Prodi::pluck('nama', 'id');
        
        $periode = PeriodeDaftarUsulanTopik::find($id_periode_daftar_usulan_topik);
        
        $filter_usulan_topik = true;
        
        return view('pendaftar-usulan-topik.daftar-periode', compact('daftar_usulan_topik', 'daftar_prodi', 'total', 'pagination', 'nama', 'id_prodi', 'nim', 'angkatan', 'usulan_judul', 'id_periode_daftar_usulan_topik', 'id', 'total_berkas', 'periode', 'filter_usulan_topik'));
      }
        return redirect('pendaftaran/usulan-topik/periode/' . $id_periode_daftar_usulan_topik);
    }

    // pimpinan
    public function detailPeriodeExport(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $usulan_judul = trim($request->input('usulan_judul'));
        $id_prodi = trim($request->input('id_prodi'));
        $id_periode_daftar_usulan_topik = trim($request->input('id_periode_daftar_usulan_topik'));

      return Excel::download(new PendaftarUsulanTopikExport($nama, $nim, $angkatan, $usulan_judul, $id_prodi, $id_periode_daftar_usulan_topik), 'SISKP - Export Pendaftar Usulan Topik & Judul Skripsi.xlsx');
    }

    // pimpinan
    public function periodeKosong()
    {
        $total = PendaftarUsulanTopik::whereNull('id_periode_daftar_usulan_topik')->count();
        $daftar_periode_kosong = PendaftarUsulanTopik::whereNull('id_periode_daftar_usulan_topik')->paginate(10);
        $total_periode_kosong = PendaftarUsulanTopik::whereNull('id_periode_daftar_usulan_topik')->count();
        return view('pendaftar-usulan-topik.daftar-periode-kosong', compact('daftar_periode_kosong', 'total_periode_kosong', 'total'));
    }

    // mahasiswa
    public function perubahan($id)
    {
        $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));
        $usulan_topik = PendaftarUsulanTopik::findOrFail($id);

        return view('pendaftar-usulan-topik.perubahan', compact('usulan_topik'));
    }

    // mahasiswa
    public function updatePerubahan(Request $request, $id)
    {
        $judul_baru = $request->post('judul_baru');

        $usulan_topik = PendaftarUsulanTopik::findOrFail($id);
        $judul_lama = $usulan_topik->usulan_judul;
        $usulan_topik->usulan_judul = $judul_baru;
        $usulan_topik->save();

        Session::flash('pesan', 'Judul Skripsi Berhasil Diubah');
        return redirect('pendaftaran/usulan-topik');
    }

    // pimpinan
    public function cetak($id)
    {
        $topik = PendaftarUsulanTopik::findOrFail($id);

        $pdf = PDF::loadView('pendaftar-usulan-topik.lampiran-usulan-topik', compact('topik'));
        return $pdf->download('lampiran usulan topik '.$topik->mahasiswa->nama.'.pdf');
    }

    // pimpinan
    public function createByAdmin($id)
    {
        $mahasiswa = \App\Mahasiswa::findOrFail($id);
        $daftar_periode_daftar_usulan_topik = \App\PeriodeDaftarUsulanTopik::pluck('nama', 'id');
        
        return view('pendaftar-usulan-topik.create-by-admin', compact('mahasiswa', 'daftar_periode_daftar_usulan_topik'));
    }

    // pimpinan
    public function storeByAdmin(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'usulan_topik' => 'required|string',
            'usulan_judul' => 'required|string',
            'id_mahasiswa' => 'required|integer'
        ]);

        if($validasi->fails()){
            return redirect()->back()->withInput()->withErrors($validasi);
        }
        
        $pendaftar = new PendaftarUsulanTopik;
        $pendaftar->usulan_topik = $request->post('usulan_topik');
        $pendaftar->usulan_judul = $request->post('usulan_judul');
        $pendaftar->id_mahasiswa = $request->post('id_mahasiswa');
        $pendaftar->tahapan = 'diterima';
        $pendaftar->save();
        
        // perbaharui tahapan skripsi mahasiswa
        $mahasiswa = \App\Mahasiswa::findOrFail($request->post('id_mahasiswa'));
        $mahasiswa->tahapan_skripsi = 'pendaftaran_topik';
        $mahasiswa->save();

        Session::flash('pesan', 'Berhasil Mendaftarkan 1 Usulan Topik');
        return redirect('mahasiswa');
    }

    // pimpinan
    public function createDosbing($id)
    {
      $pendaftar = PendaftarUsulanTopik::findOrFail($id);
      $daftar_dosen = \App\Dosen::where('status', 'aktif')->where('bisa_membimbing', 'ya')->pluck('nama', 'id');
      $daftar_semester = \App\Semester::pluck('nama', 'id');
      return view('dosbing.insert-by-usulan-topik', compact('pendaftar', 'daftar_semester', 'daftar_dosen'));
    }

    // pimpinan
    public function setujuiSemua(Request $request)
    {
        PendaftarUsulanTopik::where('id_periode_daftar_usulan_topik', $request->post('id_periode_daftar_usulan_topik'))->update([
          'tahapan' => 'diterima' 
        ]);

        Session::flash('pesan', 'Semua Berkas Usulan Topik Di Periode Ini berhasil Disetujui');
        return redirect('pendaftaran/usulan-topik/periode/' . $request->post('id_periode_daftar_usulan_topik'));
    }

    // admin
    public function formInputByAdmin($id)
    {
        $periode = PeriodeDaftarUsulanTopik::findOrFail($id);
        $daftar_mahasiswa = \App\Mahasiswa::where('kontrak_skripsi', 'ya')->pluck('nama', 'id');
        return view('pendaftar-usulan-topik.input-by-admin', compact('periode', 'daftar_mahasiswa', 'id'));
    }

    // admin
    public function inputByAdmin(Request $request)
    {
        $mahasiswa = \App\Mahasiswa::findOrFail($request->post('id_mahasiswa'));

        $pendaftar = new PendaftarUsulanTopik;
        $pendaftar->id_periode_daftar_usulan_topik = $request->post('id_periode_daftar_usulan_topik');
        $pendaftar->id_mahasiswa = $request->post('id_mahasiswa');
        $pendaftar->usulan_topik = $request->post('usulan_topik');
        $pendaftar->usulan_judul = $request->post('usulan_judul');
        $pendaftar->save();

        // notifikasi admin
        $notifikasiAdmin = new \App\NotifikasiAdmin;
        $notifikasiAdmin->link = 'pendaftaran/usulan-topik/' . $pendaftar->id;
        $notifikasiAdmin->jenis = 'pendaftaran';
        $notifikasiAdmin->deskripsi = $mahasiswa->nama . ' mendaftar usulan topik skripsi dengan judul : <strong>'. $pendaftar->usulan_judul .'</strong>. Silahkan validasi usulan topiknya';
        $notifikasiAdmin->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $mahasiswa->id;
        $notifikasiMahasiswa->link = 'pendaftaran/usulan-topik/' . $pendaftar->id;
        $notifikasiMahasiswa->jenis = 'pendaftaran';
        $notifikasiMahasiswa->deskripsi = 'Usulan topik skripsi anda dengan judul : <strong> '. $pendaftar->usulan_judul .' </strong> sedang <strong>DIPERIKSA</strong>. Silahkan menunggu!';
        $notifikasiMahasiswa->save();

        // perbaharui riwayat tahapan
        $riwayatTahapan = \App\RiwayatTahapan::where('id_mahasiswa', $mahasiswa->id)->where('tahapan', 'pendaftaran_usulan_topik')->first();
        if($riwayatTahapan){
            $riwayatTahapan->created_at = now();
            $riwayatTahapan->save();
        }else{
            $riwayat =  new \App\RiwayatTahapan;
            $riwayat->tahapan =  'pendaftaran_usulan_topik';
            $riwayat->id_mahasiswa =  $mahasiswa->id;
            $riwayat->save();
        }

        $mahasiswa->kontrak_skripsi = 'ya';
        $mahasiswa->save();

        Session::flash('pesan', 'Anda berhasil menginput 1 mahasiswa');
        return redirect('pendaftaran/usulan-topik/periode/' . $request->post('id_periode_daftar_usulan_topik'));
    }

}
