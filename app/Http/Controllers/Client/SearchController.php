<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{

    /**
     * any search will handle this controller.
     *
     * @param  String  $filter
     * @param  String  $search
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index(string $filter, string $search)
    {
        if ($filter != "produk" && $filter != "tukang" && $filter != "lokasi"){
            return view('client.search.search_error',['obj' => $filter.' tidak dapat ditemukan di sistem.']);
        }

        if ($filter == 'produk'){
            $db = $this->query_produk()->where('nama_produk', 'LIKE','%'.$search.'%');
        }
        if ($filter == 'tukang'){
            $db = $this->query_tukang()->where('users.name', 'LIKE','%'.$search.'%');
        }

        $data = $db->paginate(9)->toArray();

        return view('client.search.search',['obj' => $data, 'filter' => $filter]);
    }

    function query_produk(){
        return DB::table('produks')
            ->select(DB::raw('users.name,
       tukangs.id as kode_tukang,
       tukangs.nomor_telepon as nomor_telepon,
       tukangs.kota as kota,
       tukangs.alamat as alamat,
       tukangs.rate as rate,
       tukangs.kode_lokasi as kode_lokasi,
       tukangs.path_icon as path_icon,
       tukangs.created_at as tukang_created,
       tukangs.updated_at as tukang_updated,
       produks.id as kode_produk,
       produks.nama_produk as nama_produk,
       produks.range_min as range_min,
       produks.range_max as range_max,
       produks.diskripsi as diskripsi,
       produks.path as path,
       produks.multipath as multipath,
       produks.created_at as produk_created,
       produks.updated_at as produk_updated'))
            ->join('tukangs', 'produks.kode_tukang', '=', 'tukangs.id')
            ->join('users', 'tukangs.id', '=', 'users.kode_user');
    }

    function query_tukang(){
        return DB::table('tukangs')
            ->select(DB::raw('users.name,
       tukangs.id as kode_tukang,
       tukangs.nomor_telepon as nomor_telepon,
       tukangs.kota as kota,
       tukangs.alamat as alamat,
       tukangs.rate as rate,
       tukangs.kode_lokasi as kode_lokasi,
       tukangs.path_icon as path_icon,
       tukangs.created_at as tukang_created,
       tukangs.updated_at as tukang_updated'))
            ->join('users', 'tukangs.id', '=', 'users.kode_user');
    }

}
