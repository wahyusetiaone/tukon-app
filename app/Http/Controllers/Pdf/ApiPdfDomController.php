<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Penawaran;
use App\Models\Project;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class ApiPdfDomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function invoice(Request $request,int $id)
    {
        if (!Pembayaran::whereId($id)->exists()){
            return response('ID Pembayaran tidak ditemukan', 404);
        }
        try {
            $query = $request->input('type');
            $data = Pembayaran::with('pin.pengajuan.client.user','pin.penawaran.komponen')->whereHas('pin.pengajuan', function ($query) {
                $query->where('kode_client', Auth::id());
            })->where(['id' => $id])->first();

            $pdf = PDF::loadview('pdf.invoice',['data'=>$data]);
            $filename = str_replace(" ", "-", 'invoice-'.$data->pin->pengajuan->nama_proyek.'.pdf');
            $filename = strtolower($filename);

            if ($query == 'download'){
                return $pdf->download($filename);
            }
            return $pdf->stream($filename);
        } catch (ModelNotFoundException $ee) {
            return View('errors.404');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function penawaran(Request $request,int $id)
    {
        if (!Penawaran::whereId($id)->exists()){
            return response('ID Penawaran tidak ditemukan', 404);
        }
        try {
            $query = $request->input('type');
            $data = Penawaran::with('pin','pin.pengajuan','pin.pengajuan.client.user','pin.tukang','pin.tukang.user','komponen','pin.pembayaran')->whereHas('pin.pengajuan.client', function ($query){
                $query->where('id', Auth::id());
            })->where(['id' => $id])->firstOrFail();

            $pdf = PDF::loadview('pdf.penawaran',['data'=>$data]);
            $filename = str_replace(" ", "-", 'penawaran-'.$data->pin->pengajuan->nama_proyek.'.pdf');
            $filename = strtolower($filename);

            if ($query == 'download'){
                return $pdf->download($filename);
            }
            return $pdf->stream($filename);

        }catch (ModelNotFoundException $ee){
            return View('errors.404');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function bast(Request $request, int $id)
    {
        if (!Project::whereId($id)->exists()){
            return response('ID Project tidak ditemukan', 404);
        }

        try {
            $query = $request->input('type');
            $data = Project::with('penarikan.transaksi_penarikan.persentase','progress','progress.onprogress','progress.onprogress.doc','pembayaran','pembayaran.transaksi_pembayaran','pembayaran.pin','pembayaran.pin.pengajuan','pembayaran.pin.pengajuan.client','pembayaran.pin.pengajuan.client.user','pembayaran.pin.penawaran','pembayaran.pin.penawaran.komponen','pembayaran.pin.tukang','pembayaran.pin.tukang.user')->where('id', $id)->first();

            $pdf = PDF::loadview('pdf.bast',['data'=>$data]);
            $filename = str_replace(" ", "-", 'bast-'.$data->nama_proyek.'.pdf');
            $filename = strtolower($filename);

            if ($query == 'download'){
                return $pdf->download($filename);
            }
            return $pdf->stream($filename);

        }catch (ModelNotFoundException $ee){
            return View('errors.404');
        }
    }

}
