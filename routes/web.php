<?php

Route::get('/', 'BerandaController@index');

// beranda
Route::prefix('beranda')->group(function()
{
    Route::get('/', 'BerandaController@index');
    Route::get('admin', 'BerandaController@indexAdmin');
    Route::get('dosen', 'BerandaController@indexDosen');
    Route::get('mahasiswa', 'BerandaController@indexMahasiswa');
});

// riwayat skripsi
Route::prefix('riwayat-skripsi')->group(function(){
    Route::get('/', 'RiwayatSkripsiController@riwayatSkripsi');
    Route::get('cari', 'RiwayatSkripsiController@riwayatSkripsiCari');
    Route::get('export', 'RiwayatSkripsiController@riwayatSkripsiExport');
    Route::get('{id}/edit', 'RiwayatSkripsiController@edit');
    Route::patch('{id}/revisi', 'RiwayatSkripsiController@update');
    Route::get('{id}', 'RiwayatSkripsiController@detailRiwayatSkripsi');
});

// pendaftaran usulan topik, ujian seminar proposal, hasil & sidang skripsi
Route::prefix('pendaftaran')->group(function()
{
    // turun kp
    Route::prefix('turun-kp')->group(function(){
        Route::get('semua', 'PendaftarTurunKpController@semuaPendaftar');
        Route::get('cetak/{id}', 'PendaftarTurunKpController@cetak');
        Route::get('periode/{id}/cari', 'PendaftarTurunKpController@detailPeriodeCari');
        Route::get('periode/{id}/export', 'PendaftarTurunKpController@detailPeriodeExport');
        Route::get('periode/{id}', 'PendaftarTurunKpController@detailPeriode');
        Route::get('{id}/create-dosbing', 'PendaftarTurunKpController@createDosbing');
        Route::get('{id}/input-by-admin', 'PendaftarTurunKpController@formInputByAdmin');
        Route::post('setujui-semua', 'PendaftarTurunKpController@setujuiSemua');
        Route::post('input-by-admin', 'PendaftarTurunKpController@inputByAdmin');
    });
    Route::resource('turun-kp', 'PendaftarTurunKpController');
    
    // usulan topik
    Route::prefix('usulan-topik')->group(function(){
        Route::get('semua', 'PendaftarUsulanTopikController@semuaPendaftar');
        Route::get('cetak/{id}', 'PendaftarUsulanTopikController@cetak');
        Route::get('periode/tidak-diketahui', 'PendaftarUsulanTopikController@periodeKosong');
        Route::get('periode/{id}/cari', 'PendaftarUsulanTopikController@detailPeriodeCari');
        Route::get('periode/{id}/export', 'PendaftarUsulanTopikController@detailPeriodeExport');
        Route::get('periode/{id}', 'PendaftarUsulanTopikController@detailPeriode');
        Route::get('{id}/perubahan', 'PendaftarUsulanTopikController@perubahan');
        Route::get('{id}/create-dosbing', 'PendaftarUsulanTopikController@createDosbing');
        Route::get('{id}/input-by-admin', 'PendaftarUsulanTopikController@formInputByAdmin');
        Route::patch('{id}/perubahan', 'PendaftarUsulanTopikController@updatePerubahan');
        Route::get('create-by-admin/{id}', 'PendaftarUsulanTopikController@createByAdmin');
        Route::post('store-by-admin', 'PendaftarUsulanTopikController@storeByAdmin');
        Route::post('setujui-semua', 'PendaftarUsulanTopikController@setujuiSemua');
        Route::post('input-by-admin', 'PendaftarUsulanTopikController@inputByAdmin');
    });
    Route::resource('usulan-topik', 'PendaftarUsulanTopikController');

    // ujian
    Route::prefix('ujian')->group(function(){
        Route::get('semua', 'PendaftarUjianController@semuaPendaftar');
        Route::get('periode/{id}/cari', 'PendaftarUjianController@detailPeriodeCari');
        Route::get('periode/{id}/export', 'PendaftarUjianController@detailPeriodeExport');
        Route::get('periode/{id}', 'PendaftarUjianController@detailPeriode');
        Route::get('{id}/create-jadwal', 'PendaftarUjianController@createJadwal');
        Route::get('{id}/input-by-admin', 'PendaftarUjianController@formInputByAdmin');
        Route::post('upload-plagiasi', 'PendaftarUjianController@uploadPlagiasi');
        Route::post('setujui-semua', 'PendaftarUjianController@setujuiSemua');
        Route::post('input-by-admin', 'PendaftarUjianController@inputByAdmin');
        Route::delete('upload-plagiasi/{id}', 'PendaftarUjianController@destroyPlagiasi');
    });
    Route::resource('ujian', 'PendaftarUjianController');
});

