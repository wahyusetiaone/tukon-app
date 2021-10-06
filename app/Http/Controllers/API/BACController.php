<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BACResourceController;
use App\Models\BACabang;
use Illuminate\Http\Request;

class BACController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index()
    {
        $data = BACabang::orderBy('created_at', 'desc')->first();
        return (new BACResourceController($data))->response()->setStatusCode(200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function check(int $id)
    {
        $data = BACabang::whereId($id)->withTrashed()->first();
        return (new BACResourceController($data))->response()->setStatusCode(200);
    }
}
