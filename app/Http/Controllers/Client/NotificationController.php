<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\NotificationHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $data = NotificationHandler::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        return view('client.notification.v2.all')->with(compact('data'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function read(int $id, int $deep_id, string $what)
    {
        if (!NotificationHandler::whereId($id)->exists()){
            Alert::error('Error', 'Item tidak ditemukan !!!');
            return redirect()->back();
        }

        $data = NotificationHandler::where('id', $id)->first();
        $data->read = true;
        $data->save();

        switch ($what){
            case 'Pembayaran':
                return redirect()->route('show.pembayaran.client', $deep_id);
                break;
            case 'Penarikan Dana':
                return redirect()->route('project.client');
                break;
            case 'Penawaran':
                return redirect()->route('penawaran.client');
                break;
            case 'Proyek':
                return redirect()->route('show.project.client', $deep_id);
                break;
            case 'Pengajuan':
                return redirect()->route('show.pengajuan.client', $deep_id);
                break;
            case 'Pengembalian Dana':
                return redirect()->route('project.client', $deep_id);
                break;
        }
    }
}
