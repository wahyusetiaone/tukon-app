<?php

if(!function_exists("indonesiaDate")) {
    function indonesiaDate($tgl, $cetak_hari = true) {
        $dt = date('Y-m-d', strtotime($tgl));
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
        $split 	  = explode('-', $dt);
        $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];

        if ($cetak_hari) {
            $num = date('N', strtotime($dt));
            return $hari[$num] . ', ' . $tgl_indo;
        }
        return $tgl_indo;
    }
}

