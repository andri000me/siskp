@extends('template')
@section('main')
            <div class="row mb-2">
                <div class="col-12 col-lg-6 mb-2">
                    <div class="card border">
                        <h5 class="card-header bg-primary text-light"><span class="fa fa-users"></span> Mahasiswa Pendampingan Akademik</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"> <strong>Total </strong> <br> {{ $total_mahasiswa }} Mahasiswa</li>
                            <li class="list-group-item"> <strong>Kontrak Skripsi </strong> <br> {{ $kontrak_skripsi }} Mahasiswa</li>
                            <li class="list-group-item"> <strong>Kontrak Kerja Praktek </strong> <br> {{ $kontrak_kp }} Mahasiswa</li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-6 mb-2">
                    <div class="card border">
                        <h5 class="card-header bg-primary text-light"><span class="fa fa-users"></span> Mahasiswa Bimbingan Skripsi & Kerja Praktek </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"> <strong>Total telah lulus Skripsi </strong> <br> {{ $total_bimbingan_skripsi_lulus }} Mahasiswa</li>
                            <li class="list-group-item"> <strong>Total belum lulus Skripsi </strong> <br> {{ $total_bimbingan_skripsi }} Mahasiswa</li>
                            <li class="list-group-item"> <strong>Total belum lulus Kerja Praktek </strong> <br> {{ $total_bimbingan_kp }} Mahasiswa</li>
                        </ul>
                    </div>
                </div>
            </div>
            
                <!-- statistik tahapan skripsi pendampingan akademik -->
                <div class="card border mb-2">
                    <h5 class="card-header bg-primary text-light"><span class="fa fa-chart-line"></span> Tahapan Skripsi Mahasiswa Pendampingan Akademik</h5>
                    <canvas id="tahapanSkripsi"></canvas>
                                    <script>
                                        var ctx = document.getElementById("tahapanSkripsi");
                                        var myChart = new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                                labels: [
                                                    'Persiapan', 'Pendaftaran Topik', 'Penyusunan Proposal', 'Pendaftaran Proposal', 'Ujian Proposal', 'Penulisan Skripsi', 'Pendaftaran Hasil', 'Ujian Hasil', 'Revisi Skripsi', 'Pendaftaran Sidang', 'Ujian Sidang', 'Lulus'
                                                    ],
                                                datasets: [
                                                    {
                                                        label: "TOTAL MAHASISWA",
                                                        data: [
                                                            {{ $persiapan }}, {{ $pendaftaran_topik }}, {{ $penyusunan_proposal }}, {{ $pendaftaran_proposal }}, {{ $ujian_seminar_proposal }}, {{ $penulisan_skripsi }}, {{ $pendaftaran_hasil }}, {{ $ujian_seminar_hasil }}, {{ $revisi_skripsi }}, {{ $pendaftaran_sidang_skripsi }}, {{ $ujian_sidang_skripsi }}, {{ $lulus }}
                                                        ],
                                                        backgroundColor: "#22a6b3",
                                                        borderColor: "#22a6b3",
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
                
                <!-- statistik tahapan kerja praktek pendampingan akademik -->
                <div class="card border mb-2">
                    <h5 class="card-header bg-primary text-light"><span class="fa fa-chart-line"></span> Tahapan Kerja Praktek Mahasiswa Pendampingan Akademik</h5>
                    <canvas id="tahapanKerjaPraktek"></canvas>
                                    <script>
                                        var ctx = document.getElementById("tahapanKerjaPraktek");
                                        var myChart = new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                                labels: [
                                                    'Persiapan', 'Pendaftaran Ujian', 'Ujian Seminar', 'Revisi', 'Lulus'
                                                    ],
                                                datasets: [
                                                    {
                                                        label: "TOTAL MAHASISWA",
                                                        data: [
                                                            {{ $persiapan_kp }}, {{ $pendaftaran_kp }}, {{ $ujian_seminar_kp }}, {{ $revisi_kp }}, {{ $lulus_kp }}
                                                        ],
                                                        backgroundColor: "#badc58",
                                                        borderColor: "#badc58",
                                                        fill: false,
                                                    },
                                                ]
                                            },
                                            options: {
                                                responsive: true
                                            }
                                        } );
                                    </script>
                </div>

                <!-- statistik tahapan skripsi bimbingan skripsi -->
                <div class="card border mb-2">
                    <h5 class="card-header bg-primary text-light"><span class="fa fa-chart-line"></span> Tahapan Skripsi Mahasiswa Bimbingan Skripsi</h5>
                    <canvas id="tahapanSkripsiBimbinganSkripsi"></canvas>
                                    <script>
                                        var ctx = document.getElementById("tahapanSkripsiBimbinganSkripsi");
                                        var myChart = new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                                labels: [
                                                    'Persiapan', 'Pendaftaran Topik', 'Penyusunan Proposal', 'Pendaftaran Proposal', 'Ujian Proposal', 'Penulisan Skripsi', 'Pendaftaran Hasil', 'Ujian Hasil', 'Revisi Skripsi', 'Pendaftaran Sidang', 'Ujian Sidang', 'Lulus'
                                                    ],
                                                datasets: [
                                                    {
                                                        label: "TOTAL MAHASISWA",
                                                        data: [
                                                            {{ $bimbingan_skripsi_persiapan }}, {{ $bimbingan_skripsi_pendaftaran_topik }}, {{ $bimbingan_skripsi_penyusunan_proposal }}, {{ $bimbingan_skripsi_pendaftaran_proposal }}, {{ $bimbingan_skripsi_ujian_seminar_proposal }}, {{ $bimbingan_skripsi_penulisan_skripsi }}, {{ $bimbingan_skripsi_pendaftaran_hasil }}, {{ $bimbingan_skripsi_ujian_seminar_hasil }}, {{ $bimbingan_skripsi_revisi_skripsi }}, {{ $bimbingan_skripsi_pendaftaran_sidang_skripsi }}, {{ $bimbingan_skripsi_ujian_sidang_skripsi }}, {{ $bimbingan_skripsi_lulus }}
                                                        ],
                                                        backgroundColor: "purple",
                                                        borderColor: "purple",
                                                        fill: false,
                                                    },
                                                ]
                                            },
                                            options: {
                                                responsive: true
                                            }
                                        } );
                                    </script>
                </div>

                <!-- statistik tahapan kerja praktek bimbingan kerja praktek -->
                <div class="card border mb-2">
                    <h5 class="card-header bg-primary text-light"><span class="fa fa-chart-line"></span> Tahapan Kerja Praktek Mahasiswa Bimbingan Kerja Praktek</h5>
                    <canvas id="tahapanKerjaPraktekBimbinganKp"></canvas>
                                    <script>
                                        var ctx = document.getElementById("tahapanKerjaPraktekBimbinganKp");
                                        var myChart = new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                                labels: [
                                                    'Persiapan', 'Pendaftaran Ujian', 'Ujian Seminar', 'Revisi', 'Lulus'
                                                    ],
                                                datasets: [
                                                    {
                                                        label: "TOTAL MAHASISWA",
                                                        data: [
                                                            {{ $bimbingan_kp_persiapan }}, {{ $bimbingan_kp_pendaftaran }}, {{ $bimbingan_kp_ujian_seminar }}, {{ $bimbingan_kp_revisi }}, {{ $bimbingan_kp_lulus }}
                                                        ],
                                                        backgroundColor: "orange",
                                                        borderColor: "orange",
                                                        fill: false,
                                                    },
                                                ]
                                            },
                                            options: {
                                                responsive: true
                                            }
                                        } );
                                    </script>
                </div>
@stop