// jadwal ujian
Route::prefix('jadwal-ujian')->group(function(){
    Route::get('create-skripsi', 'JadwalUjianController@create');
    Route::get('create-kerja-praktek', 'JadwalUjianController@create');
    Route::get('dosen', 'JadwalUjianController@indexDosen');
    Route::get('semua', 'JadwalUjianController@semuaJadwal');
    Route::get('detail-peserta/{id}', 'JadwalUjianController@detailPeserta');
    Route::get('tambah-peserta/{id}', 'JadwalUjianController@createPeserta');
    Route::get('cetak/{tanggal}', 'JadwalUjianController@cetak');
    Route::get('{tanggal}/cari', 'JadwalUjianController@jadwalByTanggalCari');
    Route::get('{tanggal}', 'JadwalUjianController@jadwalByTanggal');
    Route::delete('jadwal-ujian/peserta/{id}', 'JadwalUjianController@destroyPeserta');
    Route::get('detail/{id}', 'JadwalUjianController@show');
    Route::post('peserta', 'JadwalUjianController@storePeserta');
    Route::post('kerja-praktek', 'JadwalUjianController@storeKp');
    Route::get('form-undangan/{id}', 'JadwalUjianController@formUndangan');
    Route::post('berita-acara-skripsi-ttd', 'JadwalUjianController@beritaAcaraSkripsiByMahasiswa');
    Route::post('berita-acara-kerja-praktek-ttd', 'JadwalUjianController@beritaAcaraKpByMahasiswa');
    Route::get('form-berita-acara-skripsi/{id}', 'JadwalUjianController@formBeritaAcaraSkripsi');
    Route::get('form-berita-acara-skripsi-ttd/{id}', 'JadwalUjianController@formBeritaAcaraSkripsiTtd');
    Route::get('form-berita-acara-kerja-praktek/{id}', 'JadwalUjianController@formBeritaAcaraKp');
    Route::get('form-berita-acara-kerja-praktek-ttd/{id}', 'JadwalUjianController@formBeritaAcaraKpTtd');
    Route::post('berita-acara-skripsi', 'JadwalUjianController@beritaAcaraSkripsi');
    Route::post('berita-acara-kerja-praktek', 'JadwalUjianController@beritaAcaraKp');
    Route::get('administrasi-ujian/{id}', 'JadwalUjianController@administrasiUjian');
    Route::get('form-administrasi-ujian-kp/{id}', 'JadwalUjianController@formAdministrasiUjianKp');
    Route::post('administrasi-ujian-kp', 'JadwalUjianController@administrasiUjianKp');
    Route::post('undangan', 'JadwalUjianController@undangan');
});
Route::resource('jadwal-ujian', 'JadwalUjianController');

// peserta ujian
Route::get('peserta-ujian/lama/{id}', 'PesertaUjianController@createPesertaLama');
Route::resource('peserta-ujian', 'PesertaUjianController');

// validasi
Route::prefix('validasi')->group(function()
{
    Route::post('usulan-topik', 'PendaftarUsulanTopikController@validasi');
    Route::post('ujian', 'PendaftarUjianController@validasi');
    Route::post('turun-kp', 'PendaftarTurunKpController@validasi');
});

