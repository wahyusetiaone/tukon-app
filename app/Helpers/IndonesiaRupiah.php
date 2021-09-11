<?php

if (!function_exists("indonesiaRupiah")) {
    function indonesiaRupiah($angka, $hasSymbol = true)
    {
        $hasil = number_format($angka, 0, ',', '.');
        if ($hasSymbol){
            return "Rp. ".$hasil.", -";
        }else{
            return "Rp. ".$hasil;
        }
    }
}

