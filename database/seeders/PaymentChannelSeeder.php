<?php

namespace Database\Seeders;

use App\Models\PaymentChannel;
use Illuminate\Database\Seeder;

class PaymentChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = '{"data":[{"business_id":"60fa1fa2a0b3f8482dc1f17f","is_livemode":false,"channel_code":"BCA","name":"BCA virtual account","currency":"IDR","channel_category":"VIRTUAL_ACCOUNT","is_enabled":true},{"business_id":"60fa1fa2a0b3f8482dc1f17f","is_livemode":false,"channel_code":"BRI","name":"BRI virtual account","currency":"IDR","channel_category":"VIRTUAL_ACCOUNT","is_enabled":true},{"business_id":"60fa1fa2a0b3f8482dc1f17f","is_livemode":false,"channel_code":"BNI","name":"BNI virtual account","currency":"IDR","channel_category":"VIRTUAL_ACCOUNT","is_enabled":true},{"business_id":"60fa1fa2a0b3f8482dc1f17f","is_livemode":false,"channel_code":"MANDIRI","name":"Mandiri virtual account","currency":"IDR","channel_category":"VIRTUAL_ACCOUNT","is_enabled":true},{"business_id":"60fa1fa2a0b3f8482dc1f17f","is_livemode":false,"channel_code":"PERMATA","name":"Permata virtual account","currency":"IDR","channel_category":"VIRTUAL_ACCOUNT","is_enabled":true},{"business_id":"60fa1fa2a0b3f8482dc1f17f","is_livemode":false,"channel_code":"ALFAMART","name":"Alfamart retail outlet","currency":"IDR","channel_category":"RETAIL_OUTLET","is_enabled":true},{"business_id":"60fa1fa2a0b3f8482dc1f17f","is_livemode":false,"channel_code":"INDOMARET","name":"Indomaret retail outlet","currency":"IDR","channel_category":"RETAIL_OUTLET","is_enabled":true},{"business_id":"60fa1fa2a0b3f8482dc1f17f","is_livemode":false,"channel_code":"OVO","name":"OVO e-wallet","currency":"IDR","channel_category":"EWALLET","is_enabled":true},{"business_id":"60fa1fa2a0b3f8482dc1f17f","is_livemode":false,"channel_code":"DANA","name":"DANA e-wallet","currency":"IDR","channel_category":"EWALLET","is_enabled":true},{"business_id":"60fa1fa2a0b3f8482dc1f17f","is_livemode":false,"channel_code":"LINKAJA","name":"LinkAja e-wallet","currency":"IDR","channel_category":"EWALLET","is_enabled":true},{"business_id":"60fa1fa2a0b3f8482dc1f17f","is_livemode":false,"channel_code":"VISA","name":"Visa credit and debit cards","currency":"IDR","channel_category":"CREDIT_CARD","is_enabled":true},{"business_id":"60fa1fa2a0b3f8482dc1f17f","is_livemode":false,"channel_code":"MASTERCARD","name":"Mastercard credit and debit cards","currency":"IDR","channel_category":"CREDIT_CARD","is_enabled":true},{"business_id":"60fa1fa2a0b3f8482dc1f17f","is_livemode":false,"channel_code":"JCB","name":"JCB credit and debit cards","currency":"IDR","channel_category":"CREDIT_CARD","is_enabled":true},{"business_id":"60fa1fa2a0b3f8482dc1f17f","is_livemode":false,"channel_code":"QRIS","name":"QR Codes","currency":"IDR","channel_category":"QRIS","is_enabled":true}]}';

        $arr = json_decode($json, true);
        foreach ($arr['data'] as $item){
            $post = new PaymentChannel($item);
            $post->is_enabled = false;
            $post->save();
        }
    }
}