// profil
Route::get('profil', 'BerandaController@profil');

// dosen pembimbing
Route::prefix('dosen-pembimbing')->group(function()
{
    // skripsi
    Route::prefix('skripsi')->group(function(){
        Route::get('/', 'DosenPembimbingController@indexSkripsi');
        Route::get('semua', 'DosenPembimbingController@semuaSkripsi');
        Route::get('semester/tidak-diketahui/cari', 'DosenPembimbingController@periodeKosongCari');
        Route::get('semester/tidak-diketahui/export', 'DosenPembimbingController@periodeKosongExport');
        Route::get('semester/tidak-diketahui', 'DosenPembimbingController@periodeKosong');
        Route::get('semester/{id}/cari', 'DosenPembimbingController@detailSemesterSkripsiCari');
        Route::get('semester/{id}/export', 'DosenPembimbingController@detailSemesterSkripsiExport');
        Route::get('semester/{id}', 'DosenPembimbingController@detailSemesterSkripsi');
        Route::get('create', 'DosenPembimbingController@createSkripsi');
        Route::post('store-by-usulan-topik', 'DosenPembimbingController@storeByUsulanTopik');
        Route::post('/', 'DosenPembimbingController@storeSkripsi');
        Route::get('{id}/edit', 'DosenPembimbingController@editSkripsi');
        Route::get('{id}/ganti', 'DosenPembimbingController@gantiSkripsi');
        Route::post('{id}/perpanjang', 'DosenPembimbingController@perpanjangSkripsi');
        Route::post('{id}/perpanjang-belum-lulus', 'DosenPembimbingController@perpanjangSkripsiBelumLulus');
        Route::patch('{id}/ganti', 'DosenPembimbingController@updateGantiSkripsi');
        Route::patch('{id}', 'DosenPembimbingController@updateSkripsi');
        Route::delete('{id}', 'DosenPembimbingController@destroySkripsi');
        Route::get('form-surat-penunjukan/{id}', 'DosenPembimbingController@formSuratPenunjukanSkripsi');
        Route::get('surat-kesediaan/{id}', 'DosenPembimbingController@suratKesediaanSkripsi');
        Route::post('surat-penunjukan', 'DosenPembimbingController@suratPenunjukanSkripsi');
        Route::get('surat-persetujuan-proposal/{id}', 'DosenPembimbingController@suratPersetujuanProposal');
        Route::get('surat-persetujuan-hasil/{id}', 'DosenPembimbingController@suratPersetujuanHasil');
        Route::get('surat-persetujuan-sidang/{id}', 'DosenPembimbingController@suratPersetujuanSidang');
    });
    
    
    // kerja praktek
    Route::prefix('kerja-praktek')->group(function(){
        Route::get('/', 'DosenPembimbingController@indexKp');
        Route::get('semua', 'DosenPembimbingController@semuaKp');
        Route::get('semester/{id}/cari', 'DosenPembimbingController@detailSemesterKpCari');
        Route::get('semester/{id}/export', 'DosenPembimbingController@detailSemesterKpExport');
        Route::get('semester/{id}', 'DosenPembimbingController@detailSemesterKp');
        Route::get('create', 'DosenPembimbingController@createKp');
        Route::post('store-by-turun-kp', 'DosenPembimbingController@storeByTurunKp');
        Route::post('/', 'DosenPembimbingController@storeKp');
        Route::get('{id}/edit', 'DosenPembimbingController@editKp');
        Route::post('{id}/perpanjang', 'DosenPembimbingController@perpanjangKp');
        Route::post('{id}/perpanjang-belum-lulus', 'DosenPembimbingController@perpanjangKpBelumLulus');
        Route::patch('{id}', 'DosenPembimbingController@updateKp');
        Route::delete('{id}', 'DosenPembimbingController@destroyKp');
        Route::get('surat-penunjukan/{id}', 'DosenPembimbingController@suratPenunjukanKp');
        Route::get('form-surat-persetujuan-kp/{id}', 'DosenPembimbingController@formSuratPersetujuanKp');
        Route::post('surat-persetujuan-kp', 'DosenPembimbingController@suratPersetujuanKp');
    });

});

