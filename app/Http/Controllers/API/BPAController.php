<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BPAResourceController;
use App\Models\BPA;
use Illuminate\Http\Request;

class BPAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index()
    {
        $data = BPA::orderBy('created_at', 'desc')->first();
        return (new BPAResourceController($data))->response()->setStatusCode(200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function check(int $id)
    {
        $data = BPA::whereId($id)->withTrashed()->first();
        return (new BPAResourceController($data))->response()->setStatusCode(200);
    }
}
