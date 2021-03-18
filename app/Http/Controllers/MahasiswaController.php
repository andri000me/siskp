<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MahasiswaRequest;
use Illuminate\Support\Facades\Hash;
use App\Mahasiswa;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MahasiswaExport;

class MahasiswaController extends Controller
{
    public function __construct(){
        $this->middleware('pimpinan', ['only' => [
            'index', 'destroy', 'cari', 'createImport', 'import', 'validasiKp', 'validasiSkripsi', 'validasiTahapanSkripsi', 'validasiTahapanKp', 'nonaktifkanSemuaLulus', 'export'
        ]]);

        $this->middleware('mahasiswaPimpinan', ['only' => [
            'update', 'edit'
        ]]);

        $this->middleware('pengguna', ['only' => [
            'show'
        ]]);
    }

    // pimpinan
    public function index()
    {
      $daftar_prodi = \App\Prodi::pluck('nama', 'id');
      $daftar_dosen = \App\Dosen::pluck('nama', 'id');

      if(Session::has('kaprodi')){
        $daftar_mahasiswa = Mahasiswa::where('id_prodi', Session::get('kaprodi'))->orderBy('nama', 'asc')->paginate(10);
      }else{
        $daftar_mahasiswa = Mahasiswa::orderBy('nama', 'asc')->paginate(10);
      }

      $total = Mahasiswa::all()->count();
      $filter_mahasiswa = true;

      return view('mahasiswa.index', compact('daftar_mahasiswa', 'total', 'daftar_prodi', 'daftar_dosen', 'filter_mahasiswa'));
    }

    // pimpinan
    public function show(Mahasiswa $mahasiswa)
    {
      $bisa_kp = \App\ProdiKp::where('id_prodi', $mahasiswa->id_prodi)->first() or null;
      return view('mahasiswa.detail', compact('mahasiswa', 'bisa_kp'));
    }