// dosen pembimbing berhalangan
Route::prefix('dosbing-berhalangan')->group(function(){
    Route::get('{id}', 'DosenPembimbingController@detailDosbingBerhalangan');
    Route::get('cetak/{id}', 'DosenPembimbingController@cetakDosbingBerhalangan');
    Route::delete('{id}', 'DosenPembimbingController@destroyDosbingBerhalangan');
});

// masuk & daftar
Route::prefix('masuk')->group(function()
{
    Route::get('/', 'BerandaController@masuk');

    Route::get('ujian', 'BerandaController@ujian');
    Route::get('ujian/{id}', 'BerandaController@ujianDetail');
    
    Route::get('usulan-topik', 'BerandaController@usulanTopik');
    Route::get('usulan-topik/{id}', 'BerandaController@usulanTopikDetail');
 
    Route::get('kerja-praktek', 'BerandaController@kerjaPraktek');
    Route::get('kerja-praktek/{id}', 'BerandaController@kerjaPraktekDetail');

    Route::get('jadwal/{tanggal}', 'BerandaController@jadwal');

    Route::post('/', 'BerandaController@cekPengguna');

    Route::get('riwayat-skripsi', 'BerandaController@riwayatSkripsi');
    Route::get('riwayat-skripsi/cari', 'BerandaController@riwayatSkripsiCari');
    Route::get('riwayat-skripsi/{id}', 'BerandaController@detailRiwayatSkripsi');
});
Route::get('keluar', 'BerandaController@keluar');

// pengaturan
Route::prefix('pengaturan')->group(function()
{
    Route::get('umum', 'PengaturanController@indexUmum');
    Route::get('pimpinan', 'PengaturanController@indexPimpinan');
    Route::get('prodi', 'PengaturanController@indexProdi');

    // kajur
    Route::prefix('kajur')->group(function(){
        Route::get('{id}/edit', 'PengaturanController@editKajur');
        Route::get('create', 'PengaturanController@createKajur');
        Route::post('/', 'PengaturanController@storeKajur');
        Route::patch('{id}', 'PengaturanController@updateKajur');
        Route::delete('{id}', 'PengaturanController@destroyKajur');
    });

    // prodi
    Route::prefix('prodi')->group(function(){
        Route::get('create', 'PengaturanController@createProdi');
        Route::post('/', 'PengaturanController@storeProdi');
        Route::get('{id}/edit', 'PengaturanController@editProdi');
        Route::patch('{id}', 'PengaturanController@updateProdi');
        Route::delete('{id}', 'PengaturanController@destroyProdi');
    });

    // kaprodi
    Route::prefix('kaprodi')->group(function(){
        Route::get('create', 'PengaturanController@createKaprodi');
        Route::post('/', 'PengaturanController@storeKaprodi');
        Route::get('{id}/edit', 'PengaturanController@editKaprodi');
        Route::patch('{id}', 'PengaturanController@updateKaprodi');
        Route::delete('{id}', 'PengaturanController@destroyKaprodi');
    });

    // prodi_kp
    Route::prefix('prodi-kp')->group(function(){
        Route::get('create', 'PengaturanController@createProdiKp');
        Route::post('/', 'PengaturanController@storeProdiKp');
        Route::get('{id}/edit', 'PengaturanController@editProdiKp');
        Route::patch('{id}', 'PengaturanController@updateProdiKp');
        Route::delete('{id}', 'PengaturanController@destroyProdiKp');
    });

    // minimal referensi utama
    Route::patch('referensi-utama/{id}', 'PengaturanController@updateReferensiUtama');

    // maximal file upload
    Route::patch('max-file/{id}', 'PengaturanController@updateMaxFile');

    // panduan
    Route::patch('panduan/{id}', 'PengaturanController@updatePanduan');

    // penilaian
    Route::prefix('penilaian')->group(function(){
        Route::get('/', 'IndikatorPenilaianController@index');
        Route::get('create', 'IndikatorPenilaianController@create');
        Route::post('/', 'IndikatorPenilaianController@store');
        Route::get('{id}/edit', 'IndikatorPenilaianController@edit');
        Route::patch('{id}', 'IndikatorPenilaianController@update');
        Route::delete('{id}', 'IndikatorPenilaianController@destroy');
    });

});

