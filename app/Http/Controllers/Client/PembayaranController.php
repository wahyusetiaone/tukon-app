<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Parcel\InvoiceParcel;
use App\Http\Controllers\PaymentGateway\Payment;
use App\Http\Resources\PembayaranResourceController;
use App\Models\Clients;
use App\Models\Invoice;
use App\Models\PaymentChannel;
use App\Models\Pembayaran;
use App\Models\Pin;
use App\Models\Transaksi_Pembayaran;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;
use function PHPUnit\Framework\never;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $data = Pembayaran::with('pin', 'pin.pengajuan', 'pin.tukang', 'pin.tukang.user', 'transaksi_pembayaran', 'project')->whereHas('pin.pengajuan', function ($query) {
            $query->where('kode_client', Auth::id());
        })->paginate(5)->toArray();
        return view('client.pembayaran.all')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function create(int $id, Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = Pembayaran::with('invoice', 'pin', 'pin.pengajuan', 'pin.tukang', 'pin.tukang.user', 'transaksi_pembayaran', 'project')->whereHas('pin.pengajuan', function ($query) {
                $query->where('kode_client', Auth::id());
            })->where(['id' => $id])->firstOrFail();

            $data_user = Clients::with('user')->find(Auth::id());

            $channel = PaymentChannel::where('is_enabled', true)->get();
            return view('client.pembayaran.show')->with(compact('data', 'data_user', 'channel'));
        } catch (ModelNotFoundException $ee) {
            return View('errors.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show Offline the form for creating a new resource.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function createOffline(int $id, Request $request)
    {
        return view('client.pembayaran.payoffline')->with(compact('id'));
    }

    /**
     * Show Offline the form for creating a new resource.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */

    //TODO:: Tidak digunakan karena ada ewallet yg blm tau custom tampilan

    public function viewInvoice(int $id, Request $request)
    {
        if (!Pembayaran::find($id)->exists()) {
            Alert::error('Error Pembayaran', 'Pembayaran tidak ditemukan !!!');
            return redirect()->route('pembayaran.client');
        }

        $data = Pembayaran::with('invoice', 'pin.penawaran')->find($id);

        $offline = $data->invoice->payment_offline;
        $harga_total_komponen = $data->pin->penawaran->getTotalHargaKomponen();

        //reconsturct data
        $data->invoice['items'] = json_decode($data['items']);
        if (isset($data->invoice["available_banks"])) {
            $data->invoice['available_banks'] = json_decode($data->invoice['available_banks']);
        }
        if (isset($data->invoice["available_retail_outlets"])) {
            $data->invoice['available_retail_outlets'] = json_decode($data->invoice['available_retail_outlets']);
        }
        if (isset($data->invoice["available_ewallets"])) {
            $data->invoice['available_ewallets'] = json_decode($data->invoice['available_ewallets']);
        }

        return view('client.pembayaran.layout_invoice')->with(compact('id', 'offline', 'data', 'harga_total_komponen'));

    }

    /**
     * Store Offline a newly created resource in storage.
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function storeOffline(Request $request, int $id)
    {
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
                    Alert::success('Status Pembayaran', 'Bukti pembayaran berhasil di upload, mohon tunggu admin melakukan konfirmasi. Maximal 2 x 24 jam, hari libur tidak termasuk.');
                    return redirect()->route('show.pembayaran.client', $id);
                }
                Alert::error('Error Pembayaran Menunggu', 'File yang anda upload bermasalah !!!');
                return redirect()->route('show.pembayaran.client', $id);
            }
            Alert::warning('Status Pembayaran Menunggu', 'Mohon tunggu untuk admin melakukan verifikasi transaksi anda sebelumnya !!!');
            return redirect()->route('show.pembayaran.client', $id);
        }

        Alert::error('Error Status Pembayaran', 'Tidak ada akses untuk merubah data ini !!!');
        return redirect()->route('show.pembayaran.client', $id);
    }

    /**
     * Batal the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function cancel(int $id)
    {
        if (!Pembayaran::whereId($id)->exists()) {
            return (new PembayaranResourceController(['status' => false, 'message' => 'Pembayaran tidak ditemukan !!!']))->response()->setStatusCode(200);
        }

        DB::transaction(function () use ($id) {
            $pembayaran = Pembayaran::with('pin')->whereId($id)->first();
            Pin::whereId($pembayaran->pin->id)->update(['status' => 'N01']);
            $pembayaran->delete();
        });

        return (new PembayaranResourceController(['status' => true, 'message' => 'berhasil melakukan pembatalan pembayaran, proses dikembalikan ke proses negosiasi.']))->response()->setStatusCode(200);
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
        if (!Pembayaran::find($id)->exists()) {

            Alert::error('Error Pembayaran', 'Pembayaran tidak ditemukan !!!');
            return redirect()->route('pembayaran.client');
        }

        $data = Pembayaran::with('pin', 'pin.pengajuan.client.user', 'pin.tukang', 'pin.tukang.user', 'transaksi_pembayaran', 'project')->find($id);

        if (Invoice::where('external_id', invoiceCreatedID($data->id, $data->created_at))->exists()) {
            return redirect()->route('invoice.pembayaran.client', $data->id);
        }

        DB::transaction(function () use ($data, $request, &$res) {
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
                if (isset($response["available_retail_outlets"]) && !empty($response["available_retail_outlets"])) {
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
            Alert::success('Pembayaran', 'Pembarayan berhasil di checkout !!!');
            return redirect()->route('invoice.pembayaran.client', $data->id);
        } else {
            Alert::error('Pembayaran', 'Pembarayan gagal di checkout !!!');
            return redirect()->back();
        }
    }
}
