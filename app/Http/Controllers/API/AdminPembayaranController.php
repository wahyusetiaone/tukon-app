<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminPembayaranResourceController;
use App\Models\Pembayaran;
use App\Models\Transaksi_Pembayaran;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AdminPembayaranController extends Controller
{
    /**
     * Show the form for accpet a payment.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function accept(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'id_transaksi' => 'required|integer',
            'note_return_transaksi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return (new AdminPembayaranResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }
        try {
            Pembayaran::with('transaksi_pembayaran')->where('id',$id)->firstOrFail();
            $data = Transaksi_Pembayaran::find($request->id_transaksi);
            $data->status_transaksi = "A03";
            $data->note_return_transaksi = $request->note_return_transaksi;
            $data->save();

            return (new AdminPembayaranResourceController(['status_update' => true]))->response()->setStatusCode(200);

        }catch (ModelNotFoundException $ee){
            return (new AdminPembayaranResourceController(['error' => $ee->getMessage()]))->response()->setStatusCode(401);
        }
    }

    /**
     * Show the form for reject a payment.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function reject(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'id_transaksi' => 'required|integer',
            'note_return_transaksi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return (new AdminPembayaranResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }
        try {
            Pembayaran::with('transaksi_pembayaran')->where('id',$id)->firstOrFail();
            $data = Transaksi_Pembayaran::find($request->id_transaksi);
            $data->status_transaksi = "A02";
            $data->note_return_transaksi = $request->note_return_transaksi;
            $data->save();

            return (new AdminPembayaranResourceController(['status_update' => true]))->response()->setStatusCode(200);

        }catch (ModelNotFoundException $ee){
            return (new AdminPembayaranResourceController(['error' => $ee->getMessage()]))->response()->setStatusCode(401);
        }
    }
}
