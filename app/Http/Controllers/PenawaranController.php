<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\FreeModel;
use App\Models\BidangModel;
use App\Models\JobModel;
use App\Models\PenawaranModel;
use App\Models\KontrakModel;
use App\Models\ProfileModel;
use App\Models\NotifModel;
use App\Models\PayModel;

use Illuminate\Support\Str;
use Carbon\Carbon;



class PenawaranController extends Controller
{
    public function nawar(){
        $user = auth()->user();
        $id_user = $user->id_user;
        $role_user= $user->role;

        if($role_user == 'freelancer'){
            $nawar = PenawaranModel::select('tb_penawaran.*',
            'jobs.judul as judul_job',
            'freelancer.username as freelancer_username',
            'profile.foto_profile as pp')
            ->join('tb_job as jobs', 'tb_penawaran.id_job', '=', 'jobs.id_job')
            ->join('users as freelancer', 'tb_penawaran.id_free', '=', 'freelancer.id_user')
            ->join('tb_profile as profile', 'tb_penawaran.id_free', '=', 'profile.id_user')
            ->where('tb_penawaran.id_free', $id_user)
            ->where('tb_penawaran.status', 3)

            ->get();


            
        }
        else{
            $nawar = PenawaranModel::select('tb_penawaran.*',
            'jobs.judul as judul_job',
            'freelancer.username as freelancer_username',
            'profile.foto_profile as pp')
            ->join('tb_job as jobs', 'tb_penawaran.id_job', '=', 'jobs.id_job')
            ->join('users as freelancer', 'tb_penawaran.id_free', '=', 'freelancer.id_user')
            ->join('tb_profile as profile', 'tb_penawaran.id_free', '=', 'profile.id_user')
            ->where('tb_penawaran.id_client', $id_user)
            ->where('tb_penawaran.status', 3)
            ->get();

            
        

        }
        
        

        return view('penawaran', compact('nawar'));
    }

    

    public function inputTawaran($id){

        $job = JobModel::select('tb_job.*',
         'client.username as client_name',
         'bid.bidang as bidang_name',
         'sta.status as status_name',
         'profile.foto_profile as pp')

        ->join('users as client', 'tb_job.id_client', '=', 'client.id_user')
        ->join('tb_bidang as bid', 'tb_job.bidang', '=', 'bid.id_bidang') 
        ->join('tb_status as sta', 'tb_job.status', '=', 'sta.id_status') 
        ->join('tb_profile as profile', 'tb_job.id_client', '=', 'profile.id_user')
        ->where('tb_job.id_job', $id)
        ->first();

        $user = auth()->user();
        $id_user = $user->id_user;

        $nawar = PenawaranModel::select('tb_penawaran.*',
        'profile.foto_profile as pp',
        'freelancer.username as freelancer_username')

        ->join('tb_profile as profile', 'tb_penawaran.id_free', '=', 'profile.id_user')
        ->join('users as freelancer', 'tb_penawaran.id_free', '=', 'freelancer.id_user')

        ->where('tb_penawaran.id_job', $id)
        ->where('tb_penawaran.id_free', $id_user)
        ->where('tb_penawaran.status','=',3 )


        ->get();

        $penawaran = PenawaranModel::select('tb_penawaran.*',
        'profile.foto_profile as pp',
        'freelancer.username as freelancer_username')

        ->join('tb_profile as profile', 'tb_penawaran.id_free', '=', 'profile.id_user')
        ->join('users as freelancer', 'tb_penawaran.id_free', '=', 'freelancer.id_user')

        ->where('tb_penawaran.id_job', $id)


        ->get();



        return view('detailjob', compact('job', 'nawar','penawaran'));
    }

    public function inputawaranAction(Request $request){
        $user = auth()->user();
        $id_user = $user->id_user;

        $nawar = PenawaranModel::create([
            'id_penawaran'=>$request->id_penawaran,
            'id_job'=>$request->id_job,
            'id_client'=>$request->id_client,
            'id_free'=>$id_user,
            'des_tawaran'=>$request->des_tawaran,
            'status'=>$request->status
        ]);

        $penawaran = PenawaranModel::select('tb_penawaran.*',
            'freelancer.username as free_name',
            'client.username as client_name',
            'job.judul as judul_job')
   
           ->join('users as freelancer', 'tb_penawaran.id_free', '=', 'freelancer.id_user')
           ->join('users as client', 'tb_penawaran.id_client', '=', 'client.id_user')
           ->join('tb_job as job', 'tb_penawaran.id_job', '=', 'job.id_job') 
           ->where('id_penawaran', $nawar->id_penawaran)->first();

           $notif = NotifModel::create([
            'id_user' => $request->id_client,
            'judul_notif' => "Seseorang menawarkan diri!!",
            'bagian' => 1,
            'status'=>0,
            'des_notif' => "Penawaran {$penawaran->free_name} untuk job {$penawaran->judul_job}"
            ]);

            

        

        return redirect('freelancer/penawaran');
    }

