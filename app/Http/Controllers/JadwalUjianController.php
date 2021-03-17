<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JadwalUjian;
use App\DosenPenguji;
use App\PesertaUjian;
use Session;
use DB;
use PDF;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JadwalUjianExport;

class JadwalUjianController extends Controller
{
    public function __construct(){
        $this->middleware('mahasiswa', ['only' => [
            'index'
        ]]);

        $this->middleware('mahasiswaPimpinan', ['only' => [
            'show', 'jadwalByTanggal', 'detailPeserta', 'cetak', 'administrasiUjian', 'administrasiUjianKp', 'formAdministrasiUjianKp', 'jadwalByTanggalCari'
        ]]);

        $this->middleware('pimpinan', ['only' => [
            'semuaJadwal', 'destroy', 'destroyPeserta', 'create', 'createPeserta', 'store', 'storeKp', 'storePeserta', 'undangan', 'formUndangan', 'beritaAcaraSkripsi', 'formBeritaAcaraSkripsi', 'beritaAcaraKp', 'formBeritaAcaraKp'
        ]]);

        $this->middleware('pengguna', ['only' => [
            'beritaAcaraSkripsiByMahasiswa', 'beritaAcaraKpByMahasiswa'
        ]]);

        $this->middleware('dosen', ['only' => [
            'indexDosen'
        ]]);
    }

    // mahasiswa
    public function index()
    {
        // jadwal bulan ini
        $bulan = date('m', strtotime(now()));
        $tahun = date('Y', strtotime(now()));

        $daftar_jadwal_bulan_ini = JadwalUjian::whereMonth('waktu_mulai', $bulan)->whereYear('waktu_mulai', $tahun)->orderBy('waktu_mulai', 'ASC')->paginate(10);
        $total = JadwalUjian::whereMonth('waktu_mulai', $bulan)->whereYear('waktu_mulai', $tahun)->count();

        // jadwal ujian saya
        $daftar_jadwal = JadwalUjian::where('id_mahasiswa', Session::get('id'))->orderBy('waktu_mulai', 'ASC')->get();

        return view('jadwal-ujian.index', compact('daftar_jadwal', 'daftar_jadwal_bulan_ini', 'total', 'bulan', 'tahun'));
    }

    // mahasiswa
    public function indexDosen()
    {
        // jadwal bulan ini
        $bulan = date('m', strtotime(now()));
        $tahun = date('Y', strtotime(now()));

        $daftar_jadwal_bulan_ini = JadwalUjian::whereMonth('waktu_mulai', $bulan)->whereYear('waktu_mulai', $tahun)->orderBy('waktu_mulai', 'ASC')->paginate(10);
        $total = JadwalUjian::whereMonth('waktu_mulai', $bulan)->whereYear('waktu_mulai', $tahun)->count();

        return view('jadwal-ujian.index-dosen', compact('daftar_jadwal_bulan_ini', 'total', 'bulan', 'tahun'));
    }

    // pimpinan
    public function semuaJadwal(Request $request)
    {
        $daftar_jadwal = JadwalUjian::selectRaw('MONTH(waktu_mulai) bulan, YEAR(waktu_mulai) tahun, count(*) total')->groupBy('bulan', 'tahun')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->limit(24)->get();
        return view('jadwal-ujian.semua', compact('daftar_jadwal'));
    }

    // pimpinan & mahasiswa
    public function jadwalByTanggal($tanggal)
    {
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        $daftar_jadwal = JadwalUjian::whereMonth('waktu_mulai', $bulan)->whereYear('waktu_mulai', $tahun)->orderBy('waktu_mulai', 'ASC')->paginate(10);
        $total = JadwalUjian::whereMonth('waktu_mulai', $bulan)->whereYear('waktu_mulai', $tahun)->count();

        $daftar_prodi = \App\Prodi::pluck('nama', 'id');
        $filter_jadwal_ujian = true;

        return view('jadwal-ujian.jadwal-tanggal', compact('daftar_jadwal', 'bulan', 'tahun', 'daftar_prodi', 'total', 'tanggal', 'filter_jadwal_ujian'));
    }

