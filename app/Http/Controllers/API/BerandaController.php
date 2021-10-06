<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BerandaResourceController;
use App\Http\Resources\ProdukResourceController;
use App\Models\Produk;
use App\Models\VoteRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function index()
    {
        $data['produk_terbaru'] = DB::table('produks')
            ->select(DB::raw('users.name,
       tukangs.id as kode_tukang,
       tukangs.nomor_telepon as nomor_telepon,
       tukangs.kota as kota,
       tukangs.alamat as alamat,
       tukangs.kode_lokasi as kode_lokasi,
       tukangs.path_icon as path_icon,
       tukangs.created_at as tukang_created,
       tukangs.updated_at as tukang_updated,
       tukangs.verifikasi_lokasi as verifikasi_lokasi,
       produks.id as kode_produk,
       produks.nama_produk as nama_produk,
       produks.harga as harga,
       produks.diskripsi as diskripsi,
       produks.path as path,
       produks.multipath as multipath,
       produks.created_at as produk_created,
       produks.updated_at as produk_updated'))
            ->join('tukangs', 'produks.kode_tukang', '=', 'tukangs.id')
            ->join('users', 'tukangs.id', '=', 'users.kode_user')
            ->orderBy('produk_created', 'asc')->take(5)->get();

        $data['produk'] = DB::table('produks')
            ->select(DB::raw('users.name,
       tukangs.id as kode_tukang,
       tukangs.nomor_telepon as nomor_telepon,
       tukangs.kota as kota,
       tukangs.alamat as alamat,
       tukangs.kode_lokasi as kode_lokasi,
       tukangs.path_icon as path_icon,
       tukangs.created_at as tukang_created,
       tukangs.updated_at as tukang_updated,
       tukangs.verifikasi_lokasi as verifikasi_lokasi,
       produks.id as kode_produk,
       produks.nama_produk as nama_produk,
       produks.harga as harga,
       produks.diskripsi as diskripsi,
       produks.path as path,
       produks.multipath as multipath,
       produks.created_at as produk_created,
       produks.updated_at as produk_updated'))
            ->join('tukangs', 'produks.kode_tukang', '=', 'tukangs.id')
            ->join('users', 'tukangs.id', '=', 'users.kode_user')->inRandomOrder()->take(5)->get();

        $data['top_tukang'] = DB::table('tukangs')
            ->select(DB::raw('users.name,
       tukangs.id as kode_tukang,
       tukangs.nomor_telepon as nomor_telepon,
       tukangs.kota as kota,
       tukangs.alamat as alamat,
       tukangs.kode_lokasi as kode_lokasi,
       tukangs.path_icon as path_icon,
       tukangs.rate as rate,
       tukangs.verifikasi_lokasi as verifikasi_lokasi,
       tukangs.created_at as tukang_created,
       tukangs.updated_at as tukang_updated'))
            ->join('users', 'tukangs.id', '=', 'users.kode_user')->take(5)->get();

        $data['tukang'] = DB::table('tukangs')
            ->select(DB::raw('users.name,
       tukangs.id as kode_tukang,
       tukangs.nomor_telepon as nomor_telepon,
       tukangs.kota as kota,
       tukangs.alamat as alamat,
       tukangs.kode_lokasi as kode_lokasi,
       tukangs.path_icon as path_icon,
       tukangs.verifikasi_lokasi as verifikasi_lokasi,
       tukangs.created_at as tukang_created,
       tukangs.updated_at as tukang_updated'))
            ->join('users', 'tukangs.id', '=', 'users.kode_user')->take(5)->get();

        return (new BerandaResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function new_product()
    {
        $data = DB::table('produks')
            ->select(DB::raw('users.name,
       tukangs.id as kode_tukang,
       tukangs.nomor_telepon as nomor_telepon,
       tukangs.kota as kota,
       tukangs.alamat as alamat,
       tukangs.kode_lokasi as kode_lokasi,
       tukangs.path_icon as path_icon,
       tukangs.created_at as tukang_created,
       tukangs.updated_at as tukang_updated,
       tukangs.verifikasi_lokasi as verifikasi_lokasi,
       produks.id as kode_produk,
       produks.nama_produk as nama_produk,
       produks.harga as harga,
       produks.diskripsi as diskripsi,
       produks.path as path,
       produks.multipath as multipath,
       produks.created_at as produk_created,
       produks.updated_at as produk_updated'))
            ->join('tukangs', 'produks.kode_tukang', '=', 'tukangs.id')
            ->join('users', 'tukangs.id', '=', 'users.kode_user')
            ->orderBy('produk_created', 'asc')->paginate(5);

        return (new BerandaResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function search_new_product(Request $request)
    {
        $data = DB::table('produks')
            ->select(DB::raw('users.name,
       tukangs.id as kode_tukang,
       users.name as nama_tukang,
       tukangs.nomor_telepon as nomor_telepon,
       tukangs.kota as kota,
       tukangs.alamat as alamat,
       tukangs.kode_lokasi as kode_lokasi,
       tukangs.path_icon as path_icon,
       tukangs.created_at as tukang_created,
       tukangs.updated_at as tukang_updated,
       tukangs.verifikasi_lokasi as verifikasi_lokasi,
       produks.id as kode_produk,
       produks.nama_produk as nama_produk,
       produks.harga as harga,
       produks.diskripsi as diskripsi,
       produks.path as path,
       produks.multipath as multipath,
       produks.created_at as produk_created,
       produks.updated_at as produk_updated'))
            ->join('tukangs', 'produks.kode_tukang', '=', 'tukangs.id')
            ->join('users', 'tukangs.id', '=', 'users.kode_user')
            ->orderBy('produk_created', 'asc')
            ->where('nama_produk', 'LIKE', '%' . $request->query_search . '%')
            ->paginate(10);

        return (new BerandaResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function top_tukang()
    {
        $data = DB::table('tukangs')
            ->select(DB::raw('users.name,
       tukangs.id as kode_tukang,
       tukangs.nomor_telepon as nomor_telepon,
       tukangs.kota as kota,
       tukangs.alamat as alamat,
       tukangs.kode_lokasi as kode_lokasi,
       tukangs.path_icon as path_icon,
       tukangs.rate as rate,
       tukangs.verifikasi_lokasi as verifikasi_lokasi,
       tukangs.created_at as tukang_created,
       tukangs.updated_at as tukang_updated'))
            ->join('users', 'tukangs.id', '=', 'users.kode_user')
            ->paginate(5);
        return (new BerandaResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function search_top_tukang(Request $request)
    {
        $data = DB::table('tukangs')
            ->select(DB::raw('users.name,
       tukangs.id as kode_tukang,
       tukangs.nomor_telepon as nomor_telepon,
       tukangs.kota as kota,
       tukangs.alamat as alamat,
       tukangs.kode_lokasi as kode_lokasi,
       tukangs.path_icon as path_icon,
       tukangs.verifikasi_lokasi as verifikasi_lokasi,
       tukangs.created_at as tukang_created,
       tukangs.updated_at as tukang_updated'))
            ->join('users', 'tukangs.id', '=', 'users.kode_user')
            ->where('name', 'LIKE', '%' . $request->query_search . '%')
            ->paginate(10);
        return (new BerandaResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     * @param String $location
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function filter_by_location(string $location)
    {
        $data = DB::table('produks')
            ->select(DB::raw('users.name,
       tukangs.id as kode_tukang,
       tukangs.nomor_telepon as nomor_telepon,
       tukangs.kota as kota,
       tukangs.alamat as alamat,
       tukangs.kode_lokasi as kode_lokasi,
       tukangs.path_icon as path_icon,
       tukangs.created_at as tukang_created,
       tukangs.updated_at as tukang_updated,
       tukangs.verifikasi_lokasi as verifikasi_lokasi,
       produks.id as kode_produk,
       produks.nama_produk as nama_produk,
       produks.harga as harga,
       produks.diskripsi as diskripsi,
       produks.path as path,
       produks.multipath as multipath,
       produks.created_at as produk_created,
       produks.updated_at as produk_updated'))
            ->join('tukangs', 'produks.kode_tukang', '=', 'tukangs.id')
            ->join('users', 'tukangs.id', '=', 'users.kode_user')
            ->where('kota', '=', $location)->paginate(10);

        return (new BerandaResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     * @param String $location
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function search_by_location(Request $request, string $location)
    {
        $data = DB::table('produks')
            ->select(DB::raw('users.name,
       tukangs.id as kode_tukang,
       users.name as nama_tukang,
       tukangs.nomor_telepon as nomor_telepon,
       tukangs.kota as kota,
       tukangs.alamat as alamat,
       tukangs.kode_lokasi as kode_lokasi,
       tukangs.path_icon as path_icon,
       tukangs.created_at as tukang_created,
       tukangs.updated_at as tukang_updated,
       tukangs.verifikasi_lokasi as verifikasi_lokasi,
       produks.id as kode_produk,
       produks.nama_produk as nama_produk,
       produks.harga as harga,
       produks.diskripsi as diskripsi,
       produks.path as path,
       produks.multipath as multipath,
       produks.created_at as produk_created,
       produks.updated_at as produk_updated'))
            ->join('tukangs', 'produks.kode_tukang', '=', 'tukangs.id')
            ->join('users', 'tukangs.id', '=', 'users.kode_user')
            ->orderBy('produk_created', 'asc')
            ->where([['nama_produk', 'LIKE', '%' . $request->query_search . '%'], ['kota', '=', $location]])
            ->paginate(10);

        return (new BerandaResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function search_by_locationv2(Request $request, string $location)
    {
        $data = Produk::with(['tukang.user' => function ($query){
            $query->select('kode_user', 'name');
        }])->with('tukang.voterate')
            ->with('tukang.rating')
            ->whereHas('tukang', function($query) use ($location){
            $query->where('kota', '=', $location);
        })->where('nama_produk', 'LIKE', '%'.$request->query_search.'%')->paginate(10);
        return (new ProdukResourceController($data))->response()->setStatusCode(200);
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function new_productv2()
    {
        $data = Produk::with('tukang.rate', 'tukang.user')->orderBy('created_at', 'desc')->paginate(5);

        return (new BerandaResourceController($data))->response()->setStatusCode(200);
    }
}
