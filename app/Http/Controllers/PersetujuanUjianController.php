<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PersetujuanUjian;
use Session;
use Validator;
use PDF;

class PersetujuanUjianController extends Controller
{
    public function __construct(){
        $this->middleware('mahasiswa', ['only' => [
            'index', 'create', 'store', 'destroy', 'cetak'
        ]]);

        $this->middleware('dosen', ['only' => [
            'indexDosen', 'cariDosen', 'indexDosenByTanggal', 'disetujui', 'tidakDisetujui',
        ]]);

        $this->middleware('pimpinan', ['only' => [
            'indexSemua', 'cariSemua', 'indexSemuaByTanggal', 'disetujuiAdmin', 'tidakDisetujuiAdmin',
        ]]);
    }

    // mahasiswa
    public function index()
    {
        $daftar_persetujuan = PersetujuanUjian::where('id_mahasiswa', Session::get('id'))->orderBy('id', 'desc')->paginate(10);
        $bottom_detail = true;
        return view('persetujuan-ujian.index', compact('daftar_persetujuan', 'bottom_detail'));
    }

    // dosen
    public function indexDosen()
    {
        $daftar_persetujuan = PersetujuanUjian::where('dosbing_satu_aproval', Session::get('id'))->orWhere('dosbing_dua_aproval', Session::get('id'))->selectRaw('MONTH(created_at) bulan, YEAR(created_at) tahun, count(*) total')->groupBy('bulan', 'tahun')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->limit(12)->get();
        
        $bottom_detail = true;

        return view('persetujuan-ujian.index-dosen', compact('daftar_persetujuan', 'bottom_detail'));
    }

    public function indexDosenByTanggal($tanggal)
    {
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        $daftar_persetujuan = PersetujuanUjian::where('dosbing_satu_aproval', Session::get('id'))->orWhere('dosbing_dua_aproval', Session::get('id'))->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->orderBy('created_at', 'desc')->paginate(10);

        $total = PersetujuanUjian::where('dosbing_satu_aproval', Session::get('id'))->orWhere('dosbing_dua_aproval', Session::get('id'))->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->orderBy('created_at', 'desc')->count();

        $bottom_detail = true;
        
        return view('persetujuan-ujian.detail-tanggal-dosen', compact('daftar_persetujuan', 'bulan', 'tahun', 'tanggal', 'bottom_detail', 'total'));
    }