// CRUD: admin
Route::resource('admin', 'AdminController');

// CRUD: admin
Route::prefix('semester-periode')->group(function()
{
    Route::get('/', 'SemesterPeriodeController@indexSemester');
    
    // semester
    Route::prefix('semester')->group(function(){
        Route::get('/', 'SemesterPeriodeController@indexSemester');
        Route::get('create', 'SemesterPeriodeController@createSemester');
        Route::post('/', 'SemesterPeriodeController@storeSemester');
        Route::get('{id}/edit', 'SemesterPeriodeController@editSemester');
        Route::patch('{id}', 'SemesterPeriodeController@updateSemester');
        Route::delete('{id}', 'SemesterPeriodeController@destroySemester');
    });
    
    // periode_daftar_turun_kp
    Route::prefix('periode-daftar-turun-kp')->group(function(){
        Route::get('/', 'SemesterPeriodeController@indexPeriodeDaftarTurunKp');
        Route::get('create', 'SemesterPeriodeController@createPeriodeDaftarTurunKp');
        Route::post('/', 'SemesterPeriodeController@storePeriodeDaftarTurunKp');
        Route::get('{id}/edit', 'SemesterPeriodeController@editPeriodeDaftarTurunKp');
        Route::patch('{id}', 'SemesterPeriodeController@updatePeriodeDaftarTurunKp');
        Route::delete('{id}', 'SemesterPeriodeController@destroyPeriodeDaftarTurunKp');
    });
    
    // periode_daftar_usulan_topik
    Route::prefix('periode-daftar-usulan-topik')->group(function(){
        Route::get('/', 'SemesterPeriodeController@indexPeriodeDaftarUsulanTopik');
        Route::get('create', 'SemesterPeriodeController@createPeriodeDaftarUsulanTopik');
        Route::post('/', 'SemesterPeriodeController@storePeriodeDaftarUsulanTopik');
        Route::get('{id}/edit', 'SemesterPeriodeController@editPeriodeDaftarUsulanTopik');
        Route::patch('{id}', 'SemesterPeriodeController@updatePeriodeDaftarUsulanTopik');
        Route::delete('{id}', 'SemesterPeriodeController@destroyPeriodeDaftarUsulanTopik');
    });
    
    // periode_daftar_ujian
    Route::prefix('periode-daftar-ujian')->group(function(){
        Route::get('/', 'SemesterPeriodeController@indexPeriodeDaftarUjian');
        Route::get('create', 'SemesterPeriodeController@createPeriodeDaftarUjian');
        Route::post('/', 'SemesterPeriodeController@storePeriodeDaftarUjian');
        Route::get('{id}/edit', 'SemesterPeriodeController@editPeriodeDaftarUjian');
        Route::patch('{id}', 'SemesterPeriodeController@updatePeriodeDaftarUjian');
        Route::delete('{id}', 'SemesterPeriodeController@destroyPeriodeDaftarUjian');
    });
    
});

// dosen
Route::prefix('dosen')->group(function(){
    Route::get('cari', 'DosenController@cari');
    Route::get('import', 'DosenController@createImport');
    Route::post('import', 'DosenController@import');
    Route::get('export', 'DosenController@export');
    Route::post('validasi-status', 'DosenController@validasiStatus');
    Route::post('bisa-menguji', 'DosenController@bisaMenguji');
    Route::post('bisa-membimbing', 'DosenController@bisaMembimbing');
});
Route::resource('dosen', 'DosenController');

