<?php

namespace App\Http\Controllers\PaymentGateway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Xendit\Xendit;

class PembayaranController extends Controller
{
    function __construct()
    {
        Xendit::setApiKey(env('XENDIT_KEY', null));
    }

    function getBalance()
    {
        $getBalance = \Xendit\Balance::getBalance('CASH');
        var_dump($getBalance);
    }

    function createInvoice()
    {
        $params = [
            'external_id' => 'demo_147580196270',
            'payer_email' => 'sample_email@xendit.co',
            'description' => 'Trip to Bali',
            'amount' => 32000
        ];

        $createInvoice = \Xendit\Invoice::create($params);

        return response()->json($createInvoice);
    }

    function getInvoice(string $id)
    {
        $data = \Xendit\Invoice::retrieve($id);

        return response()->json($data);
    }

    function getAllInvoice(){
        $data = \Xendit\Invoice::retrieveAll();

        return response()->json($data);
    }
}
