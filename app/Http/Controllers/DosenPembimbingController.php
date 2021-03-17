<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\DosenPembimbingSkripsi;
use App\DosenPembimbingKp;
use PDF;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DosbingSkripsiExport;
use App\Exports\DosbingKpExport;
use App\Exports\DosbingKosongExport;

class DosenPembimbingController extends Controller
{
    public function __construct(){
        $this->middleware('mahasiswa', ['only' => [
            'indexSkripsi', 'indexKp'
        ]]);

        $this->middleware('mahasiswaPimpinan', ['only' => [
            'suratKesediaanSkripsi', 'suratPenunjukanKp', 'suratPersetujuanSidang', 'suratPersetujuanHasil', 'suratPersetujuanProposal', 'formSuratPersetujuanKp'
        ]]);

        $this->middleware('pimpinan', ['only' => [
            'semuaSkripsi', 'semuaKp', 'detailSemesterSkripsi', 'detailSemesterKp', 'createSkripsi', 'createKp', 'storeSkripsi', 'storeKp', 'editSkripsi', 'editKp', 'updateSkripsi', 'updateKp', 'destroyDosbingBerhalangan', 'cetakDosbingBerhalangan', 'destroySkripsi', 'destroyKp', 'suratPenunjukanSkripsi', 'formSuratPenunjukanSkripsi', 'periodeKosong', 'perpanjangSkripsi', 'perpanjangKp', 'detailSemesterSkripsiCari', 'detailSemesterKpCari', 'periodeKosongCari', 'detailSemesterSkripsiExport', 'detailSemesterKpExport', 'periodeKosongExport', 'gantiSkripsi', 'updateGantiSkripsi', 'storeByUsulanTopik', 'storeByTurunKp'
        ]]);
    }

    // pimpinan
    public function semuaSkripsi()
    {
        $total_periode_kosong = DosenPembimbingSkripsi::whereNull('id_semester')->count();
        $total = \App\Semester::all()->count() + 1;
        $daftar_semester = \App\Semester::orderBy('waktu_tutup', 'desc')->paginate(10);
        return view('dosbing.semua-skripsi', compact('daftar_semester', 'total_periode_kosong', 'total'));
    }

    // pimpinan
    public function semuaKp()
    {
        $daftar_semester = \App\Semester::orderBy('waktu_tutup', 'desc')->paginate(10);
        $total = \App\Semester::all()->count();
        return view('dosbing.semua-kp', compact('daftar_semester', 'total'));
    }

    // pimpinan
    public function detailSemesterSkripsi($id)
    {
        $semester = \App\Semester::find($id);

        $daftar_dosbing = DosenPembimbingSkripsi::where('id_semester', $id)->orderBy('created_at', 'DESC')->paginate(10);

        $daftar_dosbing_berhalangan = \App\DosbingBerhalangan::where('id_semester', $id)->where('ujian', 'skripsi')->orderBy('id_semester', 'desc')->paginate(10);

        $total = DosenPembimbingSkripsi::where('id_semester', $id)->count();

        $daftar_dosen = \App\Dosen::where('bisa_membimbing', 'ya')->pluck('nama', 'id');

        $filter_dosbing_skripsi = true;
        return view('dosbing.daftar-semester-skripsi', compact('daftar_dosbing', 'semester', 'daftar_dosbing_berhalangan', 'id', 'daftar_dosen', 'total', 'filter_dosbing_skripsi'));
    }

