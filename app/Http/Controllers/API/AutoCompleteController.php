<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AutoCompleteResourceController;
use App\Models\Produk;
use App\Models\Tukang;
use Illuminate\Http\Request;

class AutoCompleteController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * @param String $query
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function autocompleteproductwithnameoftukang(String $query)
    {
        $data = Produk::where('nama_produk', 'LIKE', '%'.$query.'%')->take(10)->pluck('nama_produk');

        $data2 = Tukang::select('id','kota','rate')->with(['user' => function ($query) {
            $query->select('kode_user', 'name');
        }])->whereHas('user',function ($q) use ($query){
            $q->where('name', 'LIKE', '%'.$query.'%');
        })->take(10)->get();

        return (new AutoCompleteResourceController(['autocomplete' => $data, 'tukang' =>$data2]))->response()->setStatusCode(200);
    }

}