    // pimpinan & mahasiswa
    public function jadwalByTanggalCari(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $id_prodi = trim($request->input('id_prodi'));
        $ujian = trim($request->input('ujian'));
        $bulan = trim($request->input('bulan'));
        $tahun = trim($request->input('tahun'));

      if(!empty($nama) || !empty($nim) || !empty($angkatan) || !empty($id_prodi) || !empty($ujian) || !empty($bulan) || !empty($tahun)){

          if(!empty($nama)){
            $query = JadwalUjian::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('nama', 'like', '%' . $nama . '%');
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
            (!empty($bulan)) ? $query->whereMonth('waktu_mulai', $bulan) : '';
            (!empty($tahun)) ? $query->whereYear('waktu_mulai', $tahun) : '';
          }elseif(!empty($nim)){
            $query = JadwalUjian::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('nim', 'like', '%' . $nim . '%');
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
            (!empty($bulan)) ? $query->whereMonth('waktu_mulai', $bulan) : '';
            (!empty($tahun)) ? $query->whereYear('waktu_mulai', $tahun) : '';
          }elseif(!empty($angkatan)){
            $query = JadwalUjian::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('angkatan', $angkatan);
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
            (!empty($bulan)) ? $query->whereMonth('waktu_mulai', $bulan) : '';
            (!empty($tahun)) ? $query->whereYear('waktu_mulai', $tahun) : '';
          }elseif(!empty($id_prodi)){
            $query = JadwalUjian::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                $query->where('id_prodi', $id_prodi);
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            });
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
            (!empty($bulan)) ? $query->whereMonth('waktu_mulai', $bulan) : '';
            (!empty($tahun)) ? $query->whereYear('waktu_mulai', $tahun) : '';
          }elseif(!empty($ujian)){
            $query = JadwalUjian::with('mahasiswa')->where('ujian', $ujian)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            });
            (!empty($bulan)) ? $query->whereMonth('waktu_mulai', $bulan) : '';
            (!empty($tahun)) ? $query->whereYear('waktu_mulai', $tahun) : '';
          }elseif(!empty($bulan)){
            $query = JadwalUjian::with('mahasiswa')->whereMonth('waktu_mulai', $bulan)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            });
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
            (!empty($tahun)) ? $query->whereYear('waktu_mulai', $tahun) : '';
          }elseif(!empty($tahun)){
            $query = JadwalUjian::with('mahasiswa')->whereYear('waktu_mulai', $tahun)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $id_prodi){
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            });
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
            (!empty($bulan)) ? $query->whereMonth('waktu_mulai', $bulan) : '';
          }

          $total = $query->count();
          $daftar_jadwal = $query->paginate(10);

          $pagination = (!empty($nama)) ? $daftar_jadwal->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_jadwal->appends(['nim' => $nim]) : '';
          $pagination = (!empty($angkatan)) ? $daftar_jadwal->appends(['angkatan' => $angkatan]) : '';
          $pagination = (!empty($id_prodi)) ? $daftar_jadwal->appends(['id_prodi' => $id_prodi]) : '';
          $pagination = (!empty($ujian)) ? $daftar_jadwal->appends(['ujian' => $ujian]) : '';
          $pagination = (!empty($bulan)) ? $daftar_jadwal->appends(['bulan' => $bulan]) : '';
          $pagination = (!empty($tahun)) ? $daftar_jadwal->appends(['tahun' => $tahun]) : '';
          $pagination = $daftar_jadwal->appends($request->except('page'));

        $daftar_prodi = \App\Prodi::pluck('nama', 'id');
        $tanggal = $tahun . '-' . $bulan;

        $filter_jadwal_ujian = true;

        return view('jadwal-ujian.jadwal-tanggal', compact('daftar_jadwal', 'daftar_prodi', 'total', 'pagination', 'nama', 'id_prodi', 'nim', 'angkatan', 'ujian', 'bulan', 'tahun', 'tanggal', 'filter_jadwal_ujian'));
      }
        return redirect('jadwal-ujian/' . $tahun . '-' . $bulan);
    }

    // pimpinan & mahasiswa
    public function show($id)
    {
        $jadwal = JadwalUjian::findOrFail($id);
        return view('jadwal-ujian.detail', compact('jadwal'));
    }

    // pimpinan
    public function destroy($id)
    {
        $jadwal = JadwalUjian::findOrFail($id);

        $tahun = date('Y', strtotime($jadwal->waktu_mulai));
        $bulan = date('m', strtotime($jadwal->waktu_mulai));

        $jadwal->delete();
        Session::flash('pesan', 'Jadwal Ujian Berhasil Dihapus');
        return redirect('jadwal-ujian/' . $tahun . '-' . $bulan);
    }

    // pimpinan
    public function destroyPeserta($id)
    {
        $peserta = PesertaUjian::findOrFail($id);
        $peserta->delete();
        Session::flash('pesan', 'Peserta Ujian Berhasil Dihapus');
        return redirect()->back();
    }

    // pimpinan
    public function create(Request $request)
    {
        $daftar_dosen = \App\Dosen::where('status', 'aktif')->where('bisa_menguji', 'ya')->pluck('nama', 'id');
        if($request->segment(2) === 'create-skripsi'){
            $daftar_mahasiswa = \App\Mahasiswa::where('kontrak_skripsi', 'ya')->pluck('nama', 'id');
            $total_penguji = 4;
            $jenis = 'Skripsi';
        }elseif($request->segment(2) === 'create-kerja-praktek'){
            $daftar_mahasiswa = \App\Mahasiswa::where('kontrak_kp', 'ya')->pluck('nama', 'id');
            $total_penguji = 3;
            $jenis = 'Kerja Praktek';
        }
        return view('jadwal-ujian.create', compact('total_penguji', 'jenis', 'daftar_mahasiswa', 'daftar_dosen'));
    }

    // pimpinan
    public function createPeserta($id)
    {
        $jadwal = \App\JadwalUjian::findOrFail($id);
        $daftar_mahasiswa = \App\Mahasiswa::where('kontrak_skripsi', 'ya')->pluck('nama', 'id');
        return view('jadwal-ujian.create-peserta', compact('jadwal', 'daftar_mahasiswa'));
    }

    // mahasiswa & pimpinan
    public function detailPeserta($id)
    {
        $jadwal = \App\JadwalUjian::findOrFail($id);
        return view('jadwal-ujian.detail-peserta', compact('jadwal'));
    }

    // pimpinan
    public function store(Request $request)
    {
        // validasi
        $validasi = Validator::make($request->all(), [
          'ujian' => 'required|in:proposal,hasil,sidang-skripsi',
          'tempat' => 'required|string|max:100',
          'id_mahasiswa' => 'required|integer',
          'dospeng.*.id_dosen' => 'required|integer'
        ]);
        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        $waktu_mulai = date('Y-m-d H:i:s', strtotime($request->post('waktu').' '.$request->post('jam_mulai')));
        $waktu_selesai = date('Y-m-d H:i:s', strtotime($request->post('waktu').' '.$request->post('jam_selesai')));

        // Cek jika ada dosen penguji yang waktu mengujinya bentrok
        foreach($request->post('dospeng') as $dospeng){
            $dosen[] = $dospeng['id_dosen'];
        }
        $dosen_penguji = \App\DosenPenguji::whereIn('id_dosen', $dosen)->whereHas('jadwalUjian', function ($query) use ($waktu_mulai, $waktu_selesai) {
            $query->whereBetween('waktu_mulai', [$waktu_mulai, $waktu_selesai])->orWhereBetween('waktu_selesai', [$waktu_mulai, $waktu_selesai]);
        })->get();

        // input jadwal ujian
        $jadwal = new JadwalUjian;
        $jadwal->ujian = $request->post('ujian');
        $jadwal->tempat = $request->post('tempat');
        $jadwal->waktu_mulai = $waktu_mulai;
        $jadwal->waktu_selesai = $waktu_selesai;
        $jadwal->id_mahasiswa = $request->post('id_mahasiswa');
        $jadwal->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $request->post('id_mahasiswa');
        $notifikasiMahasiswa->link = 'jadwal-ujian';
        $notifikasiMahasiswa->jenis = 'jadwal-ujian';
        $notifikasiMahasiswa->deskripsi = 'Jadwal ujian <strong> ' . ucwords(str_replace('-', ' ', $request->post('ujian'))) . '</strong> anda telah tersedia';
        $notifikasiMahasiswa->save();

        // input dosen penguji
        $i=1;
        foreach($request->post('dospeng') as $dospeng){
            $penguji[] = new DosenPenguji([
                'dospeng' => $i++,
                'id_dosen' => $dospeng['id_dosen']
            ]);

            // notifikasi dosen
            $notifikasiDosen = new \App\NotifikasiDosen;
            $notifikasiDosen->id_dosen = $dospeng['id_dosen'];
            $notifikasiDosen->link = 'mahasiswa/pengujian/' . date('Y', strtotime($waktu_mulai)) . '-' . date('m', strtotime($waktu_mulai));
            $notifikasiDosen->jenis = 'jadwal-ujian';
            $notifikasiDosen->deskripsi = 'Jadwal menguji ujian <strong> ' . ucwords(str_replace('-', ' ', $request->post('ujian'))) . '</strong> telah tersedia';
            $notifikasiDosen->save();
        }
        $jadwal->dosenPenguji()->saveMany($penguji);

        // masukan penilaian sesuai ujian
        if($request->post('ujian') === 'proposal'){
            $indikators = \App\IndikatorPenilaian::where('ujian', 'proposal')->get('id');
            $j=1;
            foreach($indikators as $indikator){
                $penilaianProposal = new \App\PenilaianProposal;
                $penilaianProposal->nilai_dospeng_satu = 0;
                $penilaianProposal->nilai_dospeng_dua = 0;
                $penilaianProposal->nilai_dospeng_tiga = 0;
                $penilaianProposal->nilai_dospeng_empat = 0;
                $penilaianProposal->nilai_dospeng_lima = 0;
                $penilaianProposal->nilai_rerata = 0;
                $penilaianProposal->nilai_rerata_x_bobot = 0;
                $penilaianProposal->id_indikator_penilaian = $indikator->id;
                $penilaianProposal->id_jadwal_ujian = $jadwal->id;
                $penilaianProposal->dospeng_satu_proposal = $penguji[0]['id_dosen'];
                $penilaianProposal->dospeng_dua_proposal = $penguji[1]['id_dosen'];
                $penilaianProposal->dospeng_tiga_proposal = $penguji[2]['id_dosen'];
                $penilaianProposal->dospeng_empat_proposal = $penguji[3]['id_dosen'];
                $penilaianProposal->dospeng_lima_proposal = $penguji[4]['id_dosen'];
                $penilaianProposal->save();
                $j++;
            }
        }elseif($request->post('ujian') === 'hasil'){
            $indikators = \App\IndikatorPenilaian::where('ujian', 'hasil')->get('id');
            $j=1;
            foreach($indikators as $indikator){
                $penilaianHasil = new \App\PenilaianHasil;
                $penilaianHasil->nilai_dospeng_satu = 0;
                $penilaianHasil->nilai_dospeng_dua = 0;
                $penilaianHasil->nilai_dospeng_tiga = 0;
                $penilaianHasil->nilai_dospeng_empat = 0;
                $penilaianHasil->nilai_dospeng_lima = 0;
                $penilaianHasil->nilai_rerata = 0;
                $penilaianHasil->nilai_rerata_x_bobot = 0;
                $penilaianHasil->id_indikator_penilaian = $indikator->id;
                $penilaianHasil->id_jadwal_ujian = $jadwal->id;
                $penilaianHasil->dospeng_satu_hasil = $penguji[0]['id_dosen'];
                $penilaianHasil->dospeng_dua_hasil = $penguji[1]['id_dosen'];
                $penilaianHasil->dospeng_tiga_hasil = $penguji[2]['id_dosen'];
                $penilaianHasil->dospeng_empat_hasil = $penguji[3]['id_dosen'];
                $penilaianHasil->dospeng_lima_hasil = $penguji[4]['id_dosen'];
                $penilaianHasil->save();
                $j++;
            }
        }elseif($request->post('ujian') === 'sidang-skripsi'){
            $indikators = \App\IndikatorPenilaian::where('ujian', 'sidang-skripsi')->get('id');
            $j=1;
            foreach($indikators as $indikator){
                $penilaianSidang = new \App\PenilaianSidangSkripsi;
                $penilaianSidang->nilai_dospeng_satu = 0;
                $penilaianSidang->nilai_dospeng_dua = 0;
                $penilaianSidang->nilai_dospeng_tiga = 0;
                $penilaianSidang->nilai_dospeng_empat = 0;
                $penilaianSidang->nilai_dospeng_lima = 0;
                $penilaianSidang->nilai_rerata = 0;
                $penilaianSidang->nilai_rerata_x_bobot = 0;
                $penilaianSidang->id_indikator_penilaian = $indikator->id;
                $penilaianSidang->id_jadwal_ujian = $jadwal->id;
                $penilaianSidang->dospeng_satu_sidang = $penguji[0]['id_dosen'];
                $penilaianSidang->dospeng_dua_sidang = $penguji[1]['id_dosen'];
                $penilaianSidang->dospeng_tiga_sidang = $penguji[2]['id_dosen'];
                $penilaianSidang->dospeng_empat_sidang = $penguji[3]['id_dosen'];
                $penilaianSidang->dospeng_lima_sidang = $penguji[4]['id_dosen'];
                $penilaianSidang->save();
                $j++;
            }
        }

        // input nilai ujian skripsi
        if($request->post('ujian') === 'proposal'){
            $nilai_ujian_skripsi = \App\NilaiUjianSkripsi::updateOrCreate(['id_jadwal_ujian' => $jadwal->id], ['jumlah_nilai' => '0', 'nilai_akhir' => '0', 'status' => 'tidak-lulus']);

            $hasil_akumulasi = \App\HasilAkumulasiNilaiSkripsi::updateOrCreate(['id_mahasiswa' => $request->post('id_mahasiswa')], ['seminar_proposal' => '0', 'seminar_hasil' => '0', 'sidang_skripsi' => '0', 'total' => '0', 'nilai_huruf' => 'E']);
        }elseif($request->post('ujian') === 'hasil'){
            $nilai_ujian_skripsi = \App\NilaiUjianSkripsi::updateOrCreate(['id_jadwal_ujian' => $jadwal->id], ['jumlah_nilai' => '0', 'nilai_akhir' => '0', 'status' => 'tidak-lulus']);

            $hasil_akumulasi = \App\HasilAkumulasiNilaiSkripsi::updateOrCreate(['id_mahasiswa' => $request->post('id_mahasiswa')], ['seminar_hasil' => '0', 'sidang_skripsi' => '0']);
        }elseif($request->post('ujian') === 'sidang-skripsi'){
            $nilai_ujian_skripsi = \App\NilaiUjianSkripsi::updateOrCreate(['id_jadwal_ujian' => $jadwal->id], ['jumlah_nilai' => '0', 'nilai_akhir' => '0', 'status' => 'tidak-lulus']);

            $hasil_akumulasi = \App\HasilAkumulasiNilaiSkripsi::updateOrCreate(['id_mahasiswa' => $request->post('id_mahasiswa')], ['sidang_skripsi' => '0']);
        }

        // perbaharui tahapan skripsi mahasiswa
        $mahasiswa = \App\Mahasiswa::findOrFail($request->post('id_mahasiswa'));
        if($request->post('ujian') === 'proposal') $mahasiswa->tahapan_skripsi = 'ujian_seminar_proposal';
        elseif($request->post('ujian') === 'hasil') $mahasiswa->tahapan_skripsi = 'ujian_seminar_hasil';
        elseif($request->post('ujian') === 'sidang-skripsi') $mahasiswa->tahapan_skripsi = 'ujian_sidang_skripsi';
        $mahasiswa->save();

        \App\PendaftarUjian::find($request->post('id_pendaftar_ujian'))->update([
            'tahapan' => 'diterima'
        ]);

        Session::flash('pesan', 'Berhasil Mendaftarkan 1 Jadwal Ujian & Dosen Penguji');
        return redirect('jadwal-ujian/semua');
    }

    // pimpinan
    public function storeKp(Request $request)
    {
        // validasi
        $validasi = Validator::make($request->all(), [
          'ujian' => 'required|in:kerja-praktek',
          'tempat' => 'required|string|max:100',
          'id_mahasiswa' => 'required'
        ]);
        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        $waktu_mulai = date('Y-m-d H:i:s', strtotime($request->post('waktu').' '.$request->post('jam_mulai')));
        $waktu_selesai = date('Y-m-d H:i:s', strtotime($request->post('waktu').' '.$request->post('jam_selesai')));

        // input jadwal ujian
        $jadwal = new JadwalUjian;
        $jadwal->ujian = $request->post('ujian');
        $jadwal->tempat = $request->post('tempat');
        $jadwal->waktu_mulai = $waktu_mulai;
        $jadwal->waktu_selesai = $waktu_selesai;
        $jadwal->id_mahasiswa = $request->post('id_mahasiswa');
        $jadwal->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $request->post('id_mahasiswa');
        $notifikasiMahasiswa->link = 'jadwal-ujian';
        $notifikasiMahasiswa->jenis = 'jadwal-ujian';
        $notifikasiMahasiswa->deskripsi = 'Jadwal ujian <strong> ' . ucwords(str_replace('-', ' ', $request->post('ujian'))) . '</strong> anda telah tersedia';
        $notifikasiMahasiswa->save();

        // input dosen penguji
        $i=1;
        foreach($request->post('dospeng') as $dospeng){
            $penguji[] = new DosenPenguji([
                'dospeng' => $i++,
                'id_dosen' => $dospeng['id_dosen']
            ]);

            // notifikasi dosen
            $notifikasiDosen = new \App\NotifikasiDosen;
            $notifikasiDosen->id_dosen = $dospeng['id_dosen'];
            $notifikasiDosen->link = 'mahasiswa/pengujian';
            $notifikasiDosen->jenis = 'jadwal-ujian';
            $notifikasiDosen->deskripsi = 'Jadwal menguji ujian <strong> ' . ucwords(str_replace('-', ' ', $request->post('ujian'))) . '</strong> telah tersedia';
            $notifikasiDosen->save();

        }
        $jadwal->dosenPenguji()->saveMany($penguji);

        // masukan penilaian kp
        if($request->post('ujian') === 'kerja-praktek'){
            $indikators = \App\IndikatorPenilaian::where('ujian', 'kerja-praktek')->get('id');
            foreach($request->post('dospeng') as $dospeng){
                foreach($indikators as $indikator){
                    \App\PenilaianKp::create(
                        ['id_jadwal_ujian' => $jadwal->id, 'id_dosen' => $dospeng['id_dosen'],
                            'id_indikator_penilaian' => $indikator->id,
                            'nilai' => '0'
                        ]
                    );
                }
            }
        }

        // input nilai ujian kp
        if($request->post('ujian') === 'kerja-praktek'){
            $nilai_ujian_kp = \App\NilaiUjianKp::updateOrCreate(['id_jadwal_ujian' => $jadwal->id], ['total' => '0', 'nilai_huruf' => 'E', 'status' => 'tidak-lulus']);
        }

        // perbaharui tahapan skripsi mahasiswa
        $mahasiswa = \App\Mahasiswa::findOrFail($request->post('id_mahasiswa'));
        $mahasiswa->tahapan_kp = 'ujian_seminar';
        $mahasiswa->save();

        Session::flash('pesan', 'Berhasil Mendaftarkan 1 Jadwal Ujian & Dosen Penguji Kerja Praktek');
        return redirect('jadwal-ujian/semua');
    }

    // pimpinan
    public function storePeserta(Request $request)
    {
        foreach($request->post('mahasiswa') as $mahasiswa){
            $mhs = new PesertaUjian;
            if(!empty($mahasiswa['id_mahasiswa'])){
                $mhs->id_mahasiswa = $mahasiswa['id_mahasiswa'];
                $mhs->id_jadwal_ujian = $request->post('id_jadwal_ujian');
                $mhs->save();
            }
        }
        Session::flash('pesan', 'Berhasil Mendaftarkan Beberapa Peserta Ujian');
        return redirect('jadwal-ujian/semua');
    }

    // mahasiswa & pimpinan
    public function cetak($tanggal)
    {
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $daftar_jadwal = JadwalUjian::whereMonth('waktu_mulai', $bulan)->whereYear('waktu_mulai', $tahun)->orderBy('waktu_mulai', 'ASC')->get();

        switch($bulan)
        {
            case '1': $bulan = 'Januari'; break;
            case '2': $bulan = 'Februari'; break;
            case '3': $bulan = 'Maret'; break;
            case '4': $bulan = 'April'; break;
            case '5': $bulan = 'Mei'; break;
            case '6': $bulan = 'Juni'; break;
            case '7': $bulan = 'Juli'; break;
            case '8': $bulan = 'Agustus'; break;
            case '9': $bulan = 'September'; break;
            case '10': $bulan = 'Oktober'; break;
            case '11': $bulan = 'November'; break;
            case '12': $bulan = 'Desember'; break;
        }

        $pdf = PDF::loadView('jadwal-ujian.cetak', compact('bulan', 'tahun', 'daftar_jadwal'))->setPaper('a4', 'landscape');
        return $pdf->download('Daftar Peserta Ujian Bulan '.$bulan.' - '.$tahun.'.pdf');
    }

    // pimpinan
    public function formUndangan($id)
    {
        $jadwal = JadwalUjian::findOrFail($id);
        return view('jadwal-ujian.form-undangan', compact('jadwal'));
    }

    // pimpinan
    public function formBeritaAcaraSkripsi($id)
    {
        $jadwal = JadwalUjian::findOrFail($id);
        return view('jadwal-ujian.form-berita-acara-skripsi', compact('jadwal'));
    }

    // pimpinan
    public function formBeritaAcaraSkripsiTtd($id)
    {
        $jadwal = JadwalUjian::findOrFail($id);
        return view('jadwal-ujian.form-berita-acara-skripsi-ttd', compact('jadwal'));
    }

    // pimpinan
    public function formBeritaAcaraKp($id)
    {
        $jadwal = JadwalUjian::findOrFail($id);
        return view('jadwal-ujian.form-berita-acara-kerja-praktek', compact('jadwal'));
    }

    // pimpinan
    public function formBeritaAcaraKpTtd($id)
    {
        $jadwal = JadwalUjian::findOrFail($id);
        return view('jadwal-ujian.form-berita-acara-kerja-praktek-ttd', compact('jadwal'));
    }

    // pimpinan
    public function beritaAcaraSkripsi(Request $request)
    {
        if(empty($request->post('nomor_surat'))) return redirect()->back()->withInput()->with('kesalahan', 'Nomor Surat Wajib Diisi');

        $nomor = $request->post('nomor_surat');
        $jadwal = JadwalUjian::find($request->post('id'));
        $dosbing = \App\DosenPembimbingSkripsi::where('id_mahasiswa', $jadwal->id_mahasiswa)->first();

        $judul = \App\PendaftarUsulanTopik::where('id_mahasiswa', $jadwal->id_mahasiswa)->where('tahapan', 'diterima')->first();

        if($jadwal->ujian === 'proposal'){
            $daftar_indikator = \App\IndikatorPenilaian::where('ujian', 'proposal')->get();
            $pdf = PDF::loadView('jadwal-ujian/berita-acara-ujian-proposal', compact('jadwal', 'dosbing', 'judul', 'nomor', 'daftar_indikator'));
        }elseif($jadwal->ujian === 'hasil'){
            $daftar_indikator = \App\IndikatorPenilaian::where('ujian', 'hasil')->get();
            $pdf = PDF::loadView('jadwal-ujian/berita-acara-ujian-hasil', compact('jadwal', 'dosbing', 'judul', 'nomor', 'daftar_indikator'));
        }elseif($jadwal->ujian === 'sidang-skripsi'){
            $daftar_indikator = \App\IndikatorPenilaian::where('ujian', 'sidang-skripsi')->get();
            $pdf = PDF::loadView('jadwal-ujian/berita-acara-ujian-sidang-skripsi', compact('jadwal', 'dosbing', 'judul', 'nomor', 'daftar_indikator'));
        }
        return $pdf->download('Berita Acara Ujian '.$jadwal->ujian.' - '.$jadwal->mahasiswa->nama.'.pdf');
    }

    // mahasiswa
    public function beritaAcaraSkripsiByMahasiswa(Request $request)
    {
        if(empty($request->post('nomor_surat'))) return redirect()->back()->with('kesalahan', 'Nomor Surat Wajib Diisi');

        $jadwal = JadwalUjian::find($request->post('id'));
        $dosbing = \App\DosenPembimbingSkripsi::where('id_mahasiswa', $jadwal->id_mahasiswa)->first();
        $nomor = $request->post('nomor_surat');
        $judul = \App\PendaftarUsulanTopik::where('id_mahasiswa', $jadwal->id_mahasiswa)->where('tahapan', 'diterima')->first();

        if($jadwal->ujian === 'proposal'){
            $penilaian_ujian = \App\PenilaianProposal::where('id_jadwal_ujian', $jadwal->id)->get();
            $dosen = \App\PenilaianProposal::where('id_jadwal_ujian', $jadwal->id)->first();
            $pdf = PDF::loadView('jadwal-ujian/berita-acara-ujian-proposal-by-mahasiswa', compact('jadwal', 'dosbing', 'judul', 'penilaian_ujian', 'dosen', 'nomor'));
        }elseif($jadwal->ujian === 'hasil'){
            $penilaian_ujian = \App\PenilaianHasil::where('id_jadwal_ujian', $jadwal->id)->get();
            $dosen = \App\PenilaianHasil::where('id_jadwal_ujian', $jadwal->id)->first();
            $pdf = PDF::loadView('jadwal-ujian/berita-acara-ujian-hasil-by-mahasiswa', compact('jadwal', 'dosbing', 'judul', 'penilaian_ujian', 'dosen', 'nomor'));
        }elseif($jadwal->ujian === 'sidang-skripsi'){
            $penilaian_ujian = \App\PenilaianSidangSkripsi::where('id_jadwal_ujian', $jadwal->id)->get();
            $dosen = \App\PenilaianSidangSkripsi::where('id_jadwal_ujian', $jadwal->id)->first();
            $akumulasiSkripsi = \App\HasilAkumulasiNilaiSkripsi::where('id_mahasiswa', $jadwal->id_mahasiswa)->first();
            $pdf = PDF::loadView('jadwal-ujian/berita-acara-ujian-sidang-skripsi-by-mahasiswa', compact('jadwal', 'dosbing', 'judul', 'penilaian_ujian', 'dosen', 'akumulasiSkripsi', 'nomor'));
        }
        return $pdf->download('Berita Acara Dengan Nilai & Tanda Tangan Ujian '.$jadwal->ujian.' - '.$jadwal->mahasiswa->nama.'.pdf');
    }

    // pimpinan
    public function beritaAcaraKpByMahasiswa(Request $request)
    {
        if(empty($request->post('nomor_surat'))) return redirect()->back()->withInput()->with('kesalahan', 'Nomor Surat Wajib Diisi');
        if(empty($request->post('judul'))) return redirect()->back()->withInput()->with('kesalahan', 'Judul Penelitian Wajib Diisi');

        $jadwal = JadwalUjian::find($request->post('id'));
        $dosbing = \App\DosenPembimbingKp::where('id_mahasiswa', $jadwal->id_mahasiswa)->first();
        $daftar_indikator = \App\IndikatorPenilaian::where('ujian', 'kerja-praktek')->get();
        $nomor = $request->post('nomor_surat');
        $judul = $request->post('judul');
        $dospeng = $jadwal->penilaianKp->groupBy('id_dosen');

        $pendaftar = \App\PendaftarTurunKp::where('id_mahasiswa', $jadwal->id_mahasiswa)->first();

        $pdf = PDF::loadView('jadwal-ujian/berita-acara-ujian-kerja-praktek-by-mahasiswa', compact('jadwal', 'dosbing', 'daftar_indikator', 'dospeng', 'nomor', 'judul', 'pendaftar'));
        return $pdf->download('Berita Acara Dengan Tanda Tangan Ujian '.$jadwal->ujian.' - '.$jadwal->mahasiswa->nama.'.pdf');
    }

    // pimpinan
    public function beritaAcaraKp(Request $request)
    {
        if(empty($request->post('nomor_surat'))) return redirect()->back()->withInput()->with('kesalahan', 'Nomor Surat Wajib Diisi');
        if(empty($request->post('judul'))) return redirect()->back()->withInput()->with('kesalahan', 'Judul Ujian Wajib Diisi');

        $jadwal = JadwalUjian::find($request->post('id'));
        $dosbing = \App\DosenPembimbingKp::where('id_mahasiswa', $jadwal->id_mahasiswa)->first();
        $daftar_indikator = \App\IndikatorPenilaian::where('ujian', 'kerja-praktek')->get();
        $nomor = $request->post('nomor_surat');
        $judul = $request->post('judul');
        $dospeng = $jadwal->penilaianKp->groupBy('id_dosen');

        $pendaftar = \App\PendaftarTurunKp::where('id_mahasiswa', $jadwal->id_mahasiswa)->first();

        $pdf = PDF::loadView('jadwal-ujian/berita-acara-ujian-kerja-praktek', compact('jadwal', 'dosbing', 'daftar_indikator', 'dospeng', 'nomor', 'judul', 'pendaftar'));
        return $pdf->download('Berita Acara Ujian '.$jadwal->ujian.' - '.$jadwal->mahasiswa->nama.'.pdf');
    }

    // pimpinan
    public function undangan(Request $request)
    {
        if(empty($request->post('nomor_surat'))) return redirect()->back()->with('kesalahan', 'Nomor Surat Wajib Diisi');

        $jadwal = JadwalUjian::find($request->post('id'));
        if($jadwal->ujian === 'kerja-praktek'){
            $dosbing = \App\DosenPembimbingKp::where('id_mahasiswa', $request->post('id_mahasiswa'))->last();
        }else{
            $dosbing = \App\DosenPembimbingSkripsi::where('id_mahasiswa', $request->post('id_mahasiswa'))->last();
        }
        $pendaftar_kp = \App\PendaftarTurunKp::where('id_mahasiswa', $jadwal->id_mahasiswa)->first();

        $nomor = $request->post('nomor_surat');
        $judul = \App\PendaftarUsulanTopik::where('id_mahasiswa', $request->post('id_mahasiswa'))->where('tahapan', 'diterima')->first();

        $pdf = PDF::loadView('jadwal-ujian/undangan', compact('jadwal', 'nomor', 'judul', 'dosbing', 'pendaftar_kp'));
        return $pdf->download('surat undangan ujian '.$jadwal->ujian.' - '.$jadwal->mahasiswa->nama.'.pdf');
    }

    // pimpinan & mahasiswa
    public function administrasiUjian($id)
    {
        $jadwal = JadwalUjian::find($id);
        $dosbing = \App\DosenPembimbingSkripsi::where('id_mahasiswa', $jadwal->id_mahasiswa)->first();
        $judul = \App\PendaftarUsulanTopik::where('id_mahasiswa', $jadwal->id_mahasiswa)->where('tahapan', 'diterima')->first();
        $kaprodi = \App\Kaprodi::where('tahun_awal', '<=', date('Y'))->where('tahun_selesai', '>=', date('Y'))->where('id_prodi', $jadwal->mahasiswa->id_prodi)->first();
        $nomor = \App\PeriodeDaftarUjian::all()->last();

        if($jadwal->ujian === 'proposal'){
            $daftar_indikator = \App\IndikatorPenilaian::where('ujian', 'proposal')->get();
            $pdf = PDF::loadView('jadwal-ujian/administrasi-ujian-proposal', compact('jadwal', 'dosbing', 'judul', 'nomor', 'daftar_indikator', 'kaprodi'));
        }elseif($jadwal->ujian === 'hasil'){
            $daftar_indikator = \App\IndikatorPenilaian::where('ujian', 'hasil')->get();
            $pdf = PDF::loadView('jadwal-ujian/administrasi-ujian-hasil', compact('jadwal', 'dosbing', 'judul', 'nomor', 'daftar_indikator', 'kaprodi'));
        }elseif($jadwal->ujian === 'sidang-skripsi'){
            $daftar_indikator = \App\IndikatorPenilaian::where('ujian', 'sidang-skripsi')->get();
            $pdf = PDF::loadView('jadwal-ujian/administrasi-ujian-sidang-skripsi', compact('jadwal', 'dosbing', 'judul', 'nomor', 'daftar_indikator', 'kaprodi'));
        }
        return $pdf->download('Administrasi Ujian '.$jadwal->ujian.' - '.$jadwal->mahasiswa->nama.'.pdf');
    }

    // mahasiswa & pimpinan
    public function formAdministrasiUjianKp($id)
    {
        $jadwal = JadwalUjian::findOrFail($id);
        return view('jadwal-ujian.form-administrasi-ujian-kp', compact('jadwal'));
    }

    // mahasiswa & pimpinan
    public function administrasiUjianKp(Request $request)
    {
        $jadwal = JadwalUjian::find($request->post('id'));
        $dosbing = \App\DosenPembimbingKp::where('id_mahasiswa', $jadwal->id_mahasiswa)->first();
        $judul = $request->post('judul');
        $nomor = \App\PeriodeDaftarUjian::all()->last();
        $daftar_indikator = \App\IndikatorPenilaian::where('ujian', 'kerja-praktek')->get();
        $dospeng = $jadwal->penilaianKp->groupBy('id_dosen');
        $pendaftar = \App\PendaftarTurunKp::where('id_mahasiswa', $jadwal->id_mahasiswa)->first();
        $kaprodi = \App\Kaprodi::where('tahun_awal', '<=', date('Y'))->where('tahun_selesai', '>=', date('Y'))->where('id_prodi', $jadwal->mahasiswa->id_prodi)->first();

        $pdf = PDF::loadView('jadwal-ujian/administrasi-ujian-kerja-praktek', compact('jadwal', 'dosbing', 'judul', 'nomor', 'daftar_indikator', 'dospeng', 'pendaftar', 'kaprodi'));

        return $pdf->download('Administrasi Ujian '.$jadwal->ujian.' - '.$jadwal->mahasiswa->nama.'.pdf');
    }

    public function jadwalByTanggalExport(Request $request, $tanggal)
    {
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        return Excel::download(new JadwalUjianExport($bulan, $tahun), 'SISKP - Export Jadwal Ujian.xlsx');
    }

}
