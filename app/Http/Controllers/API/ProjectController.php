<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResourceController;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function client_show_all_project()
    {
        $data = Project::with('pembayaran', 'pembayaran.pin', 'pembayaran.pin.pengajuan', 'pembayaran.pin.penawaran', 'pembayaran.pin.tukang', 'pembayaran.pin.tukang.user')->whereHas('pembayaran.pin.pengajuan', function ($query) {
            $query->where('kode_client', Auth::id());
        })->paginate(5)->toArray();
        return (new ProjectResourceController($data))->response()->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function client_show_project(int $id)
    {
        $kode_user = User::with('client')->find(Auth::id())->kode_user;

        $validasi = Project::with('pembayaran', 'pembayaran.pin','pembayaran.pin.penawaran.komponen', 'pembayaran.pin.pengajuan', 'pembayaran.pin.penawaran', 'penarikan', 'progress.onprogress.doc')->find($id);

        if ($kode_user == $validasi->pembayaran->pin->pengajuan->kode_client) {
            return (new ProjectResourceController($validasi))->response()->setStatusCode(200);
        }
        return (new ProjectResourceController(['error' => 'Tidak ada akses untuk merubah data ini !!!']))->response()->setStatusCode(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function tukang_get_all_project()
    {
        $kode_user = User::with('tukang')->find(Auth::id())->kode_user;

        $validasi = Project::with('pembayaran', 'pembayaran.pin', 'pembayaran.pin.pengajuan', 'pembayaran.pin.pengajuan.client', 'pembayaran.pin.pengajuan.client.user', 'pembayaran.pin.penawaran')->whereHas('pembayaran.pin', function ($query) {
            $query->where('kode_tukang', Auth::id());
        })->paginate(5);

        if ($kode_user == $validasi[0]->pembayaran->pin->kode_tukang) {
            return (new ProjectResourceController($validasi))->response()->setStatusCode(200);
        }
        return (new ProjectResourceController(['error' => 'Tidak ada akses untuk merubah data ini !!!']))->response()->setStatusCode(401);
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function tukang_show_project(int $id)
    {
        $kode_user = User::with('tukang')->find(Auth::id())->kode_user;

        try {
            $validasi = Project::with('progress', 'progress.onprogress', 'progress.onprogress.doc', 'pembayaran', 'pembayaran.pin', 'pembayaran.pin.pengajuan', 'pembayaran.pin.penawaran', 'penarikan')->findOrFail($id);

            if ($kode_user == $validasi->pembayaran->pin->kode_tukang) {
                return (new ProjectResourceController($validasi))->response()->setStatusCode(200);
            }
            return (new ProjectResourceController(['error' => 'Tidak ada akses untuk merubah data ini !!!']))->response()->setStatusCode(401);
        } catch (ModelNotFoundException $ee) {
            return (new ProjectResourceController(['error' => 'Item tidak ditemukan !!!']))->response()->setStatusCode(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function client_approve(int $id)
    {

        $kode_user = User::with('client')->find(Auth::id())->kode_user;

        $validasi = Project::with('pembayaran', 'pembayaran.pin', 'pembayaran.pin.pengajuan')->find($id);

        if ($kode_user == $validasi->pembayaran->pin->pengajuan->kode_client) {
            if ($validasi->progress == 100) {
                try {
                    $data = Project::findOrFail($id);
                    if ($data->kode_status != "ON05") {
                        $data->update(['kode_status' => 'ON02']);
                        return (new ProjectResourceController(['status_update' => $data]))->response()->setStatusCode(200);
                    }
                    return (new ProjectResourceController(['error' => 'Status projek telah selesai, tidak dapat di ubah kembali']))->response()->setStatusCode(401);
                } catch (ModelNotFoundException $ee) {
                    return (new ProjectResourceController(['error' => $ee->getMessage()]))->response()->setStatusCode(401);

                }
            }
            return (new ProjectResourceController(['error' => 'Maaf status projek masih dalam tahap pengerjaan, anda tidak dapat melakukan tindakan ini !!!']))->response()->setStatusCode(401);
        }
        return (new ProjectResourceController(['error' => 'Tidak ada akses untuk merubah data ini !!!']))->response()->setStatusCode(401);

    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function tukang_approve(int $id)
    {

        $kode_user = User::with('tukang')->find(Auth::id())->kode_user;

        $validasi = Project::with('pembayaran', 'pembayaran.pin')->find($id);

        if ($kode_user == $validasi->pembayaran->pin->kode_tukang) {
            if ($validasi->persentase_progress == 100) {
                try {
                    $data = Project::findOrFail($id);
                    if ($data->kode_status != "ON05") {
                        $data->update(['kode_status' => 'ON04']);
                        return (new ProjectResourceController(['status_update' => $data]))->response()->setStatusCode(200);
                    }
                    return (new ProjectResourceController(['error' => 'Status projek telah selesai, tidak dapat di ubah kembali']))->response()->setStatusCode(401);
                } catch (ModelNotFoundException $ee) {
                    return (new ProjectResourceController(['error' => $ee->getMessage()]))->response()->setStatusCode(401);

                }
            }
            return (new ProjectResourceController(['error' => 'Maaf status projek masih dalam tahap pengerjaan, anda tidak dapat melakukan tindakan ini !!!']))->response()->setStatusCode(401);
        }
        return (new ProjectResourceController(['error' => 'Tidak ada akses untuk merubah data ini !!!']))->response()->setStatusCode(401);

    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function client_cancel(int $id)
    {
        if (!Project::whereId($id)->exists()) {
            return (new ProjectResourceController(['error' => 'Project Tidak di Temukan !!!']))->response()->setStatusCode(401);
        }

        $validasi = Project::with('pembayaran', 'pembayaran.pin', 'pembayaran.pin.pengajuan', 'penarikan')->find($id);

        if (Auth::id() == $validasi->pembayaran->pin->pengajuan->kode_client) {

            if ($validasi->kode_status != 'ON01') {
                return (new ProjectResourceController(['error' => 'Maaf proyek tidak lagi dalam status "Pengerjaan" maka pembatalan tidak dapat dilakukan !!!']))->response()->setStatusCode(401);
            }
            if ($validasi->penarikan->persentase_penarikan >= 50) {
                return (new ProjectResourceController(['error' => 'Penarikan Dana disisi Tukang sudah mencapai 50% atau lebih, proyek tidak dapat dibatalkan !!!']))->response()->setStatusCode(401);
            }
            $validasi->update(['kode_status' => 'ON03']);
            return (new ProjectResourceController(['status_update' => true, 'message' => 'Berhasil membatalkan proyek, terkait dengan pengembalian dana mohon untuk mengakses halaman "Pengembalian Dana".']))->response()->setStatusCode(200);
        }
        return (new ProjectResourceController(['error' => 'Tidak ada akses untuk merubah data ini !!!']))->response()->setStatusCode(401);

    }
}
