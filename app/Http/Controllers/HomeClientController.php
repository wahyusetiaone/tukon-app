<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeClientController extends Controller
{
    public function index()
    {
        $produk_terbaru = DB::table('produks')
            ->select(DB::raw('users.name,
       tukangs.id as kode_tukang,
       tukangs.nomor_telepon as nomor_telepon,
       tukangs.kota as kota,
       tukangs.alamat as alamat,
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
            ->join('users', 'tukangs.id', '=', 'users.kode_user')
            ->orderBy('produk_created', 'asc')->take(8)->get();

        $produk = DB::table('produks')
            ->select(DB::raw('users.name,
       tukangs.id as kode_tukang,
       tukangs.nomor_telepon as nomor_telepon,
       tukangs.kota as kota,
       tukangs.alamat as alamat,
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
            ->join('users', 'tukangs.id', '=', 'users.kode_user')->inRandomOrder()->take(8)->get();

        $top_tukang = DB::table('tukangs')
            ->select(DB::raw('users.name,
       tukangs.id as kode_tukang,
       tukangs.nomor_telepon as nomor_telepon,
       tukangs.kota as kota,
       tukangs.alamat as alamat,
       tukangs.kode_lokasi as kode_lokasi,
       tukangs.path_icon as path_icon,
       tukangs.created_at as tukang_created,
       tukangs.updated_at as tukang_updated'))
            ->join('users', 'tukangs.id', '=', 'users.kode_user')->take(8)->get();

        $tukang = DB::table('tukangs')
            ->select(DB::raw('users.name,
       tukangs.id as kode_tukang,
       tukangs.nomor_telepon as nomor_telepon,
       tukangs.kota as kota,
       tukangs.alamat as alamat,
       tukangs.kode_lokasi as kode_lokasi,
       tukangs.path_icon as path_icon,
       tukangs.created_at as tukang_created,
       tukangs.updated_at as tukang_updated'))
            ->join('users', 'tukangs.id', '=', 'users.kode_user')->take(8)->get();

        return view('home_client')->with(compact('produk_terbaru', 'produk', 'top_tukang', 'tukang'));
    }
}
