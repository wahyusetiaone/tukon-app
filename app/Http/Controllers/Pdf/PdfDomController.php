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

class PdfDomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function invoice($id)
    {
        try {
            $data = Pembayaran::with('pin.pengajuan.client.user','pin.penawaran.komponen')->whereHas('pin.pengajuan', function ($query) {
                $query->where('kode_client', Auth::id());
            })->where(['id' => $id])->firstOrFail();

            $pdf = PDF::loadview('pdf.invoice',['data'=>$data]);
            $filename = str_replace(" ", "-", 'invoice-'.$data->pin->pengajuan->nama_proyek.'.pdf');
            $filename = strtolower($filename);
            return $pdf->stream($filename);

//            return view('pdf.invoice')->with(compact('data'));
        } catch (ModelNotFoundException $ee) {
            return View('errors.404');
        }
    }

    public function penawaran($id)
    {
        try {
            $data = Penawaran::with('pin','pin.pengajuan','pin.pengajuan.client.user','pin.tukang','pin.tukang.user','komponen','pin.pembayaran')->whereHas('pin.pengajuan.client', function ($query){
                $query->where('id', Auth::id());
            })->where(['id' => $id])->firstOrFail();

            $pdf = PDF::loadview('pdf.penawaran',['data'=>$data]);
            $filename = str_replace(" ", "-", 'penawaran-'.$data->pin->pengajuan->nama_proyek.'.pdf');
            $filename = strtolower($filename);
            return $pdf->stream($filename);


//            return view('pdf.penawaran')->with(compact('data', 'kode'));
        }catch (ModelNotFoundException $ee){
            return View('errors.404');
        }
    }

    public function bast($id)
    {
        try {
            $data = Project::with('penarikan.transaksi_penarikan.persentase','progress','progress.onprogress','progress.onprogress.doc','pembayaran','pembayaran.transaksi_pembayaran','pembayaran.pin','pembayaran.pin.pengajuan','pembayaran.pin.pengajuan.client','pembayaran.pin.pengajuan.client.user','pembayaran.pin.penawaran','pembayaran.pin.penawaran.komponen','pembayaran.pin.tukang','pembayaran.pin.tukang.user')->where('id', $id)->first();

            $pdf = PDF::loadview('pdf.bast',['data'=>$data]);
            $filename = str_replace(" ", "-", 'bast-'.$data->nama_proyek.'.pdf');
            $filename = strtolower($filename);
            return $pdf->stream($filename);

//            return view('pdf.bast')->with(compact('data'));
        }catch (ModelNotFoundException $ee){
            return View('errors.404');
        }
    }

}
