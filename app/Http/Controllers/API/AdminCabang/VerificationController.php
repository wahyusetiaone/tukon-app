<?php

namespace App\Http\Controllers\API\AdminCabang;

use App\Http\Controllers\Controller;
use App\Http\Resources\VerificationResourceController;
use App\Models\BerkasVerificationTukang;
use App\Models\Tukang;
use App\Models\VerificationTukang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|object
     */
    public function ajukan_verification(Request $request, int $id)
    {
        if (!Tukang::whereId($id)->exists()) {
            return (new VerificationResourceController(['error' => 'Tukang tidak ditemukan !']))->response()->setStatusCode(401);
        }

        $validator = Validator::make($request->all(), [
            'nama_tukang' => 'required|string',
            'no_hp' => 'required|string',
            'email' => 'email',
            'alamat' => 'string',
            'koordinat' => 'required|string',
            'foto_ktp' => 'required|mimes:jpg,jpeg|max:1000',
            'foto_personal' => 'required|mimes:jpg,jpeg|max:1000',
            'foto_kantor' => 'required|array',
            'foto_kantor.*' => 'mimes:jpg,jpeg|max:1000'
        ]);

        if ($validator->fails()) {
            return (new VerificationResourceController(['error' => $validator->errors()]))->response()->setStatusCode(401);
        }

        $path = 'storage/berkas/verification/tukang/'.$id;
        $s_path = '/berkas/verification/tukang/'.$id;

        if (!Storage::disk('public')->exists($s_path)) {
            DB::transaction(function () use ($request, $id, $path, $s_path, &$data) {
                $request['tukang_id'] = $id;
                $request['admin_id'] = Auth::id();
                $data = VerificationTukang::create($request->except(['foto_ktp', 'foto_personal', 'foto_kantor']));
                foreach ($request->file('foto_kantor') as $file) {
                    if ($file->isValid()) {
                        $name = $file->store($s_path, 'public');
                        $berkas = new BerkasVerificationTukang();
                        $berkas->verificationtukang_id = $data->id;
                        $berkas->path = $path . $name;
                        $berkas->original_name = $file->getClientOriginalName();
                        $berkas->save();
                    }
                }
                $file_personal = $request->file('foto_personal');
                if ($file_personal->isValid()) {
                    $name = $file_personal->store($s_path, 'public');
                    $berkas = new BerkasVerificationTukang();
                    $berkas->verificationtukang_id = $data->id;
                    $berkas->path = $path . $name;
                    $berkas->original_name = $file_personal->getClientOriginalName();
                    $berkas->save();
                }
                $file_ktp = $request->file('foto_ktp');
                if ($file_ktp->isValid()) {
                    $name = $file_ktp->store($s_path, 'public');
                    $berkas = new BerkasVerificationTukang();
                    $berkas->verificationtukang_id = $data->id;
                    $berkas->path = $path . $name;
                    $berkas->original_name = $file_ktp->getClientOriginalName();
                    $berkas->save();
                }
            });
        } else {
            return (new VerificationResourceController(['error' => 'Tukang sudah pernah dilakukan proses verifikasi sebelumnya, mohon untuk melakukan update verifikasi !']))->response()->setStatusCode(401);
        }

        return (new VerificationResourceController(['data' => $path]))->response()->setStatusCode(200);
    }
}
