<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\FreeModel;
use App\Models\BidangModel;
use App\Models\JobModel;
use App\Models\PenawaranModel;
use App\Models\KontrakModel;
use App\Models\ProfileModel;
use App\Models\UlasanModel;




class HomeController extends Controller
{    
    
    public function homeAdmin(){

        $user = auth()->user();
        $id_user = $user->id_user;

        $profile= ProfileModel::where('id_user', $id_user)->first();
        $bidang = BidangModel::select('*')->get();


        if($profile){
            return view ('home');
        }
        else {
            return view ('inputprofile',compact('bidang'));
        }

        
    }



    public function homeClient(){

        $user = auth()->user();
        $id_user = $user->id_user;

        $bidang = BidangModel::select('*')->get();
        $profile= ProfileModel::where('id_user', $id_user)->first();


        $job = JobModel::where('id_client', $id_user)->whereNotIn('status', [8, 10])->count();
        $kontrak = kontrakModel::where('id_client', $id_user)->where('status', 2)->count();
        $penawaran = PenawaranModel::where('id_client', $id_user)->where('status', 3)->count(); 

        if($profile){
            $role = User::where('role', 'freelancer')->pluck('id_user');

            $free = ProfileModel::select('tb_profile.*',
             'bid.bidang as bidang_name',
             DB::raw('(SELECT AVG(rating) FROM tb_ulasan WHERE id_user = tb_profile.id_user) as average_rating'))

            ->join('tb_bidang as bid', 'tb_profile.bidang', '=', 'bid.id_bidang') 
            ->whereIn('tb_profile.id_user', $role)
            ->get();

        }
        else {
            return view ('inputprofile',compact('bidang'));
        }



        

        return view('home', compact('free', 'job','kontrak','penawaran','profile'));
    }

    public function homeFree(){

        $user = auth()->user();
        $id_user = $user->id_user;

        $profile= ProfileModel::where('id_user', $id_user)->first();
        $bidang = BidangModel::select('*')->get();

        $kontrak = kontrakModel::where('id_free', $id_user)->where('status', 2)->count();
        $penawaran = PenawaranModel::where('id_free', $id_user)->where('status', 3)->count();

        if($profile){

            $job = JobModel::select('tb_job.*',
            'client.username as client_name',
            'bid.bidang as bidang_name',
            'sta.status as status_name',
            'profile.foto_profile as pp')

            ->join('users as client', 'tb_job.id_client', '=', 'client.id_user')
            ->join('tb_bidang as bid', 'tb_job.bidang', '=', 'bid.id_bidang') 
            ->join('tb_status as sta', 'tb_job.status', '=', 'sta.id_status') 
            ->join('tb_profile as profile', 'tb_job.id_client', '=', 'profile.id_user')
            ->where('tb_job.status','!=',8)
            ->where('tb_job.status','!=',6)

            ->get();
            
        }
        else {
            return view ('inputprofile',compact('bidang'));
        }

        return view ('home', compact('job', 'kontrak','penawaran'));
    }

    public function blokirPage(){
        return view ('blokir');
    }
}
