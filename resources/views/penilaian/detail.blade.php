@extends('template')
@section('main')
                @include('errors.form_error')

            <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <strong class="bg-primary text-light">Detail Nilai</strong>
                    </div>

                    <!-- jika data ada -->
                    <div class="card-body border-bottom mb-0 pb-0">
                        <dl>
                            <dt>Nama & NIM</dt>
                            <dd>{{ !empty($jadwal->mahasiswa->nama) ? $jadwal->mahasiswa->nama : '-' }} ({{ !empty($jadwal->mahasiswa->nim) ? $jadwal->mahasiswa->nim : '-' }})</dd>

                            <dt>Prodi & Angkatan</dt>
                            <dd>{{ !empty($jadwal->mahasiswa->prodi->nama) ? $jadwal->mahasiswa->prodi->nama : '-' }} ({{ !empty($jadwal->mahasiswa->angkatan) ? $jadwal->mahasiswa->angkatan : '-' }})</dd>

                            <dt>Ujian</dt>
                            <dd>{{ ucwords(str_replace('-', ' ', $jadwal->ujian)) }}</dd>

                            @if($jadwal->ujian !== 'kerja-praktek')
                            <dt>Judul</dt>
                            <dd>{{ !empty($jadwal->mahasiswa->pendaftarUsulanTopik->last()->usulan_judul) ? $jadwal->mahasiswa->pendaftarUsulanTopik->last()->usulan_judul : '-' }}</dd>

                            <dt>Dosen Pembimbing Skripsi</dt>
                            <dd>
                                1). {{ !empty($jadwal->mahasiswa->dosenPembimbingSkripsi->last()->dosbingSatuSkripsi->nama) ? $jadwal->mahasiswa->dosenPembimbingSkripsi->last()->dosbingSatuSkripsi->nama : '-' }} <br>
                                2). {{ !empty($jadwal->mahasiswa->dosenPembimbingSkripsi->last()->dosbingDuaSkripsi->nama) ? $jadwal->mahasiswa->dosenPembimbingSkripsi->last()->dosbingDuaSkripsi->nama : '-' }} <br>
                            </dd>
                            @else
                            <dt>Judul</dt>
                            <dd>
                                {!! !empty($jadwal->mahasiswa->pendaftarUjian->filter(function ($value, $key) { return $value !== null; })->last()->judul_laporan_kp) ? $jadwal->mahasiswa->pendaftarUjian->filter(function ($value, $key) { return $value !== null;})->last()->judul_laporan_kp : $jadwal->mahasiswa->pendaftarUjian->filter(function ($value, $key) { return $value !== null;})->first()->judul_laporan_kp !!}
                            </dd>

                            <dt>Instansi</dt>
                            <dd>{{ !empty($jadwal->mahasiswa->pendaftarTurunKp->last()->instansi) ? $jadwal->mahasiswa->pendaftarTurunKp->last()->instansi : $jadwal->mahasiswa->dosenPembimbingKp->last()->lokasi }}</dd>

                            <dt>Alamat instansi</dt>
                            <dd>{{ !empty($jadwal->mahasiswa->pendaftarTurunKp->last()->alamat) ? $jadwal->mahasiswa->pendaftarTurunKp->last()->alamat : '-' }}</dd>

                            <dt>Dosen Pembimbing Kerja Praktek</dt>
                            <dd>
                                1). {{ !empty($jadwal->mahasiswa->dosenPembimbingKp->last()->dosbingSatuKp->nama) ? $jadwal->mahasiswa->dosenPembimbingKp->last()->dosbingSatuKp->nama : '-' }} <br>
                                2). {{ !empty($jadwal->mahasiswa->dosenPembimbingKp->last()->dosbingDuaKp->nama) ? $jadwal->mahasiswa->dosenPembimbingKp->last()->dosbingDuaKp->nama : '-' }} <br>
                            </dd>
                            @endif

                            <dt>Tempat & Waktu</dt>
                            <dd>{{ $jadwal->tempat }} Hari {{ tanggal($jadwal->waktu_mulai) }} Pukul {{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }} WITA </dd>
                        </dl>
                    </div>

                <!-- Penilaian Proposal -->
                @if(!$jadwal->penilaianProposal->isEmpty())
                    @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                    <!-- form nilai ujian proposal -->
                    <div class="card-body border-bottom mb-0 py-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered table-hover table-sm">
                                <caption class="text-center">Form Nilai Ujian</caption>
                                {!! Form::open(['url' => 'nilai-ujian/'. $jadwal->id .'/proposal', 'method' => 'patch']) !!}
                                {{ csrf_field() }}
                                <tr>
                                    <th class="text-center align-middle" rowspan="2">Indikator & Bobot</th>
                                    <th class="text-center align-middle" colspan="5">Nilai Skor Penguji</th>
                                </tr>
                                <!-- Dosen Penguji -->
                                <tr>
                                    <td class="text-center align-middle">Penguji 1 <br><small>{{ $dosen->dospengSatuProposal->nama }}</small></td>
                                    <td class="text-center align-middle">Penguji 2 <br><small>{{ $dosen->dospengDuaProposal->nama }}</small></td>
                                    <td class="text-center align-middle">Penguji 3 <br><small>{{ $dosen->dospengTigaProposal->nama }}</small></td>
                                    <td class="text-center align-middle">Penguji 4 <br><small>{{ $dosen->dospengEmpatProposal->nama }}</small></td>
                                    <td class="text-center align-middle">Penguji 5 <br><small>{{ $dosen->dospengLimaProposal->nama }}</small></td>
                                </tr>
                                @foreach($penilaian_ujian as $penilaian)
                                {!! Form::hidden("nilai[$penilaian->id][id]", $penilaian->id) !!}
                                        <tr>
                                            <td class="font-weight-bold">{{ ucwords($penilaian->indikatorPenilaian->nama) }} <br>
                                            <small>Bobot: {{ $penilaian->indikatorPenilaian->bobot }}% </small>
                                            </td>
                                            <td class="text-center">
                                                {!! Form::select("nilai[$penilaian->id][nilai_dospeng_satu]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_satu, ['class' => 'custom-select']) !!}
                                            </td>
                                            <td class="text-center">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_dua]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_dua, ['class' => 'custom-select']) !!}
                                            </td>
                                            <td class="text-center">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_tiga]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_tiga, ['class' => 'custom-select']) !!}
                                            </td>
                                            <td class="text-center">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_empat]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_empat, ['class' => 'custom-select']) !!}
                                            </td>
                                            <td class="text-center">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_lima]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_lima, ['class' => 'custom-select']) !!}
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td class="text-right font-weight-bold align-middle">Aksi</td>

                                            <td class="text-right font-weight-bold align-middle" colspan='5'><button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-paper-plane"></i> Submit</button></td>
                                        </tr>
                                {!! Form::close() !!}
                            </table>
                        </div>

                    </div>
                    @elseif(Session::has('dosen'))
                    <!-- form nilai ujian proposal -->
                    <div class="card-body border-bottom mb-0 py-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered table-hover table-sm">
                                <caption class="text-center">Form Nilai Ujian</caption>
                                {!! Form::open(['url' => 'nilai-ujian/'. $jadwal->id .'/proposal', 'method' => 'patch']) !!}
                                {{ csrf_field() }}
                                <tr>
                                    <th class="text-center align-middle" rowspan="2">Indikator & Bobot</th>
                                    <th class="text-center align-middle" >Nilai Skor Penguji</th>
                                </tr>
                                <!-- Dosen Penguji -->
                                <tr>
                                @if(Session::get('id') === $dosen->dospeng_satu_proposal)
                                    <td class="text-center align-middle d-block">Penguji 1 <br><small>{{ $dosen->dospengSatuProposal->nama }}</small></td>
                                @endif

                                @if(Session::get('id') === $dosen->dospeng_dua_proposal)
                                    <td class="text-center align-middle d-block">Penguji 2 <br><small>{{ $dosen->dospengDuaProposal->nama }}</small></td>
                                @endif

                                @if(Session::get('id') === $dosen->dospeng_tiga_proposal)
                                    <td class="text-center align-middle d-block">Penguji 3 <br><small>{{ $dosen->dospengTigaProposal->nama }}</small></td>
                                @endif

                                @if(Session::get('id') === $dosen->dospeng_empat_proposal)
                                    <td class="text-center align-middle d-block">Penguji 4 <br><small>{{ $dosen->dospengEmpatProposal->nama }}</small></td>
                                @endif

                                @if(Session::get('id') === $dosen->dospeng_lima_proposal)
                                    <td class="text-center align-middle d-block">Penguji 5 <br><small>{{ $dosen->dospengLimaProposal->nama }}</small></td>
                                @endif
                                </tr>
                                @foreach($penilaian_ujian as $penilaian)
                                {!! Form::hidden("nilai[$penilaian->id][id]", $penilaian->id) !!}
                                        <tr>
                                            <td class="font-weight-bold">{{ ucwords($penilaian->indikatorPenilaian->nama) }} <br>
                                            <small>Bobot: {{ $penilaian->indikatorPenilaian->bobot }}% </small>
                                            </td>
                                            @if(Session::get('id') === $penilaian->dospeng_satu_proposal)
                                            <td class="text-center d-block">
                                                {!! Form::select("nilai[$penilaian->id][nilai_dospeng_satu]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_satu, ['class' => 'custom-select']) !!}
                                            </td>
                                            @endif
                                            @if(Session::get('id') === $penilaian->dospeng_dua_proposal)
                                            <td class="text-center d-block">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_dua]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_dua, ['class' => 'custom-select']) !!}
                                            </td>
                                            @endif
                                            @if(Session::get('id') === $penilaian->dospeng_tiga_proposal)
                                            <td class="text-center d-block">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_tiga]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_tiga, ['class' => 'custom-select']) !!}
                                            </td>
                                            @endif
                                            @if(Session::get('id') === $penilaian->dospeng_empat_proposal)
                                            <td class="text-center d-block">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_empat]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_empat, ['class' => 'custom-select']) !!}
                                            </td>
                                            @endif
                                            @if(Session::get('id') === $penilaian->dospeng_lima_proposal)
                                            <td class="text-center d-block">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_lima]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_lima, ['class' => 'custom-select']) !!}
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td class="text-right font-weight-bold align-middle">Aksi</td>

                                            <td class="text-right font-weight-bold align-middle d-block" colspan='1'><button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-paper-plane"></i> Submit</button></td>
                                        </tr>
                                {!! Form::close() !!}
                            </table>
                        </div>

                    </div>
                    @endif

                    @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi') || Session::has('mahasiswa'))
                    <!-- tabel nilai proposal -->
                    <div class="card-body border-bottom mb-0 py-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered table-hover table-sm">
                                <caption class="text-center">Nilai Ujian</caption>
                                    <tr>
                                        <th class="text-center align-middle" rowspan="2">Indikator & Bobot (%)</th>
                                        <th class="text-center align-middle" colspan="5">Skor Penguji</th>
                                        <th class="text-center align-middle" rowspan="2">Rata-Rata</th>
                                        <th class="text-center align-middle" rowspan="2">Bobot x Rata-Rata</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center align-middle">Penguji 1<br> <small>{{ $dosen->dospengSatuProposal->nama }}</small></td>
                                        <td class="text-center align-middle">Penguji 2<br><small>{{ $dosen->dospengDuaProposal->nama }}</small></td>
                                        <td class="text-center align-middle">Penguji 3<br><small>{{ $dosen->dospengTigaProposal->nama }}</small></td>
                                        <td class="text-center align-middle">Penguji 4<br><small>{{ $dosen->dospengEmpatProposal->nama }}</small></td>
                                        <td class="text-center align-middle d-block">Penguji 5<br><small>{{ $dosen->dospengLimaProposal->nama }}</small></td>
                                    </tr>
                                    @foreach($penilaian_ujian as $penilaian)
                                    <tr>
                                        <td class="font-weight-bold">{{ ucwords($penilaian->indikatorPenilaian->nama) }} <br> <small>Bobot: {{ $penilaian->indikatorPenilaian->bobot }}%</small></td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_satu }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_dua }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_tiga }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_empat }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_lima }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_rerata }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_rerata_x_bobot }}</td>
                                    </tr>
                                    @endforeach
                                    @foreach($jadwal->nilaiUjianSkripsi as $nilaiUjian)
                                    <tr>
                                        <td class="text-right font-weight-bold align-middle" colspan="7">Jumlah Nilai</td>
                                        <td class="text-center">{{ $nilaiUjian->jumlah_nilai }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right font-weight-bold align-middle" colspan="7">Nilai Akhir Seminar Proposal: (Jumlah Nilai / 500) * 100</td>
                                        <td class="text-center">{{ $nilaiUjian->nilai_akhir }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right font-weight-bold align-middle" colspan="7">Status </td>
                                        <td class="text-center">
                                        @if($nilaiUjian->status === 'lulus')
                                            <span class="text-primary"><i class="fa fa-check"></i>&nbsp; Lulus</span>
                                        @else
                                            <span class="text-danger"><i class="fa fa-times"></i>&nbsp; Belum Lulus </span>
                                        @endif</td>
                                    </tr>
                                    @endforeach
                            </table>
                        </div>

                    </div>
                    @endif

                <!-- Penilaian Hasil -->
                @elseif(!$jadwal->penilaianHasil->isEmpty())
                    @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                    <!-- form nilai ujian hasil -->
                    <div class="card-body border-bottom mb-0 py-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered table-hover table-sm">
                                <caption class="text-center">Form Nilai Ujian</caption>
                                {!! Form::open(['url' => 'nilai-ujian/'. $jadwal->id .'/hasil', 'method' => 'patch']) !!}
                                {{ csrf_field() }}
                                <tr>
                                    <th class="text-center align-middle" rowspan="2">Indikator & Bobot</th>
                                    <th class="text-center align-middle" colspan="5">Nilai Skor Penguji</th>
                                </tr>
                                <!-- Dosen Penguji -->
                                <tr>
                                    <td class="text-center align-middle">Penguji 1 <br><small>{{ $dosen->dospengSatuHasil->nama }}</small></td>
                                    <td class="text-center align-middle">Penguji 2 <br><small>{{ $dosen->dospengDuaHasil->nama }}</small></td>
                                    <td class="text-center align-middle">Penguji 3 <br><small>{{ $dosen->dospengTigaHasil->nama }}</small></td>
                                    <td class="text-center align-middle">Penguji 4 <br><small>{{ $dosen->dospengEmpatHasil->nama }}</small></td>
                                    <td class="text-center align-middle">Penguji 5 <br><small>{{ $dosen->dospengLimaHasil->nama }}</small></td>
                                </tr>
                                @foreach($penilaian_ujian as $penilaian)
                                {!! Form::hidden("nilai[$penilaian->id][id]", $penilaian->id) !!}
                                        <tr>
                                            <td class="font-weight-bold">{{ ucwords($penilaian->indikatorPenilaian->nama) }} <br>
                                            <small>Bobot: {{ $penilaian->indikatorPenilaian->bobot }}% </small>
                                            </td>
                                            <td class="text-center">
                                                {!! Form::select("nilai[$penilaian->id][nilai_dospeng_satu]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_satu, ['class' => 'custom-select']) !!}
                                            </td>
                                            <td class="text-center">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_dua]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_dua, ['class' => 'custom-select']) !!}
                                            </td>
                                            <td class="text-center">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_tiga]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_tiga, ['class' => 'custom-select']) !!}
                                            </td>
                                            <td class="text-center">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_empat]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_empat, ['class' => 'custom-select']) !!}
                                            </td>
                                            <td class="text-center">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_lima]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_lima, ['class' => 'custom-select']) !!}
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td class="text-right font-weight-bold align-middle">Aksi</td>

                                            <td class="text-right font-weight-bold align-middle" colspan='5'><button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-paper-plane"></i> Submit</button></td>
                                        </tr>
                                {!! Form::close() !!}
                            </table>
                        </div>

                    </div>
                    @elseif(Session::has('dosen'))
                    <!-- form nilai ujian hasil -->
                    <div class="card-body border-bottom mb-0 py-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered table-hover table-sm">
                                <caption class="text-center">Form Nilai Ujian</caption>
                                {!! Form::open(['url' => 'nilai-ujian/'. $jadwal->id .'/hasil', 'method' => 'patch']) !!}
                                {{ csrf_field() }}
                                <tr>
                                    <th class="text-center align-middle" rowspan="2">Indikator & Bobot</th>
                                    <th class="text-center align-middle" >Nilai Skor Penguji</th>
                                </tr>
                                <!-- Dosen Penguji -->
                                <tr>
                                @if(Session::get('id') === $dosen->dospeng_satu_hasil)
                                    <td class="text-center align-middle d-block">Penguji 1 <br><small>{{ $dosen->dospengSatuHasil->nama }}</small></td>
                                @endif

                                @if(Session::get('id') === $dosen->dospeng_dua_hasil)
                                    <td class="text-center align-middle d-block">Penguji 2 <br><small>{{ $dosen->dospengDuaHasil->nama }}</small></td>
                                @endif

                                @if(Session::get('id') === $dosen->dospeng_tiga_hasil)
                                    <td class="text-center align-middle d-block">Penguji 3 <br><small>{{ $dosen->dospengTigaHasil->nama }}</small></td>
                                @endif

                                @if(Session::get('id') === $dosen->dospeng_empat_hasil)
                                    <td class="text-center align-middle d-block">Penguji 4 <br><small>{{ $dosen->dospengEmpatHasil->nama }}</small></td>
                                @endif

                                @if(Session::get('id') === $dosen->dospeng_lima_hasil)
                                    <td class="text-center align-middle d-block">Penguji 5 <br><small>{{ $dosen->dospengLimaHasil->nama }}</small></td>
                                @endif
                                </tr>
                                @foreach($penilaian_ujian as $penilaian)
                                {!! Form::hidden("nilai[$penilaian->id][id]", $penilaian->id) !!}
                                        <tr>
                                            <td class="font-weight-bold">{{ ucwords($penilaian->indikatorPenilaian->nama) }} <br>
                                            <small>Bobot: {{ $penilaian->indikatorPenilaian->bobot }}% </small>
                                            </td>
                                            @if(Session::get('id') === $penilaian->dospeng_satu_hasil)
                                            <td class="text-center d-block">
                                                {!! Form::select("nilai[$penilaian->id][nilai_dospeng_satu]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_satu, ['class' => 'custom-select']) !!}
                                            </td>
                                            @endif
                                            @if(Session::get('id') === $penilaian->dospeng_dua_hasil)
                                            <td class="text-center d-block">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_dua]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_dua, ['class' => 'custom-select']) !!}
                                            </td>
                                            @endif
                                            @if(Session::get('id') === $penilaian->dospeng_tiga_hasil)
                                            <td class="text-center d-block">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_tiga]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_tiga, ['class' => 'custom-select']) !!}
                                            </td>
                                            @endif
                                            @if(Session::get('id') === $penilaian->dospeng_empat_hasil)
                                            <td class="text-center d-block">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_empat]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_empat, ['class' => 'custom-select']) !!}
                                            </td>
                                            @endif
                                            @if(Session::get('id') === $penilaian->dospeng_lima_hasil)
                                            <td class="text-center d-block">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_lima]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_lima, ['class' => 'custom-select']) !!}
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td class="text-right font-weight-bold align-middle">Aksi</td>

                                            <td class="text-right font-weight-bold align-middle d-block" colspan='1'><button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-paper-plane"></i> Submit</button></td>
                                        </tr>
                                {!! Form::close() !!}
                            </table>
                        </div>

                    </div>
                    @endif

                    @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi') || Session::has('mahasiswa'))
                    <!-- tabel nilai hasil -->
                    <div class="card-body border-bottom mb-0 py-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered table-hover table-sm">
                                    <caption class="text-center">Nilai Ujian</caption>
                                    <tr>
                                        <th class="text-center align-middle" rowspan="2">Indikator & Bobot (%)</th>
                                        <th class="text-center align-middle" colspan="5">Skor Penguji</th>
                                        <th class="text-center align-middle" rowspan="2">Rata-Rata</th>
                                        <th class="text-center align-middle" rowspan="2">Bobot x Rata-Rata</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center align-middle">Penguji 1<br> <small>{{ $dosen->dospengSatuHasil->nama }}</small></td>
                                        <td class="text-center align-middle">Penguji 2<br><small>{{ $dosen->dospengDuaHasil->nama }}</small></td>
                                        <td class="text-center align-middle">Penguji 3<br><small>{{ $dosen->dospengTigaHasil->nama }}</small></td>
                                        <td class="text-center align-middle">Penguji 4<br><small>{{ $dosen->dospengEmpatHasil->nama }}</small></td>
                                        <td class="text-center align-middle d-block">Penguji 5<br><small>{{ $dosen->dospengLimaHasil->nama }}</small></td>
                                    </tr>
                                    @foreach($penilaian_ujian as $penilaian)
                                    <tr>
                                        <td class="font-weight-bold">{{ ucwords($penilaian->indikatorPenilaian->nama) }} <br> <small>Bobot: {{ $penilaian->indikatorPenilaian->bobot }}%</small></td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_satu }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_dua }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_tiga }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_empat }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_lima }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_rerata }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_rerata_x_bobot }}</td>
                                    </tr>
                                    @endforeach
                                    @foreach($jadwal->nilaiUjianSkripsi as $nilaiUjian)
                                    <tr>
                                        <td class="text-right font-weight-bold align-middle" colspan="7">Jumlah Nilai</td>
                                        <td class="text-center">{{ $nilaiUjian->jumlah_nilai }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right font-weight-bold align-middle" colspan="7">Nilai Akhir Seminar Hasil: (Jumlah Nilai / 500) * 100</td>
                                        <td class="text-center">{{ $nilaiUjian->nilai_akhir }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right font-weight-bold align-middle" colspan="7">Status </td>
                                        <td class="text-center">
                                        @if($nilaiUjian->status === 'lulus')
                                            <span class="text-primary"><i class="fa fa-check"></i>&nbsp; Lulus</span>
                                        @else
                                            <span class="text-danger"><i class="fa fa-times"></i>&nbsp; Belum Lulus </span>
                                        @endif</td>
                                    </tr>
                                    @endforeach
                            </table>
                        </div>

                    </div>
                    @endif

                <!-- penilaian sidang skripsi -->
                @elseif(!$jadwal->penilaianSidangSkripsi->isEmpty())
                    @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                    <!-- form nilai ujian sidang skripsi -->
                    <div class="card-body border-bottom mb-0 py-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered table-hover table-sm">
                                <caption class="text-center">Form Nilai Ujian</caption>
                                {!! Form::open(['url' => 'nilai-ujian/'. $jadwal->id .'/sidang-skripsi', 'method' => 'patch']) !!}
                                {{ csrf_field() }}
                                <tr>
                                    <th class="text-center align-middle" rowspan="2">Indikator & Bobot</th>
                                    <th class="text-center align-middle" colspan="5">Nilai Skor Penguji</th>
                                </tr>
                                <!-- Dosen Penguji -->
                                <tr>
                                    <td class="text-center align-middle">Penguji 1 <br><small>{{ $dosen->dospengSatuSidang->nama }}</small></td>
                                    <td class="text-center align-middle">Penguji 2 <br><small>{{ $dosen->dospengDuaSidang->nama }}</small></td>
                                    <td class="text-center align-middle">Penguji 3 <br><small>{{ $dosen->dospengTigaSidang->nama }}</small></td>
                                    <td class="text-center align-middle">Penguji 4 <br><small>{{ $dosen->dospengEmpatSidang->nama }}</small></td>
                                    <td class="text-center align-middle">Penguji 5 <br><small>{{ $dosen->dospengLimaSidang->nama }}</small></td>
                                </tr>
                                @foreach($penilaian_ujian as $penilaian)
                                {!! Form::hidden("nilai[$penilaian->id][id]", $penilaian->id) !!}
                                        <tr>
                                            <td class="font-weight-bold">{{ ucwords($penilaian->indikatorPenilaian->nama) }} <br>
                                            <small>Bobot: {{ $penilaian->indikatorPenilaian->bobot }}% </small>
                                            </td>
                                            <td class="text-center">
                                                {!! Form::select("nilai[$penilaian->id][nilai_dospeng_satu]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_satu, ['class' => 'custom-select']) !!}
                                            </td>
                                            <td class="text-center">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_dua]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_dua, ['class' => 'custom-select']) !!}
                                            </td>
                                            <td class="text-center">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_tiga]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_tiga, ['class' => 'custom-select']) !!}
                                            </td>
                                            <td class="text-center">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_empat]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_empat, ['class' => 'custom-select']) !!}
                                            </td>
                                            <td class="text-center">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_lima]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_lima, ['class' => 'custom-select']) !!}
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td class="text-right font-weight-bold align-middle">Aksi</td>

                                            <td class="text-right font-weight-bold align-middle" colspan='5'><button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-paper-plane"></i> Submit</button></td>
                                        </tr>
                                {!! Form::close() !!}
                            </table>
                        </div>

                    </div>
                    @elseif(Session::has('dosen'))
                    <!-- form nilai ujian sidang skripsi -->
                    <div class="card-body border-bottom mb-0 py-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered table-hover table-sm">
                            <caption class="text-center">Form Nilai Ujian</caption>
                                {!! Form::open(['url' => 'nilai-ujian/'. $jadwal->id .'/sidang-skripsi', 'method' => 'patch']) !!}
                                {{ csrf_field() }}
                                <tr>
                                    <th class="text-center align-middle" rowspan="2">Indikator & Bobot</th>
                                    <th class="text-center align-middle" >Nilai Skor Penguji</th>
                                </tr>
                                <!-- Dosen Penguji -->
                                <tr>
                                @if(Session::get('id') === $dosen->dospeng_satu_sidang)
                                    <td class="text-center align-middle d-block">Penguji 1 <br><small>{{ $dosen->dospengSatuSidang->nama }}</small></td>
                                @endif

                                @if(Session::get('id') === $dosen->dospeng_dua_sidang)
                                    <td class="text-center align-middle d-block">Penguji 2 <br><small>{{ $dosen->dospengDuaSidang->nama }}</small></td>
                                @endif

                                @if(Session::get('id') === $dosen->dospeng_tiga_sidang)
                                    <td class="text-center align-middle d-block">Penguji 3 <br><small>{{ $dosen->dospengTigaSidang->nama }}</small></td>
                                @endif

                                @if(Session::get('id') === $dosen->dospeng_empat_sidang)
                                    <td class="text-center align-middle d-block">Penguji 4 <br><small>{{ $dosen->dospengEmpatSidang->nama }}</small></td>
                                @endif

                                @if(Session::get('id') === $dosen->dospeng_lima_sidang)
                                    <td class="text-center align-middle d-block">Penguji 5 <br><small>{{ $dosen->dospengLimaSidang->nama }}</small></td>
                                @endif
                                </tr>
                                @foreach($penilaian_ujian as $penilaian)
                                {!! Form::hidden("nilai[$penilaian->id][id]", $penilaian->id) !!}
                                        <tr>
                                            <td class="font-weight-bold">{{ ucwords($penilaian->indikatorPenilaian->nama) }} <br>
                                            <small>Bobot: {{ $penilaian->indikatorPenilaian->bobot }}% </small>
                                            </td>
                                            @if(Session::get('id') === $penilaian->dospeng_satu_sidang)
                                            <td class="text-center d-block">
                                                {!! Form::select("nilai[$penilaian->id][nilai_dospeng_satu]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_satu, ['class' => 'custom-select']) !!}
                                            </td>
                                            @endif
                                            @if(Session::get('id') === $penilaian->dospeng_dua_sidang)
                                            <td class="text-center d-block">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_dua]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_dua, ['class' => 'custom-select']) !!}
                                            </td>
                                            @endif
                                            @if(Session::get('id') === $penilaian->dospeng_tiga_sidang)
                                            <td class="text-center d-block">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_tiga]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_tiga, ['class' => 'custom-select']) !!}
                                            </td>
                                            @endif
                                            @if(Session::get('id') === $penilaian->dospeng_empat_sidang)
                                            <td class="text-center d-block">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_empat]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_empat, ['class' => 'custom-select']) !!}
                                            </td>
                                            @endif
                                            @if(Session::get('id') === $penilaian->dospeng_lima_sidang)
                                            <td class="text-center d-block">
                                                    {!! Form::select("nilai[$penilaian->id][nilai_dospeng_lima]", ['0' => '-- Skor Nilai --', '1' => 'Sangat Buruk (1)', '2' => 'Buruk (2)', '3' => 'Cukup (3)', '4' => 'Baik (4)', '5' => 'Sangat Baik (5)'], $penilaian->nilai_dospeng_lima, ['class' => 'custom-select']) !!}
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td class="text-right font-weight-bold align-middle">Aksi</td>

                                            <td class="text-right font-weight-bold align-middle d-block" colspan='1'><button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-paper-plane"></i> Submit</button></td>
                                        </tr>
                                {!! Form::close() !!}
                            </table>
                        </div>

                    </div>
                    @endif

                    @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi') || Session::has('mahasiswa'))
                    <!-- tabel nilai sidang skripsi -->
                    <div class="card-body border-bottom mb-0 py-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered table-hover table-sm">
                                <caption class="text-center">Nilai Ujian</caption>
                                    <tr>
                                        <th class="text-center align-middle" rowspan="2">Indikator & Bobot (%)</th>
                                        <th class="text-center align-middle" colspan="5">Skor Penguji</th>
                                        <th class="text-center align-middle" rowspan="2">Rata-Rata</th>
                                        <th class="text-center align-middle" rowspan="2">Bobot x Rata-Rata</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center align-middle">Penguji 1<br> <small>{{ $dosen->dospengSatuSidang->nama }}</small></td>
                                        <td class="text-center align-middle">Penguji 2<br><small>{{ $dosen->dospengDuaSidang->nama }}</small></td>
                                        <td class="text-center align-middle">Penguji 3<br><small>{{ $dosen->dospengTigaSidang->nama }}</small></td>
                                        <td class="text-center align-middle">Penguji 4<br><small>{{ $dosen->dospengEmpatSidang->nama }}</small></td>
                                        <td class="text-center align-middle d-block">Penguji 5<br><small>{{ $dosen->dospengLimaSidang->nama }}</small></td>
                                    </tr>
                                    @foreach($penilaian_ujian as $penilaian)
                                    <tr>
                                        <td class="font-weight-bold">{{ ucwords($penilaian->indikatorPenilaian->nama) }} <br> <small>Bobot: {{ $penilaian->indikatorPenilaian->bobot }}%</small></td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_satu }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_dua }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_tiga }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_empat }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_dospeng_lima }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_rerata }}</td>
                                        <td class="text-center align-middle">{{ $penilaian->nilai_rerata_x_bobot }}</td>
                                    </tr>
                                    @endforeach
                                    @foreach($jadwal->nilaiUjianSkripsi as $nilaiUjian)
                                    <tr>
                                        <td class="text-right font-weight-bold align-middle" colspan="7">Jumlah Nilai</td>
                                        <td class="text-center">{{ $nilaiUjian->jumlah_nilai }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right font-weight-bold align-middle" colspan="7">Nilai Akhir Sidang Skripsi: (Jumlah Nilai / 500) * 100</td>
                                        <td class="text-center">{{ $nilaiUjian->nilai_akhir }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right font-weight-bold align-middle" colspan="7">Status </td>
                                        <td class="text-center">
                                        @if($nilaiUjian->status === 'lulus')
                                            <span class="text-primary"><i class="fa fa-check"></i>&nbsp; Lulus</span>
                                        @else
                                            <span class="text-danger"><i class="fa fa-times"></i>&nbsp; Belum Lulus </span>
                                        @endif</td>
                                    </tr>
                                    @endforeach
                            </table>
                        </div>

                    </div>
                    @endif

                <!-- penialaian kerja praktek -->
                @elseif(!$jadwal->penilaianKp->isEmpty())

                                        <?php $i=1 ?>
                                        @foreach($dospeng as $dosenPenguji)
                                            @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi') || Session::has('mahasiswa'))
                                            <div class="accordion" id="accordionExample">
                                                <div class="card">
                                                    <div class="card-header" id="heading{{ $i }}">
                                                        <h2 class="m-0">
                                                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#collapse{{ $i }}"> <strong> Penguji {{ $i }} - {{ $dosenPenguji[0]->dosen->nama }} </strong></button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapse{{ $i }}" class="collapse" data-parent="#accordionExample">
                                                        <div class="card-body table-responsive text-nowrap">
                                                            <table class="table table-bordered table-hover table-sm">
                                                            @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi') || $penguji === $dosenPenguji[0]->dosen->id)
                                                                {!! Form::open(['url' => 'nilai-ujian/'. $jadwal->id .'/kerja-praktek', 'method' => 'patch']) !!}
                                                                {{ csrf_field() }}
                                                            @endif
                                                                <tr>
                                                                    <th>Indikator & Bobot (%) </th>
                                                                    <th class="text-center">Nilai ({{ $indikator->nilai_min }}-{{ $indikator->nilai_max }}) </th>
                                                                </tr>
                                                                @foreach($dosenPenguji as $nilai)
                                                                <tr>
                                                                    <td>{{ ucwords($nilai->indikatorPenilaian->nama) }} <br>
                                                                    Bobot: {{ $nilai->indikatorPenilaian->bobot }}%
                                                                    </td>
                                                            @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                                                                    {!! Form::hidden("nilai[$nilai->id][id]", $nilai->id) !!}

                                                                    <td>{!! Form::text("nilai[$nilai->id][nilai]", $nilai->nilai, ['class' => 'form-control']) !!}</td>

                                                                    {!! Form::hidden("nilai[$nilai->id][bobot]", $nilai->indikatorPenilaian->bobot) !!}
                                                            @else
                                                                    <td class="text-center align-middle">{{ $nilai->nilai }}</td>
                                                            @endif
                                                                </tr>
                                                                @endforeach
                                                            @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                                                                <tr>
                                                                    <th class="text-right">Aksi</th>
                                                                    <td>
                                                                        <button type="submit" class="btn btn-primary btn-block btn-sm">
                                                                        <i class="fa fa-paper-plane"></i> Submit</button>
                                                                    </td>
                                                                </tr>
                                                                {!! Form::close() !!}
                                                            @endif
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @elseif(Session::has('dosen'))
                                            @if($penguji === $dosenPenguji[0]->dosen->id)
                                            <div class="accordion" id="accordionExample">
                                                <div class="card">
                                                    <div class="card-header" id="heading{{ $i }}">
                                                        <h2 class="m-0">
                                                            <button class="btn btn-outline-primary btn-sm btn-block" type="button" data-toggle="collapse" data-target="#collapse{{ $i }}"> <strong> PENGUJI {{ $i }} - {{ $dosenPenguji[0]->dosen->nama }} </strong></button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapse{{ $i }}" class="collapse show" data-parent="#accordionExample">
                                                        <div class="card-body table-responsive text-nowrap">
                                                            <table class="table table-bordered table-hover table-sm">
                                                                {!! Form::open(['url' => 'nilai-ujian/'. $jadwal->id .'/kerja-praktek', 'method' => 'patch']) !!}
                                                                {{ csrf_field() }}
                                                                <tr>
                                                                    <th>Indikator & Bobot (%) </th>
                                                                    <th class="text-center">Nilai ({{ $indikator->nilai_min }}-{{ $indikator->nilai_max }}) </th>
                                                                </tr>
                                                                @foreach($dosenPenguji as $nilai)
                                                                <tr>
                                                                    <td>{{ ucwords($nilai->indikatorPenilaian->nama) }} <br>
                                                                    Bobot: {{ $nilai->indikatorPenilaian->bobot }}%
                                                                    </td>
                                                                    {!! Form::hidden("nilai[$nilai->id][id]", $nilai->id) !!}

                                                                    <td>{!! Form::text("nilai[$nilai->id][nilai]", $nilai->nilai, ['class' => 'form-control']) !!}</td>

                                                                    {!! Form::hidden("nilai[$nilai->id][bobot]", $nilai->indikatorPenilaian->bobot) !!}

                                                                </tr>
                                                                @endforeach
                                                                <tr>
                                                                    <th class="text-right">Aksi</th>
                                                                    <td>
                                                                        <button type="submit" class="btn btn-primary btn-block btn-sm">
                                                                        <i class="fa fa-paper-plane"></i> Submit</button>
                                                                    </td>
                                                                </tr>
                                                                {!! Form::close() !!}
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @endif
                                        <?php $i++ ?>
                                        @endforeach

                                        @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi') || Session::has('mahasiswa'))
                                        <br>
                                        <div class="table-responsie text-nowrap">
                                        <table class="table table table-bordered table-hover table-sm">
                                            <tr>
                                                <th class="text-center">Total Nilai</th>
                                                <th class="text-center">Huruf</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                            @foreach($jadwal->nilaiUjianKp as $nilaiUjian)
                                                <tr>
                                                    <td class="text-center">{{ $nilaiUjian->total }}</td>
                                                    <td class="text-center">{{ $nilaiUjian->nilai_huruf }}</td>
                                                    <td class="text-center d-block"> <strong>
                                                    @if($nilaiUjian->status === 'lulus')
                                                        <span class="text-primary"><i class="fa fa-check"></i>&nbsp; Lulus</span>
                                                    @else
                                                        <span class="text-danger"><i class="fa fa-times"></i>&nbsp; Belum Lulus</span>
                                                    @endif
                                                    </strong></td>
                                                </tr>
                                            @endforeach
                                        </table>
                                        </div>
                                        <br>
                                        @endif

                @endif

                @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi') || Session::has('mahasiswa'))
                    @if(!empty($nilai_skripsi))
                        <div class="card-body border table-full-width table-responsive text-nowrap">
                            <table class="table table-hover table-striped table-sm">
                                <caption>Hasil Akumulasi Nilai Skripsi</caption>
                                <thead>
                                    <th class="text-center">Seminar Proposal</th>
                                    <th class="text-center">Seminar Hasil</th>
                                    <th class="text-center">Sidang Skripsi</th>
                                    <th class="text-center">Total Nilai</th>
                                    <th class="text-center">Huruf</th>
                                @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                                    <th class="text-center">Aksi</th>
                                @endif
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">{{ !empty($nilai_skripsi->seminar_proposal) ? $nilai_skripsi->seminar_proposal : '0' }} </td>
                                        <td class="text-center">{{ !empty($nilai_skripsi->seminar_hasil) ? $nilai_skripsi->seminar_hasil : '0' }}</td>
                                        <td class="text-center">{{ !empty($nilai_skripsi->sidang_skripsi) ? $nilai_skripsi->sidang_skripsi : '0' }}</td>
                                        <td class="text-center">{{ $nilai_skripsi->total }}</td>
                                        <td class="text-center">{{ $nilai_skripsi->nilai_huruf }}</td>
                                    @if(Session::has('admin') || Session::has('kajur') || Session::has('kaprodi'))
                                        <td class="text-center align-middle">
                                            <a class="text-primary" title="Input Nilai Skripsi" href="{{ url('nilai-ujian/create-by-admin/' . $jadwal->id_mahasiswa) }}"><span class="fa fa-plus fa-lg"></span></a>
                                        </td>
                                    @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endif

            </div>
@stop
