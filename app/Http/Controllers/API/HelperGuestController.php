<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\HelperGuestResourceController;
use App\Models\KodeStatus;
use App\Models\PlanProgress;
use App\Models\Roles;
use Illuminate\Http\Request;

class HelperGuestController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function kode_status()
    {
        $data = KodeStatus::all();
        return (new HelperGuestResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function roles()
    {
        $data = Roles::all();
        return (new HelperGuestResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function plan_progress()
    {
        $data = PlanProgress::all();
        return (new HelperGuestResourceController($data))->response()->setStatusCode(200);
    }
}
