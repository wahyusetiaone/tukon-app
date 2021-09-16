<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index()
    {
        $nama = "Auliya Putri Anasari";
        $email = "auliyaputrianasari@gmail.com";
        $kirim = Mail::to($email)->send(new SendMail($nama));

        if($kirim){
            echo "Email telah dikirim";
        }

    }
}
