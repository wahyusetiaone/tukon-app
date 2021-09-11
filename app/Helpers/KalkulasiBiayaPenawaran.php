<?php

if(!function_exists("kalkulasiBiayaPenawaranBaru")) {
    function kalkulasiBiayaPenawaranBaru($p_tukang, $p_bpa, $l_komponen, $u_komponen) {
        $harga_t_komponen = 0;
        for ($i = 0; $i < count($l_komponen); $i++){
            $harga_t_komponen += $l_komponen[$i] * $u_komponen[$i];
        }
        return $harga_t_komponen + ($harga_t_komponen * ($p_tukang/100)) + ($harga_t_komponen * ($p_bpa/100));
    }
}

if(!function_exists("kalkulasiBiayaPenawaranUpdate")) {
    function kalkulasiBiayaPenawaranUpdate($p_tukang, $p_bpa, $h_komponen) {
        return $h_komponen + ($h_komponen * ($p_tukang/100)) + ($h_komponen * ($p_bpa/100));
    }
}

if(!function_exists("kalkulasiBiayaPenawaranOfflineBaru")) {
    function kalkulasiBiayaPenawaranOfflineBaru($p_tukang, $l_komponen) {
        $harga_t_komponen = array_sum($l_komponen);
        return $harga_t_komponen + ($harga_t_komponen * ($p_tukang/100));
    }
}

if(!function_exists("kalkulasiBiayaPenawaranOfflineUpdate")) {
    function kalkulasiBiayaPenawaranOfflineUpdate($p_tukang, $h_komponen) {
        return $h_komponen + ($h_komponen * ($p_tukang/100));
    }
}
