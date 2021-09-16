<?php

if (!function_exists("masaLalu")) {
    function masaLalu($from)
    {
        $d2 = now();
        $interval = $from->diff($d2);
        $diffInSeconds = $interval->s; //45
        $diffInMinutes = $interval->i; //23
        $diffInHours   = $interval->h; //8
        $diffInDays    = $interval->d; //21
        $diffInMonths  = $interval->m; //4
        $diffInYears   = $interval->y; //1

        if ($diffInYears != 0){
            return $diffInYears.' tahun lalu';
        }
        if ($diffInMonths != 0){
            return $diffInMonths.' bulan lalu';
        }
        if ($diffInDays != 0){
            return $diffInDays.' hari lalu';
        }
        if ($diffInHours != 0){
            return $diffInHours.' jam lalu';
        }
        if ($diffInMinutes != 0){
            return $diffInMinutes.' menit lalu';
        }
        if ($diffInSeconds != 0){
            return $diffInSeconds.' detik lalu';
        }
        return 'sudah lama';
    }
}
