<?php
namespace App\Http\Controllers\PaymentGateway;

use App\Http\Controllers\Parcel\InvoiceParcel;
use Illuminate\Support\Facades\Http;
use Xendit\Xendit as Xendit;

abstract class Payment {

    public static function getPaymentChannel(){
        $authkey = base64_encode( env('XENDIT_KEY', null).':' );
        $response = Http::withHeaders([
            'Authorization' => 'Basic '.$authkey,
        ])->get('https://api.xendit.co/payment_channels');
        return $response->collect();
    }

    public static function getBalance()
    {
        Xendit::setApiKey(env('XENDIT_KEY', null));
        $getBalance = \Xendit\Balance::getBalance('CASH');
        return $getBalance;
    }

    //[“CREDIT_CARD”, “BCA”, “BNI”, “BNI_SYARIAH”, “BRI”, “MANDIRI”, “PERMATA”, “ALFAMART”, “INDOMARET”, “OVO”, “DANA”, “SHOPEEPAY”, “LINKAJA”, “QRIS”, “DD_BRI”]
    public static function createInvoice(InvoiceParcel $invoiceParcel)
    {
        Xendit::setApiKey(env('XENDIT_KEY', null));
        $params = [
            'external_id' => $invoiceParcel->getExternalId(),
            'payer_email' => $invoiceParcel->getPayerEmail(),
            'description' => $invoiceParcel->getDescription(),
            'amount' => $invoiceParcel->getAmount(),
            'payment_methods' => [$invoiceParcel->getPaymentMethods()],
            'items' => [
                array(
                    'name' =>$invoiceParcel->getItemName(),
                    'quantity' => $invoiceParcel->getItemQty(),
                    'price'=> $invoiceParcel->getAmount()
                )
            ]
        ];
        $createInvoice = \Xendit\Invoice::create($params);

        return $createInvoice;
    }

    public static function getInvoice(string $id)
    {
        Xendit::setApiKey(env('XENDIT_KEY', null));
        $data = \Xendit\Invoice::retrieve($id);

        return $data;
    }

    function getAllInvoice(){
        Xendit::setApiKey(env('XENDIT_KEY', null));
        $data = \Xendit\Invoice::retrieveAll();

        return response()->json($data);
    }
}
?>
