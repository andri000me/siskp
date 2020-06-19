<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IndikatorPenilaian;
use Session;
use Validator;

class IndikatorPenilaianController extends Controller
{
    public function __construct()
    {
        $this->middleware('pimpinan');
    }

    public function index()
    {
        $total = IndikatorPenilaian::all()->count();
        $daftar_penilaian = IndikatorPenilaian::paginate(10);
        $bottom_detail = true;

        return view('indikator-penilaian.index', compact('daftar_penilaian', 'bottom_detail', 'total'));
    }

    public function create()
    {
        $bottom_detail = true;
        return view('indikator-penilaian.create', compact('bottom_detail'));
    }

    public function store(Request $request)
    {
        // validasi
        $validasi = Validator::make($request->all(), [
          'nama' => 'required|string|max:255',
          'bobot' => 'required|integer',
          'ujian' => 'required|in:proposal,hasil,sidang-skripsi,kerja-praktek',
          'nilai_min' => 'required|integer',
          'nilai_max' => 'required|integer',
        ]);

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        IndikatorPenilaian::create($request->all());
        Session::flash('pesan', '1 Indikator Penilaian Berhasil Ditambahkan');
        return redirect('pengaturan/penilaian');
    }

    public function edit($id)
    {
        $penilaian = IndikatorPenilaian::findOrFail($id);
        $bottom_detail = true;

        return view('indikator-penilaian.edit', compact('penilaian', 'bottom_detail'));
    }

    public function update(Request $request, $id)
    {
        // validasi
        $validasi = Validator::make($request->all(), [
          'nama' => 'required|string|max:255',
          'bobot' => 'required|integer',
          'ujian' => 'required|in:proposal,hasil,sidang-skripsi,kerja-praktek',
          'nilai_min' => 'required|integer',
          'nilai_max' => 'required|integer',
        ]);

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }
        
        $penilaian = IndikatorPenilaian::findOrFail($id);
        $penilaian->update($request->all());
        Session::flash('pesan', '1 Indikator Penilaian Berhasil Diupdate');
        return redirect('pengaturan/penilaian');
    }

    public function destroy($id)
    {
        $penilaian = IndikatorPenilaian::findOrFail($id);
        $penilaian->delete();
        Session::flash('pesan', '1 Indikator Penilaian Berhasil Dihapus');
        return redirect('pengaturan/penilaian');
    }
}
