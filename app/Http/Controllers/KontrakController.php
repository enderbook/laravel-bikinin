<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KontrakModel;
use App\Models\FilekontrakModel;
use App\Models\PayModel;
use App\Models\HistoryPayModel;
use App\Models\UlasanModel;
use App\Models\NotifModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;

class KontrakController extends Controller
{
    public function kontrakClient(){
        $user = auth()->user();
        $id_user = $user->id_user;

        $kontrak = KontrakModel::select('tb_kontrak.*',
            'jobs.judul as judul_job',
            'freelancer.username as freelancer_username',
            'client.username as client_name',
            'profile.foto_profile as pp')
            ->join('tb_job as jobs', 'tb_kontrak.id_job', '=', 'jobs.id_job')
            ->join('users as freelancer', 'tb_kontrak.id_free', '=', 'freelancer.id_user')
            ->join('users as client', 'tb_kontrak.id_client', '=', 'client.id_user')
            ->join('tb_profile as profile', 'tb_kontrak.id_free', '=', 'profile.id_user')

            ->where(function($query) use ($id_user) {
                $query->where('tb_kontrak.id_free', $id_user)
                      ->orWhere('tb_kontrak.id_client', $id_user);
            })
            ->where('tb_kontrak.status', '!=', 8)
            ->get();

        return view('kontrak', compact('kontrak'));
    }

    public function detailKontrak($id){
        $user = auth()->user();
        $id_user = $user->id_user;

        $pay = PayModel::select(
            'tb_pay.*',
            'users.username as admin_name',
            'users.email as admin_email',
            'profile_admin.no_wa as wa_admin',
        )
        ->join('users', 'tb_pay.id_admin', '=', 'users.id_user')
        ->leftJoin('tb_profile as profile_admin', 'tb_pay.id_admin', '=', 'profile_admin.id_user')


        ->where('tb_pay.id_kontrak', $id)
        ->first();



        $file = FilekontrakModel::where('id_kontrak', $id)->get();


        $kontrak = KontrakModel::select('tb_kontrak.*',
                'jobs.judul as judul_job',
                'freelancer.username as freelancer_username',
                'client.username as client_name',
                'profile_free.foto_profile as pp_free',
                'profile_free.no_wa as wa_free',
                'profile_client.foto_profile as pp_client',
                'profile_client.no_wa as wa_client')
                
            ->join('tb_job as jobs', 'tb_kontrak.id_job', '=', 'jobs.id_job')
            ->join('users as freelancer', 'tb_kontrak.id_free', '=', 'freelancer.id_user')
            ->join('users as client', 'tb_kontrak.id_client', '=', 'client.id_user')
            ->leftJoin('tb_profile as profile_free', 'tb_kontrak.id_free', '=', 'profile_free.id_user')
            ->leftJoin('tb_profile as profile_client', 'tb_kontrak.id_client', '=', 'profile_client.id_user')
            ->where('tb_kontrak.id_kontrak', $id)
            ->first();

        $hispay = HistoryPayModel::where('kode_kontrak', $kontrak->kd_kontrak)->get();



        return view('detailkontrak', compact('kontrak', 'pay','file','hispay'));
    }

