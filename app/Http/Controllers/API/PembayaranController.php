<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Parcel\InvoiceParcel;
use App\Http\Controllers\PaymentGateway\Payment;
use App\Http\Resources\PembayaranResourceController;
use App\Models\Invoice;
use App\Models\PaymentChannel;
use App\Models\Pembayaran;
use App\Models\Pin;
use App\Models\Transaksi_Pembayaran;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    /**
     * Index the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index()
    {
        $validasi = Pembayaran::with('pin.tukang.user', 'pin.penawaran.komponen', 'transaksi_pembayaran', 'pin.pengajuan')->whereHas('pin.pengajuan', function ($query) {
            $query->where('kode_client', Auth::id());
        })->orderByDesc('created_at')->get();

        return (new PembayaranResourceController($validasi))->response()->setStatusCode(200);
    }

    /**
     * Index the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function tagihan()
    {
        $kode_user = User::with('client')->find(Auth::id())->kode_user;

        $validasi = Pembayaran::where([['kode_status', '!=', 'P03']])->with('pin', 'pin.penawaran', 'transaksi_pembayaran')->whereHas('pin.pengajuan', function ($query) {
            $query->where('kode_client', Auth::id());
        })->get();

        return (new PembayaranResourceController($validasi))->response()->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function show(int $id)
    {
        $kode_user = User::with('client')->find(Auth::id())->kode_user;

        $validasi = Pembayaran::with('invoice','pin.tukang.user', 'pin.pengajuan', 'pin.penawaran.komponen', 'transaksi_pembayaran', 'invoice')->find($id);

        if ($kode_user == $validasi->pin->pengajuan->kode_client) {

            return (new PembayaranResourceController($validasi))->response()->setStatusCode(200);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function create(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'note_transaksi' => 'string',
            'path_transaksi' => 'required|mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            return (new PembayaranResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        $kode_user = User::with('client')->find(Auth::id())->kode_user;

        $validasi = Pembayaran::with('pin', 'pin.pengajuan')->find($id);

        if ($kode_user == $validasi->pin->pengajuan->kode_client) {
            if ($validasi->kode_status == "P01" || $validasi->kode_status == "P01A") {
                if ($request->hasfile('path_transaksi')) {
                    $file = $request->file('path_transaksi');
                    $path = null;
                    if ($file->isValid()) {
                        $path = $file->store('images/pembayaran', 'public');
                        $path = substr($path, 6);
                        $path = "storage/images" . $path;
                    }

                    if (!$request->has('note_transaksi')) {
                        $request['note_transaksi'] = "---";
                    }

                    $data = new Transaksi_Pembayaran();
                    $data->kode_pembayaran = $id;
                    $data->note_transaksi = $request['note_transaksi'];
                    $data->status_transaksi = "A01";
                    $data->path = $path;
                    $data->save();

                    return (new PembayaranResourceController($data))->response()->setStatusCode(200);
                }
            }
            return (new PembayaranResourceController(['error' => 'Mohon tunggu untuk admin melakukan verifikasi transaksi anda sebelumnya !!!']))->response()->setStatusCode(401);
        }
        return (new PembayaranResourceController(['error' => 'Tidak ada akses untuk merubah data ini !!!']))->response()->setStatusCode(401);

    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function availablePayChannel()
    {
        $channel = PaymentChannel::where('is_enabled', true)->get();
        return (new PembayaranResourceController($channel))->response()->setStatusCode(200);
    }

    /**
     * Show Checkout the form for creating a new resource.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function checkOut(int $id, Request $request)
    {

        $validator = Validator::make($request->all(), [
            'mode' => 'required|string',
            'channel' => 'required|string',
        ]);

        if ($validator->fails()) {
            return (new PembayaranResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        if (!Pembayaran::where('id', $id)->exists()) {
            return (new PembayaranResourceController(['error' => 'Pembayaran tidak ditemukan !!!']))->response()->setStatusCode(401);
        }

        $data = Pembayaran::with('pin', 'pin.pengajuan.client.user', 'pin.tukang', 'pin.tukang.user', 'transaksi_pembayaran', 'project')->find($id);

        if (Invoice::where('external_id', invoiceCreatedID($data->id, $data->created_at))->exists()) {
            return (new PembayaranResourceController(['error' => 'Invoice untuk pembayaran ini telah dibuat !!!']))->response()->setStatusCode(401);
        }

        DB::transaction(function () use ($data, $request, &$res, &$response) {
            $res = false;
            $invoice = new Invoice();
            $invoice->external_id = invoiceCreatedID($data->id, $data->created_at);
            $invoice->kode_pembayaran = $data->id;
            $invoice->amount = $data->total_tagihan;
            $invoice->payer_email = $data->pin->pengajuan->client->user->email;
            $invoice->description = 'Pembayaran ' . $data->pin->pengajuan->nama_proyek;
            $invoice->items = jsonTypeForItem($data->pin->pengajuan->nama_proyek, 1, $data->total_tagihan);
            if ($request->input('mode') == "offline") {
                $invoice->status = "PENDING";
                $invoice->payment_offline = true;
                $invoice->save();
                $res = true;
            } elseif ($request->input('mode') == "online") {
                $parcel = new InvoiceParcel();
                $parcel->setExternalId($invoice->external_id);
                $parcel->setAmount($data->total_tagihan);
                $parcel->setDescription('Pembayaran ' . $data->pin->pengajuan->nama_proyek);
                $parcel->setPayerEmail($data->pin->pengajuan->client->user->email);
                $parcel->setPaymentMethods($request->input('channel'));
                $parcel->setItemName($data->pin->pengajuan->nama_proyek);

                $response = Payment::createInvoice($parcel);

                $timezone = new DateTimeZone('Asia/Jakarta');
                $date = new DateTime($response["expiry_date"]);
                $date->setTimeZone($timezone);

                $invoice->id = $response["id"];
                $invoice->status = "PENDING";
                $invoice->expiry_date = $date;
                $invoice->invoice_url = $response["invoice_url"];
                $invoice->payment_offline = false;
                if (isset($response["available_banks"]) && !empty($response["available_banks"])) {
                    $invoice->available_banks = jsonTypeForAvailableBank($response["available_banks"]);
                }
                if (isset($response["available_retail_outlets"]) && !empty($response["available_ewallets"])) {
                    $invoice->available_retail_outlets = jsonTypeForAvailableRetail($response["available_retail_outlets"]);
                }
                if (isset($response["available_ewallets"]) && !empty($response["available_ewallets"])) {
                    $invoice->available_ewallets = jsonTypeForAvailableewallet($response["available_ewallets"]);
                }
                $invoice->save();
                $res = true;
            }
        });
        if ($res) {
            return (new PembayaranResourceController(['success' => 'Pembarayan berhasil di checkout !!!', 'invoice' => $response]))->response()->setStatusCode(200);
        } else {
            return (new PembayaranResourceController(['error' => 'Pembarayan gagal di checkout, sesuatu salah bekerja !!!']))->response()->setStatusCode(401);
        }
    }

    /**
     * Show Offline the form for creating a new resource.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function viewInvoice(int $id, Request $request)
    {

        return response()->json(array('Disabled API'), 200);
//        if (!Pembayaran::find($id)->exists()) {
//            return redirect()->route('pembayaran.client');
//        }
//
//        $data = Pembayaran::with('invoice','pin.penawaran')->find($id);
//        $offline = $data->invoice->payment_offline;
//        $harga_total_komponen = $data->pin->penawaran->getTotalHargaKomponen();
//
//        //reconsturct data
//        $data->invoice['items'] = json_decode($data['items']);
//        if (isset($data->invoice["available_banks"])) {
//            $data->invoice['available_banks'] = json_decode($data->invoice['available_banks']);
//        }
//        if (isset($data->invoice["available_retail_outlets"])) {
//            $data->invoice['available_retail_outlets'] = json_decode($data->invoice['available_retail_outlets']);
//        }
//        if (isset($data->invoice["available_ewallets"])) {
//            $data->invoice['available_ewallets'] = json_decode($data->invoice['available_ewallets']);
//        }
//
//        return view('client.pembayaran.layout_invoice_m')->with(compact('id', 'offline', 'data', 'harga_total_komponen'));
    }

    /**
     * Batal the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function cancel(int $id)
    {
        if (!Pembayaran::whereId($id)->exists()) {
            return (new PembayaranResourceController(['error' => 'Pembayaran tidak ditemukan !!!']))->response()->setStatusCode(404);
        }

        DB::transaction(function () use ($id) {
            $pembayaran = Pembayaran::with('pin')->whereId($id)->first();
            Pin::whereId($pembayaran->pin->id)->update(['status' => 'N01']);
            $pembayaran->delete();
        });

        return (new PembayaranResourceController(['status' => true, 'message' => 'berhasil melakukan pembatalan pembayaran, proses dikembalikan ke proses negosiasi.']))->response()->setStatusCode(200);
    }
}
