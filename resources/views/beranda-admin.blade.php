@extends('template')
@section('main')
            <div class="row mb-2">
                <div class="col-12 col-lg-6 mb-2">
                    <div class="card border">
                        <h5 class="card-header bg-primary text-light"><span class="fa fa-users"></span> Mahasiswa </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"> <strong>Total </strong> <br> {{ number_format($total_mahasiswa, 0, ',', '.') }} Mahasiswa</li>
                            <li class="list-group-item"> <strong>Kontrak Skripsi </strong> <br> {{ number_format($kontrak_skripsi, 0, ',', '.') }} Mahasiswa</li>
                            <li class="list-group-item"> <strong>Kontrak Kerja Praktek </strong> <br> {{ number_format($kontrak_kp, 0, ',', '.') }} Mahasiswa</li>
                            <li class="list-group-item"> <strong>Sementara Skripsi </strong> <br> {{ number_format($sementara_skripsi, 0, ',', '.') }} Mahasiswa</li>
                            <li class="list-group-item"> <strong>Telah Lulus </strong> <br> {{ number_format($telah_lulus, 0, ',', '.') }} Mahasiswa </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-6 mb-2">
                    <div class="card border">
                        <h5 class="card-header bg-primary text-light"><span class="fa fa-chalkboard-teacher"></span> Dosen </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"> <strong>Total </strong> <br> {{ $total_dosen }} Dosen</li>
                            <li class="list-group-item"> <strong>Tidak Aktif </strong> <br> {{ $dosen_tidak_aktif }} Dosen</li>
                            <li class="list-group-item"> <strong>Cuti </strong> <br> {{ $dosen_cuti }} Dosen</li>
                            <li class="list-group-item"> <strong>Bisa Membimbing </strong> <br> {{ $bisa_membimbing }} Dosen</li>
                            <li class="list-group-item"> <strong>Bisa Menguji </strong> <br> {{ $bisa_menguji }} Dosen</li>
                        </ul>
                    </div>
                </div>
            </div>

                <!-- statistik pendaftar ujian -->
                <div class="card border mb-2">
                    <h5 class="card-header bg-primary text-light"><span class="fa fa-chart-line"></span> Pendaftar Ujian 10 Periode Terakhir </h5>
                    <canvas id="pendaftarUjian"></canvas>
                    <script>
                        var ctx = document.getElementById("pendaftarUjian");
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: [
                                    @foreach($persentase_ujian as $ujian)
                                        '{{ $ujian->nama }}',
                                    @endforeach
                                    ],
                                datasets: [
                                    {
                                        label: "Total Pendaftar",
                                        data: [
                                        @foreach($persentase_ujian as $ujian)
                                            {{ $ujian->pendaftarUjian->count() }},
                                        @endforeach
                                        ],
                                        backgroundColor: "#eb4d4b",
                                        borderColor: "#eb4d4b",
                                        fill: true,
                                    },
                                ]
                            },
                            options: {
                                responsive: true
                            }
                        } );
                    </script>
                </div>

                <!-- statistik tahapan kerja praktek -->
                <div class="card border mb-2">
                    <h5 class="card-header bg-primary text-light"><span class="fa fa-chart-line"></span> Pendaftar Ujian 10 Periode Terakhir Berdasarkan Ujian </h5>
                    <canvas id="pendaftarByUjian"></canvas>
                                    <script>
                                        var ctx = document.getElementById("pendaftarByUjian");
                                        var myChart = new Chart(ctx, {
                                            type: 'line',
                                            data: {
                                                labels: [
                                                    'Kerja Praktek', 'Seminar Proposal', 'Seminar Hasil', 'Sidang Skripsi'
                                                    ],
                                                datasets: [
                                                    @foreach($pendaftar_by_ujian as $ujian)
                                                    {
                                                        label: "{{ $ujian['periode'] }}",
                                                        data: [
                                                            {{ $ujian['kerja-praktek'] }}, 
                                                            {{ $ujian['proposal'] }}, 
                                                            {{ $ujian['hasil'] }}, 
                                                            {{ $ujian['sidang-skripsi'] }}
                                                        ],
                                                        borderColor: '#'+(Math.random()*0xFFFFFF<<0).toString(16),
                                                        fill: false,
                                                    },
                                                    @endforeach
                                                ],
                                            },
                                            options: {
                                                responsive: true
                                            }
                                        } );
                                    </script>
                </div>

                <!-- statistik pendaftar usulan topik -->
                <div class="card border mb-2">
                    <h5 class="card-header bg-primary text-light"><span class="fa fa-chart-line"></span> Pendaftar Usulan Topik 10 Periode Terakhir </h5>

                    <canvas id="pendaftarUsulanTopik"></canvas>
                    <script>
                        var ctx = document.getElementById("pendaftarUsulanTopik");
                        var myChart = new Chart(ctx, {
                            type : 'bar',
                            data: {
                            labels: [
                                @foreach($persentase_usulan_topik as $usulan)
                                    '{{ $usulan->nama }}',
                                @endforeach
                                ],
                            datasets: [
                                    {
                                        label             : "Total Pendaftar",
                                        data: [
                                        @foreach($persentase_usulan_topik as $usulan)
                                            {{ $usulan->pendaftarUsulanTopik->count() }},
                                        @endforeach
                                        ],
                                        backgroundColor   : "#1E88E5",
                                        borderColor       : "#1E88E5",
                                        fill              : true,
                                    },
                                ]
                            },
                            options: {
                                responsive                : true
                            }
                        } );
                    </script>
                </div>

                <!-- statistik pendaftar turun kp -->
                <div class="card border mb-2">
                    <h5 class="card-header bg-primary text-light"><span class="fa fa-chart-line"></span> Pendaftar Turun KP 10 Periode Terakhir </h5>

                    <canvas id="pendaftarTurunKp"></canvas>
                    <script>
                        var ctx = document.getElementById("pendaftarTurunKp");
                        var myChart = new Chart(ctx, {
                            type : 'bar',
                            data: {
                            labels: [
                                @foreach($persentase_turun_kp as $turun)
                                    '{{ $turun->nama }}',
                                @endforeach
                                ],
                            datasets: [
                                    {
                                        label             : "Total Pendaftar",
                                        data: [
                                        @foreach($persentase_turun_kp as $turun)
                                            {{ $turun->pendaftarTurunKp->count() }},
                                        @endforeach
                                        ],
                                        backgroundColor   : "orange",
                                        borderColor       : "orange",
                                        fill              : false,
                                    },
                                ]
                            },
                            options: {
                                responsive                : true
                            }
                        } );
                    </script>
                </div>

                <!-- statistik tahapan skripsi -->
                <div class="card border mb-2">
                    <h5 class="card-header bg-primary text-light"><span class="fa fa-chart-line"></span> Tahapan Skripsi Angkatan {{ $angkatan->pluck('angkatan')->last() }} - {{ $angkatan->pluck('angkatan')->first() }}   </h5>
                    <canvas id="tahapanSkripsi"></canvas>
                                    <script>
                                        var ctx = document.getElementById("tahapanSkripsi");
                                        var myChart = new Chart(ctx, {
                                            type: 'line',
                                            data: {
                                                labels: [
                                                    'Pendaftaran Topik', 'Penyusunan Proposal', 'Pendaftaran Proposal', 'Ujian Proposal', 'Penulisan Skripsi', 'Pendaftaran Hasil', 'Ujian Hasil', 'Revisi Skripsi', 'Pendaftaran Sidang', 'Ujian Sidang', 'Lulus'
                                                    ],
                                                datasets: [
                                                    @foreach($skripsi_mahasiswa as $skripsi)
                                                    {
                                                        label: {{ $skripsi['angkatan'] }},
                                                        data: [
                                                            {{ $skripsi['pendaftaran_topik'] }}, {{ $skripsi['penyusunan_proposal'] }}, {{ $skripsi['pendaftaran_proposal'] }}, {{ $skripsi['ujian_seminar_proposal'] }}, {{ $skripsi['penulisan_skripsi'] }}, {{ $skripsi['pendaftaran_hasil'] }}, {{ $skripsi['ujian_seminar_hasil'] }}, {{ $skripsi['revisi_skripsi'] }}, {{ $skripsi['pendaftaran_sidang_skripsi'] }}, {{ $skripsi['ujian_sidang_skripsi'] }}, {{ $skripsi['lulus'] }}
                                                        ],
                                                        borderColor: '#'+(Math.random()*0xFFFFFF<<0).toString(16),
                                                        fill: false,
                                                    },
                                                    @endforeach
                                                ]
                                            },
                                            options: {
                                                responsive: true
                                            }
                                        } );
                                    </script>
                </div>

                <!-- statistik tahapan kerja praktek -->
                <div class="card border mb-2">
                    <h5 class="card-header bg-primary text-light"><span class="fa fa-chart-line"></span> Tahapan Kerja Praktek Angkatan {{ $angkatan->pluck('angkatan')->last() }} - {{ $angkatan->pluck('angkatan')->first() }} </h5>
                    <canvas id="tahapanKerjaPraktek"></canvas>
                                    <script>
                                        var ctx = document.getElementById("tahapanKerjaPraktek");
                                        var myChart = new Chart(ctx, {
                                            type: 'line',
                                            data: {
                                                labels: [
                                                    'Pendaftaran Ujian', 'Ujian Seminar', 'Revisi', 'Lulus'
                                                    ],
                                                datasets: [
                                                    @foreach($kp_mahasiswa as $kp)
                                                    {
                                                        label: {{ $kp['angkatan'] }},
                                                        data: [
                                                            {{ $kp['pendaftaran_kp'] }}, {{ $kp['ujian_seminar_kp'] }}, {{ $kp['revisi_kp'] }}, {{ $kp['lulus_kp'] }}
                                                        ],
                                                        borderColor: '#'+(Math.random()*0xFFFFFF<<0).toString(16),
                                                        fill: false,
                                                    },
                                                    @endforeach
                                                ]
                                            },
                                            options: {
                                                responsive: true
                                            }
                                        } );
                                    </script>
                </div>
@stop