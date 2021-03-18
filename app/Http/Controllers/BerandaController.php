<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MahasiswaExport;
use Illuminate\Filesystem\Filesystem;

class BerandaController extends Controller
{
    public function __construct(){
        $this->middleware('pengguna', ['only' => [
            'index', 'profil'
        ]]);

        $this->middleware('pimpinan', ['only' => [
            'indexAdmin',
        ]]);

        $this->middleware('dosen', ['only' => [
            'indexDosen',
        ]]);

        $this->middleware('mahasiswa', ['only' => [
            'indexMahasiswa', 'indexRevisi', 'createRevisi', 'storeRevisi', 'editRevisi', 'updateRevisi'
        ]]);
    }

    // pengguna
    public function index()
    {
        if(Session::has('admin') || Session::has('kajur') ||Session::has('kaprodi')) return redirect('beranda/admin');
        elseif(Session::has('dosen')) return redirect('beranda/dosen');
        elseif(Session::has('mahasiswa')) return redirect('beranda/mahasiswa');
        else return redirect('masuk');
    }

    // pimpinan
    public function indexAdmin()
    {
        // mahasiswa
        $total_mahasiswa = \App\Mahasiswa::all()->count();
        $kontrak_skripsi = \App\Mahasiswa::where('kontrak_skripsi', 'ya')->count();
        $kontrak_kp = \App\Mahasiswa::where('kontrak_kp', 'ya')->count();
        $telah_lulus = \App\Mahasiswa::where('tahapan_skripsi', 'lulus')->count();
        $sementara_skripsi = \App\Mahasiswa::whereNotIn('tahapan_skripsi', ['persiapan', 'lulus'])->count();

        // dosen
        $total_dosen = \App\Dosen::all()->count();
        $bisa_menguji = \App\Dosen::where('bisa_menguji', 'ya')->count();
        $bisa_membimbing = \App\Dosen::where('bisa_membimbing', 'ya')->count();
        $dosen_aktif = \App\Dosen::where('status', 'aktif')->count();
        $dosen_tidak_aktif = \App\Dosen::where('status', 'tidak-aktif')->count();
        $dosen_cuti = \App\Dosen::where('status', 'cuti')->count();

        // PENDAFTAR USULAN TOPIK, UJIAN & TURUN KP 10 PERIODE TERAKHIR
        $persentase_usulan_topik = \App\PeriodeDaftarUsulanTopik::limit(10)->orderBy('waktu_buka', 'desc')->get();
        $persentase_ujian = \App\PeriodeDaftarUjian::limit(10)->orderBy('waktu_buka', 'desc')->get();
        $persentase_turun_kp = \App\PeriodeDaftarTurunKp::limit(10)->orderBy('waktu_buka', 'desc')->get();

        $angkatan = \App\Mahasiswa::select('angkatan')->distinct()->orderBy('angkatan', 'desc')->limit(7)->get();
        $angkatan->shift();
        $angkatan->shift();

        $skripsi_mahasiswa = [];
        $kp_mahasiswa = [];

        // TAHAPAN SKRIPSI MAHASISWA
        foreach($angkatan as $ang){
            $skripsi_mahasiswa[] = [
                'angkatan' => $ang->angkatan,
                'pendaftaran_topik' => \App\Mahasiswa::where('tahapan_skripsi', 'pendaftaran_topik')->where('kontrak_skripsi', 'ya')->where('angkatan', $ang->angkatan)->count(),
                'penyusunan_proposal' => \App\Mahasiswa::where('tahapan_skripsi', 'penyusunan_proposal')->where('kontrak_skripsi', 'ya')->where('angkatan', $ang->angkatan)->count(),
                'pendaftaran_proposal' => \App\Mahasiswa::where('tahapan_skripsi', 'pendaftaran_proposal')->where('kontrak_skripsi', 'ya')->where('angkatan', $ang->angkatan)->count(),
                'ujian_seminar_proposal' => \App\Mahasiswa::where('tahapan_skripsi', 'ujian_seminar_proposal')->where('kontrak_skripsi', 'ya')->where('angkatan', $ang->angkatan)->count(),
                'penulisan_skripsi' => \App\Mahasiswa::where('tahapan_skripsi', 'penulisan_skripsi')->where('kontrak_skripsi', 'ya')->where('angkatan', $ang->angkatan)->count(),
                'pendaftaran_hasil' => \App\Mahasiswa::where('tahapan_skripsi', 'pendaftaran_hasil')->where('kontrak_skripsi', 'ya')->where('angkatan', $ang->angkatan)->count(),
                'ujian_seminar_hasil' => \App\Mahasiswa::where('tahapan_skripsi', 'ujian_seminar_hasil')->where('kontrak_skripsi', 'ya')->where('angkatan', $ang->angkatan)->count(),
                'revisi_skripsi' => \App\Mahasiswa::where('tahapan_skripsi', 'revisi_skripsi')->where('kontrak_skripsi', 'ya')->where('angkatan', $ang->angkatan)->count(),
                'pendaftaran_sidang_skripsi' => \App\Mahasiswa::where('tahapan_skripsi', 'pendaftaran_sidang_skripsi')->where('kontrak_skripsi', 'ya')->where('angkatan', $ang->angkatan)->count(),
                'ujian_sidang_skripsi' => \App\Mahasiswa::where('tahapan_skripsi', 'ujian_sidang_skripsi')->where('kontrak_skripsi', 'ya')->where('angkatan', $ang->angkatan)->count(),
                'lulus' => \App\Mahasiswa::where('tahapan_skripsi', 'lulus')->where('kontrak_skripsi', 'ya')->where('angkatan', $ang->angkatan)->count()
            ];
        }

        // TAHAPAN KERJA PRAKTEK MAHASISWA
        foreach($angkatan as $ang){
            $kp_mahasiswa[] = [
                'angkatan' => $ang->angkatan,
                'pendaftaran_kp' => \App\Mahasiswa::where('tahapan_kp', 'pendaftaran')->where('kontrak_kp', 'ya')->where('angkatan', $ang->angkatan)->count(),
                'ujian_seminar_kp' => \App\Mahasiswa::where('tahapan_kp', 'ujian_seminar')->where('kontrak_kp', 'ya')->where('angkatan', $ang->angkatan)->count(),
                'revisi_kp' => \App\Mahasiswa::where('tahapan_kp', 'revisi')->where('kontrak_kp', 'ya')->where('angkatan', $ang->angkatan)->count(),
                'lulus_kp' => \App\Mahasiswa::where('tahapan_kp', 'lulus')->where('kontrak_kp', 'ya')->where('angkatan', $ang->angkatan)->count()
            ];
        }

        // Pendaftar Ujian 10 Periode Terakhir By Ujian
        $daftar_periode = \App\PeriodeDaftarUjian::limit(10)->orderBy('waktu_buka', 'desc')->get();
        foreach($daftar_periode as $ujian){
            $pendaftar_by_ujian[] = [
                'periode' => $ujian->nama,
                'kerja-praktek' => \App\PendaftarUjian::where('ujian', 'kerja-praktek')->where('id_periode_daftar_ujian', $ujian->id)->count(),
                'proposal' => \App\PendaftarUjian::where('ujian', 'proposal')->where('id_periode_daftar_ujian', $ujian->id)->count(),
                'hasil' => \App\PendaftarUjian::where('ujian', 'hasil')->where('id_periode_daftar_ujian', $ujian->id)->count(),
                'sidang-skripsi' => \App\PendaftarUjian::where('ujian', 'sidang-skripsi')->where('id_periode_daftar_ujian', $ujian->id)->count(),
            ];
        }

        return view('beranda-admin', compact(
            'kp_mahasiswa', 'skripsi_mahasiswa', 'total_mahasiswa', 'dosen_aktif', 'dosen_tidak_aktif', 'dosen_cuti', 'kontrak_skripsi', 'kontrak_kp', 'total_dosen', 'bisa_menguji', 'bisa_membimbing', 'persentase_usulan_topik', 'persentase_ujian', 'telah_lulus', 'sementara_skripsi', 'persentase_turun_kp', 'angkatan', 'daftar_periode', 'pendaftar_by_ujian'
        ));
    }

