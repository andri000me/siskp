<?php

// tanggal format indonesia
function tanggal($tanggal)
{
	$hari = array ( 1 =>    'Senin',
				'Selasa',
				'Rabu',
				'Kamis',
				'Jumat',
				'Sabtu',
				'Minggu'
			);
			
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
            );
    $tanggal = date('Y-m-d', strtotime($tanggal));
	$split 	  = explode('-', $tanggal);
	$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
	
	$num = date('N', strtotime($tanggal));
	return $hari[$num] . ', ' . $tgl_indo;
}

function selisih_waktu($tanggal1) {

    $tgl1 = date_create($tanggal1);
    $tgl2 = date_create('now');

    $selisih_tgl = date_diff($tgl2, $tgl1);

    $selisih["tahun"] = $selisih_tgl->y;
    $selisih["bulan"] = $selisih_tgl->m;
    $selisih["hari"] = $selisih_tgl->d;
    $selisih["jam"] = $selisih_tgl->h;
    $selisih["menit"] = $selisih_tgl->i;
    $selisih["detik"] = $selisih_tgl->s;
    
    if($selisih['tahun']){
        if($tgl1 <= $tgl2) return $selisih['tahun'] . ' tahun yang lalu';
        else return $selisih['tahun'] . ' tahun lagi';
    }elseif($selisih['bulan']){
        if($tgl1 <= $tgl2) return $selisih['bulan'] . ' bulan yang lalu';
        else return $selisih['bulan'] . ' bulan lagi';
    }elseif($selisih['hari']){
        if($tgl1 <= $tgl2) return $selisih['hari'] . ' hari yang lalu';
        else return $selisih['hari'] . ' hari lagi';
    }elseif($selisih['jam']){
        if($tgl1 <= $tgl2) return $selisih['jam'] . ' jam yang lalu';
        else return $selisih['jam'] . ' jam lagi';
    }elseif($selisih['menit']){
        if($tgl1 <= $tgl2) return $selisih['menit'] . ' menit yang lalu';
        else return $selisih['menit'] . ' menit lagi';
    }elseif($selisih['detik']){
        if($tgl1 <= $tgl2) return $selisih['detik'] . ' detik yang lalu';
        else return $selisih['detik'] . ' detik lagi';
    }else{
        return 'baru saja';
    }
}