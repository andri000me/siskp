<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DosenRequest;
use Illuminate\Support\Facades\Hash;
use App\Dosen;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DosenExport;
use App\Imports\DosenImport;
use App\Exports\AkademikExport;
use App\Exports\SkripsiExport;
use App\Exports\KerjaPraktekExport;
use App\Exports\PengujianExport;

class DosenController extends Controller
{
    public function __construct(){
        $this->middleware('pimpinan', ['only' => [
            'index', 'destroy', 'cari', 'createImport', 'import', 'export', 'validasiStatus', 'bisaMenguji', 'bisaMembimbing', 'create', 'store'
        ]]);

        $this->middleware('dosenPimpinan', ['only' => [
            'update', 'edit', 'show', 'detailByDosen'
        ]]);

        $this->middleware('dosen', ['only' => [
            'akademik', 'skripsi', 'kerjaPraktek', 'pengujian', 'akademikCari', 'skripsiCari', 'kerjaPraktekCari', 'pengujianCari', 'akademikExport', 'pengujianExport', 'kerjaPraktekExport', 'skripsiExport', 'pengujianByTanggal'
        ]]);
    }

    // pimpinan
    public function index()
    {
        $total_dosen = Dosen::count();
        $filter_dosen = true;

        $daftar_dosen = Dosen::latest('nip')->paginate(10);
        $daftar_prodi = \App\Prodi::pluck('nama', 'id');

        return view('dosen.index', compact('daftar_dosen', 'total_dosen', 'daftar_prodi', 'filter_dosen'));
    }

    // dosen & pimpinan
    public function show(Dosen $dosen)
    {
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
    }

    // pimpinan
    public function destroy(Dosen $dosen)
    {
        $dosen->delete();
        Session::flash('pesan', '1 Dosen Berhasil Dihapus');
        return redirect('dosen');
    }

