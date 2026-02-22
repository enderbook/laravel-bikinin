<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KontrakModel;
use App\Models\PenawaranModel;
use App\Models\PayModel;
use App\Models\JobModel;
use App\Models\FilekontrakModel;


class HistoryController extends Controller
{
    public function historyTampil($id)
    {
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
                ->whereIn('tb_penawaran.status', [8,9,12,13])
                ->get();

                $kontrak = KontrakModel::select('tb_kontrak.*',
                    'jobs.judul as judul_job',
                    'freelancer.username as freelancer_username',
                    'client.username as client_name',
                    'profile.foto_profile as pp')
                    ->join('tb_job as jobs', 'tb_kontrak.id_job', '=', 'jobs.id_job')
                    ->join('users as freelancer', 'tb_kontrak.id_free', '=', 'freelancer.id_user')
                    ->join('users as client', 'tb_kontrak.id_client', '=', 'client.id_user')
                    ->join('tb_profile as profile', 'tb_kontrak.id_free', '=', 'profile.id_user')

                    ->where('tb_kontrak.id_free', $id_user)
                    ->whereIn('tb_kontrak.status', [8,11])->get();
    
                return view ('histori',compact('kontrak','nawar'));
                
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
                ->whereIn('tb_penawaran.status', [8, 9, 10, 11])
                ->get();

                $job = JobModel::select('tb_job.*',
                    'client.username as client_name',
                    'bid.bidang as bidang_name',
                    'sta.status as status_name')

                    ->join('users as client', 'tb_job.id_client', '=', 'client.id_user')
                    ->join('tb_bidang as bid', 'tb_job.bidang', '=', 'bid.id_bidang') 
                    ->join('tb_status as sta', 'tb_job.status', '=', 'sta.id_status') 
                    ->where('tb_job.id_client', $id_user)
                    ->where('tb_job.status', '=',8)

                    ->get();
    
                $adakontrak = KontrakModel::pluck('id_job')->toArray();
                $kontrak = KontrakModel::select('tb_kontrak.*',
                    'jobs.judul as judul_job',
                    'freelancer.username as freelancer_username',
                    'client.username as client_name',
                    'profile.foto_profile as pp')
                    ->join('tb_job as jobs', 'tb_kontrak.id_job', '=', 'jobs.id_job')
                    ->join('users as freelancer', 'tb_kontrak.id_free', '=', 'freelancer.id_user')
                    ->join('users as client', 'tb_kontrak.id_client', '=', 'client.id_user')
                    ->join('tb_profile as profile', 'tb_kontrak.id_free', '=', 'profile.id_user')

                    ->where('tb_kontrak.id_client', $id_user)
                    ->whereIn('tb_kontrak.status', [8,10])->get();

                return view ('histori',compact('kontrak','nawar','job','adakontrak'));
    
            }



    }

    public function hapusNawar($id){
        $user = auth()->user();
        $role_user= $user->role;

        $nawar = PenawaranModel::where('id_penawaran', $id)->first();

        if ($role_user == 'freelancer') {
            if($nawar->status == 8){
                $nawar = PenawaranModel::where('id_penawaran', $id)->update(['status'=>10]);
            }
            elseif($nawar->status == 9){
                $nawar = PenawaranModel::where('id_penawaran', $id)->update(['status'=>11]);
            }
            else{
                $nawar = PenawaranModel::where('id_penawaran', $id)->delete();
            }
        }
        elseif ($role_user == 'client') {
            if($nawar->status == 8){
                $nawar = PenawaranModel::where('id_penawaran', $id)->update(['status'=>12]);
            }
            elseif($nawar->status == 9){
                $nawar = PenawaranModel::where('id_penawaran', $id)->update(['status'=>13]);
            }
            else{
                $nawar = PenawaranModel::where('id_penawaran', $id)->delete();
            }
        }

        

        return redirect()->back();

    }

    public function hapusKontrak($id){
        $user = auth()->user();
        $role_user= $user->role;

        $kontrak = KontrakModel::where('id_kontrak', $id)->first();

        if ($role_user == 'freelancer') {
            if($kontrak->status == 8){
                $kontrak = KontrakModel::where('id_kontrak', $id)->update(['status'=>10]);
                $pay = PayModel::where('id_kontrak', $id)->update(['status'=>10]);
            }
            else{
                $kontrak = KontrakModel::where('id_kontrak', $id)->delete();
                $pay = PayModel::where('id_kontrak', $id)->delete();
            }
        }
        elseif ($role_user == 'client') {
            if($kontrak->status == 8){
                $kontrak = KontrakModel::where('id_kontrak', $id)->update(['status'=>11]);
                $pay = PayModel::where('id_kontrak', $id)->update(['status'=>11]);
            }
            else{
                $kontrak = KontrakModel::where('id_kontrak', $id)->first();
                $pay = PayModel::where('id_kontrak', $id)->first();

                $destinationPath = public_path('imageup');

                unlink($destinationPath . '/' . $kontrak->delivarable);
                unlink($destinationPath . '/' . $pay->poto_client);
                unlink($destinationPath . '/' . $pay->poto);

                $files = FilekontrakModel::where('id_kontrak', $id)->get();

                foreach ($files as $f) {
                    $destinationPath = public_path('imageup');
                    $filePath = $destinationPath . '/' . $f->file;

                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    $f->delete();
                }

                $kontrak->delete();
                $pay->delete();
            }
        }        
        


        return redirect()->back();

    }

    public function hapusJob($id){

        $job = JobModel::where('id_job', $id)->update(['status'=>10]);

        return redirect()->back();

    }
}
