<?php

namespace App\Http\Controllers\PaymentGateway;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Log_Callback_Xendit;
use Illuminate\Http\Request;

class LogController extends Controller
{

    public function index(Request $request)
    {

        $log = new Log_Callback_Xendit();
        $log->log = json_encode($request->all());
        $log->save();
        return response()->json(array('status' => true), 200);
    }

    /**
     * Index the application dashboard.
     *
     * @param String event
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\Support\Renderable|\Illuminate\Http\Response|object
     */
    public function fva(Request $request, string $event)
    {
        $log = new Log_Callback_Xendit();
        $log->log = json_encode($request->all());

        if ($event == 'paid') {
            $log->flag = 'FVA PAID';

            if (!Invoice::where('external_id', $request->external_id)->exists()) {
                $log->save();
                return response()->json(array('status' => true), 200);
            }
            //trigger
            $invoice = Invoice::where('external_id', $request->external_id)->first();
            $invoice->status =$request->status;
            $invoice->save();

            $log->auto_trigger = true;
            $log->save();
        }

        if ($event == 'created') {
            $log->flag = 'FVA CREATED';
            $log->save();
        }
        return response()->json(array('status' => true), 200);
    }

    /**
     * Index the application dashboard.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\Support\Renderable|\Illuminate\Http\Response|object
     */
    public function retail(Request $request)
    {
        $log = new Log_Callback_Xendit();
        $log->log = json_encode($request->all());
        $log->flag = 'RETAIL PAID';

        if (!Invoice::where('external_id', $request->external_id)->exists()) {
            $log->save();
            return response()->json(array('status' => true), 200);
        }
        //trigger
        $invoice = Invoice::where('external_id', $request->external_id)->first();
        $invoice->status =$request->status;
        $invoice->save();


        $log->auto_trigger = true;
        $log->save();

        return response()->json(array('status' => true), 200);
    }

    /**
     * Index the application dashboard.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\Support\Renderable|\Illuminate\Http\Response|object
     */
    public function invoice(Request $request)
    {
        $log = new Log_Callback_Xendit();
        $log->log = json_encode($request->all());
        $log->flag = 'INVOICE UPDATE';

        if (!Invoice::where('external_id', $request->external_id)->exists()) {
            $log->save();
            return response()->json(array('status' => true), 200);
        }
        //trigger
        $invoice = Invoice::where('external_id', $request->external_id)->first();
        $invoice->status =$request->status;
        $invoice->save();


        $log->auto_trigger = true;
        $log->save();

        return response()->json(array('status' => true), 200);
    }

    /**
     * Index the application dashboard.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\Support\Renderable|\Illuminate\Http\Response|object
     */
    public function ewallet(Request $request)
    {
        $log = new Log_Callback_Xendit();
        $log->log = json_encode($request->all());
        $log->flag = 'EWALLET UPDATE';

        if (!Invoice::where('external_id', $request->external_id)->exists()) {
            $log->save();
            return response()->json(array('status' => true), 200);
        }
        //trigger
        $invoice = Invoice::where('external_id', $request->external_id)->first();
        $status_update = 'EXPAIRED';
        if ($request->data->status == 'SUCCEEDED'){
            $status_update = 'PAID';
        }
        $invoice->status = $status_update;
        $invoice->save();


        $log->auto_trigger = true;
        $log->save();

        return response()->json(array('status' => true), 200);
    }

}
