<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelperView extends Controller
{
    public function index(){
        return view('client.pengajuan.form');
    }
}
