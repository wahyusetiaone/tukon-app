<?php

if (!function_exists("indonesiaRupiah")) {
    function indonesiaRupiah($angka)
    {
        $hasil = number_format($angka, 0, ',', '.');
        return "Rp. ".$hasil.", -";
    }
}

