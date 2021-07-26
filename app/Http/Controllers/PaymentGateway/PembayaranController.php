<?php

namespace App\Http\Controllers\PaymentGateway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Xendit\Xendit;

class PembayaranController extends Controller
{
    function __construct()
    {
        Xendit::setApiKey('xnd_development_3IGoqRXwNT7TJ1ARO2gzrlnY59kGXA9wG0S0dUon47y94E9uk2EtxOAs3tBzXdMo');

    }

    function getBalance()
    {
        $params = ['external_id' => 'demo_147580196270',
            'payer_email' => 'sample_email@xendit.co',
            'description' => 'Trip to Bali',
            'amount' => 32000
        ];

        $createInvoice = \Xendit\Invoice::create($params);
        var_dump($createInvoice);
    }

    function createInvoice()
    {
        $params = ['external_id' => 'demo_147580196270',
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

    function createPayout(){
        $params = [
            'external_id' => 'payouts-123456789',
            'amount' => 50000,
            'email' => 'klient@tukon.com'
        ];

        $createPayout = \Xendit\Payouts::create($params);

        return response()->json($createPayout);
    }

    function getPayout(string $id)
    {
        $data = \Xendit\Payouts::retrieve($id);

        return response()->json($data);
    }

    function voidPayout(string $id){
        $data = \Xendit\Payouts::void($id);

        return response()->json($data);
    }
}