    public function detailNawar($id){
        $nawar = PenawaranModel::select('tb_penawaran.*',
            'jobs.judul as judul_job',
            'freelancer.username as freelancer_username',
            'profile.foto_profile as pp')
            ->join('tb_job as jobs', 'tb_penawaran.id_job', '=', 'jobs.id_job')
            ->join('users as freelancer', 'tb_penawaran.id_free', '=', 'freelancer.id_user')
            ->join('tb_profile as profile', 'tb_penawaran.id_free', '=', 'profile.id_user')

            ->where('tb_penawaran.id_penawaran', $id)
            ->first();

            return view('detailnawar', compact('nawar'));
    }

    public function statusNawar(Request $request){

        if($request->status_nawar == 8){

            $tanggal = Carbon::now()->format('dmy'); // 310524
            $random = strtoupper(Str::random(6)); // contoh: ZXKP

            $kode= "KON{$tanggal}{$random}";

            $kontrak= KontrakModel::create([
                'id_kontrak'=>$request->id_kontrak,
                'id_client'=>$request->id_client,
                'id_free'=>$request->id_free,
                'id_job'=>$request->id_job,
                'status'=>$request->status_kontrak,
                'deadline'=>$request->deadline,
                'bukti_transfer'=>$request->bukti_transfer,
                'kd_kontrak'=>$kode
    
            ]);

            $nawar= PenawaranModel::where('id_penawaran', $request->id_penawaran)->update(['status'=>$request->status_nawar]);

            $admins = User::where('role', 'admin')->where('status', '!=', 3)->get();

            $admin = $admins->sortBy(function ($admin) {
                return PayModel::where('id_admin', $admin->id_id_user)->count();
            })->first();

            $pay= PayModel::create([
                'judul'=>$request->id_job,
                'id_client'=>$request->id_client,
                'id_free'=>$request->id_free,
                'id_admin'=>$admin->id_user,
                'id_kontrak'=>$kontrak->id_kontrak,
                'poto'=>$request->poto,
                'nm_rek'=>$request->nm_rek,
                'no_rek'=>$request->no_rek,
                'status'=>$request->status_pay

            ]);

            $penawaran = PenawaranModel::select('tb_penawaran.*',
            'freelancer.username as free_name',
            'client.username as client_name',
            'job.judul as judul_job')
   
           ->join('users as freelancer', 'tb_penawaran.id_free', '=', 'freelancer.id_user')
           ->join('users as client', 'tb_penawaran.id_client', '=', 'client.id_user')
           ->join('tb_job as job', 'tb_penawaran.id_job', '=', 'job.id_job') 
           ->where('id_penawaran', $request->id_penawaran)->first();

            $notif = NotifModel::create([
                'id_user' => $request->id_client,
                'judul_notif' => "Anda telah menerima Penawaran",
                'bagian' => 1,
                'status'=>0,
                'des_notif' => "Diterima Penawaran {$penawaran->free_name} untuk job {$penawaran->judul_job}"
            ]);
    
            $notif = NotifModel::create([
                'id_user' => $request->id_free,
                'judul_notif' => "Penawaranmu Diterima Loh!!!",
                'bagian' => 1,
                'status'=>0,
                'des_notif' => "{$penawaran->client_name} Menerima penawaranmu untuk job {$penawaran->judul_job}"
            ]);

        }
        else {

            $nawar= PenawaranModel::where('id_penawaran', $request->id_penawaran)->update([
                
                'status'=>9
            ]);

            $penawaran = PenawaranModel::select('tb_penawaran.*',
            'freelancer.username as free_name',
            'client.username as client_name',
            'job.judul as judul_job')
   
           ->join('users as freelancer', 'tb_penawaran.id_free', '=', 'freelancer.id_user')
           ->join('users as client', 'tb_penawaran.id_client', '=', 'client.id_user')
           ->join('tb_job as job', 'tb_penawaran.id_job', '=', 'job.id_job') 
           ->where('id_penawaran', $request->id_penawaran)->first();

           $notif = NotifModel::create([
            'id_user' => $request->id_client,
            'judul_notif' => "Anda telah menolak Penawaran",
            'bagian' => 1,
            'status'=>0,
            'des_notif' => "Ditolak Penawaran {$penawaran->free_name} untuk job {$penawaran->judul_job}"
            ]);

            $notif = NotifModel::create([
                'id_user' => $request->id_free,
                'judul_notif' => "Penawaranmu Ditolak Loh!!!",
                'bagian' => 1,
                'status'=>0,
                'des_notif' => "{$penawaran->client_name} Menolak penawaranmu untuk job {$penawaran->judul_job}"
            ]);

        }

        

        return redirect('kontrak');
    }

    public function batalNawar($id){

        $nawar = PenawaranModel::where('id_penawaran', $id)->delete(); 
        return redirect('freelancer/penawaran');

    }



}
