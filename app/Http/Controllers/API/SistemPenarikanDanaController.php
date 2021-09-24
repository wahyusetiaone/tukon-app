<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SistemPenarikanDanaResourceController;
use App\Models\Sistem_Penarikan_Dana;
use Illuminate\Http\Request;

class SistemPenarikanDanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index()
    {
        $data = Sistem_Penarikan_Dana::all();
        return (new SistemPenarikanDanaResourceController($data))->response()->setStatusCode(200);
    }
}