    // dosen
    public function cariDosen(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $ujian = trim($request->input('ujian'));
        $pembimbing = trim($request->input('pembimbing'));

      if(!empty($nama) || !empty($nim) || !empty($ujian) || !empty($pembimbing)){

          if(!empty($nama)){
            $query = PersetujuanUjian::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                $query->where('nama', 'like', '%' . $nama . '%');
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            });
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
            if($pembimbing === 'utama'){
                $query->where('dosbing_satu_aproval', Session::get('id'));
            }elseif($pembimbing === 'pendamping'){
                $query->where('dosbing_dua_aproval', Session::get('id'));
            }
          }elseif(!empty($nim)){
            $query = PersetujuanUjian::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                $query->where('nim', 'like', '%' . $nim . '%');
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            });
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
            if($pembimbing === 'utama'){
                $query->where('dosbing_satu_aproval', Session::get('id'));
            }elseif($pembimbing === 'pendamping'){
                $query->where('dosbing_dua_aproval', Session::get('id'));
            }
          }elseif(!empty($ujian)){
            $query = PersetujuanUjian::with('mahasiswa')->where('ujian', $ujian)->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            });
            if($pembimbing === 'utama'){
                $query->where('dosbing_satu_aproval', Session::get('id'));
            }elseif($pembimbing === 'pendamping'){
                $query->where('dosbing_dua_aproval', Session::get('id'));
            } 
          }elseif(!empty($pembimbing)){
            $query = PersetujuanUjian::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            });
            if($pembimbing === 'utama'){
                $query->where('dosbing_satu_aproval', Session::get('id'));
            }elseif($pembimbing === 'pendamping'){
                $query->where('dosbing_dua_aproval', Session::get('id'));
            }
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
          }

          $total = $query->count();
          $daftar_persetujuan = $query->orderBy('id', 'desc')->paginate(10);

          $pagination = (!empty($nama)) ? $daftar_persetujuan->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_persetujuan->appends(['nim' => $nim]) : '';
          $pagination = (!empty($ujian)) ? $daftar_persetujuan->appends(['ujian' => $ujian]) : '';
          $pagination = (!empty($pembimbing)) ? $daftar_persetujuan->appends(['pembimbing' => $pembimbing]) : '';
          $pagination = $daftar_persetujuan->appends($request->except('page'));

        return view('persetujuan-ujian.index-dosen', compact('daftar_persetujuan', 'total', 'pagination', 'nama', 'nim', 'ujian', 'pembimbing'));
      }
        return redirect('persetujuan-ujian/mahasiswa');
    }

    // pimpinan
    public function indexSemua()
    {
        $daftar_persetujuan = PersetujuanUjian::selectRaw('MONTH(created_at) bulan, YEAR(created_at) tahun, count(*) total')->groupBy('bulan', 'tahun')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->limit(12)->get();

        $bottom_detail = true;
        return view('persetujuan-ujian.index-admin', compact('daftar_persetujuan', 'bottom_detail'));
    }

    public function indexSemuaByTanggal($tanggal)
    {
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        $daftar_persetujuan = PersetujuanUjian::whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->orderBy('created_at', 'desc')->paginate(10);

        $total = PersetujuanUjian::whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->orderBy('created_at', 'desc')->count();

        $bottom_detail = true;
        
        return view('persetujuan-ujian.detail-tanggal-admin', compact('daftar_persetujuan', 'bulan', 'tahun', 'tanggal', 'bottom_detail', 'total'));
    }

    // pimpinan
    public function cariSemua(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $ujian = trim($request->input('ujian'));
        $dosbing_satu_aproval = trim($request->input('dosbing_satu_aproval'));
        $dosbing_dua_aproval = trim($request->input('dosbing_dua_aproval'));

      if(!empty($nama) || !empty($nim) || !empty($ujian) || !empty($pembimbing) || !empty($dosbing_dua_aproval) || !empty($dosbing_satu_aproval)){

          if(!empty($nama)){
            $query = PersetujuanUjian::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                $query->where('nama', 'like', '%' . $nama . '%');
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            });
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
            (!empty($dosbing_satu_aproval)) ? $query->where('dosbing_satu_aproval', $dosbing_satu_aproval) : '';
            (!empty($dosbing_dua_aproval)) ? $query->where('dosbing_dua_aproval', $dosbing_dua_aproval) : '';
          }elseif(!empty($nim)){
            $query = PersetujuanUjian::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                $query->where('nim', 'like', '%' . $nim . '%');
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            });
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
            (!empty($dosbing_satu_aproval)) ? $query->where('dosbing_satu_aproval', $dosbing_satu_aproval) : '';
            (!empty($dosbing_dua_aproval)) ? $query->where('dosbing_dua_aproval', $dosbing_dua_aproval) : '';
          }elseif(!empty($ujian)){
            $query = PersetujuanUjian::with('mahasiswa')->where('ujian', $ujian)->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            });
            (!empty($dosbing_satu_aproval)) ? $query->where('dosbing_satu_aproval', $dosbing_satu_aproval) : '';
            (!empty($dosbing_dua_aproval)) ? $query->where('dosbing_dua_aproval', $dosbing_dua_aproval) : ''; 
          }elseif(!empty($dosbing_satu_aproval)){
            $query = PersetujuanUjian::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            });
            $query->where('dosbing_satu_aproval', $dosbing_satu_aproval);
            (!empty($dosbing_dua_aproval)) ? $query->where('dosbing_dua_aproval', $dosbing_dua_aproval) : '';
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
          }elseif(!empty($dosbing_dua_aproval)){
            $query = PersetujuanUjian::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            });
            $query->where('dosbing_dua_aproval', $dosbing_dua_aproval);
            (!empty($dosbing_satu_aproval)) ? $query->where('dosbing_satu_aproval', $dosbing_satu_aproval) : '';
            (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
          }

          $total = $query->count();
          $daftar_persetujuan = $query->orderBy('id', 'desc')->paginate(10);
          $daftar_dosen = \App\Dosen::where('bisa_membimbing', 'ya')->pluck('nama', 'id');

          $pagination = (!empty($nama)) ? $daftar_persetujuan->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_persetujuan->appends(['nim' => $nim]) : '';
          $pagination = (!empty($ujian)) ? $daftar_persetujuan->appends(['ujian' => $ujian]) : '';
          $pagination = (!empty($dosbing_satu_aproval)) ? $daftar_persetujuan->appends(['dosbing_satu_aproval' => $dosbing_satu_aproval]) : '';
          $pagination = (!empty($dosbing_dua_aproval)) ? $daftar_persetujuan->appends(['dosbing_dua_aproval' => $dosbing_dua_aproval]) : '';
          $pagination = $daftar_persetujuan->appends($request->except('page'));

        return view('persetujuan-ujian.index-admin', compact('daftar_persetujuan', 'total', 'pagination', 'nama', 'nim', 'ujian', 'dosbing_dua_aproval', 'dosbing_satu_aproval', 'daftar_dosen'));
      }
        return redirect('persetujuan-ujian/semua');
    }

    // mahasiswa
    public function create()
    {
        $bottom_detail = true;
        return view('persetujuan-ujian.create', compact('bottom_detail'));
    }

    // mahasiswa
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'ujian' => 'required|in:proposal,hasil,kerja-praktek,sidang-skripsi',
        ]);
        if($validasi->fails()){
            return redirect()->back()->withInput()->withErrors($validasi);
        }

        if($request->post('ujian') === 'proposal' || $request->post('ujian') === 'hasil' || $request->post('ujian') === 'sidang-skripsi'){
            $dosbing = \App\DosenPembimbingSkripsi::where('id_mahasiswa', Session::get('id'))->latest()->first();
            if(!$dosbing){
                Session::flash('kesalahan', 'Dosen Pembimbing Skripsi Anda Belum Tersedia!');
                return redirect()->back();
            }

            $judul = \App\PendaftarUsulanTopik::where('id_mahasiswa', Session::get('id'))->where('tahapan', 'diterima')->first() or null;
            if(empty($judul)) return redirect()->back()->withInput()->with('kesalahan', 'Usulan topik anda belum ada yang diterima, silahkan memasukan sendiri atau minta admin untuk memasukan usulan topik terlebih dahulu!');

            $persetujuan = new PersetujuanUjian;
            $persetujuan->ujian = $request->post('ujian');
            $persetujuan->id_mahasiswa = Session::get('id');
            $persetujuan->dosbing_satu_aproval = $dosbing->dosbing_satu_skripsi;
            $persetujuan->dosbing_dua_aproval = $dosbing->dosbing_dua_skripsi;
            $persetujuan->save();

            // notifikasi dosen pembimbing satu
            $notifikasiDosen = new \App\NotifikasiDosen;
            $notifikasiDosen->id_dosen = $dosbing->dosbing_satu_skripsi;
            $notifikasiDosen->link = 'persetujuan-ujian/mahasiswa';
            $notifikasiDosen->jenis = 'persetujuan-ujian';
            $notifikasiDosen->deskripsi = '<strong> ' . Session::get('nama') . '</strong> meminta persetujuan ujian <strong>'. ucwords(str_replace('-', ' ', $request->post('ujian'))) .'</strong> secara online.';
            $notifikasiDosen->save();
            
            // notifikasi dosen pembimbing dua
            $notifikasiDosen = new \App\NotifikasiDosen;
            $notifikasiDosen->id_dosen = $dosbing->dosbing_dua_skripsi;
            $notifikasiDosen->link = 'persetujuan-ujian/mahasiswa';
            $notifikasiDosen->jenis = 'persetujuan-ujian';
            $notifikasiDosen->deskripsi = '<strong> ' . Session::get('nama') . '</strong> meminta persetujuan ujian <strong>'. ucwords(str_replace('-', ' ', $request->post('ujian'))) .'</strong> secara online.';
            $notifikasiDosen->save();
        }elseif($request->post('ujian') === 'kerja-praktek'){
            $dosbing = \App\DosenPembimbingKp::where('id_mahasiswa', Session::get('id'))->latest()->first();
            if(!$dosbing){
                Session::flash('kesalahan', 'Dosen Pembimbing Kerja Praktek Anda Belum Tersedia!');
                return redirect()->back();
            }

            $persetujuan = new PersetujuanUjian;
            $persetujuan->ujian = $request->post('ujian');
            $persetujuan->id_mahasiswa = Session::get('id');
            $persetujuan->dosbing_satu_aproval = $dosbing->dosbing_satu_kp;
            $persetujuan->dosbing_dua_aproval = $dosbing->dosbing_dua_kp;
            $persetujuan->save();

            // notifikasi dosen pembimbing satu
            $notifikasiDosen = new \App\NotifikasiDosen;
            $notifikasiDosen->id_dosen = $dosbing->dosbing_satu_kp;
            $notifikasiDosen->link = 'persetujuan-ujian/mahasiswa';
            $notifikasiDosen->jenis = 'persetujuan-ujian';
            $notifikasiDosen->deskripsi = '<strong> ' . Session::get('nama') . '</strong> meminta persetujuan ujian <strong>'. ucwords(str_replace('-', ' ', $request->post('ujian'))) .'</strong> secara online.';
            $notifikasiDosen->save();

            // notifikasi dosen pembimbing dua
            $notifikasiDosen = new \App\NotifikasiDosen;
            $notifikasiDosen->id_dosen = $dosbing->dosbing_dua_kp;
            $notifikasiDosen->link = 'persetujuan-ujian/mahasiswa';
            $notifikasiDosen->jenis = 'persetujuan-ujian';
            $notifikasiDosen->deskripsi = '<strong> ' . Session::get('nama') . '</strong> meminta persetujuan ujian <strong>'. ucwords(str_replace('-', ' ', $request->post('ujian'))) .'</strong> secara online.';
            $notifikasiDosen->save();
        }

        Session::flash('pesan', 'Persetujuan Ujian Berhasil Diajukan');
        return redirect('persetujuan-ujian');
    }

    // mahasiswa
    public function destroy($id)
    {
        $persetujuan = PersetujuanUjian::findOrFail($id);
        $persetujuan->delete();
        Session::flash('pesan', '1 Persetujuan Ujian Berhasil Dihapus');
        return redirect('persetujuan-ujian');
    }

    // dosen
    public function disetujui(Request $request, $id)
    {
        $persetujuan = PersetujuanUjian::findOrFail($id);
        if($persetujuan->dosbing_satu_aproval === Session::get('id')) $persetujuan->status_dosbing_satu = 'disetujui';
        elseif($persetujuan->dosbing_dua_aproval === Session::get('id')) $persetujuan->status_dosbing_dua = 'disetujui';
        $persetujuan->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $persetujuan->id_mahasiswa;
        $notifikasiMahasiswa->link = 'persetujuan-ujian';
        $notifikasiMahasiswa->jenis = 'persetujuan-ujian';
        $notifikasiMahasiswa->deskripsi = 'Persetujuan ujian <strong>'. $persetujuan->ujian .'</strong> anda telah disetujui oleh Salah satu dosen pembimbing';
        $notifikasiMahasiswa->save();

        Session::flash('pesan', '1 Persetujuan Ujian Berhasil Disetujui');
        return redirect('persetujuan-ujian/mahasiswa/' . $request->tanggal);
    }

    // dosen
    public function tidakDisetujui(Request $request, $id)
    {
        $persetujuan = PersetujuanUjian::findOrFail($id);
        if($persetujuan->dosbing_satu_aproval === Session::get('id')) $persetujuan->status_dosbing_satu = 'tidak-disetujui';
        elseif($persetujuan->dosbing_dua_aproval === Session::get('id')) $persetujuan->status_dosbing_dua = 'tidak-disetujui';
        $persetujuan->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $persetujuan->id_mahasiswa;
        $notifikasiMahasiswa->link = 'persetujuan-ujian';
        $notifikasiMahasiswa->jenis = 'persetujuan-ujian';
        $notifikasiMahasiswa->deskripsi = 'Persetujuan ujian <strong>'. $persetujuan->ujian .'</strong> anda tidak disetujui oleh Salah satu dosen pembimbing';
        $notifikasiMahasiswa->save();

        Session::flash('pesan', '1 Persetujuan Ujian Tidak Disetujui');
        return redirect('persetujuan-ujian/mahasiswa/' . $request->tanggal);
    }

    // admin
    public function disetujuiAdmin(Request $request, $id)
    {
        // return $request->all();
        $persetujuan = PersetujuanUjian::findOrFail($id);
        if($persetujuan->dosbing_satu_aproval == $request->post('dosbing_satu_aproval')){
            $persetujuan->status_dosbing_satu = 'disetujui';
        }elseif($persetujuan->dosbing_dua_aproval == $request->post('dosbing_dua_aproval')){
            $persetujuan->status_dosbing_dua = 'disetujui';
        } 
        $persetujuan->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $persetujuan->id_mahasiswa;
        $notifikasiMahasiswa->link = 'persetujuan-ujian';
        $notifikasiMahasiswa->jenis = 'persetujuan-ujian';
        $notifikasiMahasiswa->deskripsi = 'Persetujuan ujian <strong>'. $persetujuan->ujian .'</strong> anda telah disetujui oleh Salah satu dosen pembimbing';
        $notifikasiMahasiswa->save();

        Session::flash('pesan', '1 Persetujuan Ujian Berhasil Disetujui');
        return redirect('persetujuan-ujian/semua/' . $request->tanggal);
    }

    // admin
    public function tidakDisetujuiAdmin(Request $request, $id)
    {
        $persetujuan = PersetujuanUjian::findOrFail($id);
        if($persetujuan->dosbing_satu_aproval == $request->post('dosbing_satu_aproval')) $persetujuan->status_dosbing_satu = 'tidak-disetujui';
        elseif($persetujuan->dosbing_dua_aproval == $request->post('dosbing_dua_aproval')) $persetujuan->status_dosbing_dua = 'tidak-disetujui';
        $persetujuan->save();

        // notifikasi mahasiswa
        $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
        $notifikasiMahasiswa->id_mahasiswa = $persetujuan->id_mahasiswa;
        $notifikasiMahasiswa->link = 'persetujuan-ujian';
        $notifikasiMahasiswa->jenis = 'persetujuan-ujian';
        $notifikasiMahasiswa->deskripsi = 'Persetujuan ujian <strong>'. $persetujuan->ujian .'</strong> anda tidak disetujui oleh Salah satu dosen pembimbing';
        $notifikasiMahasiswa->save();

        Session::flash('pesan', '1 Persetujuan Ujian Tidak Disetujui');
        return redirect('persetujuan-ujian/semua/' . $request->tanggal);
    }

    // mahasiswa
    public function cetak($id)
    {
        $persetujuan = PersetujuanUjian::findOrFail($id);
        if($persetujuan->status_dosbing_dua !== 'disetujui' || $persetujuan->status_dosbing_satu !== 'disetujui'){
            Session::flash('kesalahan', 'Dosen Pembimbing Belum Menyetujui Ujian Anda!');
            return redirect()->back();
        }
        $judul = \App\PendaftarUsulanTopik::where('id_mahasiswa', Session::get('id'))->where('tahapan', 'diterima')->first() or null;
        $pdf = PDF::loadView('persetujuan-ujian/lembar-persetujuan-ujian', compact('persetujuan', 'judul'));
        return $pdf->download('Lembar Persetujuan Ujian '.$persetujuan->ujian.' - '.$persetujuan->mahasiswa->nama.'.pdf');
    }
    
}