    // pimpinan
    public function cari(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nip = trim($request->input('nip'));
        $prodi = trim($request->input('id_prodi'));
        $status = trim($request->input('status'));
        $bisa_menguji = trim($request->input('bisa_menguji'));
        $bisa_membimbing = trim($request->input('bisa_membimbing'));

      if(!empty($nama) || !empty($nip) || !empty($prodi) || !empty($status) || !empty($bisa_menguji) || !empty($bisa_membimbing)){

          if(!empty($nama)){
            $query = Dosen::where('nama', 'like', '%' . $nama . '%');
            (!empty($nip)) ? $query->where('nip', 'like', '%' . $nip . '%') : '';
            (!empty($prodi)) ? $query->where('id_prodi', $prodi) : '';
            (!empty($status)) ? $query->where('status', $status) : '';
            (!empty($bisa_menguji)) ? $query->where('bisa_menguji', $bisa_menguji) : '';
            (!empty($bisa_membimbing)) ? $query->where('bisa_membimbing', $bisa_membimbing) : '';
          }elseif(!empty($nip)){
            $query = Dosen::where('nip', 'like', '%' . $nip . '%');
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($prodi)) ? $query->where('id_prodi', $prodi) : '';
            (!empty($status)) ? $query->where('status', $status) : '';
            (!empty($bisa_menguji)) ? $query->where('bisa_menguji', $bisa_menguji) : '';
            (!empty($bisa_membimbing)) ? $query->where('bisa_membimbing', $bisa_membimbing) : '';
          }elseif(!empty($prodi)){
            $query = Dosen::where('id_prodi', $prodi);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nip)) ? $query->where('nip', 'like', '%' . $nip . '%') : '';
            (!empty($status)) ? $query->where('status', $status) : '';
            (!empty($bisa_menguji)) ? $query->where('bisa_menguji', $bisa_menguji) : '';
            (!empty($bisa_membimbing)) ? $query->where('bisa_membimbing', $bisa_membimbing) : '';
          }elseif(!empty($status)){
            $query = Dosen::where('status', $status);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nip)) ? $query->where('nip', 'like', '%' . $nip . '%') : '';
            (!empty($prodi)) ? $query->where('prodi', $prodi) : '';
            (!empty($bisa_menguji)) ? $query->where('bisa_menguji', $bisa_menguji) : '';
            (!empty($bisa_membimbing)) ? $query->where('bisa_membimbing', $bisa_membimbing) : '';
          }elseif(!empty($bisa_menguji)){
            $query = Dosen::where('bisa_menguji', $bisa_menguji);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nip)) ? $query->where('nip', 'like', '%' . $nip . '%') : '';
            (!empty($prodi)) ? $query->where('prodi', $prodi) : '';
            (!empty($status)) ? $query->where('status', $status) : '';
            (!empty($bisa_membimbing)) ? $query->where('bisa_membimbing', $bisa_membimbing) : '';
          }elseif(!empty($bisa_membimbing)){
            $query = Dosen::where('bisa_membimbing', $bisa_membimbing);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nip)) ? $query->where('nip', 'like', '%' . $nip . '%') : '';
            (!empty($prodi)) ? $query->where('prodi', $prodi) : '';
            (!empty($status)) ? $query->where('status', $status) : '';
            (!empty($bisa_menguji)) ? $query->where('bisa_menguji', $bisa_menguji) : '';
          }

          $total_dosen = $query->count();
          $daftar_dosen = $query->paginate(10);

          $pagination = (!empty($nama)) ? $daftar_dosen->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nip)) ? $daftar_dosen->appends(['nip' => $nip]) : '';
          $pagination = (!empty($prodi)) ? $daftar_dosen->appends(['id_prodi' => $prodi]) : '';
          $pagination = (!empty($status)) ? $daftar_dosen->appends(['status' => $status]) : '';
          $pagination = (!empty($bisa_menguji)) ? $daftar_dosen->appends(['bisa_menguji' => $bisa_menguji]) : '';
          $pagination = (!empty($bisa_membimbing)) ? $daftar_dosen->appends(['bisa_membimbing' => $bisa_membimbing]) : '';
          $pagination = $daftar_dosen->appends($request->except('page'));

          $daftar_prodi = \App\Prodi::pluck('nama', 'id');

          $filter_dosen = true;

          return view('dosen.index', compact('daftar_dosen', 'daftar_prodi', 'nama', 'nip', 'prodi', 'status', 'bisa_menguji', 'bisa_membimbing', 'pagination', 'total_dosen', 'filter_dosen'));
        }
        return redirect('dosen');
    }

    // pimpinan
    public function createImport()
    {
      $prodi = \App\Prodi::all();
      if(blank($prodi)) return redirect()->back()->with('kesalahan', 'Anda belum memasukan Program Studi');

      return view('dosen.import');
    }

    // pimpinan
    public function import(Request $request)
    {
		  $this->validate($request, [
			  'import_status' => 'required|mimes:csv,xls,xlsx,csv'
      ]);
		  $file = $request->file('import_status');
      $nama_file = rand().$file->getClientOriginalName();
      $file->move('assets/file',$nama_file);
		  Excel::import(new DosenImport, 'assets/file/'.$nama_file);
      unlink('assets/file/'.$nama_file);
	    Session::flash('pesan', 'Semua Dosen Berhasil Divalidasi Keatifannya!');
      return redirect('dosen');
    }

    // pimpinan
    public function export(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nip = trim($request->input('nip'));
        $id_prodi = trim($request->input('id_prodi'));
        $status = trim($request->input('status'));
        $bisa_menguji = trim($request->input('bisa_menguji'));
        $bisa_membimbing = trim($request->input('bisa_membimbing'));

      return Excel::download(new DosenExport($nama, $nip, $id_prodi, $status, $bisa_menguji, $bisa_membimbing), 'SISKP - Export Dosen.xlsx');
    }

    // pimpinan
    public function validasiStatus(Request $request)
    {
        $dosen = Dosen::findOrFail($request->post('id'));
        $dosen->status = $request->post('status');
        $dosen->save();
        Session::flash('pesan','1 Dosen Berhasil Divalidasi Statusnya!');
        return redirect('dosen/'.$dosen->id);
    }

    // pimpinan
    public function bisaMenguji(Request $request)
    {
        $dosen = Dosen::findOrFail($request->post('id'));
        $dosen->bisa_menguji = $request->post('bisa_menguji');
        $dosen->save();
        Session::flash('pesan','1 Dosen Berhasil Divalidasi Status Pengujinya!');
        return redirect('dosen/'.$dosen->id);
    }

    // pimpinan
    public function bisaMembimbing(Request $request)
    {
        $dosen = Dosen::findOrFail($request->post('id'));
        $dosen->bisa_membimbing = $request->post('bisa_membimbing');
        $dosen->save();
        Session::flash('pesan','1 Dosen Berhasil Divalidasi Status Pembimbingnya!');
        return redirect('dosen/'.$dosen->id);
    }

    // dosen & pimpinan
    public function edit(Dosen $dosen)
    {
      if(Session::has('dosen') && $dosen->id !== Session::get('id')){
        return redirect()->back()->with('kesalahan', 'Anda Tidak Boleh Mengedit Profil Dosen Lain!');
      }

      $daftar_prodi = \App\Prodi::pluck('nama', 'id');

      if(Session::has('dosen') && Session::get('id') === $dosen->id){
        return view('dosen.edit', compact('dosen', 'daftar_prodi'));
      }elseif(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi')){
        return view('dosen.edit', compact('dosen', 'daftar_prodi'));
      }else{
        return redirect('dosen/'.$dosen->id);
      }
    }

    // dosen & pimpinan
    public function update(DosenRequest $request, Dosen $dosen)
    {
        if(Session::has('dosen') && $dosen->id !== Session::get('id')){
          return redirect()->back()->with('kesalahan', 'Anda Tidak Boleh Mengedit Profil Dosen Lain!');
        }

        if(!empty($request->post('password'))) $dosen->password = Hash::make($request->post('password'));
        if($request->hasFile('tanda_tangan')){
          $this->hapusFile($dosen);
          $dosen->tanda_tangan = $this->uploadFile($request);
        }
        $dosen->nama = $request->post('nama');
        $dosen->nip = $request->post('nip');
        $dosen->id_prodi = $request->post('id_prodi');
        if(!empty($request->post('status'))) $dosen->status = $request->post('status');
        if(!empty($request->post('bisa_menguji'))) $dosen->bisa_menguji = $request->post('bisa_menguji');
        if(!empty($request->post('bisa_membimbing'))) $dosen->bisa_membimbing = $request->post('bisa_membimbing');
        $dosen->save();

        if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi')){
          Session::flash('pesan', '1 Dosen Berhasil Diupdate');
          return redirect('dosen');
        }
        Session::forget('nama');
        Session::put('nama', $request->post('nama'));
        Session::flash('pesan', '1 Dosen Berhasil Diupdate');
        return redirect('profil');
    }

    // pimpinan
    public function create()
    {
      $daftar_prodi = \App\Prodi::pluck('nama', 'id');
      return view('dosen.create', compact('daftar_prodi'));
    }

    // pimpinan
    public function store(DosenRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->input('password'));
        if($request->hasFile('tanda_tangan')){
          $input['tanda_tangan'] = $this->uploadFile($request);
        }
        Dosen::create($input);
        Session::flash('pesan', '1 Dosen Berhasil Ditambahkan');
        return redirect('dosen');
    }

    // dosen
    public function akademik()
    {
      $daftar_prodi = \App\Prodi::pluck('nama', 'id');

      $daftar_pa = \App\Mahasiswa::where('id_dosen', Session::get('id'))->orderBy('angkatan', 'desc')->paginate(10);

      $total = \App\Mahasiswa::where('id_dosen', Session::get('id'))->count();

      $filter_bimbingan_akademik = true;

      return view('dosen.akademik', compact('daftar_pa', 'daftar_prodi', 'total', 'filter_bimbingan_akademik'));
    }

    // dosen
    public function akademikCari(Request $request)
    {
      $nama = trim($request->input('nama'));
      $nim = trim($request->input('nim'));
      $angkatan = trim($request->input('angkatan'));
      $tahapan_kp = trim($request->input('tahapan_kp'));
      $tahapan_skripsi = trim($request->input('tahapan_skripsi'));
      $id_prodi = trim($request->input('id_prodi'));
      $kontrak_kp = trim($request->input('kontrak_kp'));
      $kontrak_skripsi = trim($request->input('kontrak_skripsi'));

      if(!empty($nama) || !empty($nim) || !empty($angkatan) || !empty($tahapan_kp) || !empty($tahapan_kp) || !empty($tahapan_skripsi) || !empty($id_prodi) || !empty($kontrak_kp) || !empty($kontrak_skripsi)){

          if(!empty($nama)){
            $query = \App\Mahasiswa::where('id_dosen', Session::get('id'))->where('nama', 'like', '%' . $nama . '%');
            (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
            (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
            (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
          }elseif(!empty($nim)){
            $query = \App\Mahasiswa::where('id_dosen', Session::get('id'))->where('nim', 'like', '%' . $nim . '%');
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
            (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
            (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
          }elseif(!empty($angkatan)){
            $query = \App\Mahasiswa::where('id_dosen', Session::get('id'))->where('angkatan', $angkatan);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
            (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
            (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
          }elseif(!empty($tahapan_kp)){
            $query = \App\Mahasiswa::where('id_dosen', Session::get('id'))->where('tahapan_kp', $tahapan_kp);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
            (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
          }elseif(!empty($tahapan_skripsi)){
            $query = \App\Mahasiswa::where('id_dosen', Session::get('id'))->where('tahapan_skripsi', $tahapan_skripsi);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
            (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
            (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
          }elseif(!empty($id_prodi)){
            $query = \App\Mahasiswa::where('id_dosen', Session::get('id'))->where('id_prodi', $id_prodi);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
            (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
            (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
          }elseif(!empty($kontrak_kp)){
            $query = \App\Mahasiswa::where('id_dosen', Session::get('id'))->where('kontrak_kp', $kontrak_kp);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
            (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
          }elseif(!empty($kontrak_skripsi)){
            $query = \App\Mahasiswa::where('id_dosen', Session::get('id'))->where('kontrak_skripsi', $kontrak_skripsi);
            (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
            (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
            (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
            (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
            (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
            (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
          }

          $total = $query->count();

          $daftar_pa = $query->orderBy('angkatan', 'desc')->paginate(10);

          $pagination = (!empty($nama)) ? $daftar_pa->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_pa->appends(['nim' => $nim]) : '';
          $pagination = (!empty($angkatan)) ? $daftar_pa->appends(['angkatan' => $angkatan]) : '';
          $pagination = (!empty($tahapan_kp)) ? $daftar_pa->appends(['tahapan_kp' => $tahapan_kp]) : '';
          $pagination = (!empty($tahapan_skripsi)) ? $daftar_pa->appends(['tahapan_skripsi' => $tahapan_skripsi]) : '';
          $pagination = (!empty($id_prodi)) ? $daftar_pa->appends(['id_prodi' => $id_prodi]) : '';
          $pagination = (!empty($kontrak_kp)) ? $daftar_pa->appends(['kontrak_kp' => $kontrak_kp]) : '';
          $pagination = (!empty($kontrak_skripsi)) ? $daftar_pa->appends(['kontrak_skripsi' => $kontrak_skripsi]) : '';
          $pagination = $daftar_pa->appends($request->except('page'));

          $daftar_prodi = \App\Prodi::pluck('nama', 'id');

          $filter_bimbingan_akademik = true;

          return view('dosen.akademik', compact('daftar_pa', 'daftar_prodi', 'nama', 'nim', 'angkatan', 'tahapan_kp', 'tahapan_skripsi', 'id_prodi', 'kontrak_kp', 'kontrak_skripsi', 'pagination', 'total', 'filter_bimbingan_akademik'));
      }
      return redirect('mahasiswa/akademik');
    }

    // dosen
    public function akademikExport(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $tahapan_kp = trim($request->input('tahapan_kp'));
        $tahapan_skripsi = trim($request->input('tahapan_skripsi'));
        $id_dosen = Session::get('id');
        $id_prodi = trim($request->input('id_prodi'));
        $kontrak_kp = trim($request->input('kontrak_kp'));
        $kontrak_skripsi = trim($request->input('kontrak_skripsi'));

      return Excel::download(new AkademikExport($nama, $nim, $angkatan, $id_prodi, $id_dosen, $tahapan_kp, $tahapan_skripsi, $kontrak_kp, $kontrak_skripsi), 'SISKP - Export Mahasiswa Pendampingan Akademik ' . Session::get('nama') . '.xlsx');
    }

    // dosen
    public function skripsi()
    {
      $daftar_skripsi = \App\DosenPembimbingSkripsi::where('dosbing_satu_skripsi', Session::get('id'))->orWhere('dosbing_dua_skripsi', Session::get('id'))->orderBy('id', 'desc')->paginate(10);

      $total = \App\DosenPembimbingSkripsi::where('dosbing_satu_skripsi', Session::get('id'))->orWhere('dosbing_dua_skripsi', Session::get('id'))->count();

      $daftar_prodi = \App\Prodi::pluck('nama', 'id');
      $daftar_semester = \App\Semester::pluck('nama', 'id');
      $filter_bimbingan_skripsi = true;

      return view('dosen.skripsi', compact('daftar_skripsi', 'daftar_prodi', 'total', 'daftar_semester', 'filter_bimbingan_skripsi'));
    }

    // dosen
    public function skripsiCari(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $id_prodi = trim($request->input('id_prodi'));
        $kontrak_skripsi = trim($request->input('kontrak_skripsi'));
        $tahapan_skripsi = trim($request->input('tahapan_skripsi'));
        $pembimbing = trim($request->input('pembimbing'));
        $id_semester = trim($request->input('id_semester'));

      if(!empty($nama) || !empty($nim) || !empty($angkatan) || !empty($id_prodi) || !empty($kontrak_skripsi) || !empty($tahapan_skripsi) || !empty($pembimbing) || !empty($id_semester)){

          if(!empty($nama)){
            $query = \App\DosenPembimbingSkripsi::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi, $id_prodi, $kontrak_skripsi){
                $query->where('nama', 'like', '%' . $nama . '%');
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
                (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
              });
            (!empty($id_semester)) ? $query->where('id_semester', $id_semester) : '';
            if(!empty($pembimbing)){
              if($pembimbing === 'utama') $query->where('dosbing_satu_skripsi', Session::get('id'));
              else $query->where('dosbing_dua_skripsi', Session::get('id'));
            }
          }elseif(!empty($nim)){
            $query = \App\DosenPembimbingSkripsi::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi, $id_prodi, $kontrak_skripsi){
                $query->where('nim', 'like', '%' . $nim . '%');
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
                (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($id_semester)) ? $query->where('id_semester', $id_semester) : '';
            if(!empty($pembimbing)){
              if($pembimbing === 'utama') $query->where('dosbing_satu_skripsi', Session::get('id'));
              else $query->where('dosbing_dua_skripsi', Session::get('id'));
            }
          }elseif(!empty($angkatan)){
            $query = \App\DosenPembimbingSkripsi::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi, $id_prodi, $kontrak_skripsi){
                $query->where('angkatan', $angkatan);
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
                (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($id_semester)) ? $query->where('id_semester', $id_semester) : '';
            if(!empty($pembimbing)){
              if($pembimbing === 'utama') $query->where('dosbing_satu_skripsi', Session::get('id'));
              else $query->where('dosbing_dua_skripsi', Session::get('id'));
            }
          }elseif(!empty($tahapan_skripsi)){
            $query = \App\DosenPembimbingSkripsi::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi, $id_prodi, $kontrak_skripsi){
                $query->where('tahapan_skripsi', $tahapan_skripsi);
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($id_semester)) ? $query->where('id_semester', $id_semester) : '';
            if(!empty($pembimbing)){
              if($pembimbing === 'utama') $query->where('dosbing_satu_skripsi', Session::get('id'));
              else $query->where('dosbing_dua_skripsi', Session::get('id'));
            }
          }elseif(!empty($kontrak_skripsi)){
            $query = \App\DosenPembimbingSkripsi::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi, $id_prodi, $kontrak_skripsi){
                $query->where('kontrak_skripsi', $kontrak_skripsi);
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($id_semester)) ? $query->where('id_semester', $id_semester) : '';
            if(!empty($pembimbing)){
              if($pembimbing === 'utama') $query->where('dosbing_satu_skripsi', Session::get('id'));
              else $query->where('dosbing_dua_skripsi', Session::get('id'));
            }
          }elseif(!empty($id_prodi)){
            $query = \App\DosenPembimbingSkripsi::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi, $id_prodi, $kontrak_skripsi){
                $query->where('id_prodi', $id_prodi);
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
                (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
            });
            (!empty($id_semester)) ? $query->where('id_semester', $id_semester) : '';
            if(!empty($pembimbing)){
              if($pembimbing === 'utama') $query->where('dosbing_satu_skripsi', Session::get('id'));
              else $query->where('dosbing_dua_skripsi', Session::get('id'));
            }
          }elseif(!empty($id_semester)){
            $query = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('id_semester', $id_semester)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi, $id_prodi, $kontrak_skripsi){
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
                (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            if(!empty($pembimbing)){
              if($pembimbing === 'utama') $query->where('dosbing_satu_skripsi', Session::get('id'));
              else $query->where('dosbing_dua_skripsi', Session::get('id'));
            }
          }elseif(!empty($pembimbing)){
            if($pembimbing === 'utama'){
              $query = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_satu_skripsi', Session::get('id'));
            }else{
              $query = \App\DosenPembimbingSkripsi::with('mahasiswa')->where('dosbing_dua_skripsi', Session::get('id'));
            }
            $query->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_skripsi, $id_prodi, $kontrak_skripsi){
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_skripsi)) ? $query->where('tahapan_skripsi', $tahapan_skripsi) : '';
                (!empty($kontrak_skripsi)) ? $query->where('kontrak_skripsi', $kontrak_skripsi) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($id_semester)) ? $query->where('id_semester', $id_semester) : '';
          }

          $total = $query->count();
          $daftar_skripsi = $query->orderBy('id', 'desc')->paginate(10);

          $pagination = (!empty($nama)) ? $daftar_skripsi->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_skripsi->appends(['nim' => $nim]) : '';
          $pagination = (!empty($angkatan)) ? $daftar_skripsi->appends(['angkatan' => $angkatan]) : '';
          $pagination = (!empty($kontrak_skripsi)) ? $daftar_skripsi->appends(['kontrak_skripsi' => $kontrak_skripsi]) : '';
          $pagination = (!empty($tahapan_skripsi)) ? $daftar_skripsi->appends(['tahapan_skripsi' => $tahapan_skripsi]) : '';
          $pagination = (!empty($id_prodi)) ? $daftar_skripsi->appends(['id_prodi' => $id_prodi]) : '';
          $pagination = (!empty($id_semester)) ? $daftar_skripsi->appends(['id_semester' => $id_semester]) : '';
          $pagination = (!empty($pembimbing)) ? $daftar_skripsi->appends(['pembimbing' => $pembimbing]) : '';
          $pagination = $daftar_skripsi->appends($request->except('page'));

        $daftar_prodi = \App\Prodi::pluck('nama', 'id');
        $daftar_semester = \App\Semester::pluck('nama', 'id');

        $filter_bimbingan_skripsi = true;

        return view('dosen.skripsi', compact('daftar_skripsi', 'daftar_prodi', 'daftar_semester', 'total', 'pagination', 'nama', 'kontrak_skripsi', 'nim', 'angkatan', 'tahapan_skripsi', 'id_prodi', 'id_semester', 'pembimbing', 'filter_bimbingan_skripsi'));
      }
        return redirect('mahasiswa/skripsi');
    }

    // dosen
    public function skripsiExport(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $tahapan_skripsi = trim($request->input('tahapan_skripsi'));
        $id_prodi = trim($request->input('id_prodi'));
        $kontrak_skripsi = trim($request->input('kontrak_skripsi'));
        $pembimbing = trim($request->input('pembimbing'));
        $id_semester = trim($request->input('id_semester'));
        $id_dosen = Session::get('id');

      return Excel::download(new SkripsiExport($id_dosen, $nama, $nim, $angkatan, $tahapan_skripsi, $id_prodi, $kontrak_skripsi, $pembimbing, $id_semester), 'SISKP - Export Mahasiswa Bimbingan Skripsi '. Session::get('nama') .'.xlsx');
    }

    // dosen
    public function kerjaPraktek()
    {
      $daftar_kp = \App\DosenPembimbingKp::where('dosbing_satu_kp', Session::get('id'))->orWhere('dosbing_dua_kp', Session::get('id'))->orderBy('id', 'desc')->paginate(10);

      $total = \App\DosenPembimbingKp::where('dosbing_satu_kp', Session::get('id'))->orWhere('dosbing_dua_kp', Session::get('id'))->count();

      $daftar_prodi = \App\Prodi::pluck('nama', 'id');
      $daftar_semester = \App\Semester::pluck('nama', 'id');

      $filter_bimbingan_kp = true;

      return view('dosen.kerja-praktek', compact('daftar_kp', 'total', 'daftar_prodi', 'daftar_semester', 'filter_bimbingan_kp'));
    }

    // dosen
    public function kerjaPraktekCari(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $id_prodi = trim($request->input('id_prodi'));
        $kontrak_kp = trim($request->input('kontrak_kp'));
        $tahapan_kp = trim($request->input('tahapan_kp'));
        $pembimbing = trim($request->input('pembimbing'));
        $id_semester = trim($request->input('id_semester'));

      if(!empty($nama) || !empty($nim) || !empty($angkatan) || !empty($id_prodi) || !empty($kontrak_kp) || !empty($tahapan_kp) || !empty($pembimbing) || !empty($id_semester)){

          if(!empty($nama)){
            $query = \App\DosenPembimbingKp::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_kp, $id_prodi, $kontrak_kp){
                $query->where('nama', 'like', '%' . $nama . '%');
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
                (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
              });
            (!empty($id_semester)) ? $query->where('id_semester', $id_semester) : '';
            if(!empty($pembimbing)){
              if($pembimbing === 'utama') $query->where('dosbing_satu_kp', Session::get('id'));
              else $query->where('dosbing_dua_kp', Session::get('id'));
            }
          }elseif(!empty($nim)){
            $query = \App\DosenPembimbingKp::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_kp, $id_prodi, $kontrak_kp){
                $query->where('nim', 'like', '%' . $nim . '%');
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
                (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($id_semester)) ? $query->where('id_semester', $id_semester) : '';
            if(!empty($pembimbing)){
              if($pembimbing === 'utama') $query->where('dosbing_satu_kp', Session::get('id'));
              else $query->where('dosbing_dua_kp', Session::get('id'));
            }
          }elseif(!empty($angkatan)){
            $query = \App\DosenPembimbingKp::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_kp, $id_prodi, $kontrak_kp){
                $query->where('angkatan', $angkatan);
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
                (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($id_semester)) ? $query->where('id_semester', $id_semester) : '';
            if(!empty($pembimbing)){
              if($pembimbing === 'utama') $query->where('dosbing_satu_kp', Session::get('id'));
              else $query->where('dosbing_dua_kp', Session::get('id'));
            }
          }elseif(!empty($tahapan_kp)){
            $query = \App\DosenPembimbingKp::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_kp, $id_prodi, $kontrak_kp){
                $query->where('tahapan_kp', $tahapan_kp);
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($id_semester)) ? $query->where('id_semester', $id_semester) : '';
            if(!empty($pembimbing)){
              if($pembimbing === 'utama') $query->where('dosbing_satu_kp', Session::get('id'));
              else $query->where('dosbing_dua_kp', Session::get('id'));
            }
          }elseif(!empty($kontrak_kp)){
            $query = \App\DosenPembimbingKp::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_kp, $id_prodi, $kontrak_kp){
                $query->where('kontrak_kp', $kontrak_kp);
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($id_semester)) ? $query->where('id_semester', $id_semester) : '';
            if(!empty($pembimbing)){
              if($pembimbing === 'utama') $query->where('dosbing_satu_kp', Session::get('id'));
              else $query->where('dosbing_dua_kp', Session::get('id'));
            }
          }elseif(!empty($id_prodi)){
            $query = \App\DosenPembimbingKp::with('mahasiswa')->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_kp, $id_prodi, $kontrak_kp){
                $query->where('id_prodi', $id_prodi);
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
                (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
            });
            (!empty($id_semester)) ? $query->where('id_semester', $id_semester) : '';
            if(!empty($pembimbing)){
              if($pembimbing === 'utama') $query->where('dosbing_satu_kp', Session::get('id'));
              else $query->where('dosbing_dua_kp', Session::get('id'));
            }
          }elseif(!empty($id_semester)){
            $query = \App\DosenPembimbingKp::with('mahasiswa')->where('id_semester', $id_semester)->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_kp, $id_prodi, $kontrak_kp){
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
                (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            if(!empty($pembimbing)){
              if($pembimbing === 'utama') $query->where('dosbing_satu_kp', Session::get('id'));
              else $query->where('dosbing_dua_kp', Session::get('id'));
            }
          }elseif(!empty($pembimbing)){
            if($pembimbing === 'utama'){
              $query = \App\DosenPembimbingKp::with('mahasiswa')->where('dosbing_satu_kp', Session::get('id'));
            }else{
              $query = \App\DosenPembimbingKp::with('mahasiswa')->where('dosbing_dua_kp', Session::get('id'));
            }
            $query->whereHas('mahasiswa', function ($query) use ($nim, $nama, $angkatan, $tahapan_kp, $id_prodi, $kontrak_kp){
                (!empty($nim)) ? $query->where('nim', 'like', '%' . $nim . '%') : '';
                (!empty($nama)) ? $query->where('nama', 'like', '%' . $nama . '%') : '';
                (!empty($angkatan)) ? $query->where('angkatan', $angkatan) : '';
                (!empty($tahapan_kp)) ? $query->where('tahapan_kp', $tahapan_kp) : '';
                (!empty($kontrak_kp)) ? $query->where('kontrak_kp', $kontrak_kp) : '';
                (!empty($id_prodi)) ? $query->where('id_prodi', $id_prodi) : '';
            });
            (!empty($id_semester)) ? $query->where('id_semester', $id_semester) : '';
          }

          $total = $query->count();
          $daftar_kp = $query->orderBy('id', 'desc')->paginate(10);

          $pagination = (!empty($nama)) ? $daftar_kp->appends(['nama' => $nama]) : '';
          $pagination = (!empty($nim)) ? $daftar_kp->appends(['nim' => $nim]) : '';
          $pagination = (!empty($angkatan)) ? $daftar_kp->appends(['angkatan' => $angkatan]) : '';
          $pagination = (!empty($kontrak_kp)) ? $daftar_kp->appends(['kontrak_kp' => $kontrak_kp]) : '';
          $pagination = (!empty($tahapan_kp)) ? $daftar_kp->appends(['tahapan_kp' => $tahapan_kp]) : '';
          $pagination = (!empty($id_prodi)) ? $daftar_kp->appends(['id_prodi' => $id_prodi]) : '';
          $pagination = (!empty($id_semester)) ? $daftar_kp->appends(['id_semester' => $id_semester]) : '';
          $pagination = (!empty($pembimbing)) ? $daftar_kp->appends(['pembimbing' => $pembimbing]) : '';
          $pagination = $daftar_kp->appends($request->except('page'));

        $daftar_prodi = \App\Prodi::pluck('nama', 'id');
        $daftar_semester = \App\Semester::pluck('nama', 'id');

        $filter_bimbingan_kp = true;

        return view('dosen.kerja-praktek', compact('daftar_kp', 'daftar_prodi', 'daftar_semester', 'total', 'pagination', 'nama', 'kontrak_kp', 'nim', 'angkatan', 'tahapan_kp', 'id_prodi', 'id_semester', 'pembimbing', 'filter_bimbingan_kp'));
      }
        return redirect('mahasiswa/kerja-praktek');
    }

    // dosen
    public function kerjaPraktekExport(Request $request)
    {
        $nama = trim($request->input('nama'));
        $nim = trim($request->input('nim'));
        $angkatan = trim($request->input('angkatan'));
        $tahapan_kp = trim($request->input('tahapan_kp'));
        $id_prodi = trim($request->input('id_prodi'));
        $kontrak_kp = trim($request->input('kontrak_kp'));
        $pembimbing = trim($request->input('pembimbing'));
        $id_semester = trim($request->input('id_semester'));
        $id_dosen = Session::get('id');

      return Excel::download(new KerjaPraktekExport($id_dosen, $nama, $nim, $angkatan, $tahapan_kp, $id_prodi, $kontrak_kp, $pembimbing, $id_semester), 'SISKP - Export Mahasiswa Bimbingan Kerja Praktek '. Session::get('nama') .'.xlsx');
    }

    // dosen
    public function pengujian()
    {
        $daftar_pengujian = \App\JadwalUjian::selectRaw('MONTH(waktu_mulai) bulan, YEAR(waktu_mulai) tahun')->groupBy('bulan', 'tahun')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->limit(24)->get();

        return view('dosen.pengujian', compact('daftar_pengujian'));
    }

    // dosen
    public function pengujianByTanggal($tanggal)
    {
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        $daftar_pengujian = \App\DosenPenguji::where('id_dosen', Session::get('id'))->whereHas('jadwalUjian', function($query) use ($bulan, $tahun){
            $query->whereMonth('waktu_mulai', $bulan)->whereYear('waktu_mulai', $tahun)->orderBy('waktu_mulai', 'desc');
        })->get();

        return view('dosen.jadwal-tanggal', compact('daftar_pengujian', 'bulan', 'tahun', 'tanggal'));
    }

    // dosen
    public function pengujianCari(Request $request)
    {
        $waktu = trim($request->input('waktu'));
        $ujian = trim($request->input('ujian'));

      if(!empty($waktu) || !empty($ujian)){

          if(!empty($waktu)){
            $query = \App\DosenPenguji::with('jadwalUjian')->where('id_dosen', Session::get('id'))->whereHas('jadwalUjian', function ($query) use ($waktu, $ujian){
                $query->where('waktu_mulai', 'like', '%' . $waktu . '%');
                (!empty($ujian)) ? $query->where('ujian', $ujian) : '';
              });
          }elseif(!empty($ujian)){
            $query = \App\DosenPenguji::with('jadwalUjian')->where('id_dosen', Session::get('id'))->whereHas('jadwalUjian', function ($query) use ($waktu, $ujian){
              $query->where('ujian', $ujian);
              (!empty($waktu)) ? $query->where('waktu_mulai', 'like', '%' . $waktu . '%') : '';
              });
          }

          $total = $query->count();
          $daftar_pengujian = $query->paginate(10);

          $pagination = (!empty($waktu)) ? $daftar_pengujian->appends(['waktu' => $waktu]) : '';
          $pagination = (!empty($ujian)) ? $daftar_pengujian->appends(['ujian' => $ujian]) : '';
          $pagination = $daftar_pengujian->appends($request->except('page'));

        return view('dosen.pengujian', compact('daftar_pengujian', 'total', 'pagination', 'waktu', 'ujian'));
      }
        return redirect('mahasiswa/pengujian');
    }

    // dosen
    public function pengujianExport(Request $request)
    {
        $waktu = trim($request->input('waktu'));
        $ujian = trim($request->input('ujian'));
        $id_dosen = Session::get('id');

      return Excel::download(new PengujianExport($id_dosen, $waktu, $ujian), 'SISKP - Export Mahasiswa Pengujian '. Session::get('nama') .'.xlsx');
    }

    // dosen & pimpinan
    public function detailByDosen($id)
    {
        $mahasiswa = \App\Mahasiswa::find($id);
        $bisa_kp = \App\ProdiKp::where('id_prodi', $mahasiswa->id_prodi)->first() or null;
        return view('dosen.detail-mahasiswa', compact('mahasiswa', 'bisa_kp'));
    }

    private function uploadFile(Request $request){
        $file = $request->file('tanda_tangan');
        $ext = $file->getClientOriginalExtension();
        if($request->file('tanda_tangan')->isValid()){
          $file_name = date('YmdHis').".$ext";
          $upload_path = 'assets/ttd';
          $request->file('tanda_tangan')->move($upload_path, $file_name);
          return $file_name;
        }
        return false;
    }

    private function hapusFile($dosen){
      $file = 'assets/ttd/'.$dosen->tanda_tangan;
      if(file_exists($file) && isset($dosen->tanda_tangan)){
      $delete = unlink($file);
        if($delete){
          return true;
        }
        return false;
      }
    }

}