// mahasiswa
Route::prefix('mahasiswa')->group(function(){
    Route::get('cari', 'MahasiswaController@cari');
    Route::get('export', 'MahasiswaController@export');
    
    Route::get('akademik/cari', 'DosenController@akademikCari');
    Route::get('akademik/export', 'DosenController@akademikExport');
    Route::get('akademik', 'DosenController@akademik');
    
    Route::get('skripsi/cari', 'DosenController@skripsiCari');
    Route::get('skripsi/export', 'DosenController@skripsiExport');
    Route::get('skripsi', 'DosenController@skripsi');
    
    Route::get('kerja-praktek/cari', 'DosenController@kerjaPraktekCari');
    Route::get('kerja-praktek/export', 'DosenController@kerjaPraktekExport');
    Route::get('kerja-praktek', 'DosenController@kerjaPraktek');

    Route::get('pengujian/{tanggal}', 'DosenController@pengujianByTanggal');
    Route::get('pengujian/cari', 'DosenController@pengujianCari');
    Route::get('pengujian/export', 'DosenController@pengujianExport');
    Route::get('pengujian', 'DosenController@pengujian');
    
    Route::get('detail/{id}', 'DosenController@detailByDosen');
    Route::get('import', 'MahasiswaController@createImport');
    Route::get('import-maba', 'MahasiswaController@createImportMaba');
    Route::post('import', 'MahasiswaController@import');
    Route::post('import-maba', 'MahasiswaController@importMaba');
    
    Route::post('validasi-kp', 'MahasiswaController@validasiKp');
    Route::post('validasi-skripsi', 'MahasiswaController@validasiSkripsi');
    Route::post('validasi-layak-skripsi', 'MahasiswaController@validasiLayakSkripsi');
    Route::post('validasi-tahapan-skripsi', 'MahasiswaController@validasiTahapanSkripsi');
    Route::post('validasi-tahapan-kp', 'MahasiswaController@validasiTahapanKp');
    
    Route::post('nonaktifkan-semua-lulus', 'MahasiswaController@nonaktifkanSemuaLulus');
});
Route::resource('mahasiswa', 'MahasiswaController');

// Bimbingan
Route::prefix('bimbingan')->group(function(){
    Route::get('create-proposal', 'BimbinganController@create');
    Route::get('create-hasil', 'BimbinganController@create');
    Route::get('create-sidang-skripsi', 'BimbinganController@create');
    Route::get('create-kerja-praktek', 'BimbinganController@create');
    
    Route::get('{id}/edit-proposal', 'BimbinganController@edit');
    Route::get('{id}/edit-hasil', 'BimbinganController@edit');
    Route::get('{id}/edit-sidang-skripsi', 'BimbinganController@edit');
    Route::get('{id}/edit-kerja-praktek', 'BimbinganController@edit');

    Route::get('proposal', 'BimbinganController@index');
    Route::get('hasil', 'BimbinganController@index');
    Route::get('sidang-skripsi', 'BimbinganController@index');
    Route::get('kerja-praktek', 'BimbinganController@index');
});
Route::resource('bimbingan', 'BimbinganController');

Route::get('export-mahasiswa', 'BerandaController@exportMahasiswa');

Route::get('tentang', 'BerandaController@tentang');

Route::get('view-cetak', 'DosenPembimbingController@viewCetak');
Route::get('surat-penunjukan', 'DosenPembimbingController@suratPenunjukan');

