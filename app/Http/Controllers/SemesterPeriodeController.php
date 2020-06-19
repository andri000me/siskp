<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Semester;
use App\PeriodeDaftarUsulanTopik;
use App\PeriodeDaftarTurunKp;
use App\PeriodeDaftarUjian;
use Validator;

class SemesterPeriodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('pimpinan');
    }

    public function indexSemester()
    {
        $semester_aktif = Semester::where('waktu_buka', '<=', date('Y-m-d'))->where('waktu_tutup', '>=', date('Y-m-d'))->first() or null;
        $daftar_semester = Semester::orderBy('id', 'desc')->paginate(10);
        
        $total = Semester::all()->count();
        $bottom_detail = true;
        
        return view('semester-periode.index-semester', compact(
            'daftar_semester', 'semester_aktif', 'total', 'bottom_detail' 
        ));
    }

    public function indexPeriodeDaftarTurunKp()
    {
        $daftar_periode_daftar_turun_kp = PeriodeDaftarTurunKp::orderBy('id', 'desc')->paginate(10);
        $total = PeriodeDaftarTurunKp::all()->count(10);
        $bottom_detail = true;

        return view('semester-periode.index-periode-daftar-turun-kp', compact(
            'daftar_periode_daftar_turun_kp', 'total', 'bottom_detail' 
        ));
    }

    public function indexPeriodeDaftarUsulanTopik()
    {
        $daftar_periode_daftar_usulan_topik = PeriodeDaftarUsulanTopik::orderBy('id', 'desc')->paginate(10);
        $total = PeriodeDaftarUsulanTopik::all()->count();
        $bottom_detail = true;

        return view('semester-periode.index-periode-daftar-usulan-topik', compact(
            'daftar_periode_daftar_usulan_topik', 'total', 'bottom_detail'
        ));
    }

    public function indexPeriodeDaftarUjian()
    {
        $total = PeriodeDaftarUjian::all()->count();
        $bottom_detail = true;

        $daftar_periode_daftar_ujian = PeriodeDaftarUjian::orderBy('id', 'desc')->paginate(10);

        return view('semester-periode.index-periode-daftar-ujian', compact(
            'daftar_periode_daftar_ujian', 'total', 'bottom_detail'  
        ));
    }

    public function createSemester()
    {
        $bottom_detail = true;
        return view('semester-periode.create-semester', compact('bottom_detail'));
    }

    public function storeSemester(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:100',
            'waktu_buka' => 'required|date',
            'waktu_tutup' => 'required|date',
        ]);

        Semester::create($request->all());
        Session::flash('pesan', '1 Semester berhasil ditambahkan');
        return redirect('semester-periode/semester');
    }

    public function editSemester($id)
    {
        $semester = Semester::findOrFail($id);
        $bottom_detail = true;

        return view('semester-periode.edit-semester', compact('semester', 'bottom_detail'));
    }

    public function updateSemester(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:100',
            'waktu_buka' => 'required|date',
            'waktu_tutup' => 'required|date',
        ]);

        $semester = Semester::findOrFail($id);
        $semester->update($request->all());
        Session::flash('pesan', '1 Semester berhasil diupdate');
        return redirect('semester-periode/semester');
    }

    public function destroySemester($id)
    {
        $semester = Semester::findOrFail($id);
        $semester->delete();
        Session::flash('pesan', '1 Semester berhasil dihapus');
        return redirect('semester-periode/semester');
    }

    public function createPeriodeDaftarTurunKp()
    {
        $daftar_semester = Semester::pluck('nama', 'id');
        $bottom_detail = true;

        return view('semester-periode.create-periode-daftar-turun-kp', compact('daftar_semester', 'bottom_detail'));
    }

    public function storePeriodeDaftarTurunKp(Request $request)
    {
        $semester = Semester::findOrFail($request->input('id_semester'));

        $this->validate($request, [
            'nama' => 'required|string|max:100',
            'waktu_buka' => 'required|date|after_or_equal:'.$semester->waktu_buka,
            'waktu_tutup' => 'required|date|before_or_equal:'.$semester->waktu_tutup,
            'id_semester' => 'required|integer'
        ]);
        
        PeriodeDaftarTurunKp::create($request->all());
        Session::flash('pesan', '1 Periode Daftar Turun Kerja Praktek berhasil ditambahkan');
        return redirect('semester-periode/periode-daftar-turun-kp');
    }

    public function editPeriodeDaftarTurunKp($id)
    {
        $daftar_semester = Semester::pluck('nama', 'id');
        $periode_daftar_turun_kp = PeriodeDaftarTurunKp::findOrFail($id);
        $bottom_detail = true;

        return view('semester-periode.edit-periode-daftar-turun-kp', compact('daftar_semester', 'periode_daftar_turun_kp', 'bottom_detail'));
    }

    public function updatePeriodeDaftarTurunKp(Request $request, $id)
    {
        $semester = Semester::findOrFail($request->input('id_semester'));

        $this->validate($request, [
            'nama' => 'required|string|max:100',
            'waktu_buka' => 'required|date|after_or_equal:'.$semester->waktu_buka,
            'waktu_tutup' => 'required|date|before_or_equal:'.$semester->waktu_tutup,
            'id_semester' => 'required|integer'
        ]);

        $periode_daftar_turun_kp = PeriodeDaftarTurunKp::findOrFail($id);
        $periode_daftar_turun_kp->update($request->all());
        Session::flash('pesan', '1 Periode Daftar Turun Kerja Praktek berhasil diupdate');
        return redirect('semester-periode/periode-daftar-turun-kp');
    }

    public function destroyPeriodeDaftarTurunKp($id)
    {
        $periode_daftar_turun_kp = PeriodeDaftarTurunKp::findOrFail($id);
        $periode_daftar_turun_kp->delete();
        Session::flash('pesan', '1 Periode Daftar Turun Kerja Praktek berhasil dihapus');
        return redirect('semester-periode/periode-daftar-turun-kp');
    }
    
    
    public function createPeriodeDaftarUsulanTopik()
    {
        $daftar_semester = Semester::pluck('nama', 'id');
        $bottom_detail = true;

        return view('semester-periode.create-periode-daftar-usulan-topik', compact('daftar_semester', 'bottom_detail'));
    }

    public function storePeriodeDaftarUsulanTopik(Request $request)
    {
        $semester = Semester::findOrFail($request->input('id_semester'));

        $this->validate($request, [
            'nama' => 'required|string|max:100',
            'waktu_buka' => 'required|date|after_or_equal:'.$semester->waktu_buka,
            'waktu_tutup' => 'required|date|before_or_equal:'.$semester->waktu_tutup,
            'id_semester' => 'required|integer'
        ]);
        
        PeriodeDaftarUsulanTopik::create($request->all());
        Session::flash('pesan', '1 Periode Daftar Usulan Topik berhasil ditambahkan');
        return redirect('semester-periode/periode-daftar-usulan-topik');
    }

    public function editPeriodeDaftarUsulanTopik($id)
    {
        $daftar_semester = Semester::pluck('nama', 'id');
        $periode_daftar_usulan_topik = PeriodeDaftarUsulanTopik::findOrFail($id);
        $bottom_detail = true;

        return view('semester-periode.edit-periode-daftar-usulan-topik', compact('daftar_semester', 'periode_daftar_usulan_topik', 'bottom_detail'));
    }

    public function updatePeriodeDaftarUsulanTopik(Request $request, $id)
    {
        $semester = Semester::findOrFail($request->input('id_semester'));

        $this->validate($request, [
            'nama' => 'required|string|max:100',
            'waktu_buka' => 'required|date|after_or_equal:'.$semester->waktu_buka,
            'waktu_tutup' => 'required|date|before_or_equal:'.$semester->waktu_tutup,
            'id_semester' => 'required|integer'
        ]);

        $periode_daftar_usulan_topik = PeriodeDaftarUsulanTopik::findOrFail($id);
        $periode_daftar_usulan_topik->update($request->all());
        Session::flash('pesan', '1 Periode Daftar Usulan Topik berhasil diupdate');
        return redirect('semester-periode/periode-daftar-usulan-topik');
    }

    public function destroyPeriodeDaftarUsulanTopik($id)
    {
        $periode_daftar_usulan_topik = PeriodeDaftarUsulanTopik::findOrFail($id);
        $periode_daftar_usulan_topik->delete();
        Session::flash('pesan', '1 Periode Daftar Usulan Topik berhasil dihapus');
        return redirect('semester-periode/periode-daftar-usulan-topik');
    }


    public function createPeriodeDaftarUjian()
    {
        $daftar_semester = Semester::pluck('nama', 'id');
        $bottom_detail = true;

        return view('semester-periode.create-periode-daftar-ujian', compact('daftar_semester', 'bottom_detail'));
    }

    public function storePeriodeDaftarUjian(Request $request)
    {
        $semester = Semester::findOrFail($request->input('id_semester'));

        $this->validate($request, [
            'nama' => 'required|string|max:100',
            'waktu_buka' => 'required|date|after_or_equal:'.$semester->waktu_buka,
            'waktu_tutup' => 'required|date|before_or_equal:'.$semester->waktu_tutup,
            'id_semester' => 'required|integer',
            'nomor_undangan' => 'required|string|max:100',
        ]);

        PeriodeDaftarUjian::create($request->all());
        Session::flash('pesan', '1 Periode Daftar Ujian berhasil ditambahkan');
        return redirect('semester-periode/periode-daftar-ujian');
    }

    public function editPeriodeDaftarUjian($id)
    {
        $daftar_semester = Semester::pluck('nama', 'id');
        $periode_daftar_ujian = PeriodeDaftarUjian::findOrFail($id);
        $bottom_detail = true;

        return view('semester-periode.edit-periode-daftar-ujian', compact('daftar_semester', 'periode_daftar_ujian', 'bottom_detail'));
    }

    public function updatePeriodeDaftarUjian(Request $request, $id)
    {
        $semester = Semester::findOrFail($request->input('id_semester'));

        $this->validate($request, [
            'nama' => 'required|string|max:100',
            'waktu_buka' => 'required|date|after_or_equal:'.$semester->waktu_buka,
            'waktu_tutup' => 'required|date|before_or_equal:'.$semester->waktu_tutup,
            'id_semester' => 'required|integer',
            'nomor_undangan' => 'required|string|max:100',
        ]);

        $periode_daftar_ujian = PeriodeDaftarUjian::findOrFail($id);
        $periode_daftar_ujian->update($request->all());
        Session::flash('pesan', '1 Periode Daftar Ujian berhasil diupdate');
        return redirect('semester-periode/periode-daftar-ujian');
    }

    public function destroyPeriodeDaftarUjian($id)
    {
        $periode_daftar_ujian = PeriodeDaftarUjian::findOrFail($id);
        $periode_daftar_ujian->delete();
        Session::flash('pesan', '1 Periode Daftar Ujian berhasil dihapus');
        return redirect('semester-periode/periode-daftar-ujian');
    }

}
