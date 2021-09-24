<?php

namespace App\Http\Controllers\Tukang;

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
        $data = NotificationHandler::where('user_id', Auth::id())->where('read',false)->orderBy('created_at', 'desc')->paginate(10);
        return view('tukang.notification.all')->with(compact('data'));
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
                return redirect()->route('projek');
                break;
            case 'Penarikan Dana':
                return redirect()->route('show.penarikan.dana', $deep_id);
                break;
            case 'Penawaran':
                return redirect()->route('show.penawaran', $deep_id);
                break;
            case 'Proyek':
                return redirect()->route('show.projek', $deep_id);
                break;
            case 'Pengajuan':
                return redirect()->route('show.pengajuan', $deep_id);
                break;
            case 'Pengembalian Dana':
                return redirect()->route('projek', $deep_id);
                break;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function countNotification(int $id)
    {
        $data = NotificationHandler::where('user_id', $id)->where('read', false)->count();
        return response()->json([$data]);
    }
}
