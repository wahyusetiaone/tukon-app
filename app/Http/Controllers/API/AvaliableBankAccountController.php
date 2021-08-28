<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AvaliableBankAccountResourceController;
use App\Models\AvaliableBankAccount;
use Illuminate\Http\Request;

class AvaliableBankAccountController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index()
    {
        $data = AvaliableBankAccount::all();
        return (new AvaliableBankAccountResourceController($data))->response()->setStatusCode(200);
    }
}
