<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asistensi;
use App\DetailAsistensi;
use Session;
use Validator;

class AsistensiController extends Controller
{
    public function __construct(){
        $this->middleware('mahasiswa', ['only' => [
            'index', 'createSkripsi', 'createKp', 'store', 'destroy'
        ]]);

        $this->middleware('dosen', ['only' => [
            'indexDosen', 'cariDosen'
        ]]);

        $this->middleware('pimpinan', ['only' => [
            'indexSemua', 'cariSemua'
        ]]);

        $this->middleware('pengguna', ['only' => [
            'show'
        ]]);

        $this->middleware('mahasiswaDosen', ['only' => [
            'tambahKomentar', 'komentar'
        ]]);

    }

    // mahasiswa
    public function index()
    {
        $daftar_asistensi = Asistensi::where('id_mahasiswa', Session::get('id'))->orderBy('id', 'desc')->paginate(10);
        return view('asistensi.index', compact('daftar_asistensi'));
    }

    // dosen
    public function indexDosen()
    {
        $daftar_asistensi = Asistensi::where('id_dosen', Session::get('id'))->orderBy('id', 'desc')->paginate(10);
        $total = Asistensi::where('id_dosen', Session::get('id'))->count();
        return view('asistensi.index-dosen', compact('daftar_asistensi', 'total'));
    }

