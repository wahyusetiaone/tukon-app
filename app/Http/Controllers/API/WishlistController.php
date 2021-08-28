<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\WishlistResourceController;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index()
    {
        $kode_client = Auth::user();
        $kode_client = $kode_client->kode_user;
        $data = Wishlist::with('produk', 'produk.tukang', 'produk.tukang.user')->where('kode_client', $kode_client)->paginate(10);

        return (new WishlistResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_produk' => 'required|array'
        ]);

        if ($validator->fails()) {
            return (new WishlistResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        $kode_client = Auth::user();
        $kode_client = $kode_client->kode_user;

        foreach ($request->input('kode_produk') as $item) {
            if (Wishlist::where(['kode_client' => $kode_client, 'kode_produk' => $item])->exists()) {
                return (new WishlistResourceController(['error' => 'record already exist.', 'kode_produk' => $item]))->response()->setStatusCode(401);
            }
            $wish = new Wishlist();
            $wish->kode_client = $kode_client;
            $wish->kode_produk = $item;
            $wish->save();
        }
        $request['countWishlist'] = Wishlist::where('kode_client',$kode_client)->count();

        return (new WishlistResourceController($request))->response()->setStatusCode(200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_produk' => 'required|array'

        ]);

        if ($validator->fails()) {
            return (new WishlistResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        foreach ($request->input('kode_produk') as $item) {
            if (!Wishlist::where(['id' => $item])->exists()) {
                return (new WishlistResourceController(['error' => 'record not found.', 'kode_wishlist' => $item]))->response()->setStatusCode(401);
            }
        }

        Wishlist::destroy($request->all());

        return (new WishlistResourceController($request))->response()->setStatusCode(200);
    }

//    public function send(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'kode_tukang' => 'required',
//            'value' => 'required',
//
//        ]);
//
//        if ($validator->fails()) {
//            return (new RatingResourceController(['error'=>$validator->errors()]))->response()->setStatusCode(401);
//        }
//
//        $kode_client = Auth::user();
//        $kode_client = $kode_client->kode_user;
//        $vote = new VoteRate();
//        $vote->kode_tukang = $request->input('kode_tukang');
//        $vote->kode_client = $kode_client;
//        $vote->value = $request->input('value');
//        $vote->save();
//
//        return (new RatingResourceController($vote))->response()->setStatusCode(200);
//    }
}