// NILAI UJIAN
Route::prefix('nilai-ujian')->group(function(){

    // TAMPIL NILAI
    Route::get('/', 'PenilaianController@indexSkripsi');
    Route::get('skripsi/cari', 'PenilaianController@indexSkripsiCari');
    Route::get('skripsi/export', 'PenilaianController@indexSkripsiExport');
    Route::get('skripsi', 'PenilaianController@indexSkripsi');
    Route::get('kerja-praktek', 'PenilaianController@indexKerjaPraktek');
    Route::get('dosen/cari', 'PenilaianController@dosenCari');
    Route::get('dosen/export', 'PenilaianController@dosenExport');
    
    Route::get('dosen/{tanggal}', 'PenilaianController@dosenByTanggal');
    Route::get('dosen', 'PenilaianController@dosen');
    Route::get('mahasiswa', 'PenilaianController@mahasiswa');

    Route::patch('{id}/proposal', 'PenilaianController@updateProposal');
    Route::patch('{id}/hasil', 'PenilaianController@updateHasil');
    Route::patch('{id}/sidang-skripsi', 'PenilaianController@updateSidangSkripsi');
    Route::patch('{id}/kerja-praktek', 'PenilaianController@updateKerjaPraktek');

    Route::get('{id}/detail', 'PenilaianController@detail');

    Route::get('{id}/detail-proposal', 'PenilaianController@detailUjian');
    Route::get('{id}/detail-hasil', 'PenilaianController@detailUjian');
    Route::get('{id}/detail-sidang-skripsi', 'PenilaianController@detailUjian');
    Route::get('{id}/detail-kerja-praktek', 'PenilaianController@detailKerjaPraktek');
    
    // By Admin
    Route::get('detail-by-admin/{id}', 'PenilaianController@detailByAdmin');
    Route::get('create-by-admin/{id}', 'PenilaianController@createByAdmin');
    Route::post('store-by-admin/{id}', 'PenilaianController@storeByAdmin');
});

// revisi skripsi
Route::prefix('revisi-skripsi')->group(function(){
    Route::get('/', 'BerandaController@indexRevisi');
    Route::get('/create', 'BerandaController@createRevisi');
    Route::post('/', 'BerandaController@storeRevisi');
    Route::get('{id}/edit', 'BerandaController@editRevisi');
    Route::patch('{id}', 'BerandaController@updateRevisi');
});

// asistensi
Route::prefix('asistensi')->group(function(){
    Route::get('cari-semua', 'AsistensiController@cariSemua');
    Route::get('cari-dosen', 'AsistensiController@cariDosen');
    Route::get('create-skripsi', 'AsistensiController@createSkripsi');
    Route::get('create-kerja-praktek', 'AsistensiController@createKp');
    Route::get('mahasiswa', 'AsistensiController@indexDosen');
    Route::get('semua', 'AsistensiController@indexSemua');
    Route::get('{id}/tambah-komentar', 'AsistensiController@tambahKomentar');
    Route::post('{id}/komentar', 'AsistensiController@komentar');
});
Route::resource('asistensi', 'AsistensiController');

// persetujuan ujian
Route::prefix('persetujuan-ujian')->group(function(){
    Route::get('cari-semua', 'PersetujuanUjianController@cariSemua');
    Route::get('cari-dosen', 'PersetujuanUjianController@cariDosen');
    Route::get('mahasiswa', 'PersetujuanUjianController@indexDosen');
    Route::get('semua', 'PersetujuanUjianController@indexSemua');
    Route::get('{id}/cetak', 'PersetujuanUjianController@cetak');
    Route::post('{id}/disetujui', 'PersetujuanUjianController@disetujui');
    Route::post('{id}/tidak-disetujui', 'PersetujuanUjianController@tidakDisetujui');
});
Route::resource('persetujuan-ujian', 'PersetujuanUjianController');

// notifikasi
Route::prefix('notifikasi')->group(function(){
    Route::get('admin', 'NotifikasiController@indexAdmin');
    Route::get('dosen', 'NotifikasiController@indexDosen');
    Route::get('mahasiswa', 'NotifikasiController@indexMahasiswa');
    Route::get('{id}', 'NotifikasiController@show');
    Route::post('semua-dibaca', 'NotifikasiController@semuaDibaca');
    Route::post('hapus-dibaca', 'NotifikasiController@hapusDibaca');
    Route::post('hapus-semua', 'NotifikasiController@hapusSemua');
});

Route::get('cek', 'BerandaController@cek');
Route::get('tes', 'BerandaController@tes');
// Route::post('tes', 'BerandaController@storeTes');
Route::get('phpinfo', 'BerandaController@phpinfo');