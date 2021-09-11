<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResourceController;
use App\Models\NotificationHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Index the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index(Request $request)
    {
        $data = NotificationHandler::where('user_id', Auth::id())->orderBy('read', 'asc')->paginate(8);

        $query = $request->input('only');

        if ($query =='unread'){
            $data = NotificationHandler::where(
                [
                    ['user_id', Auth::id()],
                    ['read', false]
                ]
            )->paginate(8);
        }
        if ($query =='readed'){
            $data = NotificationHandler::where(
                [
                    ['user_id', Auth::id()],
                    ['read', true]
                ]
            )->paginate(8);
        }

        return (new NotificationResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Index the form for creating a new resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function markReaded(int $id)
    {
        if (!NotificationHandler::whereId($id)->exists()){
            return (new NotificationResourceController(['error' => 'Notifikasi tidak ditemukan']))->response()->setStatusCode(404);
        }

        $data = NotificationHandler::where('id', $id)->first();
        $data->read = true;
        $data->save();

        return (new NotificationResourceController($data))->response()->setStatusCode(200);
    }
}
