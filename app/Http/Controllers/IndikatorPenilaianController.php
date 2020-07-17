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
        $daftar_penilaian = IndikatorPenilaian::latest()->paginate(10);

        return view('indikator-penilaian.index', compact('daftar_penilaian', 'total'));
    }

    public function create()
    {
        return view('indikator-penilaian.create');
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

        return view('indikator-penilaian.edit', compact('penilaian'));
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
