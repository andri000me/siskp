@extends('template-masuk')
@section('main-masuk')
    <div class="col-12 col-lg-9 my-2">
        <h6 class="card-header bg-primary font-weight-bold text-light"><span class="fa fa-info-circle fa-lg"></span> Info Skripsi & Kerja Praktek</h6>

        <ul class="list-group border list-group-flush">
            <li class="list-group-item">
                <a href="{{ url('masuk/ujian') }}" class="font-weight-bold text-dark"><span class="far fa-edit fa-fw"></span> Ujian </a><br>
                        <!-- jika periode ujian telah dibuka -->
                        @if(!empty($periode_ujian))
                        Pendaftaran Ujian periode <span class="text-capitalize">{{ $periode_ujian->nama }}</span> telah dibuka mulai dari Hari {{ tanggal($periode_ujian->waktu_buka) }} s/d Hari {{ tanggal($periode_ujian->waktu_tutup) }}.
                        <!-- jika periode ujian belum dibuka -->
                        @else
                        Pendaftaran Ujian belum dibuka.
                        @endif
            </li>
            <li class="list-group-item">
                <a href="{{ url('masuk/jadwal/' . date('Y-m')) }}" class="font-weight-bold text-dark"><span class="far fa-clock fa-fw"></span> Jadwal Ujian </a><br>
                        @if(!empty($daftar_jadwal))
                        {{ $daftar_jadwal }} Mahasiswa mengikuti ujian di Bulan
                        @switch(date('m'))
                            @case(1) Januari @break
                            @case(2) Februari @break
                            @case(3) Maret @break
                            @case(4) April @break
                            @case(5) Mei @break
                            @case(6) Juni @break
                            @case(7) Juli @break
                            @case(8) Agustus @break
                            @case(9) September @break
                            @case(10) Oktober @break
                            @case(11) November @break
                            @case(12) Desember @break
                        @endswitch
                         {{ date('Y') }}.

                        <!-- jika data kosong -->
                        @else
                        Jadwal Ujian belum tersedia.
                        @endif
            </li>
            <li class="list-group-item">
                <a href="{{ url('masuk/usulan-topik') }}" class="font-weight-bold text-dark"><span class="far fa-lightbulb fa-fw"></span> Usulan Topik </a><br>
                <!-- jika periode usulan topik telah dibuka -->
                @if(!empty($periode_usulan_topik))
                Pendaftaran Usulan Topik periode <span class="text-capitalize">{{ $periode_usulan_topik->nama }}</span> telah dibuka mulai dari Hari {{ tanggal($periode_usulan_topik->waktu_buka) }} s/d Hari {{ tanggal($periode_usulan_topik->waktu_tutup) }}.

                <!-- jika periode usulan topik belum dibuka -->
                @else
                Pendaftaran Usulan Topik belum dibuka.
                @endif
            </li>
            <li class="list-group-item">
                <a href="{{ url('masuk/kerja-praktek') }}" class="font-weight-bold text-dark"><span class="fa fa-university fa-fw"></span> Kerja Praktek </a><br>
                <!-- jika periode turun kp telah dibuka -->
                @if(!empty($periode_turun_kp))
                Pendaftaran Turun Kerja Praktek periode <span class="text-capitalize">{{ $periode_turun_kp->nama }}</span> telah dibuka mulai dari Hari {{ tanggal($periode_turun_kp->waktu_buka) }} s/d Hari {{ tanggal($periode_turun_kp->waktu_tutup) }}.

                <!-- jika periode turun kp belum dibuka -->
                @else
                Pendaftaran Turun Kerja Praktek belum dibuka.
                @endif
            </li>
            <li class="list-group-item">
                <a href="{{ url('masuk/riwayat-skripsi') }}" class="font-weight-bold text-dark"><span class="fa fa-history fa-fw"></span> Riwayat Skripsi </a><br>
                {{ number_format($mahasiswa_lulus, 0, ',', '.') }} Mahasiswa telah lulus & {{ number_format($mahasiswa_sementara_skripsi, 0, ',', '.') }} Mahasiswa sedang mengerjakan skripsinya.
            </li>
        </ul>
    </div>
@stop