    public function kontrakFile(Request $request) {
        if ($request->hasFile('file_kontrak')) {
            $file = $request->file('file_kontrak'); 
            $tujuan_upload = public_path('imageup');
            $file_name =date('Y-m-d-H-i-s') . '-' .$file->getClientOriginalName(); 
            $file->move($tujuan_upload, $file_name); 
    
            $saved = FilekontrakModel::create([
                'id_kontrak' => $request->id_kontrak,
                'file' => $file_name
            ]);
    
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'file_name' => $file_name,
                    'file_url' => url('imageup/' . $file_name),
                    'id_file' => $saved->id_file
                ]);
            }
    
            return redirect()->back()->with('success', 'File berhasil diunggah!');
        }
    
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada file yang diunggah.'
            ], 400);
        }
    
        return redirect()->back()->with('error', 'Tidak ada file yang diunggah.');
    }

    public function hapusFile($id){

        $file = FilekontrakModel::where('id_file', $id)->first();

        $existingfile = $file->file;

        $destinationPath = public_path('imageup');

        unlink($destinationPath . '/' . $existingfile);

        $file->delete();
        
        return response()->json(['success' => true, 'message' => 'File berhasil dihapus!']);

    }

    public function kontrakAkhiri(Request $request){
        $user = auth()->user();
        $id_user = $user->id_user;

        $isi_kontrak = KontrakModel::where('id_kontrak', $request->id_kontrak)->first();

        $kontrak = KontrakModel::where('id_kontrak', $request->id_kontrak)->update([
        
            'status' =>8
        ]);

        $pay = PayModel::select('*')->where('id_kontrak', $request->id_kontrak)->update([
          
            'status' =>8
        ]);

        try {
            $ulasan = UlasanModel::create([
                'id_penulis' => $isi_kontrak->id_client,
                'id_user' => $isi_kontrak->id_free,
                'ulasan' => $request->ulasan,
                'rating' => $request->rating,
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }


        return redirect('/kontrak');
    }

    public function clientKontrak(Request $request) {
        $request->validate([
            'poto' => 'nullable|file|image|max:1024000', 
        ]);

        $pay = PayModel::where('id_pay', $request->id_pay)->first();
        $status = $pay->status;

        $kontrak = kontrakModel::where('id_kontrak', $request->id_kontrak)->first();

        $existingPotoClient = $pay->poto_client;
        $file_name_client = $existingPotoClient; 

        if ($request->hasFile('poto')) {
            $file = $request->file('poto');

            $file_name_client = date('Y-m-d-H-i-s') . '-' . $file->getClientOriginalName();

            $destinationPath = public_path('imageup');

            if ($existingPotoClient && file_exists($destinationPath . '/' . $existingPotoClient)) {
                unlink($destinationPath . '/' . $existingPotoClient);
            }

            $file->move($destinationPath, $file_name_client);

            
            if (!empty($kontrak->delivarable)) {
                $status = 1;
            } 

        }

        

        $payUpdate = $pay->update([
            'status' => $status, 
            'poto_client' => $file_name_client 
        ]);

        if($status == 1){
            $notif = NotifModel::create([
                'id_user' => $pay->id_admin,
                'judul_notif' => "Kontrak siap transfer!",
                'bagian' => 2,
                'status'=>0,
                'des_notif' => "Admin telah bisa mentrasfer uang utk kontrak : {$kontrak->kd_kontrak}"
            ]);
        }

        

        return redirect('kontrak/detail/'.$kontrak->id_kontrak)->with('success', 'Berhasil Diinput!');
    }

    public function freeKontrak(Request $request){

        $request->validate([
            'poto' => 'nullable|file|max:204800', // 200MB = 204800KB
        ]);

        $kontrak = kontrakModel::where('id_kontrak', $request->id_kontrak)->first();

        $existingDelivarable = $kontrak->delivarable;
        $file_name = $existingDelivarable;

        $file_name = $request->potoAda;

        if ($request->hasFile('poto')) {
            $file = $request->file('poto');

            $file_name = date('Y-m-d-H-i-s') . '-' . $file->getClientOriginalName();

            $destinationPath = public_path('imageup');

            if ($existingDelivarable && file_exists($destinationPath . '/' . $existingDelivarable)) {
                unlink($destinationPath . '/' . $existingDelivarable);
            }

            $file->move($destinationPath, $file_name);
        }

        $user = auth()->user();
        $role_user = $user->role;

        $kontraak = KontrakModel::where('id_kontrak', $request->id_kontrak)->update([
         
            'status' => $request->status_kontrak,
            'delivarable' => $file_name
        ]);

        $pay = PayModel::where('id_pay', $request->id_pay)->first();

        if (!empty($pay->poto_client)) {
            $pay->update(['status' => 1]);
            $notif = NotifModel::create([
                'id_user' => $pay->id_admin,
                'judul_notif' => "Kontrak siap transfer!",
                'bagian' => 2,
                'status'=>0,
                'des_notif' => "Admin telah bisa mentrasfer uang utk kontrak : {$kontrak->kd_kontrak}"
            ]);
        } 

        $kontrak = kontrakModel::select('tb_kontrak.*',
        'client.username as client_name',
        'freelancer.username as free_name',
        'client.id_user as id_client',
        'jobs.judul as judul_name')

        ->join('users as client', 'tb_kontrak.id_client', '=', 'client.id_user')
        ->join('users as freelancer', 'tb_kontrak.id_free', '=', 'freelancer.id_user')
        ->join('tb_job as jobs', 'tb_kontrak.id_job', '=', 'jobs.id_job')
        ->where('tb_kontrak.id_kontrak', $request->id_kontrak)->first();

        $notif = NotifModel::create([
            'id_user' => $kontrak->id_client,
            'judul_notif' => "Delivarable udah ada loh!!",
            'bagian' => 2,
            'status'=>0,
            'des_notif' => "{$kontrak->free_name} telah mengirim delivarable utk job {$kontrak->judul_name}"
        ]);

        
        return redirect('kontrak/detail/'.$kontrak->id_kontrak)->with('success', 'Berhasil Diinput!');
    }

    function downloadFile($id){
        $kontrak = KontrakModel::where('id_kontrak', $id)->first();

        if (!$kontrak) {
            return response()->json([
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        $filename = $kontrak->delivarable;
        $filePath = public_path('imageup/' . $filename); 

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return response()->json([
                'message' => 'File tidak ditemukan di server!'
            ], 404);
        }
    }

    function deadLine(Request $request){
        $deadline = KontrakModel::where('id_kontrak', $request->id_kontrak_deadline)->update([
            'deadline'=>$request->deadline
        ]);

        return redirect()->back();
    }

 

    

    
}
