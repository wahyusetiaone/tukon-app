<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists("momPleaseDeleteIt")) {
    function momPleaseDeleteIt($path)
    {
        $explode = explode('/', $path);
        unset($explode[0]);
        $namefile = implode("/",$explode);;
        Storage::disk('public')->delete($namefile);
    }
}