    // dosen
    public function indexDosen()
    {
        // total bimbingan skripsi & kp yg belum lulus & lulus
        $total_bimbingan_skripsi = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_satu_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->whereNotIn('tahapan_skripsi', ['lulus']);
        })->count();
        $total_bimbingan_skripsi += \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_dua_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->whereNotIn('tahapan_skripsi', ['lulus']);
        })->count();

        $total_bimbingan_skripsi_lulus = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_satu_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'lulus');
        })->count();
        $total_bimbingan_skripsi_lulus += \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_dua_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'lulus');
        })->count();

        $total_bimbingan_kp = \App\DosenPembimbingKp::with('mahasiswa')->where('dosbing_satu_kp', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->whereNotIn('tahapan_kp', ['lulus']);
        })->count();
        $total_bimbingan_kp += \App\DosenPembimbingKp::with('mahasiswa')->where('dosbing_dua_kp', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->whereNotIn('tahapan_kp', ['lulus']);
        })->count();

        // tahapan mahasiswa skripsi
        $bimbingan_skripsi_pendaftaran_topik = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_satu_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'pendaftaran_topik');
        })->count();
        $bimbingan_skripsi_pendaftaran_topik += \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_dua_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'pendaftaran_topik');
        })->count();

        $bimbingan_skripsi_penyusunan_proposal = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_satu_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'penyusunan_proposal');
        })->count();
        $bimbingan_skripsi_penyusunan_proposal += \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_dua_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'penyusunan_proposal');
        })->count();

        $bimbingan_skripsi_pendaftaran_proposal = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_satu_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'pendaftaran_proposal');
        })->count();
        $bimbingan_skripsi_pendaftaran_proposal += \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_dua_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'pendaftaran_proposal');
        })->count();

        $bimbingan_skripsi_ujian_seminar_proposal = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_satu_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'ujian_seminar_proposal');
        })->count();
        $bimbingan_skripsi_ujian_seminar_proposal += \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_dua_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'ujian_seminar_proposal');
        })->count();

        $bimbingan_skripsi_penulisan_skripsi = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_satu_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'penulisan_skripsi');
        })->count();
        $bimbingan_skripsi_penulisan_skripsi += \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_dua_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'penulisan_skripsi');
        })->count();

        $bimbingan_skripsi_pendaftaran_hasil = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_satu_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'pendaftaran_hasil');
        })->count();
        $bimbingan_skripsi_pendaftaran_hasil += \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_dua_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'pendaftaran_hasil');
        })->count();

        $bimbingan_skripsi_ujian_seminar_hasil = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_satu_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'ujian_seminar_hasil');
        })->count();
        $bimbingan_skripsi_ujian_seminar_hasil += \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_dua_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'ujian_seminar_hasil');
        })->count();

        $bimbingan_skripsi_revisi_skripsi = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_satu_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'revisi_skripsi');
        })->count();
        $bimbingan_skripsi_revisi_skripsi += \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_dua_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'revisi_skripsi');
        })->count();

        $bimbingan_skripsi_pendaftaran_sidang_skripsi = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_satu_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'pendaftaran_sidang_skripsi');
        })->count();
        $bimbingan_skripsi_pendaftaran_sidang_skripsi += \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_dua_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'pendaftaran_sidang_skripsi');
        })->count();

        $bimbingan_skripsi_ujian_sidang_skripsi = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_satu_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'ujian_sidang_skripsi');
        })->count();
        $bimbingan_skripsi_ujian_sidang_skripsi += \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_dua_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'ujian_sidang_skripsi');
        })->count();

        $bimbingan_skripsi_lulus = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_satu_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'lulus');
        })->count();
        $bimbingan_skripsi_lulus += \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_dua_skripsi', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_skripsi', 'lulus');
        })->count();

        // tahapan kp mahasiswa bimbingan kp
        $bimbingan_kp_pendaftaran = \App\DosenPembimbingKp::with('mahasiswa')->where('dosbing_satu_kp', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_kp', 'pendaftaran');
        })->count();
        $bimbingan_kp_pendaftaran += \App\DosenPembimbingKp::with('mahasiswa')->where('dosbing_dua_kp', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_kp', 'pendaftaran');
        })->count();

        $bimbingan_kp_ujian_seminar = \App\DosenPembimbingKp::with('mahasiswa')->where('dosbing_satu_kp', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_kp', 'ujian_seminar');
        })->count();
        $bimbingan_kp_ujian_seminar += \App\DosenPembimbingKp::with('mahasiswa')->where('dosbing_dua_kp', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_kp', 'ujian_seminar');
        })->count();

        $bimbingan_kp_revisi = \App\DosenPembimbingKp::with('mahasiswa')->where('dosbing_satu_kp', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_kp', 'revisi');
        })->count();
        $bimbingan_kp_revisi += \App\DosenPembimbingKp::with('mahasiswa')->where('dosbing_dua_kp', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_kp', 'revisi');
        })->count();

        $bimbingan_kp_lulus = \App\DosenPembimbingKp::with('mahasiswa')->where('dosbing_satu_kp', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_kp', 'lulus');
        })->count();
        $bimbingan_kp_lulus += \App\DosenPembimbingKp::with('mahasiswa')->where('dosbing_dua_kp', Session::get('id'))->whereHas('mahasiswa', function ($query) {
            $query->where('tahapan_kp', 'lulus');
        })->count();

        $total_mahasiswa = \App\Mahasiswa::where('id_dosen', Session::get('id'))->count();
        $kontrak_skripsi = \App\Mahasiswa::where('kontrak_skripsi', 'ya')->where('id_dosen', Session::get('id'))->count();
        $kontrak_kp = \App\Mahasiswa::where('kontrak_kp', 'ya')->where('id_dosen', Session::get('id'))->count();

        $prodi_kp = \App\ProdiKp::pluck('id_prodi');

        // tahapan kp mahasiswa pa
        $pendaftaran_kp = \App\Mahasiswa::where('tahapan_kp', 'pendaftaran')->where('id_dosen', Session::get('id'))->whereIn('id_prodi', $prodi_kp)->count();
        $ujian_seminar_kp = \App\Mahasiswa::where('tahapan_kp', 'ujian_seminar')->where('id_dosen', Session::get('id'))->whereIn('id_prodi', $prodi_kp)->count();
        $revisi_kp = \App\Mahasiswa::where('tahapan_kp', 'revisi')->where('id_dosen', Session::get('id'))->whereIn('id_prodi', $prodi_kp)->count();
        $lulus_kp = \App\Mahasiswa::where('tahapan_kp', 'lulus')->where('id_dosen', Session::get('id'))->whereIn('id_prodi', $prodi_kp)->count();

        // tahapan skripsi mahasiswa pa
        $pendaftaran_topik = \App\Mahasiswa::where('tahapan_skripsi', 'pendaftaran_topik')->where('id_dosen', Session::get('id'))->count();
        $penyusunan_proposal = \App\Mahasiswa::where('tahapan_skripsi', 'penyusunan_proposal')->where('id_dosen', Session::get('id'))->count();
        $pendaftaran_proposal = \App\Mahasiswa::where('tahapan_skripsi', 'pendaftaran_proposal')->where('id_dosen', Session::get('id'))->count();
        $ujian_seminar_proposal = \App\Mahasiswa::where('tahapan_skripsi', 'ujian_seminar_proposal')->where('id_dosen', Session::get('id'))->count();
        $penulisan_skripsi = \App\Mahasiswa::where('tahapan_skripsi', 'penulisan_skripsi')->where('id_dosen', Session::get('id'))->count();
        $pendaftaran_hasil = \App\Mahasiswa::where('tahapan_skripsi', 'pendaftaran_hasil')->where('id_dosen', Session::get('id'))->count();
        $ujian_seminar_hasil = \App\Mahasiswa::where('tahapan_skripsi', 'ujian_seminar_hasil')->where('id_dosen', Session::get('id'))->count();
        $revisi_skripsi = \App\Mahasiswa::where('tahapan_skripsi', 'revisi_skripsi')->where('id_dosen', Session::get('id'))->count();
        $pendaftaran_sidang_skripsi = \App\Mahasiswa::where('tahapan_skripsi', 'pendaftaran_sidang_skripsi')->where('id_dosen', Session::get('id'))->count();
        $ujian_sidang_skripsi = \App\Mahasiswa::where('tahapan_skripsi', 'ujian_sidang_skripsi')->where('id_dosen', Session::get('id'))->count();
        $lulus = \App\Mahasiswa::where('tahapan_skripsi', 'lulus')->where('id_dosen', Session::get('id'))->count();

        return view('beranda-dosen', compact(
            'total_mahasiswa', 'kontrak_skripsi', 'kontrak_kp', 'pendaftaran_kp', 'ujian_seminar_kp', 'revisi_kp', 'lulus_kp', 'pendaftaran_topik', 'penyusunan_proposal', 'pendaftaran_proposal', 'ujian_seminar_proposal', 'penulisan_skripsi', 'pendaftaran_hasil', 'ujian_seminar_hasil', 'revisi_skripsi', 'pendaftaran_sidang_skripsi', 'ujian_sidang_skripsi', 'lulus', 'bimbingan_skripsi_pendaftaran_topik', 'bimbingan_skripsi_penyusunan_proposal', 'bimbingan_skripsi_pendaftaran_proposal', 'bimbingan_skripsi_ujian_seminar_proposal', 'bimbingan_skripsi_penulisan_skripsi', 'bimbingan_skripsi_pendaftaran_hasil', 'bimbingan_skripsi_ujian_seminar_hasil', 'bimbingan_skripsi_revisi_skripsi', 'bimbingan_skripsi_pendaftaran_sidang_skripsi', 'bimbingan_skripsi_ujian_sidang_skripsi', 'bimbingan_skripsi_lulus', 'total_bimbingan_skripsi', 'total_bimbingan_kp', 'bimbingan_kp_lulus', 'bimbingan_kp_revisi', 'bimbingan_kp_ujian_seminar', 'bimbingan_kp_pendaftaran', 'total_bimbingan_skripsi_lulus'
        ));
    }

    // mahasiswa
    public function indexMahasiswa()
    {
        $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));

        $bimbingan_kp = \App\Bimbingan::where('bimbingan', 'kerja-praktek')->where('id_mahasiswa', Session::get('id'))->count();
        $bimbingan_proposal = \App\Bimbingan::where('bimbingan', 'proposal')->where('id_mahasiswa', Session::get('id'))->count();
        $bimbingan_hasil = \App\Bimbingan::where('bimbingan', 'hasil')->where('id_mahasiswa', Session::get('id'))->count();
        $bimbingan_sidang = \App\Bimbingan::where('bimbingan', 'sidang-skripsi')->where('id_mahasiswa', Session::get('id'))->count();

        $peserta_ujian = \App\PesertaUjian::where('id_mahasiswa', Session::get('id'))->count();
        $peserta_ujian += \App\PesertaUjianLama::where('id_mahasiswa', Session::get('id'))->count();

        $jadwal_ujian = \App\JadwalUjian::where('id_mahasiswa', Session::get('id'))->orderBy('id', 'desc')->limit(4)->get();

        $nilai_skripsi = \App\HasilAkumulasiNilaiSkripsi::where('id_mahasiswa', Session::get('id'))->get();
        $nilai_kp = \App\NilaiUjianKp::whereHas('jadwalUjian', function ($query) {
            $query->where('id_mahasiswa', Session::get('id'));
        })->get();

        $revisi = \App\RiwayatSkripsi::where('id_mahasiswa', Session::get('id'))->first();

        return view('beranda-mahasiswa', compact('mahasiswa', 'bimbingan_kp', 'bimbingan_proposal', 'bimbingan_hasil', 'bimbingan_sidang', 'peserta_ujian', 'jadwal_ujian', 'nilai_skripsi', 'nilai_kp', 'revisi'));
    }

    // no user
    public function masuk()
    {
        if(Session::has('mahasiswa')) return redirect('beranda/mahasiswa');
        elseif(Session::has('dosen')) return redirect('beranda/dosen');
        elseif(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi')) return redirect('beranda/mahasiswa');

        $periode_ujian = \App\PeriodeDaftarUjian::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;
        $daftar_jadwal = \App\JadwalUjian::whereMonth('waktu_mulai', date('m'))->whereYear('waktu_mulai', date('Y'))->orderBy('waktu_mulai', 'ASC')->count();
        $periode_usulan_topik = \App\PeriodeDaftarUsulanTopik::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;
        $periode_turun_kp = \App\PeriodeDaftarTurunKp::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;
        $mahasiswa_lulus = \App\Mahasiswa::where('tahapan_skripsi', 'lulus')->count();
        $mahasiswa_sementara_skripsi = \App\Mahasiswa::whereNotIn('tahapan_skripsi', ['persiapan', 'lulus'])->count();

        return view('masuk', compact('periode_ujian', 'daftar_jadwal', 'periode_usulan_topik', 'periode_turun_kp', 'mahasiswa_lulus', 'mahasiswa_sementara_skripsi'));
    }

    // no user
    public function ujian()
    {
        if(Session::has('mahasiswa')) return redirect('beranda/mahasiswa');
        elseif(Session::has('dosen')) return redirect('beranda/dosen');
        elseif(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi')) return redirect('beranda/mahasiswa');

        $periode_aktif = \App\PeriodeDaftarUjian::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;
        if(!empty($periode_aktif)){
            $daftar_pendaftar = \App\PendaftarUjian::where('id_periode_daftar_ujian', $periode_aktif->id)->paginate(10);
            $total = \App\PendaftarUjian::where('id_periode_daftar_ujian', $periode_aktif->id)->count();
        }else{
            $daftar_pendaftar = null;
            $total = 0;
        }

        return view('ujian', compact('periode_aktif', 'daftar_pendaftar', 'total'));
    }

    // no user
    public function ujianDetail($id)
    {
        $pendaftar = \App\PendaftarUjian::findOrFail($id);

        return view('ujian-detail', compact('pendaftar'));
    }

    // no user
    public function kerjaPraktek()
    {
        if(Session::has('mahasiswa')) return redirect('beranda/mahasiswa');
        elseif(Session::has('dosen')) return redirect('beranda/dosen');
        elseif(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi')) return redirect('beranda/mahasiswa');

        $periode_aktif = \App\PeriodeDaftarTurunKp::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;
        if(!empty($periode_aktif)){
            $daftar_pendaftar = \App\PendaftarTurunKp::where('id_periode_daftar_turun_kp', $periode_aktif->id)->paginate(10);
            $total = \App\PendaftarTurunKp::where('id_periode_daftar_turun_kp', $periode_aktif->id)->count();
        }else{
            $daftar_pendaftar = null;
            $total = 0;
        }

        return view('kerja-praktek', compact('periode_aktif', 'daftar_pendaftar', 'total'));
    }

    // no user
    public function kerjaPraktekDetail($id)
    {
        $pendaftar = \App\PendaftarTurunKp::findOrFail($id);
        return view('kerja-praktek-detail', compact('pendaftar'));
    }

    // no user
    public function usulanTopik()
    {
        $pengaturan = \App\Pengaturan::find(1);

        if(Session::has('mahasiswa')) return redirect('beranda/mahasiswa');
        elseif(Session::has('dosen')) return redirect('beranda/dosen');
        elseif(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi')) return redirect('beranda/mahasiswa');

        $periode_aktif = \App\PeriodeDaftarUsulanTopik::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;
        if(!empty($periode_aktif)){
            $daftar_pendaftar = \App\PendaftarUsulanTopik::where('id_periode_daftar_usulan_topik', $periode_aktif->id)->paginate(10);
            $total = \App\PendaftarUsulanTopik::where('id_periode_daftar_usulan_topik', $periode_aktif->id)->count();
        }else{
            $daftar_pendaftar = null;
            $total = 0;
        }

        return view('usulan-topik', compact('periode_aktif', 'daftar_pendaftar', 'total'));
    }

    // no user
    public function usulanTopikDetail($id)
    {
        $pendaftar = \App\PendaftarUsulanTopik::findOrFail($id);

        return view('usulan-topik-detail', compact('pendaftar'));
    }

    // no user
    public function jadwal($tanggal)
    {
        if(Session::has('mahasiswa')) return redirect('beranda/mahasiswa');
        elseif(Session::has('dosen')) return redirect('beranda/dosen');
        elseif(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi')) return redirect('beranda/mahasiswa');

        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $daftar_jadwal = \App\JadwalUjian::whereMonth('waktu_mulai', $bulan)->whereYear('waktu_mulai', $tahun)->orderBy('waktu_mulai', 'ASC')->paginate(10);
        $total = \App\JadwalUjian::whereMonth('waktu_mulai', $bulan)->whereYear('waktu_mulai', $tahun)->orderBy('waktu_mulai', 'ASC')->count();
        return view('jadwal', compact('daftar_jadwal', 'bulan', 'tahun', 'total'));
    }

    // no user
    public function cekPengguna(Request $request)
    {
        $req = $request->all();

        $validasi = Validator::make($req, [
          'pengguna' => 'required|in:mahasiswa,dosen,admin',
          'username' => 'required|string|max:100',
          'password' => 'required|string|max:255'
        ]);

        if($validasi->fails()){
          return redirect('masuk')->withInput()->withErrors($validasi);
        }

        if($request->post('pengguna') === 'mahasiswa'){
            $mahasiswa = \App\Mahasiswa::where('nim', '=', $request->post('username'))->first();
            if($mahasiswa && Hash::check($request->post('password'), $mahasiswa->password)){
                $prodi_kp = \App\ProdiKp::where('id_prodi', $mahasiswa->id_prodi)->get();
                if(!$prodi_kp->isEmpty()) Session::put('bisa_kp', true);
                Session::put('masuk', true);
                Session::put('mahasiswa', true);
                Session::put('id', $mahasiswa->id);
                Session::put('nama', $mahasiswa->nama);
                if(empty($mahasiswa->id_prodi) || empty($mahasiswa->id_dosen)){
                    return redirect('profil')->with('kesalahan', 'Silahkan lengkapi profil anda, seperti memperbaiki Program Studi atau Dosen Pembimbing Akademik jika terjadi kesalahan dan jangan lupa mengganti password sistem anda!');
                }

                // cek jika mahasiswa masih pakai password default
                if (Hash::check($mahasiswa->nim, $mahasiswa->password)) Session::put('default_password', true);

                return redirect('/');
            }else{
                return redirect('masuk')->with('pesan', 'Username dan/atau Password Anda Tidak Valid')->withInput();
            }
        }elseif($request->post('pengguna') === 'dosen'){
            $dosen = \App\Dosen::where('nip', $request->post('username'))->first();
            if($dosen && Hash::check($request->post('password'), $dosen->password)){
                Session::put('masuk', true);
                Session::put('dosen', true);
                Session::put('id', $dosen->id);
                Session::put('nama', $dosen->nama);

                $kajur_aktif = \App\Kajur::where('tahun_awal', '<=', date('Y'))->where('tahun_selesai', '>=', date('Y'))->where('id_dosen', $dosen->id)->first() or null;
                if(!blank($kajur_aktif)) Session::put('kajur', true);
                $kaprodi_aktif = \App\Kaprodi::where('tahun_awal', '<=', date('Y'))->where('tahun_selesai', '>=', date('Y'))->where('id_dosen', $dosen->id)->first() or null;
                if(!blank($kaprodi_aktif)){
                    Session::put('kaprodi', $dosen->kaprodi[0]->id_prodi);
                    Session::put('nama_prodi', $dosen->kaprodi[0]->prodi->nama);
                    $prodi_kp = \App\ProdiKp::where('id_prodi', Session::get('kaprodi'))->get();
                    if(!$prodi_kp->isEmpty()) Session::put('kaprodi_kp', true);
                }

                // cek jika dosen masih pakai password default
                if(Hash::check($dosen->nip, $dosen->password)) Session::put('default_password', true);

                return redirect('/');
            }else{
                return redirect('masuk')->with('pesan', 'NIP dan/atau Password Tidak Valid')->withInput();
            }
        }elseif($request->post('pengguna') === 'admin'){
            $admin = \App\Admin::where('username', $request->post('username'))->first();
            if($admin && Hash::check($request->post('password'), $admin->password)){
                Session::put('masuk', true);
                Session::put('admin', true);
                Session::put('id', $admin->id);
                Session::put('nama', $admin->nama);
                if($admin->level === 'pengelola') Session::put('pengelola', true);
                else Session::put('pimpinan', true);
                return redirect('/');
            }else{
                return redirect('masuk')->with('pesan', 'Username dan/atau Password Anda Tidak Valid')->withInput();
            }
        }
    }

    // no user
    public function keluar()
    {
        Session::flush();
        return redirect('masuk');
    }

    // pengguna
    public function profil()
    {
        if(Session::has('mahasiswa'))
        {
            $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));
            return view('mahasiswa.detail', compact('mahasiswa'));
        }elseif(Session::has('dosen')){
            $dosen = \App\Dosen::findOrFail(Session::get('id'));

            $prodi_kp = \App\ProdiKp::pluck('id_prodi');

            // total mahasiswa PA yang belum lulus kp
            $total_maspa_kp = \App\Mahasiswa::where('id_dosen', $dosen->id)->whereNotIn('tahapan_kp', ['lulus'])->whereIn('id_prodi', $prodi_kp)->count();

            // total mahasiswa bimbingan kp yg bleum lulus
            $total_masbing_kp = \App\DosenPembimbingKp::with('mahasiswa')->where('dosbing_satu_kp', $dosen->id)->whereHas('mahasiswa', function ($query) {
              $query->whereNotIn('tahapan_kp', ['lulus']);
            })->count();
            $total_masbing_kp += \App\DosenPembimbingKp::with('mahasiswa')->where('dosbing_dua_kp', $dosen->id)->whereHas('mahasiswa', function ($query) {
              $query->whereNotIn('tahapan_kp', ['lulus']);
            })->count();

            // total mahasiswa PA yang belum lulus skripsi
            $total_maspa_skripsi = \App\Mahasiswa::where('id_dosen', $dosen->id)->whereNotIn('tahapan_skripsi', ['lulus'])->count();

            // total mahasiswa bimbingan skripsi yg belum lulus
            $total_masbing_skripsi = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_satu_skripsi', $dosen->id)->whereHas('mahasiswa', function ($query) {
              $query->whereNotIn('tahapan_skripsi', ['lulus']);
            })->count();
            $total_masbing_skripsi += \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_dua_skripsi', $dosen->id)->whereHas('mahasiswa', function ($query) {
              $query->whereNotIn('tahapan_skripsi', ['lulus']);
            })->count();

            return view('dosen.detail', compact(
                'dosen', 'total_maspa_skripsi', 'total_masbing_skripsi', 'total_maspa_kp', 'total_masbing_kp'
            ));

        }elseif(Session::has('admin')){
            $admin = \App\Admin::findOrFail(Session::get('id'));
            return view('admin.detail', compact('admin'));
        }
    }

    // no user
    public function riwayatSkripsi()
    {
        $pengaturan = \App\Pengaturan::find(1);

        $daftar_pendaftar = \App\PendaftarUsulanTopik::where('tahapan', 'diterima')->paginate(10);
        $total = \App\PendaftarUsulanTopik::where('tahapan', 'diterima')->count();
        return view('riwayat-skripsi', compact('pengaturan', 'daftar_pendaftar', 'total'));
    }

    // no user
    public function detailRiwayatSkripsi($id)
    {
        $mahasiswa = \App\Mahasiswa::findOrFail($id);

        return view('detail-riwayat-skripsi', compact('mahasiswa'));
    }

    // no user
    public function riwayatSkripsiCari(Request $request)
    {
        $pengaturan = \App\Pengaturan::find(1);

        $judul = trim($request->input('judul'));
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $tahapan_skripsi = trim($request->input('tahapan_skripsi'));

      if(!empty($nama) || !empty($nim) || !empty($angkatan) || !empty($judul) || !empty($tahapan_skripsi)){

          if(!empty($judul)){
            $query = \App\PendaftarUsulanTopik::with('mahasiswa')->where('tahapan', 'diterima')->where('usulan_judul', 'like', '%' . $judul . '%')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi){
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            });
          }elseif(!empty($nim)){
            $query = \App\PendaftarUsulanTopik::with('mahasiswa')->where('tahapan', 'diterima')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi){
                $query->where('nim', 'like', '%' . $nim . '%');
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            });
            (!empty($judul)) ? $query->where('usulan_judul', 'like', '%' . $judul . '%') : '';
          }elseif(!empty($angkatan)){
            $query = \App\PendaftarUsulanTopik::with('mahasiswa')->where('tahapan', 'diterima')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi){
                $query->where('angkatan', $angkatan);
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            });
            (!empty($judul)) ? $query->where('usulan_judul', 'like', '%' . $judul . '%') : '';
          }elseif(!empty($nama)){
            $query = \App\PendaftarUsulanTopik::with('mahasiswa')->where('tahapan', 'diterima')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi){
                $query->where('nama', 'like', '%' . $nama . '%');
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            });
            (!empty($judul)) ? $query->where('usulan_judul', 'like', '%' . $judul . '%') : '';
          }elseif(!empty($tahapan_skripsi)){
            $query = \App\PendaftarUsulanTopik::with('mahasiswa')->where('tahapan', 'diterima')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi){
                $query->where('tahapan_skripsi', $tahapan_skripsi);
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            });
            (!empty($judul)) ? $query->where('usulan_judul', 'like', '%' . $judul . '%') : '';
          }
            $total = $query->count();
            $daftar_pendaftar = $query->paginate(10);

          $pagination = (!empty($nama)) ? $daftar_pendaftar->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_pendaftar->appends(['nim' => $nim]) : '';
          $pagination = (!empty($angkatan)) ? $daftar_pendaftar->appends(['angkatan' => $angkatan]) : '';
          $pagination = (!empty($judul)) ? $daftar_pendaftar->appends(['judul' => $judul]) : '';
          $pagination = (!empty($tahapan_skripsi)) ? $daftar_pendaftar->appends(['tahapan_skripsi' => $tahapan_skripsi]) : '';
          $pagination = $daftar_pendaftar->appends($request->except('page'));

        return view('riwayat-skripsi', compact('pengaturan', 'daftar_pendaftar', 'total', 'pagination', 'nama', 'judul', 'nim', 'angkatan', 'tahapan_skripsi'));
      }
        return redirect('masuk/riwayat-skripsi');
    }

    // mahasiswa
    public function indexRevisi()
    {
        $pendaftar = \App\PendaftarUjian::where('ujian', 'sidang-skripsi')->where('id_mahasiswa', Session::get('id'))->get()->last();
        $riwayat = \App\RiwayatSkripsi::where('id_mahasiswa', Session::get('id'))->get()->last();
        return view('revisi.index', compact('pendaftar', 'riwayat'));
    }

    // mahasiswa
    public function createRevisi()
    {
        $pengaturan = \App\Pengaturan::find(1);

        return view('revisi.create', compact('pengaturan'));
    }

    // mahasiswa
    public function storeRevisi(Request $request)
    {
        $pengaturan = \App\Pengaturan::find(1);

        $validasi = Validator::make($request->all(), [
          'file_laporan' => 'required|mimes:pdf|max:' . $pengaturan->max_file_upload,
          'file_jurnal_skripsi' => 'required|mimes:pdf|max:' . $pengaturan->max_file_upload
        ]);

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        $input_laporan = $request->post('file_laporan');
        $input_jurnal = $request->post('file_jurnal_skripsi');

        $input_laporan['id_mahasiswa'] = Session::get('id');
        $input_jurnal['id_mahasiswa'] = Session::get('id');

        $pendaftar = \App\PendaftarUjian::where('id_mahasiswa', Session::get('id'))->where('ujian', 'sidang-skripsi')->first();

        if(empty($pendaftar)) return redirect()->back()->withInput()->with('kesalahan', 'Anda Belum Pernah Mendaftar Ujian Sidang Skripsi');

        if($request->hasFile('file_laporan')){
            $this->hapusFile($pendaftar);
            $input_laporan['file_laporan'] = $this->uploadFile($request);
        }

        if($request->hasFile('file_jurnal_skripsi')){
            $riwayat = \App\RiwayatSkripsi::where('id_mahasiswa', Session::get('id'))->first();
            if($riwayat) $this->hapusJurnal($riwayat);
            $input_jurnal['file_jurnal_skripsi'] = $this->uploadJurnal($request);
        }

        $pendaftar->update($input_laporan);
        \App\RiwayatSkripsi::create($input_jurnal);

        Session::flash('pesan', 'Anda Berhasil Merevisi Laporan & Jurnal Skripsi!');
        return redirect('beranda/mahasiswa');
    }

    // mahasiswa
    public function editRevisi($id)
    {
        $pengaturan = \App\Pengaturan::find(1);
        $revisi = \App\RiwayatSkripsi::find($id);

        return view('revisi.edit', compact('pengaturan', 'revisi'));
    }

    // mahasiswa
    public function updateRevisi(Request $request)
    {
        $pengaturan = \App\Pengaturan::find(1);

        $validasi = Validator::make($request->all(), [
          'file_laporan' => 'required|mimes:pdf|max:' . $pengaturan->max_file_upload,
          'file_jurnal_skripsi' => 'required|mimes:pdf|max:' . $pengaturan->max_file_upload
        ]);

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        $input_laporan = $request->post('file_laporan');
        $input_jurnal = $request->post('file_jurnal_skripsi');

        $input_laporan['id_mahasiswa'] = Session::get('id');
        $input_jurnal['id_mahasiswa'] = Session::get('id');

        $pendaftar = \App\PendaftarUjian::where('id_mahasiswa', Session::get('id'))->where('ujian', 'sidang-skripsi')->first();

        if($request->hasFile('file_laporan')){
            $this->hapusFile($pendaftar);
            $input_laporan['file_laporan'] = $this->uploadFile($request);
        }

        if($request->hasFile('file_jurnal_skripsi')){
            $riwayat = \App\RiwayatSkripsi::where('id_mahasiswa', Session::get('id'))->first();
            if($riwayat) $this->hapusJurnal($riwayat);
            $input_jurnal['file_jurnal_skripsi'] = $this->uploadJurnal($request);
        }

        $pendaftar->update($input_laporan);
        \App\RiwayatSkripsi::create($input_jurnal);

        Session::flash('pesan', 'Anda Berhasil Merevisi Laporan & Jurnal Skripsi!');
        return redirect('beranda/mahasiswa');
    }

    // Upload & Hapus File Laporan Skripsi
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

    // Upload & Hapus File Jurnal Skripsi
    private function hapusJurnal($jurnal){
      $file = 'assets/jurnal/'.$jurnal->file_jurnal_skripsi;
      if(file_exists($file) && isset($jurnal->file_jurnal_skripsi)){
      $delete = unlink($file);
        if($delete){
          return true;
        }
        return false;
      }
    }

    private function uploadJurnal(Request $request){
        $file = $request->file('file_jurnal_skripsi');
        $ext = $file->getClientOriginalExtension();
        if($request->file('file_jurnal_skripsi')->isValid()){
          $file_name = date('YmdHis').".$ext";
          $upload_path = 'assets/jurnal';
          $request->file('file_jurnal_skripsi')->move($upload_path, $file_name);
          return $file_name;
        }
        return false;
    }

    // no user
    public function tes()
    {
        $dosen = \App\Dosen::latest('id')->first();
        return $dosen;
        // return view('tes-import');
    }

    public function storeTes(Request $request)
    {
        $file = $request->file('import');

		$nama_file = rand().$file->getClientOriginalName();
		$file->move('assets/file', $nama_file);

        Excel::import(new \App\Imports\TesImport, 'assets/file/'.$nama_file);
        Session::flash('pesan','Berhasil Mengimport!');

        unlink('assets/file/'.$nama_file);

        return redirect('tes');
    }

    public function cek()
    {
        $file = new Filesystem;
        $file->cleanDirectory('assets/img/faces');
        return 'Isi directory berhasil dihapus';
        // return view('tes');
    }

    public function phpinfo()
    {
        phpinfo();
    }

}