    // dosen
    public function cariDosen(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $topik_bimbingan = trim($request->input('topik_bimbingan'));
        $jenis = trim($request->input('jenis'));

      if(!empty($nama) || !empty($nim) || !empty($topik_bimbingan) || !empty($jenis)){

          if(!empty($nama)){
            $query = Asistensi::with('mahasiswa')->where('id_dosen', Session::get('id'))->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                $query->where('nama', 'like', '%' . $nama . '%');
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            });
            (!empty($topik_bimbingan)) ? $query->where('topik_bimbingan', 'like', '%' . $topik_bimbingan . '%') : '';
            (!empty($jenis)) ? $query->where('jenis', $jenis) : '';
          }elseif(!empty($nim)){
            $query = Asistensi::with('mahasiswa')->where('id_dosen', Session::get('id'))->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                $query->where('nim', 'like', '%' . $nim . '%');
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            });
            (!empty($topik_bimbingan)) ? $query->where('topik_bimbingan', 'like', '%' . $topik_bimbingan . '%') : '';
            (!empty($jenis)) ? $query->where('jenis', $jenis) : '';
          }elseif(!empty($topik_bimbingan)){
            $query = Asistensi::with('mahasiswa')->where('id_dosen', Session::get('id'))->where('topik_bimbingan', 'like', '%' . $topik_bimbingan . '%')->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            });
            (!empty($jenis)) ? $query->where('jenis', $jenis) : '';
          }elseif(!empty($jenis)){
            $query = Asistensi::with('mahasiswa')->where('jenis', $jenis)->where('id_dosen', Session::get('id'))->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            });
            (!empty($topik_bimbingan)) ? $query->where('topik_bimbingan', 'like', '%' . $topik_bimbingan . '%') : '';
          }

          $total = $query->count();
          $daftar_asistensi = $query->orderBy('id', 'desc')->paginate(10);

          $pagination = (!empty($nama)) ? $daftar_asistensi->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_asistensi->appends(['nim' => $nim]) : '';
          $pagination = (!empty($topik_bimbingan)) ? $daftar_asistensi->appends(['topik_bimbingan' => $topik_bimbingan]) : '';
          $pagination = (!empty($jenis)) ? $daftar_asistensi->appends(['topik_bimbingan' => $topik_bimbingan]) : '';
          $pagination = $daftar_asistensi->appends($request->except('page'));

        return view('asistensi.index-dosen', compact('daftar_asistensi', 'total', 'pagination', 'nama', 'nim', 'topik_bimbingan', 'jenis'));
      }
        return redirect('asistensi/mahasiswa');
    }

    // pimpinan
    public function indexSemua()
    {
        $daftar_asistensi = Asistensi::orderBy('id', 'desc')->paginate(10);
        $total = Asistensi::all()->count();
        $daftar_dosen = \App\Dosen::where('bisa_membimbing', 'ya')->pluck('nama', 'id');

        return view('asistensi.index-admin', compact('daftar_asistensi', 'total', 'daftar_dosen'));
    }

    // pimpinan
    public function cariSemua(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $id_dosen = trim($request->input('id_dosen'));
        $topik_bimbingan = trim($request->input('topik_bimbingan'));
        $jenis = trim($request->input('jenis'));

      if(!empty($nama) || !empty($nim) || !empty($id_dosen) || !empty($topik_bimbingan) || !empty($jenis)){

          if(!empty($nama)){
            $query = Asistensi::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                $query->where('nama', 'like', '%' . $nama . '%');
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            });
            (!empty($id_dosen)) ? $query->where('id_dosen', $id_dosen) : '';
            (!empty($topik_bimbingan)) ? $query->where('topik_bimbingan', 'like', '%' . $topik_bimbingan . '%') : '';
            (!empty($jenis)) ? $query->where('jenis', $jenis) : '';
          }elseif(!empty($nim)){
            $query = Asistensi::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                $query->where('nim', 'like', '%' . $nim . '%');
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            });
            (!empty($id_dosen)) ? $query->where('id_dosen', $id_dosen) : '';
            (!empty($topik_bimbingan)) ? $query->where('topik_bimbingan', 'like', '%' . $topik_bimbingan . '%') : '';
            (!empty($jenis)) ? $query->where('jenis', $jenis) : '';
          }elseif(!empty($id_dosen)){
            $query = Asistensi::with('mahasiswa')->where('id_dosen', $id_dosen)->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            });
            (!empty($topik_bimbingan)) ? $query->where('topik_bimbingan', 'like', '%' . $topik_bimbingan . '%') : '';
            (!empty($jenis)) ? $query->where('jenis', $jenis) : '';
          }elseif(!empty($topik_bimbingan)){
            $query = Asistensi::with('mahasiswa')->where('topik_bimbingan', 'like', '%' . $topik_bimbingan . '%')->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            });
            (!empty($id_dosen)) ? $query->where('id_dosen', $id_dosen) : '';
            (!empty($jenis)) ? $query->where('jenis', $jenis) : '';
          }elseif(!empty($jenis)){
            $query = Asistensi::with('mahasiswa')->where('jenis', $jenis)->whereHas('mahasiswa', function ($query) use ($nim, $nama){
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            });
            (!empty($id_dosen)) ? $query->where('id_dosen', $id_dosen) : '';
            (!empty($topik_bimbingan)) ? $query->where('topik_bimbingan', 'like', '%' . $topik_bimbingan . '%') : '';
          }

          $total = $query->count();
          $daftar_asistensi = $query->orderBy('id', 'desc')->paginate(10);

          $pagination = (!empty($nama)) ? $daftar_asistensi->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_asistensi->appends(['nim' => $nim]) : '';
          $pagination = (!empty($id_dosen)) ? $daftar_asistensi->appends(['id_dosen' => $id_dosen]) : '';
          $pagination = (!empty($topik_bimbingan)) ? $daftar_asistensi->appends(['topik_bimbingan' => $topik_bimbingan]) : '';
          $pagination = (!empty($jenis)) ? $daftar_asistensi->appends(['topik_bimbingan' => $topik_bimbingan]) : '';
          $pagination = $daftar_asistensi->appends($request->except('page'));

        $daftar_dosen = \App\Dosen::where('bisa_membimbing', 'ya')->pluck('nama', 'id');

        return view('asistensi.index-admin', compact('daftar_asistensi', 'daftar_dosen', 'total', 'pagination', 'nama', 'id_dosen', 'nim', 'topik_bimbingan', 'jenis'));
      }
        return redirect('asistensi/semua');
    }

    // mahasiswa
    public function createSkripsi(Request $request)
    {
        $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));

        if($mahasiswa->kontrak_skripsi === 'tidak'){
            return redirect()->back()->with('kesalahan', 'Anda belum mengontrak Mata Kuliah Skripsi');
        }

        if(empty($mahasiswa->id_dosen)){
            return redirect()->back()->with('kesalahan', 'Dosen Pendamping Akademik anda masih kosong, silahkan lengkapi Profil anda terlebih dahulu');
        }

        if(empty($mahasiswa->id_prodi)){
            return redirect()->back()->with('kesalahan', 'Program Studi anda masih kosong, silahkan lengkapi Profil anda terlebih dahulu');
        }

        $dosbing = \App\DosenPembimbingSkripsi::where('id_mahasiswa', Session::get('id'))->get()->last();
        if(!$dosbing){
            Session::flash('kesalahan', 'Dosen Pembimbing Skripsi anda belum tersedia!');
            return redirect()->back();
        }

        $daftar_dosen = \App\Dosen::whereIn('id', [$dosbing->dosbing_satu_skripsi, $dosbing->dosbing_dua_skripsi])->pluck('nama', 'id');

        $pengaturan = \App\Pengaturan::find(1);

        return view('asistensi.create-skripsi', compact('daftar_dosen', 'pengaturan'));
    }

    // mahasiswa
    public function createKp(Request $request)
    {
        $mahasiswa = \App\Mahasiswa::findOrFail(Session::get('id'));

        if($mahasiswa->kontrak_kp === 'tidak'){
            return redirect()->back()->with('kesalahan', 'Anda belum mengontrak Mata Kuliah Kerja Praktek');
        }

        if(empty($mahasiswa->id_dosen)){
            return redirect()->back()->with('kesalahan', 'Dosen Pendamping Akademik anda masih kosong, silahkan lengkapi Profil anda terlebih dahulu');
        }

        if(empty($mahasiswa->id_prodi)){
            return redirect()->back()->with('kesalahan', 'Program Studi anda masih kosong, silahkan lengkapi Profil anda terlebih dahulu');
        }

        $dosbing = \App\DosenPembimbingKp::where('id_mahasiswa', Session::get('id'))->get()->last();
        if(!$dosbing){
            Session::flash('kesalahan', 'Dosen Pembimbing Kerja Praktek anda belum tersedia!');
            return redirect()->back();
        }

        $daftar_dosen = \App\Dosen::whereIn('id', [$dosbing->dosbing_satu_kp, $dosbing->dosbing_dua_kp])->pluck('nama', 'id');

        $pengaturan = \App\Pengaturan::find(1);

        return view('asistensi.create-kerja-praktek', compact('daftar_dosen', 'pengaturan'));
    }

    // mahasiswa
    public function store(Request $request)
    {
        $pengaturan = \App\Pengaturan::find(1);
        if($request->post('jenis') === 'skripsi'){
            $dosbing = \App\DosenPembimbingSkripsi::where('id_mahasiswa', Session::get('id'))->first();

            $validasi = Validator::make($request->all(), [
                'id_dosen' => 'required|in:' . $dosbing->dosbing_satu_skripsi .','.$dosbing->dosbing_dua_skripsi,
                'topik_bimbingan' => 'required|string|max:100',
                'isi' => 'required|string',
                'file' => 'sometimes|mimes:pdf|max:' . $pengaturan->max_file_upload,
            ]);

            if($validasi->fails()){
                return redirect()->back()->withInput()->withErrors($validasi);
            }
        }elseif($request->post('jenis') === 'kerja-praktek'){
            $dosbing = \App\DosenPembimbingKp::where('id_mahasiswa', Session::get('id'))->first();

            $validasi = Validator::make($request->all(), [
                'id_dosen' => 'required|in:' . $dosbing->dosbing_satu_kp .','.$dosbing->dosbing_dua_kp,
                'topik_bimbingan' => 'required|string|max:100',
                'isi' => 'required|string',
                'file' => 'sometimes|mimes:pdf|max:' . $pengaturan->max_file_upload,
            ]);

            if($validasi->fails()){
                return redirect()->back()->withInput()->withErrors($validasi);
            }
        }

        $asistensi = new Asistensi;
        $asistensi->topik_bimbingan = $request->post('topik_bimbingan');
        $asistensi->id_dosen = $request->post('id_dosen');
        $asistensi->jenis = $request->post('jenis');
        $asistensi->id_mahasiswa = Session::get('id');
        $asistensi->save();

        $detailAsistensi = new DetailAsistensi;
        $detailAsistensi->isi = $request->post('isi');
        $detailAsistensi->is_mahasiswa = '1';
        $detailAsistensi->id_asistensi = $asistensi->id;
        if($request->hasFile('file')){
            $detailAsistensi->file = $this->uploadFile($request);
        }
        $detailAsistensi->save();

        // notifikasi dosen
        $notifikasiDosen = new \App\NotifikasiDosen;
        $notifikasiDosen->id_dosen = $request->post('id_dosen');
        $notifikasiDosen->link = 'asistensi/' . $asistensi->id;
        $notifikasiDosen->jenis = 'asistensi';
        $notifikasiDosen->deskripsi = '<strong> ' . Session::get('nama') . '</strong> Ingin mengajukan asistensi <strong>'. ucwords(str_replace('-', ' ', $request->post('jenis'))) .'</strong> secara online dengan topik bimbingan : <strong>' . $request->post('topik_bimbingan') . '</strong>';
        $notifikasiDosen->save();

        Session::flash('pesan', 'Asistensi Berhasil Diajukan');
        return redirect('asistensi');
    }

    // pengguna
    public function show($id)
    {
        $asistensi = Asistensi::findOrFail($id);
        $detail_asistensi = $asistensi->detailAsistensi;
        $bottom_asistensi = true;
        return view('asistensi.detail', compact('asistensi', 'detail_asistensi', 'bottom_asistensi'));
    }

    // mahasiswa & dosen
    public function tambahKomentar($id)
    {
        $asistensi = Asistensi::findOrFail($id);

        // validasi
        if(Session::has('mahasiswa')){
            if(Session::get('id') !== $asistensi->id_mahasiswa) return redirect()->back()->withInput()->with('kesalahan', 'Anda Tidak Punya Akses Untuk Komentar Disini');
        }elseif(Session::has('dosen')){
            if(Session::get('id') !== $asistensi->id_dosen) return redirect()->back()->withInput()->with('kesalahan', 'Anda Tidak Punya Akses Untuk Komentar Disini');
        }

        $pengaturan = \App\Pengaturan::find(1);
        return view('asistensi.tambah-komentar', compact('pengaturan', 'asistensi'));
    }

    // mahasiswa & dosen
    public function komentar(Request $request, $id)
    {
        $asistensi = Asistensi::findOrFail($id);

        // validasi
        if(Session::has('mahasiswa')){
            if(Session::get('id') !== $asistensi->id_mahasiswa) return redirect()->back()->withInput()->with('kesalahan', 'Anda Tidak Punya Akses Untuk Komentar Disini');
        }elseif(Session::has('dosen')){
            if(Session::get('id') !== $asistensi->id_dosen) return redirect()->back()->withInput()->with('kesalahan', 'Anda Tidak Punya Akses Untuk Komentar Disini');
        }

        $pengaturan = \App\Pengaturan::find(1);
        $validasi = Validator::make($request->all(), [
            'isi' => 'required|string',
            'file' => 'sometimes|mimes:pdf|max:' . $pengaturan->max_file_upload,
        ]);

        if($validasi->fails()){
            return redirect()->back()->withInput()->withErrors($validasi);
        }

        $detailAsistensi = new DetailAsistensi;
        $detailAsistensi->isi = $request->post('isi');
        if(Session::has('mahasiswa')) $detailAsistensi->is_mahasiswa = '1';
        elseif(Session::has('dosen')) $detailAsistensi->is_dosen = '1';
        $detailAsistensi->id_asistensi = $id;
        if($request->hasFile('file')){
            $detailAsistensi->file = $this->uploadFile($request);
        }
        $detailAsistensi->save();

        if(Session::has('mahasiswa')){
            // notifikasi dosen
            $notifikasiDosen = new \App\NotifikasiDosen;
            $notifikasiDosen->id_dosen = $asistensi->id_dosen;
            $notifikasiDosen->link = 'asistensi/' . $asistensi->id;
            $notifikasiDosen->jenis = 'asistensi';
            $notifikasiDosen->deskripsi = '<strong> ' . Session::get('nama') . '</strong> memberikan komentar baru pada topik bimbingan : <strong>' . $asistensi->topik_bimbingan . '</strong>';
            $notifikasiDosen->save();
        }elseif(Session::has('dosen')){
            // notifikasi mahasiswa
            $notifikasiMahasiswa = new \App\NotifikasiMahasiswa;
            $notifikasiMahasiswa->id_mahasiswa = $asistensi->id_mahasiswa;
            $notifikasiMahasiswa->link = 'asistensi/' . $asistensi->id;
            $notifikasiMahasiswa->jenis = 'asistensi';
            $notifikasiMahasiswa->deskripsi = '<strong> ' . Session::get('nama') . '</strong> memberikan komentar baru pada topik bimbingan : <strong>' . $asistensi->topik_bimbingan . '</strong>';
            $notifikasiMahasiswa->save();
        }

        Session::flash('pesan', 'Komentar Berhasil Dikirim');
        return redirect('asistensi/' . $id);

    }

    // mahasiswa
    public function destroy($id)
    {
        $asistensi = Asistensi::findOrFail($id);
        $asistensi->delete();
        Session::flash('pesan', '1 Asistensi Berhasil Dihapus');
        return redirect('asistensi');
    }

    private function uploadFile(Request $request){
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        if($request->file('file')->isValid()){
          $file_name = date('YmdHis').".$ext";
          $upload_path = 'assets/asistensi';
          $request->file('file')->move($upload_path, $file_name);
          return $file_name;
        }
        return false;
    }

}