    // pimpinan
    public function detailSemesterSkripsiCari(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $id_semester = trim($request->input('id_semester'));
        $dosbing_dua_skripsi = trim($request->input('dosbing_dua_skripsi'));
        $dosbing_satu_skripsi = trim($request->input('dosbing_satu_skripsi'));
        $tahapan_skripsi = trim($request->input('tahapan_skripsi'));

      if(!empty($nama) || !empty($nim) || !empty($angkatan) || !empty($dosbing_satu_skripsi) || !empty($dosbing_dua_skripsi) || !empty($tahapan_skripsi)){

          if(!empty($nama)){
            $query = DosenPembimbingSkripsi::with('mahasiswa')->where('id_semester', $id_semester)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi){
                $query->where('nama', 'like', '%' . $nama . '%');
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            });
            (!empty($dosbing_satu_skripsi)) ? $query->where('dosbing_satu_skripsi', $dosbing_satu_skripsi) : '';
            (!empty($dosbing_dua_skripsi)) ? $query->where('dosbing_dua_skripsi', $dosbing_dua_skripsi) : '';
          }elseif(!empty($nim)){
            $query = DosenPembimbingSkripsi::with('mahasiswa')->where('id_semester', $id_semester)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi){
                $query->where('nim', 'like', '%' . $nim . '%');
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
              });
            (!empty($dosbing_satu_skripsi)) ? $query->where('dosbing_satu_skripsi', $dosbing_satu_skripsi) : '';
            (!empty($dosbing_dua_skripsi)) ? $query->where('dosbing_dua_skripsi', $dosbing_dua_skripsi) : '';
          }elseif(!empty($tahapan_skripsi)){
            $query = DosenPembimbingSkripsi::with('mahasiswa')->where('id_semester', $id_semester)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi){
                $query->where('tahapan_skripsi', $tahapan_skripsi);
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
              });
            (!empty($dosbing_satu_skripsi)) ? $query->where('dosbing_satu_skripsi', $dosbing_satu_skripsi) : '';
            (!empty($dosbing_dua_skripsi)) ? $query->where('dosbing_dua_skripsi', $dosbing_dua_skripsi) : '';
          }elseif(!empty($angkatan)){
            $query = DosenPembimbingSkripsi::with('mahasiswa')->where('id_semester', $id_semester)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi){
                $query->where('angkatan', $angkatan);
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
              });
            (!empty($dosbing_satu_skripsi)) ? $query->where('dosbing_satu_skripsi', $dosbing_satu_skripsi) : '';
            (!empty($dosbing_dua_skripsi)) ? $query->where('dosbing_dua_skripsi', $dosbing_dua_skripsi) : '';
          }elseif(!empty($dosbing_satu_skripsi)){
            $query = DosenPembimbingSkripsi::with('mahasiswa')->where('id_semester', $id_semester)->where('dosbing_satu_skripsi', $dosbing_satu_skripsi)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi){
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
              });
            (!empty($dosbing_dua_skripsi)) ? $query->where('dosbing_dua_skripsi', $dosbing_dua_skripsi) : '';
          }elseif(!empty($dosbing_dua_skripsi)){
            $query = DosenPembimbingSkripsi::with('mahasiswa')->where('id_semester', $id_semester)->where('dosbing_dua_skripsi', $dosbing_dua_skripsi)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi){
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
              });
            (!empty($dosbing_satu_skripsi)) ? $query->where('dosbing_satu_skripsi', $dosbing_satu_skripsi) : '';
          }

          $total = $query->count();
          $daftar_dosbing = $query->paginate(10);
          $daftar_dosbing_berhalangan = \App\DosbingBerhalangan::where('id_semester', $id_semester)->where('ujian', 'skripsi')->orderBy('id_semester', 'desc')->paginate(10);

          $pagination = (!empty($nama)) ? $daftar_dosbing->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_dosbing->appends(['nim' => $nim]) : '';
          $pagination = (!empty($angkatan)) ? $daftar_dosbing->appends(['angkatan' => $angkatan]) : '';
          $pagination = (!empty($tahapan_skripsi)) ? $daftar_dosbing->appends(['tahapan_skripsi' => $tahapan_skripsi]) : '';
          $pagination = (!empty($dosbing_satu_skripsi)) ? $daftar_dosbing->appends(['dosbing_satu_skripsi' => $dosbing_satu_skripsi]) : '';
          $pagination = (!empty($dosbing_dua_skripsi)) ? $daftar_dosbing->appends(['dosbing_dua_skripsi' => $dosbing_dua_skripsi]) : '';
          $pagination = (!empty($id_semester)) ? $daftar_dosbing->appends(['id_semester' => $id_semester]) : '';
          $pagination = $daftar_dosbing->appends($request->except('page'));

        $daftar_dosen = \App\Dosen::where('bisa_membimbing', 'ya')->pluck('nama', 'id');
        $id = $id_semester;
        $semester = \App\Semester::find($id);

        $filter_dosbing_skripsi = true;

        return view('dosbing.daftar-semester-skripsi', compact('daftar_dosbing', 'daftar_dosen', 'total', 'pagination', 'nama', 'tahapan_skripsi', 'dosbing_dua_skripsi', 'nim', 'angkatan', 'dosbing_satu_skripsi', 'id_semester', 'id', 'semester', 'daftar_dosbing_berhalangan', 'filter_dosbing_skripsi'));
      }
        return redirect('dosen-pembimbing/skripsi/semester/' . $id_semester);
    }

    // pimpinan
    public function detailSemesterSkripsiExport(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $dosbing_satu_skripsi = trim($request->input('dosbing_satu_skripsi'));
        $dosbing_dua_skripsi = trim($request->input('dosbing_dua_skripsi'));
        $id_semester = trim($request->input('id_semester'));

      return Excel::download(new DosbingSkripsiExport($nama, $nim, $angkatan, $dosbing_satu_skripsi, $dosbing_dua_skripsi, $id_semester), 'SISKP - Export Dosen Pembimbing Skripsi.xlsx');
    }

    // pimpinan
    public function periodeKosong()
    {
        $daftar_dosbing = DosenPembimbingSkripsi::whereNull('id_semester')->paginate(10);
        $total = DosenPembimbingSkripsi::whereNull('id_semester')->count();
        $daftar_dosen = \App\Dosen::where('bisa_membimbing', 'ya')->pluck('nama', 'id');
        $filter_dosbing_kosong = true;

        return view('dosbing.daftar-skripsi-periode-kosong', compact('daftar_dosbing', 'total', 'daftar_dosen', 'filter_dosbing_kosong'));
    }

    // pimpinan
    public function periodeKosongCari(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $dosbing_dua_skripsi = trim($request->input('dosbing_dua_skripsi'));
        $dosbing_satu_skripsi = trim($request->input('dosbing_satu_skripsi'));

      if(!empty($nama) || !empty($nim) || !empty($angkatan) || !empty($dosbing_satu_skripsi) || !empty($dosbing_dua_skripsi)){

          if(!empty($nama)){
            $query = DosenPembimbingSkripsi::with('mahasiswa')->whereNull('id_semester')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan){
                $query->where('nama', 'like', '%' . $nama . '%');
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            });
            (!empty($dosbing_satu_skripsi)) ? $query->where('dosbing_satu_skripsi', $dosbing_satu_skripsi) : '';
            (!empty($dosbing_dua_skripsi)) ? $query->where('dosbing_dua_skripsi', $dosbing_dua_skripsi) : '';
          }elseif(!empty($nim)){
            $query = DosenPembimbingSkripsi::with('mahasiswa')->whereNull('id_semester')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan){
                $query->where('nim', 'like', '%' . $nim . '%');
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
              });
            (!empty($dosbing_satu_skripsi)) ? $query->where('dosbing_satu_skripsi', $dosbing_satu_skripsi) : '';
            (!empty($dosbing_dua_skripsi)) ? $query->where('dosbing_dua_skripsi', $dosbing_dua_skripsi) : '';
          }elseif(!empty($angkatan)){
            $query = DosenPembimbingSkripsi::with('mahasiswa')->whereNull('id_semester')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan){
                $query->where('angkatan', $angkatan);
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
              });
            (!empty($dosbing_satu_skripsi)) ? $query->where('dosbing_satu_skripsi', $dosbing_satu_skripsi) : '';
            (!empty($dosbing_dua_skripsi)) ? $query->where('dosbing_dua_skripsi', $dosbing_dua_skripsi) : '';
          }elseif(!empty($dosbing_satu_skripsi)){
            $query = DosenPembimbingSkripsi::with('mahasiswa')->whereNull('id_semester')->where('dosbing_satu_skripsi', $dosbing_satu_skripsi)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan){
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
              });
            (!empty($dosbing_dua_skripsi)) ? $query->where('dosbing_dua_skripsi', $dosbing_dua_skripsi) : '';
          }elseif(!empty($dosbing_dua_skripsi)){
            $query = DosenPembimbingSkripsi::with('mahasiswa')->whereNull('id_semester')->where('dosbing_dua_skripsi', $dosbing_dua_skripsi)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan){
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
              });
            (!empty($dosbing_satu_skripsi)) ? $query->where('dosbing_satu_skripsi', $dosbing_satu_skripsi) : '';
          }

          $total = $query->count();
          $daftar_dosbing = $query->paginate(10);

          $pagination = (!empty($nama)) ? $daftar_dosbing->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_dosbing->appends(['nim' => $nim]) : '';
          $pagination = (!empty($angkatan)) ? $daftar_dosbing->appends(['angkatan' => $angkatan]) : '';
          $pagination = (!empty($dosbing_satu_skripsi)) ? $daftar_dosbing->appends(['dosbing_satu_skripsi' => $dosbing_satu_skripsi]) : '';
          $pagination = (!empty($dosbing_dua_skripsi)) ? $daftar_dosbing->appends(['dosbing_dua_skripsi' => $dosbing_dua_skripsi]) : '';
          $pagination = $daftar_dosbing->appends($request->except('page'));

        $daftar_dosen = \App\Dosen::where('bisa_membimbing', 'ya')->pluck('nama', 'id');

        $filter_dosbing_kosong = true;

        return view('dosbing.daftar-skripsi-periode-kosong', compact('daftar_dosbing', 'daftar_dosen', 'total', 'pagination', 'nama', 'dosbing_dua_skripsi', 'nim', 'angkatan', 'dosbing_satu_skripsi', 'filter_dosbing_kosong'));
      }
        return redirect('dosen-pembimbing/skripsi/semester/tidak-diketahui');
    }

    // pimpinan
    public function periodeKosongExport(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $dosbing_satu_skripsi = trim($request->input('dosbing_satu_skripsi'));
        $dosbing_dua_skripsi = trim($request->input('dosbing_dua_skripsi'));

      return Excel::download(new DosbingKosongExport($nama, $nim, $angkatan, $dosbing_satu_skripsi, $dosbing_dua_skripsi), 'SISKP - Export Dosen Pembimbing Skripsi Kosong.xlsx');
    }

    // pimpinan
    public function detailSemesterKp($id)
    {
        $semester = \App\Semester::find($id);

        $daftar_dosbing = DosenPembimbingKp::where('id_semester', $id)->orderBy('created_at', 'DESC')->paginate(10);

        $daftar_dosbing_berhalangan = \App\DosbingBerhalangan::where('id_semester', $id)->where('ujian', 'kerja-praktek')->orderBy('id_semester', 'desc')->paginate(10);

        $total = DosenPembimbingKp::where('id_semester', $id)->count();
        $daftar_dosen = \App\Dosen::where('bisa_membimbing', 'ya')->pluck('nama', 'id');

        $filter_dosbing_kp = true;

        return view('dosbing.daftar-semester-kp', compact('daftar_dosbing', 'semester', 'daftar_dosbing_berhalangan', 'id', 'daftar_dosen', 'total', 'filter_dosbing_kp'));
    }

    // pimpinan
    public function detailSemesterKpCari(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $lokasi = trim($request->input('lokasi'));
        $id_semester = trim($request->input('id_semester'));
        $dosbing_dua_kp = trim($request->input('dosbing_dua_kp'));
        $dosbing_satu_kp = trim($request->input('dosbing_satu_kp'));
        $tahapan_kp = trim($request->input('tahapan_kp'));

      if(!empty($nama) || !empty($lokasi) || !empty($nim) || !empty($angkatan) || !empty($dosbing_satu_kp) || !empty($dosbing_dua_kp) || !empty($tahapan_kp)){

          if(!empty($nama)){
            $query = DosenPembimbingKp::with('mahasiswa')->where('id_semester', $id_semester)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $lokasi, $tahapan_kp){
                $query->where('nama', 'like', '%' . $nama . '%');
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($lokasi)) ? $query->where('lokasi', 'like', '%' . $lokasi . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
            });
            (!empty($dosbing_satu_kp)) ? $query->where('dosbing_satu_kp', $dosbing_satu_kp) : '';
            (!empty($dosbing_dua_kp)) ? $query->where('dosbing_dua_kp', $dosbing_dua_kp) : '';
          }elseif(!empty($nim)){
            $query = DosenPembimbingKp::with('mahasiswa')->where('id_semester', $id_semester)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $lokasi, $tahapan_kp){
                $query->where('nim', 'like', '%' . $nim . '%');
                (!empty($lokasi)) ? $query->where('lokasi', 'like', '%' . $lokasi . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
              });
            (!empty($dosbing_satu_kp)) ? $query->where('dosbing_satu_kp', $dosbing_satu_kp) : '';
            (!empty($dosbing_dua_kp)) ? $query->where('dosbing_dua_kp', $dosbing_dua_kp) : '';
          }elseif(!empty($angkatan)){
            $query = DosenPembimbingKp::with('mahasiswa')->where('id_semester', $id_semester)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $lokasi, $tahapan_kp){
                $query->where('angkatan', $angkatan);
                (!empty($lokasi)) ? $query->where('lokasi', 'like', '%' . $lokasi . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
              });
            (!empty($dosbing_satu_kp)) ? $query->where('dosbing_satu_kp', $dosbing_satu_kp) : '';
            (!empty($dosbing_dua_kp)) ? $query->where('dosbing_dua_kp', $dosbing_dua_kp) : '';
          }elseif(!empty($tahapan_kp)){
            $query = DosenPembimbingKp::with('mahasiswa')->where('id_semester', $id_semester)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $lokasi, $tahapan_kp){
                $query->where('tahapan_kp', $tahapan_kp);
                (!empty($lokasi)) ? $query->where('lokasi', 'like', '%' . $lokasi . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
              });
            (!empty($dosbing_satu_kp)) ? $query->where('dosbing_satu_kp', $dosbing_satu_kp) : '';
            (!empty($dosbing_dua_kp)) ? $query->where('dosbing_dua_kp', $dosbing_dua_kp) : '';
          }elseif(!empty($lokasi)){
            $query = DosenPembimbingKp::with('mahasiswa')->where('id_semester', $id_semester)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $lokasi, $tahapan_kp){
                $query->where('lokasi', 'like', '%' . $lokasi . '%');
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
              });
            (!empty($dosbing_satu_kp)) ? $query->where('dosbing_satu_kp', $dosbing_satu_kp) : '';
            (!empty($dosbing_dua_kp)) ? $query->where('dosbing_dua_kp', $dosbing_dua_kp) : '';
          }elseif(!empty($dosbing_satu_kp)){
            $query = DosenPembimbingKp::with('mahasiswa')->where('id_semester', $id_semester)->where('dosbing_satu_kp', $dosbing_satu_kp)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $lokasi, $tahapan_kp){
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($lokasi)) ? $query->where('lokasi', 'like', '%' . $lokasi . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
              });
            (!empty($dosbing_dua_kp)) ? $query->where('dosbing_dua_kp', $dosbing_dua_kp) : '';
          }elseif(!empty($dosbing_dua_kp)){
            $query = DosenPembimbingKp::with('mahasiswa')->where('id_semester', $id_semester)->where('dosbing_dua_kp', $dosbing_dua_kp)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $lokasi, $tahapan_kp){
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($lokasi)) ? $query->where('lokasi', 'like', '%' . $lokasi . '%') : '';
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
              });
            (!empty($dosbing_satu_kp)) ? $query->where('dosbing_satu_kp', $dosbing_satu_kp) : '';
          }

          $total = $query->count();
          $daftar_dosbing = $query->paginate(10);
          $daftar_dosbing_berhalangan = \App\DosbingBerhalangan::where('id_semester', $id_semester)->where('ujian', 'kerja-praktek')->orderBy('id_semester', 'desc')->paginate(10);

          $pagination = (!empty($nama)) ? $daftar_dosbing->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_dosbing->appends(['nim' => $nim]) : '';
          $pagination = (!empty($angkatan)) ? $daftar_dosbing->appends(['angkatan' => $angkatan]) : '';
          $pagination = (!empty($tahapan_kp)) ? $daftar_dosbing->appends(['tahapan_kp' => $tahapan_kp]) : '';
          $pagination = (!empty($lokasi)) ? $daftar_dosbing->appends(['lokasi' => $lokasi]) : '';
          $pagination = (!empty($dosbing_satu_kp)) ? $daftar_dosbing->appends(['dosbing_satu_kp' => $dosbing_satu_kp]) : '';
          $pagination = (!empty($dosbing_dua_kp)) ? $daftar_dosbing->appends(['dosbing_dua_kp' => $dosbing_dua_kp]) : '';
          $pagination = (!empty($id_semester)) ? $daftar_dosbing->appends(['id_semester' => $id_semester]) : '';
          $pagination = $daftar_dosbing->appends($request->except('page'));

        $daftar_dosen = \App\Dosen::where('bisa_membimbing', 'ya')->pluck('nama', 'id');
        $id = $id_semester;
        $semester = \App\Semester::find($id);

        $filter_dosbing_kp = true;

        return view('dosbing.daftar-semester-kp', compact('daftar_dosbing', 'daftar_dosen', 'total', 'pagination', 'nama', 'tahapan_kp', 'dosbing_dua_kp', 'nim', 'angkatan', 'dosbing_satu_kp', 'id_semester', 'id', 'semester', 'lokasi', 'daftar_dosbing_berhalangan', 'filter_dosbing_kp'));
      }
        return redirect('dosen-pembimbing/kerja-praktek/semester/' . $id_semester);
    }

    // pimpinan
    public function detailSemesterKpExport(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $lokasi = trim($request->input('lokasi'));
        $dosbing_satu_kp = trim($request->input('dosbing_satu_kp'));
        $dosbing_dua_kp = trim($request->input('dosbing_dua_kp'));
        $id_semester = trim($request->input('id_semester'));

      return Excel::download(new DosbingKpExport($nama, $nim, $angkatan, $lokasi, $dosbing_satu_kp, $dosbing_dua_kp, $id_semester), 'SISKP - Export Dosen Pembimbing Kerja Praktek.xlsx');
    }

    // pimpinan
    public function createSkripsi()
    {
        $daftar_mahasiswa = \App\Mahasiswa::where('kontrak_skripsi', 'ya')->pluck('nama', 'id');
        $daftar_semester = \App\Semester::pluck('nama', 'id');
        $daftar_dosen = \App\Dosen::where('status', 'aktif')->where('bisa_membimbing', 'ya')->pluck('nama', 'id');
        return view('dosbing.create-skripsi', compact('daftar_mahasiswa', 'daftar_semester', 'daftar_dosen'));
    }

    // pimpinan
    public function createKp()
    {
        $daftar_mahasiswa = \App\Mahasiswa::where('kontrak_kp', 'ya')->pluck('nama', 'id');
        $daftar_semester = \App\Semester::pluck('nama', 'id');
        $daftar_dosen = \App\Dosen::where('status', 'aktif')->where('bisa_membimbing', 'ya')->pluck('nama', 'id');
        return view('dosbing.create-kp', compact('daftar_mahasiswa', 'daftar_semester', 'daftar_dosen'));
    }

    // pimpinan
    public function storeSkripsi(Request $request)
    {
        $validasi = Validator::make($request->all(), [
          'id_mahasiswa' => 'required|integer',
          'dosbing_satu_skripsi' => 'required|integer',
          'dosbing_dua_skripsi' => 'required|integer',
          'id_semester' => 'required|integer'
        ]);

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        if($request->post('dosbing_satu_skripsi') === $request->post('dosbing_dua_skripsi')){
            return redirect()->back()->withInput()->with('kesalahan', 'Dosen Pembimbing Tidak Boleh Sama!');
        }

        $dosbing = DosenPembimbingSkripsi::where('id_semester', $request->post('id_semester'))->where('id_mahasiswa', $request->post('id_mahasiswa'))->where('dosbing_satu_skripsi', $request->post('dosbing_satu_skripsi'))->where('dosbing_dua_skripsi', $request->post('dosbing_dua_skripsi'))->first();

        if($dosbing){
            Session::flash('kesalahan', 'Sudah Ada Data Yang Sama!');
            return redirect()->back()->withInput();
        }

        // input dosen pembimbing skripsi
        DosenPembimbingSkripsi::create($request->all());

        // perbaharui tahapan skripsi mahasiswa
        $mahasiswa = \App\Mahasiswa::findOrFail($request->post('id_mahasiswa'));
        $mahasiswa->tahapan_skripsi = 'penyusunan_proposal';
        $mahasiswa->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $request->post('id_mahasiswa');
        $notifikasiMahasiswa->link = 'dosen-pembimbing/skripsi';
        $notifikasiMahasiswa->jenis = 'dosen-pembimbing';
        $notifikasiMahasiswa->deskripsi = 'Dosen Pembimbing Skripsi anda telah tersedia';
        $notifikasiMahasiswa->save();

        Session::flash('pesan','Dosen Pembimbing Skripsi Berhasil Ditambahkan!');
        return redirect('dosen-pembimbing/skripsi/semester/'.$request->post('id_semester'));
    }

    // pimpinan
    public function storeByUsulanTopik(Request $request)
    {
        $validasi = Validator::make($request->all(), [
          'id_mahasiswa' => 'required|integer',
          'dosbing_satu_skripsi' => 'required|integer',
          'dosbing_dua_skripsi' => 'required|integer',
          'id_semester' => 'required|integer'
        ]);

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        if($request->post('dosbing_satu_skripsi') === $request->post('dosbing_dua_skripsi')){
            return redirect()->back()->withInput()->with('kesalahan', 'Dosen Pembimbing Tidak Boleh Sama!');
        }

        $dosbing = DosenPembimbingSkripsi::where('id_semester', $request->post('id_semester'))->where('id_mahasiswa', $request->post('id_mahasiswa'))->where('dosbing_satu_skripsi', $request->post('dosbing_satu_skripsi'))->where('dosbing_dua_skripsi', $request->post('dosbing_dua_skripsi'))->first();

        if($dosbing){
            Session::flash('kesalahan', 'Sudah Ada Data Yang Sama!');
            return redirect()->back()->withInput();
        }

        // input dosen pembimbing skripsi
        DosenPembimbingSkripsi::create($request->all());

        // perbaharui tahapan skripsi mahasiswa
        $mahasiswa = \App\Mahasiswa::findOrFail($request->post('id_mahasiswa'));
        $mahasiswa->tahapan_skripsi = 'penyusunan_proposal';
        $mahasiswa->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $request->post('id_mahasiswa');
        $notifikasiMahasiswa->link = 'dosen-pembimbing/skripsi';
        $notifikasiMahasiswa->jenis = 'dosen-pembimbing';
        $notifikasiMahasiswa->deskripsi = 'Dosen Pembimbing Skripsi anda telah tersedia';
        $notifikasiMahasiswa->save();

        \App\PendaftarUsulanTopik::find($request->post('id_pendaftar_usulan_topik'))->update([
            'tahapan' => 'diterima'
        ]);

        Session::flash('pesan','Dosen Pembimbing Skripsi Berhasil Ditambahkan!');
        return redirect('dosen-pembimbing/skripsi/semester/'.$request->post('id_semester'));
    }

    // pimpinan
    public function storeByTurunKp(Request $request)
    {
        $validasi = Validator::make($request->all(), [
          'id_mahasiswa' => 'required|integer',
          'lokasi' => 'required|string',
          'dosbing_satu_kp' => 'required|integer',
          'dosbing_dua_kp' => 'required|integer',
          'id_semester' => 'required|integer'
        ]);

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        if($request->post('dosbing_satu_kp') === $request->post('dosbing_dua_kp')){
            return redirect()->back()->withInput()->with('kesalahan', 'Dosen Pembimbing Tidak Boleh Sama!');
        }

        $dosbing = DosenPembimbingKp::where('id_semester', $request->post('id_semester'))->where('id_mahasiswa', $request->post('id_mahasiswa'))->where('dosbing_satu_kp', $request->post('dosbing_satu_kp'))->where('dosbing_dua_kp', $request->post('dosbing_dua_kp'))->first();

        if($dosbing){
            Session::flash('kesalahan', 'Sudah Ada Data Yang Sama!');
            return redirect()->back()->withInput();
        }

        // input dosen pembimbing kp
        DosenPembimbingKp::create($request->all());

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $request->post('id_mahasiswa');
        $notifikasiMahasiswa->link = 'dosen-pembimbing/kerja-praktek';
        $notifikasiMahasiswa->jenis = 'dosen-pembimbing';
        $notifikasiMahasiswa->deskripsi = 'Dosen Pembimbing Kerja Praktek anda telah tersedia';
        $notifikasiMahasiswa->save();

        \App\PendaftarTurunKp::find($request->post('id_pendaftar_turun_kp'))->update([
            'tahapan' => 'diterima'
        ]);

        Session::flash('pesan','Dosen Pembimbing Kerja Praktek Berhasil Ditambahkan!');
        return redirect('dosen-pembimbing/kerja-praktek/semester/'.$request->post('id_semester'));
    }

    // pimpinan
    public function storeKp(Request $request)
    {
        $validasi = Validator::make($request->all(), [
          'id_mahasiswa' => 'required|integer',
          'dosbing_satu_kp' => 'required|integer',
          'dosbing_dua_kp' => 'required|integer',
          'id_semester' => 'required|integer'
        ]);

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        if($request->post('dosbing_satu_kp') === $request->post('dosbing_dua_kp')){
            return redirect()->back()->withInput()->with('kesalahan', 'Dosen Pembimbing Tidak Boleh Sama!');
        }

        $dosbing = DosenPembimbingKp::where('id_semester', $request->post('id_semester'))->where('id_mahasiswa', $request->post('id_mahasiswa'))->where('dosbing_satu_kp', $request->post('dosbing_satu_kp'))->where('dosbing_dua_kp', $request->post('dosbing_dua_kp'))->first();

        if($dosbing){
            Session::flash('kesalahan', 'Sudah Ada Data Yang Sama!');
            return redirect()->back()->withInput();
        }

        // input dosen pembimbing kp
        DosenPembimbingKp::create($request->all());

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $request->post('id_mahasiswa');
        $notifikasiMahasiswa->link = 'dosen-pembimbing/kerja-praktek';
        $notifikasiMahasiswa->jenis = 'dosen-pembimbing';
        $notifikasiMahasiswa->deskripsi = 'Dosen Pembimbing Kerja Praktek anda telah tersedia';
        $notifikasiMahasiswa->save();

        Session::flash('pesan','Dosen Pembimbing Kerja Praktek Berhasil Ditambahkan!');
        return redirect('dosen-pembimbing/kerja-praktek/semester/'.$request->post('id_semester'));
    }

    // pimpinan
    public function gantiSkripsi($id)
    {
        $dosbing = DosenPembimbingSkripsi::findOrFail($id);
        $daftar_semester = \App\Semester::pluck('nama', 'id');
        $dosen_sekarang = \App\Dosen::whereIn('id', [$dosbing->dosbingSatuSkripsi->id, $dosbing->dosbingDuaSkripsi->id])->pluck('nama', 'id');
        $daftar_dosen = \App\Dosen::where('status', 'aktif')->where('bisa_membimbing', 'ya')->whereNotIn('id', [$dosbing->dosbingSatuSkripsi->id, $dosbing->dosbingDuaSkripsi->id])->pluck('nama', 'id');
        return view('dosbing.ganti-skripsi', compact('dosbing', 'daftar_semester', 'daftar_dosen', 'dosen_sekarang'));
    }

    // pimpinan
    public function editSkripsi($id)
    {
        $dosbing = DosenPembimbingSkripsi::findOrFail($id);
        $daftar_semester = \App\Semester::pluck('nama', 'id');
        $dosen_sekarang = \App\Dosen::whereIn('id', [$dosbing->dosbingSatuSkripsi->id, $dosbing->dosbingDuaSkripsi->id])->pluck('nama', 'id');
        $daftar_dosen = \App\Dosen::where('status', 'aktif')->where('bisa_membimbing', 'ya')->whereNotIn('id', [$dosbing->dosbingSatuSkripsi->id, $dosbing->dosbingDuaSkripsi->id])->pluck('nama', 'id');
        return view('dosbing.edit-skripsi', compact('dosbing', 'daftar_semester', 'daftar_dosen', 'dosen_sekarang'));
    }

    // pimpinan
    public function editKp($id)
    {
        $dosbing = DosenPembimbingKp::findOrFail($id);
        $daftar_semester = \App\Semester::pluck('nama', 'id');
        $dosen_sekarang = \App\Dosen::whereIn('id', [$dosbing->dosbingSatuKp->id, $dosbing->dosbingDuaKp->id])->pluck('nama', 'id');
        $daftar_dosen = \App\Dosen::where('status', 'aktif')->where('bisa_membimbing', 'ya')->whereNotIN('id', [$dosbing->dosbingSatuKp->id, $dosbing->dosbingDuaKp->id])->pluck('nama', 'id');
        return view('dosbing.edit-kp', compact('dosbing', 'daftar_semester', 'daftar_dosen', 'dosen_sekarang'));
    }

    // pimpinan
    public function updateGantiSkripsi(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
          'id_mahasiswa' => 'required|integer',
          'ujian' => 'required|string',
          'dosen_berhalangan' => 'required|integer',
          'dosen_pengganti' => 'required|integer',
          'status' => 'required|in:tidak-bersedia,mundur',
          'alasan' => 'required|string',
          'id_semester' => 'required|integer'
        ]);

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        $dosbing_satu = DosenPembimbingSkripsi::where('id', $request->post('id'))->where('dosbing_satu_skripsi', $request->post('dosen_berhalangan'))->first();
        $dosbing = DosenPembimbingSkripsi::findOrFail($request->post('id'));
        if(!empty($dosbing_satu)){
            $pembimbing = '1';
            $dosbing->dosbing_satu_skripsi = $request->post('dosen_pengganti');
        }else{
            $pembimbing = '2';
            $dosbing->dosbing_dua_skripsi = $request->post('dosen_pengganti');
        }
        $dosbing->save();

        $berhalangan = new \App\DosbingBerhalangan;
        $berhalangan->id_semester = $request->post('id_semester');
        $berhalangan->id_dosen = $request->post('dosen_berhalangan');
        $berhalangan->id_mahasiswa = $request->post('id_mahasiswa');
        $berhalangan->ujian = $request->post('ujian');
        $berhalangan->status = $request->post('status');
        $berhalangan->alasan = $request->post('alasan');
        $berhalangan->dosbing = $pembimbing;
        $berhalangan->save();

        Session::flash('pesan','Dosen Pembimbing Skripsi Berhasil Diupdate!');
        return redirect('dosen-pembimbing/skripsi/semester/'.$request->post('id_semester'));
    }

    // pimpinan
    public function updateSkripsi(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
          'id_mahasiswa' => 'required|integer',
          'ujian' => 'required|string',
          'dosen_salah' => 'required|integer',
          'dosen_pengganti' => 'required|integer',
          'id_semester' => 'required|integer'
        ]);

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        $dosbing_satu = DosenPembimbingSkripsi::where('id', $request->post('id'))->where('dosbing_satu_skripsi', $request->post('dosen_salah'))->first();
        $dosbing = DosenPembimbingSkripsi::findOrFail($request->post('id'));
        if(!empty($dosbing_satu)){
            $pembimbing = '1';
            $dosbing->dosbing_satu_skripsi = $request->post('dosen_pengganti');
        }else{
            $pembimbing = '2';
            $dosbing->dosbing_dua_skripsi = $request->post('dosen_pengganti');
        }
        $dosbing->save();

        Session::flash('pesan','Dosen Pembimbing Skripsi Berhasil Diupdate!');
        return redirect('dosen-pembimbing/skripsi/semester/'.$request->post('id_semester'));
    }

    // pimpinan
    public function updateKp(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
          'id_mahasiswa' => 'required|integer',
          'ujian' => 'required|string',
          'dosen_berhalangan' => 'required|integer',
          'dosen_pengganti' => 'required|integer',
          'status' => 'required|in:tidak-bersedia,mundur',
          'alasan' => 'required|string',
          'id_semester' => 'required|integer'
        ]);

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        $dosbing_satu = DosenPembimbingKp::where('id', $request->post('id'))->where('dosbing_satu_kp', $request->post('dosen_berhalangan'))->first();
        $dosbing = DosenPembimbingKp::findOrFail($request->post('id'));
        if(!empty($dosbing_satu)){
            $pembimbing = '1';
            $dosbing->dosbing_satu_kp = $request->post('dosen_pengganti');
        }else{
            $pembimbing = '2';
            $dosbing->dosbing_dua_kp = $request->post('dosen_pengganti');
        }
        $dosbing->save();

        $berhalangan = new \App\DosbingBerhalangan;
        $berhalangan->id_semester = $request->post('id_semester');
        $berhalangan->id_dosen = $request->post('dosen_berhalangan');
        $berhalangan->id_mahasiswa = $request->post('id_mahasiswa');
        $berhalangan->ujian = $request->post('ujian');
        $berhalangan->status = $request->post('status');
        $berhalangan->alasan = $request->post('alasan');
        $berhalangan->dosbing = $pembimbing;
        $berhalangan->save();

        Session::flash('pesan','Dosen Pembimbing Kerja Praktek Berhasil Diupdate!');
        return redirect('dosen-pembimbing/kerja-praktek/semester/'.$request->post('id_semester'));
    }

    // pimpinan
    public function destroyDosbingBerhalangan($id)
    {
        $dosbing = \App\DosbingBerhalangan::findOrFail($id);
        $dosbing->delete();
        Session::flash('pesan', 'Dosen Berhalangan Berhasil Dihapus');
        return redirect()->back();
    }

    // pimpinan
    public function cetakDosbingBerhalangan($id)
    {
        $dosbing = \App\DosbingBerhalangan::findOrFail($id);
        $pdf = PDF::loadView('dosbing-mundur.surat-pengunduran-diri', compact('dosbing'));
        return $pdf->download('Surat Pengunduran Diri Dosen Pembimbing '.$dosbing->mahasiswa->nama.'.pdf');
    }

    // pimpinan
    public function destroySkripsi($id)
    {
        $dosbing = DosenPembimbingSkripsi::findOrFail($id);
        $dosbing->delete();
        Session::flash('pesan', '1 Data Dosen Pembimbing Skripsi Berhasil Dihapus');
        return redirect()->back();
    }

    // pimpinan
    public function destroyKp($id)
    {
        $dosbing = DosenPembimbingKp::findOrFail($id);
        $dosbing->delete();
        Session::flash('pesan', '1 Data Dosen Pembimbing Kerja Praktek Berhasil Dihapus');
        return redirect()->back();
    }

    // pimpinan
    public function suratPenunjukanSkripsi(Request $request)
    {
        $dosbing = DosenPembimbingSkripsi::findOrFail($request->post('id'));
        $nomor = $request->post('nomor_surat');
        $judul = \App\PendaftarUsulanTopik::where('id_mahasiswa', $dosbing->id_mahasiswa)->where('tahapan', 'diterima')->first();
        $kajur = \App\Kajur::where('tahun_awal', '<=', date('Y'))->where('tahun_selesai', '>=', date('Y'))->first();

        $pdf = PDF::loadView('dosbing/surat-penunjukan-skripsi', compact('dosbing', 'nomor', 'judul', 'kajur'));
        return $pdf->download('Surat Penunjukan Skripsi '.$dosbing->mahasiswa->nama.'.pdf');
    }

    // pimpinan
    public function formSuratPenunjukanSkripsi($id)
    {
        $dosbing = DosenPembimbingSkripsi::findOrFail($id);
        $judul = \App\PendaftarUsulanTopik::where('id_mahasiswa', $dosbing->id_mahasiswa)->where('tahapan', 'diterima')->first();
        return view('dosbing.form-surat-penunjukan', compact('dosbing', 'judul'));
    }

    // mahasiswa & pimpinan
    public function suratKesediaanSkripsi($id)
    {
        $dosbing = DosenPembimbingSkripsi::findOrFail($id);
        $usulan_topik = \App\PendaftarUsulanTopik::where('id_mahasiswa', $dosbing->id_mahasiswa)->where('tahapan', 'diterima')->first();

        $pdf = PDF::loadView('dosbing.surat-kesediaan', compact('dosbing', 'usulan_topik'));
        return $pdf->download('Surat Pernyataan Kesediaan Dosen Pembimbing '.$dosbing->mahasiswa->nama.'.pdf');
    }

    // mahasiswa & pimpinan
    public function suratPersetujuanProposal($id)
    {
        $dosbing = DosenPembimbingSkripsi::findOrFail($id);
        $usulan_topik = \App\PendaftarUsulanTopik::where('id_mahasiswa', $dosbing->id_mahasiswa)->where('tahapan', 'diterima')->first();

        $pdf = PDF::loadView('dosbing.surat-persetujuan-proposal', compact('dosbing', 'usulan_topik'));
        return $pdf->download('Surat Pernyataan Persetujuan Ujian Seminar Proposal '.$dosbing->mahasiswa->nama.'.pdf');
    }

    // mahasiswa & pimpinan
    public function suratPersetujuanHasil($id)
    {
        $dosbing = DosenPembimbingSkripsi::findOrFail($id);
        $usulan_topik = \App\PendaftarUsulanTopik::where('id_mahasiswa', $dosbing->id_mahasiswa)->where('tahapan', 'diterima')->first();

        $pdf = PDF::loadView('dosbing.surat-persetujuan-hasil', compact('dosbing', 'usulan_topik'));
        return $pdf->download('Surat Pernyataan Persetujuan Ujian Seminar Hasil '.$dosbing->mahasiswa->nama.'.pdf');
    }

    // mahasiswa & pimpinan
    public function suratPersetujuanSidang($id)
    {
        $dosbing = DosenPembimbingSkripsi::findOrFail($id);
        $usulan_topik = \App\PendaftarUsulanTopik::where('id_mahasiswa', $dosbing->id_mahasiswa)->where('tahapan', 'diterima')->first();

        $pdf = PDF::loadView('dosbing.surat-persetujuan-sidang', compact('dosbing', 'usulan_topik'));
        return $pdf->download('Surat Pernyataan Persetujuan Ujian Sidang Skripsi '.$dosbing->mahasiswa->nama.'.pdf');
    }

    // mahasiswa & pimpinan
    public function suratPenunjukanKp($id)
    {
        $semester = \App\Semester::find($id);
        $daftar_dosbing = DosenPembimbingKp::where('id_semester', $id)->get();
        $kajur = \App\Kajur::where('tahun_awal', '<=', date('Y'))->where('tahun_selesai', '>=', date('Y'))->first();

        $pdf = PDF::loadView('dosbing/surat-penunjukan-kp', compact('daftar_dosbing', 'semester', 'kajur'));
        return $pdf->download('Surat Penunjukan Kerja Praktek Semester '.$semester->nama.'.pdf');
    }

    // pimpinan
    public function formSuratPersetujuanKp($id)
    {
        $dosbing = DosenPembimbingKp::findOrFail($id);
        return view('dosbing.form-surat-persetujuan-kp', compact('dosbing'));
    }

    // mahasiswa & pimpinan
    public function suratPersetujuanKp(Request $request)
    {
        $dosbing = DosenPembimbingKp::findOrFail($request->id);
        $judul = $request->post('judul');
        $instansi = $request->post('instansi');

        $pdf = PDF::loadView('dosbing.surat-persetujuan-kp', compact('dosbing', 'instansi', 'judul'));
        return $pdf->download('Surat Pernyataan Persetujuan Ujian Seminar Kerja Praktek '.$dosbing->mahasiswa->nama.'.pdf');
    }

    // mahasiswa
    public function indexSkripsi()
    {
        $daftar_dosbing = DosenPembimbingSkripsi::where('id_mahasiswa', Session::get('id'))->orderBy('id_semester', 'desc')->get();
        $daftar_dosbing_berhalangan = \App\DosbingBerhalangan::where('id_mahasiswa', Session::get('id'))->where('ujian', 'skripsi')->orderBy('id_semester','desc')->get();
        return view('dosbing.index-skripsi', compact('daftar_dosbing', 'daftar_dosbing_berhalangan'));
    }

    // mahasiswa
    public function indexKp()
    {
        $daftar_dosbing = DosenPembimbingKp::where('id_mahasiswa', Session::get('id'))->orderBy('id_semester', 'desc')->get();
        $daftar_dosbing_berhalangan = \App\DosbingBerhalangan::where('id_mahasiswa', Session::get('id'))->where('ujian', 'kerja-praktek')->orderBy('id_semester','desc')->get();
        return view('dosbing.index-kp', compact('daftar_dosbing', 'daftar_dosbing_berhalangan'));
    }

    // pimpinan
    public function perpanjangSkripsi($id, Request $request)
    {
        $dosbing = DosenPembimbingSkripsi::findOrFail($id);
        $semester_aktif = \App\Semester::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;
        if(!$semester_aktif){
            Session::flash('kesalahan', 'Semester Aktif Belum Dimasukan oleh Admin');
            return redirect()->back();
        }else{
            if($dosbing->id_semester === $semester_aktif->id){
                Session::flash('kesalahan', 'Semester Aktif Adalah Semester Ini!');
                return redirect()->back();
            }

            $dosbing_semester_aktif = DosenPembimbingSkripsi::where('id_semester', $semester_aktif->id)->where('id_mahasiswa', $dosbing->id_mahasiswa)->where('dosbing_satu_skripsi', $dosbing->dosbing_satu_skripsi)->where('dosbing_dua_skripsi', $dosbing->dosbing_dua_skripsi)->first();

            if($dosbing_semester_aktif){
                Session::flash('kesalahan', 'Sudah Ada Data Yang Sama Di Semester Aktif!');
                return redirect()->back();
            }

            $perpanjang = new DosenPembimbingSkripsi;
            $perpanjang->id_mahasiswa = $dosbing->id_mahasiswa;
            $perpanjang->dosbing_satu_skripsi = $dosbing->dosbing_satu_skripsi;
            $perpanjang->dosbing_dua_skripsi = $dosbing->dosbing_dua_skripsi;
            $perpanjang->id_semester = $semester_aktif->id;
            $perpanjang->save();

            Session::flash('pesan', 'Berhasil Perpanjang Dosen Pembimbing Skripsi Ke Semester Aktif');
            return redirect()->back();
        }
    }

    // pimpinan
    public function perpanjangKp($id, Request $request)
    {
        $dosbing = DosenPembimbingKp::findOrFail($id);
        $semester_aktif = \App\Semester::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;
        if(!$semester_aktif){
            Session::flash('kesalahan', 'Semester Aktif Belum Dimasukan oleh Admin');
            return redirect()->back();
        }else{
            if($dosbing->id_semester === $semester_aktif->id){
                Session::flash('kesalahan', 'Semester Aktif Adalah Semester Ini!');
                return redirect()->back();
            }

            $dosbing_semester_aktif = DosenPembimbingKp::where('id_semester', $semester_aktif->id)->where('id_mahasiswa', $dosbing->id_mahasiswa)->where('dosbing_satu_kp', $dosbing->dosbing_satu_kp)->where('dosbing_dua_kp', $dosbing->dosbing_dua_kp)->first();

            if($dosbing_semester_aktif){
                Session::flash('kesalahan', 'Sudah Ada Data Yang Sama Di Semester Aktif!');
                return redirect()->back();
            }

            $perpanjang = new DosenPembimbingKp;
            $perpanjang->id_mahasiswa = $dosbing->id_mahasiswa;
            $perpanjang->dosbing_satu_kp = $dosbing->dosbing_satu_kp;
            $perpanjang->dosbing_dua_kp = $dosbing->dosbing_dua_kp;
            $perpanjang->lokasi = $dosbing->lokasi;
            $perpanjang->id_semester = $semester_aktif->id;
            $perpanjang->save();

            Session::flash('pesan', 'Berhasil Perpanjang Dosen Pembimbing Kerja Praktek Ke Semester Aktif');
            return redirect()->back();
        }
    }

    // pimpinan
    public function perpanjangSkripsiBelumLulus(Request $request, $id)
    {
        $semester_aktif = \App\Semester::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;
        if(!$semester_aktif){
            Session::flash('kesalahan', 'Semester Aktif Belum Dimasukan oleh Admin');
            return redirect()->back();
        }else{

          if($id == $semester_aktif->id){
            Session::flash('kesalahan', 'Semester Aktif Adalah Semester Ini!');
            return redirect()->back();
          }
          $daftar_dosbing = DosenPembimbingSkripsi::with('mahasiswa')->where('id_semester', $id)->whereHas('mahasiswa', function ($query) {
            $query->whereNotIn('tahapan_skripsi', ['lulus']);
          })->get();
          foreach($daftar_dosbing as $dosbing){
            $perpanjang = new DosenPembimbingSkripsi;
            $perpanjang->id_mahasiswa = $dosbing->id_mahasiswa;
            $perpanjang->dosbing_satu_skripsi = $dosbing->dosbing_satu_skripsi;
            $perpanjang->dosbing_dua_skripsi = $dosbing->dosbing_dua_skripsi;
            $perpanjang->id_semester = $semester_aktif->id;
            $perpanjang->save();
          }

          Session::flash('pesan', 'Berhasil memperjanjang pembimbing skripsi ke semester aktif bagi mahasiswa yang belum lulus!');
          return redirect()->back();
        }
    }

    // pimpinan
    public function perpanjangKpBelumLulus(Request $request, $id)
    {
        $semester_aktif = \App\Semester::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;
        if(!$semester_aktif){
            Session::flash('kesalahan', 'Semester Aktif Belum Dimasukan oleh Admin');
            return redirect()->back();
        }else{
            if($id == $semester_aktif->id){
                Session::flash('kesalahan', 'Semester Aktif Adalah Semester Ini!');
                return redirect()->back();
            }

        $daftar_dosbing = DosenPembimbingKp::with('mahasiswa')->where('id_semester', $id)->whereHas('mahasiswa', function ($query) {
            $query->whereNotIn('tahapan_kp', ['lulus']);
        })->get();
        foreach($daftar_dosbing as $dosbing){
            $perpanjang = new DosenPembimbingKp;
            $perpanjang->id_mahasiswa = $dosbing->id_mahasiswa;
            $perpanjang->dosbing_satu_kp = $dosbing->dosbing_satu_kp;
            $perpanjang->dosbing_dua_kp = $dosbing->dosbing_dua_kp;
            $perpanjang->lokasi = $dosbing->lokasi;
            $perpanjang->id_semester = $semester_aktif->id;
            $perpanjang->save();
        }

          Session::flash('pesan', 'Berhasil memperjanjang pembimbing kerja praktek ke semester aktif bagi mahasiswa yang belum lulus!');
          return redirect()->back();
      }
    }


  }
