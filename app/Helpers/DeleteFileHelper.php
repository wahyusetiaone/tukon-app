<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists("deleteFileHelper")) {
    function deleteFileHelper($path_from_db)
    {
        //path from db has a text "storage/", must be remove first

        $path_ori = substr($path_from_db,8);
        Storage::disk('public')->delete($path_ori);
    }
}

