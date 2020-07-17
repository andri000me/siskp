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
        
        return view('semester-periode.index-semester', compact(
            'daftar_semester', 'semester_aktif', 'total' 
        ));
    }

    public function indexPeriodeDaftarTurunKp()
    {
        $daftar_periode_daftar_turun_kp = PeriodeDaftarTurunKp::orderBy('id', 'desc')->paginate(10);
        $total = PeriodeDaftarTurunKp::all()->count(10);

        return view('semester-periode.index-periode-daftar-turun-kp', compact(
            'daftar_periode_daftar_turun_kp', 'total' 
        ));
    }

    public function indexPeriodeDaftarUsulanTopik()
    {
        $daftar_periode_daftar_usulan_topik = PeriodeDaftarUsulanTopik::orderBy('id', 'desc')->paginate(10);
        $total = PeriodeDaftarUsulanTopik::all()->count();

        return view('semester-periode.index-periode-daftar-usulan-topik', compact(
            'daftar_periode_daftar_usulan_topik', 'total'
        ));
    }

    public function indexPeriodeDaftarUjian()
    {
        $total = PeriodeDaftarUjian::all()->count();

        $daftar_periode_daftar_ujian = PeriodeDaftarUjian::orderBy('id', 'desc')->paginate(10);

        return view('semester-periode.index-periode-daftar-ujian', compact(
            'daftar_periode_daftar_ujian', 'total'  
        ));
    }

    public function createSemester()
    {
        return view('semester-periode.create-semester');
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

        return view('semester-periode.edit-semester', compact('semester'));
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
        return view('semester-periode.create-periode-daftar-turun-kp', compact('daftar_semester'));
    }

    public function storePeriodeDaftarTurunKp(Request $request)
    {
        PeriodeDaftarTurunKp::create($request->all());
        Session::flash('pesan', '1 Periode Daftar Turun Kerja Praktek berhasil ditambahkan');
        return redirect('semester-periode/periode-daftar-turun-kp');
    }

    public function editPeriodeDaftarTurunKp($id)
    {
        $daftar_semester = Semester::pluck('nama', 'id');
        $periode_daftar_turun_kp = PeriodeDaftarTurunKp::findOrFail($id);

        return view('semester-periode.edit-periode-daftar-turun-kp', compact('daftar_semester', 'periode_daftar_turun_kp'));
    }

    public function updatePeriodeDaftarTurunKp(Request $request, $id)
    {
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

        return view('semester-periode.create-periode-daftar-usulan-topik', compact('daftar_semester'));
    }

    public function storePeriodeDaftarUsulanTopik(Request $request)
    {
        PeriodeDaftarUsulanTopik::create($request->all());
        Session::flash('pesan', '1 Periode Daftar Usulan Topik berhasil ditambahkan');
        return redirect('semester-periode/periode-daftar-usulan-topik');
    }

    public function editPeriodeDaftarUsulanTopik($id)
    {
        $daftar_semester = Semester::pluck('nama', 'id');
        $periode_daftar_usulan_topik = PeriodeDaftarUsulanTopik::findOrFail($id);

        return view('semester-periode.edit-periode-daftar-usulan-topik', compact('daftar_semester', 'periode_daftar_usulan_topik'));
    }

    public function updatePeriodeDaftarUsulanTopik(Request $request, $id)
    {
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

        return view('semester-periode.create-periode-daftar-ujian', compact('daftar_semester'));
    }

    public function storePeriodeDaftarUjian(Request $request)
    {
        PeriodeDaftarUjian::create($request->all());
        Session::flash('pesan', '1 Periode Daftar Ujian berhasil ditambahkan');
        return redirect('semester-periode/periode-daftar-ujian');
    }

    public function editPeriodeDaftarUjian($id)
    {
        $daftar_semester = Semester::pluck('nama', 'id');
        $periode_daftar_ujian = PeriodeDaftarUjian::findOrFail($id);

        return view('semester-periode.edit-periode-daftar-ujian', compact('daftar_semester', 'periode_daftar_ujian'));
    }

    public function updatePeriodeDaftarUjian(Request $request, $id)
    {
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
