<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RiwayatSkripsiExport;

class RiwayatSkripsiController extends Controller
{
    public function __construct()
    {
        $this->middleware('pengguna', ['only' => [
            'riwayatSkripsi', 'detailRiwayatSkripsi', 'riwayatSkripsiCari', 'riwayatSkripsiExport'   
        ]]);

        $this->middleware('pimpinan', ['only' => [
            'edit', 'updateJurnal' 
        ]]);
    }

    // pengguna
    public function riwayatSkripsi()
    {
        $pengaturan = \App\Pengaturan::find(1);
        $filter_riwayat = true;

        $daftar_pendaftar = \App\PendaftarUsulanTopik::where('tahapan', 'diterima')->paginate(10);
        $total = \App\PendaftarUsulanTopik::where('tahapan', 'diterima')->count();
        return view('riwayat-skripsi.riwayat-skripsi', compact('pengaturan', 'daftar_pendaftar', 'total', 'filter_riwayat'));
    }

    // pengguna
    public function detailRiwayatSkripsi($id)
    {
        $pengaturan = \App\Pengaturan::find(1);
        $mahasiswa = \App\Mahasiswa::findOrFail($id);

        return view('riwayat-skripsi.detail-riwayat-skripsi', compact('mahasiswa', 'pengaturan'));
    }

    // pengguna
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

          $filter_riwayat = true;

        return view('riwayat-skripsi.riwayat-skripsi', compact('pengaturan', 'daftar_pendaftar', 'total', 'pagination', 'nama', 'judul', 'nim', 'angkatan', 'tahapan_skripsi', 'filter_riwayat'));
      }
        return redirect('riwayat-skripsi');
    }

    // pengguna
    public function riwayatSkripsiExport(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $judul = trim($request->input('judul'));
        $tahapan_skripsi = trim($request->input('tahapan_skripsi'));

      return Excel::download(new RiwayatSkripsiExport($nama, $nim, $angkatan, $judul, $tahapan_skripsi), 'SISKP - Export Riwayat Skripsi.xlsx');
    }

    // admin
    public function edit($id)
    {
        $pengaturan = \App\Pengaturan::find(1);
        $mahasiswa = \App\Mahasiswa::find($id);
        $judul = \App\PendaftarUsulanTopik::where('id_mahasiswa', $id)->first();
        return view('revisi.edit-skripsi', compact('pengaturan', 'mahasiswa', 'judul'));
    }

    // admin
    public function update(Request $request)
    {
        $pengaturan = \App\Pengaturan::find(1);

        $validasi = Validator::make($request->all(), [
          'file_jurnal_skripsi' => 'sometimes|mimes:pdf|max:' . $pengaturan->max_file_upload,
          'usulan_judul' => 'required|string'
        ]);        

        if($validasi->fails()){
          return redirect()->back()->withInput()->withErrors($validasi);
        }

        $judul = \App\PendaftarUsulanTopik::find($request->post('id_pendaftar_usulan_topik'));
        $judul->usulan_judul = $request->post('usulan_judul');
        $judul->save();

        if($request->hasFile('file_jurnal_skripsi')){
            $input_jurnal = $request->post('file_jurnal_skripsi');
            $input_jurnal['id_mahasiswa'] = Session::get('id');

            $riwayat = \App\RiwayatSkripsi::where('id_mahasiswa', $request->post('id_mahasiswa'))->first();
            if($riwayat) $this->hapusJurnal($riwayat);
            $input_jurnal['file_jurnal_skripsi'] = $this->uploadJurnal($request);

            \App\RiwayatSkripsi::updateOrCreate(['id_mahasiswa' => $request->post('id_mahasiswa')], [
              'file_jurnal_skripsi' => $input_jurnal['file_jurnal_skripsi']
            ]);
        }

        Session::flash('pesan', 'Anda Berhasil Merevisi Judul & Jurnal Skripsi!');
        return redirect('riwayat-skripsi/' . $request->post('id_mahasiswa'));
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

}