    // pimpinan
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        Session::flash('pesan', '1 Mahasiswa Berhasil Dihapus');
        return redirect('mahasiswa');
    }

    // pimpinan
    public function cari(Request $request)
    {
      $nama = trim($request->input('nama'));
      $nim = trim($request->input('nim'));
      $angkatan = trim($request->input('angkatan'));
      $tahapan_kp = trim($request->input('tahapan_kp'));
      $tahapan_skripsi = trim($request->input('tahapan_skripsi'));
      $id_dosen = trim($request->input('id_dosen'));
      $id_prodi = trim($request->input('id_prodi'));
      $kontrak_kp = trim($request->input('kontrak_kp'));
      $kontrak_skripsi = trim($request->input('kontrak_skripsi'));

      if(!empty($nama) || !empty($nim) || !empty($angkatan) || !empty($tahapan_kp) || !empty($tahapan_kp) || !empty($tahapan_skripsi) || !empty($id_dosen) || !empty($id_prodi) || !empty($kontrak_kp) || !empty($kontrak_skripsi)){

          if(!empty($nama)){
            $query = Mahasiswa::where('nama', 'like', '%' . $nama . '%');
            (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
            (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            (!empty($id_dosen)) ? $query->where('id_dosen', $id_dosen) : '';
            (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
            (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
          }elseif(!empty($nim)){
            $query = Mahasiswa::where('nim', 'like', '%' . $nim . '%');
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
            (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            (!empty($id_dosen)) ? $query->where('id_dosen', $id_dosen) : '';
            (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
            (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
          }elseif(!empty($angkatan)){
            $query = Mahasiswa::where('angkatan', $angkatan);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
            (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            (!empty($id_dosen)) ? $query->where('id_dosen', $id_dosen) : '';
            (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
            (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
          }elseif(!empty($tahapan_kp)){
            $query = Mahasiswa::where('tahapan_kp', $tahapan_kp);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            (!empty($id_dosen)) ? $query->where('id_dosen', $id_dosen) : '';
            (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
            (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
          }elseif(!empty($tahapan_skripsi)){
            $query = Mahasiswa::where('tahapan_skripsi', $tahapan_skripsi);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
            (!empty($id_dosen)) ? $query->where('id_dosen', $id_dosen) : '';
            (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
            (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
          }elseif(!empty($id_dosen)){
            $query = Mahasiswa::where('id_dosen', $id_dosen);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
            (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
            (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
          }elseif(!empty($id_prodi)){
            $query = Mahasiswa::where('id_prodi', $id_prodi);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
            (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            (!empty($id_dosen)) ? $query->where('id_dosen', $id_dosen) : '';
            (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
            (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
          }elseif(!empty($kontrak_kp)){
            $query = Mahasiswa::where('kontrak_kp', $kontrak_kp);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
            (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            (!empty($id_dosen)) ? $query->where('id_dosen', $id_dosen) : '';
            (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
          }elseif(!empty($kontrak_skripsi)){
            $query = Mahasiswa::where('kontrak_skripsi', $kontrak_skripsi);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
            (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            (!empty($id_dosen)) ? $query->where('id_dosen', $id_dosen) : '';
            (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
          }

          $total = $query->count();

          if(Session::has('kaprodi')){
            $daftar_mahasiswa = $query->where('id_prodi', Session::get('kaprodi'))->paginate(10);
          }else{
            $daftar_mahasiswa = $query->paginate(10);
          }

          $pagination = (!empty($nama)) ? $daftar_mahasiswa->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_mahasiswa->appends(['nim' => $nim]) : '';
          $pagination = (!empty($angkatan)) ? $daftar_mahasiswa->appends(['angkatan' => $angkatan]) : '';
          $pagination = (!empty($tahapan_kp)) ? $daftar_mahasiswa->appends(['tahapan_kp' => $tahapan_kp]) : '';
          $pagination = (!empty($tahapan_skripsi)) ? $daftar_mahasiswa->appends(['tahapan_skripsi' => $tahapan_skripsi]) : '';
          $pagination = (!empty($id_dosen)) ? $daftar_mahasiswa->appends(['id_dosen' => $id_dosen]) : '';
          $pagination = (!empty($id_prodi)) ? $daftar_mahasiswa->appends(['id_prodi' => $id_prodi]) : '';
          $pagination = (!empty($kontrak_kp)) ? $daftar_mahasiswa->appends(['kontrak_kp' => $kontrak_kp]) : '';
          $pagination = (!empty($kontrak_skripsi)) ? $daftar_mahasiswa->appends(['kontrak_skripsi' => $kontrak_skripsi]) : '';
          $pagination = $daftar_mahasiswa->appends($request->except('page'));

          $daftar_prodi = \App\Prodi::pluck('nama', 'id');
          $daftar_dosen = \App\Dosen::pluck('nama', 'id');

          $filter_mahasiswa = true;

          return view('mahasiswa.index', compact('daftar_mahasiswa', 'daftar_prodi', 'daftar_dosen', 'nama', 'nim', 'angkatan', 'tahapan_kp', 'tahapan_skripsi', 'id_dosen', 'id_prodi', 'kontrak_kp', 'kontrak_skripsi', 'pagination', 'total', 'filter_mahasiswa'));
      }
      return redirect('mahasiswa');
    }

    // pimpinan
    public function export(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $tahapan_kp = trim($request->input('tahapan_kp'));
        $tahapan_skripsi = trim($request->input('tahapan_skripsi'));
        $id_dosen = trim($request->input('id_dosen'));
        $id_prodi = trim($request->input('id_prodi'));
        $kontrak_kp = trim($request->input('kontrak_kp'));
        $kontrak_skripsi = trim($request->input('kontrak_skripsi'));

      return Excel::download(new MahasiswaExport($nama, $nim, $angkatan, $id_prodi, $id_dosen, $tahapan_kp, $tahapan_skripsi, $kontrak_kp, $kontrak_skripsi), 'SISKP - Export Mahasiswa.xlsx');
    }

    // pimpinan
    public function createImport()
    {
      $semua_prodi = \App\Prodi::all();

      if(blank($semua_prodi)) return redirect()->back()->with('kesalahan', 'Program Studi Harus Dimasukan Terlebih Dahulu Sebelum Mengimport Mahasiswa!');

      return view('mahasiswa.import');
    }

    // pimpinan
    public function createImportMaba()
    {
      $semua_prodi = \App\Prodi::all();

      if(blank($semua_prodi)) return redirect()->back()->with('kesalahan', 'Program Studi Harus Dimasukan Terlebih Dahulu Sebelum Mengimport Mahasiswa!');

      return view('mahasiswa.import-maba');
    }

    // pimpinan
    public function import(Request $request)
    {
      $file = $request->file('import');
      $fitur = $request->post('fitur');

      if(empty($file) || empty($fitur)) return redirect()->back()->with('kesalahan', 'Fitur Harus Dipilih dan/atau File Harus Diinput');

		  $nama_file = rand().$file->getClientOriginalName();
		  $file->move('assets/file', $nama_file);

      if($fitur === 'kontrak_skripsi'){
        Excel::import(new \App\Imports\MahasiswaImportSkripsi, 'assets/file/'.$nama_file);
        Session::flash('pesan','Berhasil Mengimport Mahasiswa Yang Mengontrak Mata Kuliah Skripsi!');
      }elseif($fitur === 'kontrak_kp'){
        Excel::import(new \App\Imports\MahasiswaImportKp, 'assets/file/'.$nama_file);
        Session::flash('pesan','Berhasil Mengimport Mahasiswa Yang Mengontrak Mata Kuliah Kerja Praktek!');
      }

      unlink('assets/file/'.$nama_file);

      return redirect('mahasiswa');
    }

    // pimpinan
    public function importMaba(Request $request)
    {
      $file = $request->file('import');

      if(empty($file)) return redirect()->back()->with('kesalahan', 'Fitur Harus Dipilih dan/atau File Harus Diinput');

		  $nama_file = rand().$file->getClientOriginalName();
		  $file->move('assets/file', $nama_file);

      Excel::import(new \App\Imports\MahasiswaImportMaba, 'assets/file/'.$nama_file);
      Session::flash('pesan','Berhasil Mengimport Mahasiswa Baru!');

      unlink('assets/file/'.$nama_file);

      return redirect('mahasiswa');
    }

    // pimpinan
    public function validasiKp(Request $request)
    {
        $mahasiswa = Mahasiswa::findOrFail($request->post('id'));
        $mahasiswa->kontrak_kp = $request->post('kontrak_kp');
        $mahasiswa->save();
        Session::flash('pesan','1 Mahasiswa Berhasil Divalidasi Kerja Prakteknya!');
        return redirect('mahasiswa/'.$mahasiswa->id);
    }

    // pimpinan
    public function validasiSkripsi(Request $request)
    {
        $mahasiswa = Mahasiswa::findOrFail($request->post('id'));
        $mahasiswa->kontrak_skripsi = $request->post('kontrak_skripsi');
        $mahasiswa->save();
        Session::flash('pesan','1 Mahasiswa Berhasil Divalidasi Skripsinya!');
        return redirect('mahasiswa/'.$mahasiswa->id);
    }

    // pimpinan
    public function validasiTahapanSkripsi(Request $request)
    {
        $mahasiswa = Mahasiswa::findOrFail($request->post('id'));
        $mahasiswa->tahapan_skripsi = $request->post('tahapan_skripsi');
        $mahasiswa->save();
        Session::flash('pesan','1 Mahasiswa Berhasil Divalidasi Tahapan Skripsinya!');
        return redirect('mahasiswa/'.$mahasiswa->id);
    }

    // pimpinan
    public function validasiTahapanKp(Request $request)
    {
        $mahasiswa = Mahasiswa::findOrFail($request->post('id'));
        $mahasiswa->tahapan_kp = $request->post('tahapan_kp');
        $mahasiswa->save();
        Session::flash('pesan','1 Mahasiswa Berhasil Divalidasi Tahapan Kerja Prakteknya!');
        return redirect('mahasiswa/'.$mahasiswa->id);
    }

    // mahasiswa & pimpinan
    public function edit(Mahasiswa $mahasiswa)
    {
      if(Session::has('mahasiswa') && $mahasiswa->id !== Session::get('id')){
        return redirect()->back()->with('kesalahan', 'Anda Tidak Boleh Mengedit Profil Mahasiswa Lain!');
      }
      $daftar_prodi = \App\Prodi::pluck('nama', 'id');
      $daftar_dosen = \App\Dosen::where('status', 'aktif')->pluck('nama', 'id');
      return view('mahasiswa.edit', compact('mahasiswa', 'daftar_prodi', 'daftar_dosen'));
    }

    // mahasiswa & pimpinan
    public function update(MahasiswaRequest $request, Mahasiswa $mahasiswa)
    {
        if(Session::has('mahasiswa') && $mahasiswa->id !== Session::get('id')){
          return redirect()->back()->with('kesalahan', 'Anda Tidak Boleh Mengedit Profil Mahasiswa Lain!');
        }

        if(!empty($request->input('password'))) $mahasiswa->password = Hash::make($request->input('password'));
        $mahasiswa->nama = $request->input('nama');
        $mahasiswa->nim = $request->input('nim');
        $mahasiswa->angkatan = $request->input('angkatan');
        $mahasiswa->id_dosen = $request->input('id_dosen');
        $mahasiswa->id_prodi = $request->input('id_prodi');
        $mahasiswa->save();

        if (!Hash::check($mahasiswa->nim, $mahasiswa->password)) Session::forget('default_password');
        else Session::put('default_password', true);

        $prodi_kp = \App\ProdiKp::where('id_prodi', $mahasiswa->id_prodi)->first();
        if($prodi_kp) Session::put('bisa_kp', true);
        else Session::forget('bisa_kp');

        if(!Session::has('admin')){
          Session::forget('nama');
          Session::put('nama', $request->input('nama'));
        }
        Session::flash('pesan', '1 mahasiswa Berhasil Diupdate');
        if(Session::has('mahasiswa')) return redirect('profil');
        else return redirect('mahasiswa/' . $mahasiswa->id);
    }

    // pimpinan
    public function nonaktifkanSemuaLulus(Request $request)
    {
        $prodi_kp = \App\ProdiKp::pluck('id_prodi');

        Mahasiswa::where('tahapan_skripsi', 'lulus')->update([
          'kontrak_skripsi' => 'tidak',
        ]);

        Mahasiswa::where('tahapan_skripsi', 'lulus')->whereIn('id_prodi', $prodi_kp)->update([
          'tahapan_kp' => 'lulus'
        ]);

        Mahasiswa::where('tahapan_kp', 'lulus')->update([
          'kontrak_kp' => 'tidak'
        ]);

        Session::flash('pesan', 'Semua Mahasiswa yang telah lulus Berhasil Di Nonaktifkan Status Kontrak Skripsi & Kontrak Kerja Prakteknya');
        return redirect('mahasiswa');
    }

}
