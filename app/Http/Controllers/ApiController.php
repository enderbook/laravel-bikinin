<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FreeModel;
use App\Models\BidangModel;
use App\Models\ProfileModel;
use App\Models\JobModel;
use App\Models\NotifModel;
use App\Models\PenawaranModel;
use App\Models\PayModel;
use App\Models\KontrakModel;
use App\Models\UlasanModel;
use App\Models\NewsModel;
use App\Models\FilekontrakModel;
use Hash;
use Auth;
use Str;
use Carbon\Carbon;


class ApiController extends Controller
{
    
    function login(Request $request){
        $login = Auth::Attempt($request->all());
        if($login){
            $user = Auth::user();
            $user->save();
            $user->api_token = Str::random(100);
            //$user->makeVisible('api_token');

            return response()->json([
                'response_code' => 201,
                'message'=> 'Login Succesfully',
                'content'=> $user
            ]);
        }else{
            return response()->json([
                'response_code' => 500,
                'message'=>'Maaf, Username atau Password Salah!'
            ]);
        }
    }

    public function register(Request $request){
        $register = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'role' => $request->role,
            'status' => 3
        ]);

        if($register){
            $notif = NotifModel::create([
                'id_user' => $register->id_user,
                'judul_notif' => "Selamat Datang!",
                'bagian' => 4,
                'status'=>0,
                'des_notif' => "Anda telah bergabung sebagai {$register->role}"
            ]);
        }

        if ($register) {
            return response()->json([
                'response_code' => 200,
                'message' => 'Suksess Boi!!!',
                'content'=>$register
            ]);
        } else {
            return response()->json([
                'response_code' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        
    }

    function tampilFree(){
        
        $free = FreeModel::select(
            'tb_free.*',
            'free.username as freelancer_name',
            'bid.bidang as bidang_name',
            'des.des_singkat as deskripsi'
        )
        ->join('users as free', 'free.id_user', '=', 'tb_free.id_user') 
        ->join('tb_bidang as bid', 'tb_free.bidang', '=', 'bid.id_bidang')
        ->join('tb_profile as des', 'tb_free.id_user', '=', 'des.id_user')
        ->get();

        if($free){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$free
            ]);
        }
        else{
            return response()->json([
                'response_code'=>201,
                'message'=>'Internal Error'
            ]);
        }     

    }

    function tampilBidang(){
        
        $bidang = BidangModel::select('*')->get();


        if($bidang){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$bidang
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        }     

    }

    function tampilJob(){
        
        $job = JobModel::select('tb_job.*',
        'client.username as client_name',
        'profile.foto_profile as pp_client',
        'bid.bidang as bidang_name',
        'sta.status as status_name')

       ->join('users as client', 'tb_job.id_client', '=', 'client.id_user')
       ->join('tb_profile as profile', 'tb_job.id_client', '=', 'profile.id_user')
       ->join('tb_bidang as bid', 'tb_job.bidang', '=', 'bid.id_bidang') 
       ->join('tb_status as sta', 'tb_job.status', '=', 'sta.id_status') 

        ->where('tb_job.status','!=', 8)


        ->get();


        if($job){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$job
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        }     

    }

    function detJob(Request $request){

        $id_job = $request->query('id_job');
        $job = JobModel::select('tb_job.*',
        'client.username as client_name',
        'profile.foto_profile as pp_client',
        'bid.bidang as bidang_name',
        'sta.status as status_name')

       ->join('users as client', 'tb_job.id_client', '=', 'client.id_user')
       ->join('tb_profile as profile', 'tb_job.id_client', '=', 'profile.id_user')
       ->join('tb_bidang as bid', 'tb_job.bidang', '=', 'bid.id_bidang') 
       ->join('tb_status as sta', 'tb_job.status', '=', 'sta.id_status') 

        ->where('tb_job.id_job', $id_job)
        ->first();


        if($job){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>[$job]
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        }     

    }

    function tampilJobclient(Request $request){
        
        $id_user = $request->query('id_user');
        $source = $request->query('source');

        $job = JobModel::select('tb_job.*',
         'client.username as client_name',
         'profile.foto_profile as pp_client',
         'bid.bidang as bidang_name',
         'sta.status as status_name')

        ->join('users as client', 'tb_job.id_client', '=', 'client.id_user')
        ->join('tb_profile as profile', 'tb_job.id_client', '=', 'profile.id_user')
        ->join('tb_bidang as bid', 'tb_job.bidang', '=', 'bid.id_bidang') 
        ->join('tb_status as sta', 'tb_job.status', '=', 'sta.id_status') 

        ->where('tb_job.id_client', $id_user);

        if ($source == "history") {
            $job->where('tb_job.status', 8);
        }
        else {
            $job->where('tb_job.status', '!=', 8);
        }

        $result = $job->get();


        if($result){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$result
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        }     

    }

    function inputJob(Request $request){
        $namaBidang = $request->bidang_name;
        $bidangBaru = strtolower(trim($namaBidang));

        $bidang = BidangModel::whereRaw('LOWER(bidang) LIKE ?', ['%' . $bidangBaru . '%'])->first();
    
        if (!$bidang) {
            $bidang = BidangModel::create([
                'bidang' => $bidangBaru
            ]);
        }
    
        $bidangId = $bidang->id_bidang;
    
        $job = JobModel::create([
            'id_job' => $request->id_job,
            'id_client' => $request->id_client,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_akhir' => $request->tgl_akhir,
            'status' => $request->status,
            'bidang' => $bidangId,
            'harga' => $request->harga
        ]);
    
        if ($job) {
            return response()->json([
                'response_code' => 200,
                'message' => 'Suksess Boi!!!',
                'content' => $job
            ]);
        } else {
            return response()->json([
                'response_code' => 500,
                'message' => 'Internal Error'
            ]);
        }
    }

    function jobPenawaran(Request $request){

        $id_job = $request->query('id_job');

        $penawaran = PenawaranModel::select('tb_penawaran.*',
         'freelancer.username as free_name',
         'profile.foto_profile as pp_free',
         'sta.status as status_name',
         'prof.nm_rek as nm_rek_free',
         'prof.no_rek as no_rek_free',
         'job.judul as judul_job')

        ->join('users as freelancer', 'tb_penawaran.id_free', '=', 'freelancer.id_user')
        ->join('tb_profile as profile', 'tb_penawaran.id_free', '=', 'profile.id_user')
        ->join('tb_status as sta', 'tb_penawaran.status', '=', 'sta.id_status') 
        ->join('tb_profile as prof', 'tb_penawaran.id_free', '=', 'prof.id_user') 
        ->join('tb_job as job', 'tb_penawaran.id_job', '=', 'job.id_job') 


        ->where('tb_penawaran.id_job', $id_job)
        ->where('tb_penawaran.status','=', 3)

        ->get();

        if($penawaran){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$penawaran
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        }  

    }

    public function hapusJob(Request $request){
        $id_job = $request->query('id_job');

        $kontrak = KontrakModel::where('id_job',$id_job)->where('status', 8)->get();

        if($kontrak->isEmpty()){
            $job= JobModel::where('id_job', $id_job)->update([
                'status' =>8
            ]);
        }
        

        if($job){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!'
            ]);
        }
        else{
            return response()->json([
                'response_code'=>201,
                'message'=>'Internal Error'
            ]);
        }    
    }

    public function cekJobKontrak(Request $request){
        $id_job = $request->query('id_job');
        $kontrak = KontrakModel::where('id_job',$id_job)->where('status', 8)->get();
        

        if($kontrak->isEmpty()){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!'
            ]);
        }
        else{
            return response()->json([
                'response_code'=>201,
                'message'=>'Internal Error'
            ]);
        }    
    }

    public function editJob(Request $request){
        $job = JobModel::where('id_job', $request->id_job)->update([
            'id_client'=>$request->id_client,
            'judul'=>$request->judul,
            'deskripsi'=>$request->deskripsi,
            'tgl_mulai'=>$request->tgl_mulai,
            'tgl_akhir'=>$request->tgl_akhir,
            'status'=>$request->status,
            'bidang'=>$request->bidang,
            'harga' => $request->harga
        ]);

        if($job){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content' =>$job
            ]);
        }
        else{
            return response()->json([
                'response_code'=>201,
                'message'=>'Internal Error'
            ]);
        } 
    }

    function tampilPenawaran(Request $request){

        $id_user = $request->query('id_user');
        $source = $request->query('source');
        $role_user = $request->query('role_user');

        $penawaran = PenawaranModel::select('tb_penawaran.*',
         'freelancer.username as free_name',
         'sta.status as status_name',
         'prof.nm_rek as nm_rek_free',
         'prof.foto_profile as pp_free',
         'prof.no_rek as no_rek_free',
         'job.judul as judul_job')

        ->join('users as freelancer', 'tb_penawaran.id_free', '=', 'freelancer.id_user')
        ->join('tb_status as sta', 'tb_penawaran.status', '=', 'sta.id_status') 
        ->join('tb_profile as prof', 'tb_penawaran.id_free', '=', 'prof.id_user') 
        ->join('tb_job as job', 'tb_penawaran.id_job', '=', 'job.id_job') ;

        if ($source == "history") {
            if ($role_user == "freelancer") {
                
                $penawaran->where('tb_penawaran.id_free', $id_user)->whereIn('tb_penawaran.status', [8,9,12,13]);
            }
            else {
                $penawaran->where('tb_penawaran.id_client', $id_user)->whereIn('tb_penawaran.status', [8, 9, 10, 11]);
            }
        }
        else {
            if ($role_user == "freelancer") {
                
                $penawaran->where('tb_penawaran.id_free', $id_user)->where('tb_penawaran.status', '=', 3);
            }
            else {
                $penawaran->where('tb_penawaran.id_client', $id_user)->where('tb_penawaran.status', '=', 3);
            }
        }

        $result = $penawaran->get();


        if($result){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$result
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        }  

    }

    function inputPenawaran(Request $request){
        $penawaran = PenawaranModel::create([
            'id_job'=>$request->id_job,
            'id_client'=>$request->id_client,
            'id_free'=>$request->id_free,
            'des_tawaran'=>$request->des_tawaran,          
            'status'=>$request->status,

        ]);

        $nawar = PenawaranModel::select('tb_penawaran.*',
            'freelancer.username as free_name',
            'client.username as client_name',
            'job.judul as judul_job')
   
           ->join('users as freelancer', 'tb_penawaran.id_free', '=', 'freelancer.id_user')
           ->join('users as client', 'tb_penawaran.id_client', '=', 'client.id_user')
           ->join('tb_job as job', 'tb_penawaran.id_job', '=', 'job.id_job') 
           ->where('id_penawaran', $penawaran->id_penawaran)->first();

           $notif = NotifModel::create([
            'id_user' => $request->id_client,
            'judul_notif' => "Seseorang menawarkan diri!!",
            'bagian' => 1,
            'status'=>0,
            'des_notif' => "Penawaran {$nawar->free_name} untuk job {$nawar->judul_job}"
            ]);

        if($penawaran){
            return response()->json([
                
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$penawaran
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        }   
    }

    public function batalNawar(Request $request){

        $id_penawaran = $request->query('id_penawaran');

        $nawar = PenawaranModel::where('id_penawaran', $id_penawaran)->delete(); 
        
        if($nawar){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        } 

        

    }

    function inputKonpay(Request $request){
        $tanggal = Carbon::now()->format('dmy'); // 310524
        $random = strtoupper(Str::random(6)); // contoh: ZXKP

        $kode= "KON{$tanggal}{$random}";

        $kontrak = KontrakModel::create([
            'id_kontrak'=>$request->id_kontrak,
            'id_job'=>$request->id_job,
            'id_client'=>$request->id_client,
            'id_free'=>$request->id_free,         
            'status'=>$request->status,
            'delivarable'=>$request->delivarable,
            'kd_kontrak'=>$kode

        ]);

        $admins = User::where('role', 'admin')->where('status', '!=', 3)->get();

        $admin = $admins->sortBy(function ($admin) {
            return PayModel::where('id_admin', $admin->id_user)->count();
        })->first();


        $pay= PayModel::create([
            'judul'=>$request->id_job,
            'id_client'=>$request->id_client,
            'id_free'=>$request->id_free,
            'id_admin'=>$admin->id_user,
            'id_kontrak'=>$kontrak->id_kontrak,
            'poto'=>$request->poto,
            'poto'=>$request->poto,
            'nm_rek'=>$request->nm_rek,
            'no_rek'=>$request->no_rek,
            'status'=>$request->status_pay

        ]);

        $penawaran= PenawaranModel::where('id_penawaran',$request->id_penawaran)->update([
            'status'=>8
        ]);

        

        $kontrakend = KontrakModel::select('tb_kontrak.*',
        'freelancer.username as free_name',
        'client.username as client_name',
        'sta.status as status_name',
        'jobs.judul as judul_job',
        'pay.poto_client as poto_client',
        'pay.id_pay as id_pay',
        'pay.status as status_pay',
        'profFree.foto_profile as pp_free',
        'profFree.no_wa as wa_free',
        'profClient.foto_profile as pp_client',
        'profClient.no_wa as wa_client',
        'admin.email as admin_email',
        'profAdmin.no_wa as wa_admin',

        )

       ->join('users as freelancer', 'tb_kontrak.id_free', '=', 'freelancer.id_user')
       ->join('users as client', 'tb_kontrak.id_client', '=', 'client.id_user')
       ->join('tb_status as sta', 'tb_kontrak.status', '=', 'sta.id_status') 
       ->join('tb_job as jobs', 'tb_kontrak.id_job', '=', 'jobs.id_job')
       ->join('tb_pay as pay', 'tb_kontrak.id_kontrak', '=', 'pay.id_kontrak')
       ->leftjoin('users as admin', 'pay.id_admin', '=', 'admin.id_user')
       ->join('tb_profile as profFree', 'tb_kontrak.id_free', '=', 'profFree.id_user')
       ->join('tb_profile as profClient', 'tb_kontrak.id_client', '=', 'profClient.id_user')
       ->leftjoin('tb_profile as profAdmin', 'admin.id_user', '=', 'profAdmin.id_user')
        ->where('tb_kontrak.id_kontrak', $kontrak->id_kontrak)
        ->first(); 

        $notif = NotifModel::create([
            'id_user' => $kontrakend->id_client,
            'judul_notif' => "Anda telah menerima Penawaran",
            'bagian' => 1,
            'status'=>0,
            'des_notif' => "Diterima Penawaran {$kontrakend->free_name} untuk job {$kontrakend->judul_job}"
        ]);

        $notif = NotifModel::create([
            'id_user' => $kontrakend->id_free,
            'judul_notif' => "Penawaranmu Diterima Loh!!!",
            'bagian' => 1,
            'status'=>0,
            'des_notif' => "{$kontrakend->client_name} Menerima penawaranmu untuk job {$kontrakend->judul_job}"
        ]);


        if($kontrakend){
            return response()->json([
                
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content' =>[$kontrakend]
             
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        }   
    }

    function tolakPenawaran(Request $request){

        $nawar = PenawaranModel::select('tb_penawaran.*',
         'freelancer.username as free_name',
         'client.username as client_name',
         'job.judul as judul_job')

        ->join('users as freelancer', 'tb_penawaran.id_free', '=', 'freelancer.id_user')
        ->join('users as client', 'tb_penawaran.id_client', '=', 'client.id_user')
        ->join('tb_job as job', 'tb_penawaran.id_job', '=', 'job.id_job')
        ->where('tb_penawaran.id_penawaran', $request->id_penawaran)->first() ;

        $notif = NotifModel::create([
            'id_user' => $nawar->id_client,
            'judul_notif' => "Anda telah menolak Penawaran",
            'bagian' => 1,
            'status'=>0,
            'des_notif' => "Ditolak Penawaran {$nawar->free_name} untuk job {$nawar->judul_job}"
        ]);

        $notif = NotifModel::create([
            'id_user' => $nawar->id_free,
            'judul_notif' => "Penawaranmu Ditolak Loh!!!",
            'bagian' => 1,
            'status'=>0,
            'des_notif' => "{$nawar->client_name} Menolak penawaranmu untuk job {$nawar->judul_job}"
        ]);

        $penawaran= PenawaranModel::where('id_penawaran',$request->id_penawaran)->update([
            'status'=>9
        ]);

        if($penawaran){
            return response()->json([
                
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
            
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        }  

    }

    function jobKontrak(Request $request){
        $id_job = $request->query('id_job');

        $kontrak = KontrakModel::select('tb_kontrak.*',
         'freelancer.username as free_name',
         'client.username as client_name',
         'sta.status as status_name',
         'jobs.judul as judul_job',
         'pay.poto_client as poto_client',
         'pay.poto as poto_admin',
         'pay.id_pay as id_pay',
         'pay.status as status_pay',
         'profFree.foto_profile as pp_free',
         'profFree.no_wa as wa_free',
         'profClient.foto_profile as pp_client',
         'profClient.no_wa as wa_client',
         'admin.email as admin_email',
         'profAdmin.no_wa as wa_admin')

        ->join('users as freelancer', 'tb_kontrak.id_free', '=', 'freelancer.id_user')
        ->join('users as client', 'tb_kontrak.id_client', '=', 'client.id_user')
        ->join('tb_status as sta', 'tb_kontrak.status', '=', 'sta.id_status') 
        ->join('tb_job as jobs', 'tb_kontrak.id_job', '=', 'jobs.id_job')
        ->join('tb_pay as pay', 'tb_kontrak.id_kontrak', '=', 'pay.id_kontrak')
        ->leftjoin('users as admin', 'pay.id_admin', '=', 'admin.id_user')
        ->join('tb_profile as profFree', 'tb_kontrak.id_free', '=', 'profFree.id_user')
        ->join('tb_profile as profClient', 'tb_kontrak.id_client', '=', 'profClient.id_user')
        ->leftjoin('tb_profile as profAdmin', 'admin.id_user', '=', 'profAdmin.id_user')

        ->where('tb_kontrak.id_job', $id_job)
        ->where('tb_kontrak.status','!=', 8)

        ->get();

        

        if($kontrak){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$kontrak
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        }  


    }

    function tampilKontrak(Request $request){
        $id_user = $request->query('id_user');
        $role_user = $request->query('role_user');
        $source = $request->query('source');

        $kontrak = KontrakModel::select('tb_kontrak.*',
         'freelancer.username as free_name',
         'client.username as client_name',
         'sta.status as status_name',
         'jobs.judul as judul_job',
         'pay.poto_client as poto_client',
         'pay.poto as poto_admin',
         'pay.id_pay as id_pay',
         'pay.status as status_pay',
         'profFree.foto_profile as pp_free',
         'profFree.no_wa as wa_free',
         'profClient.foto_profile as pp_client',
         'profClient.no_wa as wa_client',
         'admin.email as admin_email',
         'profAdmin.no_wa as wa_admin')

        ->join('users as freelancer', 'tb_kontrak.id_free', '=', 'freelancer.id_user')
        ->join('users as client', 'tb_kontrak.id_client', '=', 'client.id_user')
        ->join('tb_status as sta', 'tb_kontrak.status', '=', 'sta.id_status') 
        ->join('tb_job as jobs', 'tb_kontrak.id_job', '=', 'jobs.id_job')
        ->join('tb_pay as pay', 'tb_kontrak.id_kontrak', '=', 'pay.id_kontrak')
        ->leftjoin('users as admin', 'pay.id_admin', '=', 'admin.id_user')
        ->join('tb_profile as profFree', 'tb_kontrak.id_free', '=', 'profFree.id_user')
        ->join('tb_profile as profClient', 'tb_kontrak.id_client', '=', 'profClient.id_user')
        ->leftjoin('tb_profile as profAdmin', 'admin.id_user', '=', 'profAdmin.id_user');

        if ($source == "history") {
            if ($role_user == "freelancer") {
                $kontrak->where('tb_kontrak.id_free', $id_user)->whereIn('tb_kontrak.status', [8,11]);
            }
            else {
                $kontrak->where('tb_kontrak.id_client', $id_user)->whereIn('tb_kontrak.status', [8,10]);
            }
        }
        else {
            if ($role_user == "freelancer") {
                $kontrak->where('tb_kontrak.id_free', $id_user)->where('tb_kontrak.status', '!=', 8);
            }
            else {
                $kontrak->where('tb_kontrak.id_client', $id_user)->where('tb_kontrak.status', '!=', 8);
            }
        }

        $result = $kontrak->get();

         
        if($result){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$result
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        } 

    }

    function refresKontrak(Request $request){
        $id_kontrak = $request->query('id_kontrak');

        $kontrak = KontrakModel::select('tb_kontrak.*',
         'freelancer.username as free_name',
         'client.username as client_name',
         'sta.status as status_name',
         'jobs.judul as judul_job',
         'pay.poto_client as poto_client',
         'pay.poto as poto_admin',
         'pay.id_pay as id_pay',
         'pay.status as status_pay',
         'profFree.foto_profile as pp_free',
         'profFree.no_wa as wa_free',
         'profClient.foto_profile as pp_client',
         'profClient.no_wa as wa_client',
         'admin.email as admin_email',
         'profAdmin.no_wa as wa_admin')

        ->join('users as freelancer', 'tb_kontrak.id_free', '=', 'freelancer.id_user')
        ->join('users as client', 'tb_kontrak.id_client', '=', 'client.id_user')
        ->join('tb_status as sta', 'tb_kontrak.status', '=', 'sta.id_status') 
        ->join('tb_job as jobs', 'tb_kontrak.id_job', '=', 'jobs.id_job')
        ->join('tb_pay as pay', 'tb_kontrak.id_kontrak', '=', 'pay.id_kontrak')
        ->leftjoin('users as admin', 'pay.id_admin', '=', 'admin.id_user')
        ->join('tb_profile as profFree', 'tb_kontrak.id_free', '=', 'profFree.id_user')
        ->join('tb_profile as profClient', 'tb_kontrak.id_client', '=', 'profClient.id_user')
        ->leftjoin('tb_profile as profAdmin', 'admin.id_user', '=', 'profAdmin.id_user')
        ->where('tb_kontrak.id_kontrak', $id_kontrak)->first();

        if($kontrak){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>[$kontrak]
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        } 
    }

    function akhiriKonpay(Request $request){
        $kontrak= KontrakModel::where('id_kontrak',$request->id_kontrak)->update(['status' =>8]);
        $pay= PayModel::where('id_kontrak',$request->id_kontrak)->update(['status' =>8]);

        $kontrak = KontrakModel::select('tb_kontrak.*',
        'freelancer.username as free_name',
        'client.username as client_name',
        'freelancer.id_user as id_free',
        'client.id_user as id_client',
        'jobs.judul as judul_job')

       ->join('users as freelancer', 'tb_kontrak.id_free', '=', 'freelancer.id_user')
       ->join('users as client', 'tb_kontrak.id_client', '=', 'client.id_user')
       ->join('tb_job as jobs', 'tb_kontrak.id_job', '=', 'jobs.id_job')
        ->where('tb_kontrak.id_kontrak', $request->id_kontrak)
        ->first(); 

        $notif = NotifModel::create([
            'id_user' => $kontrak->id_client,
            'judul_notif' => "Kontrak telah diakhiri!",
            'bagian' => 2,
            'status'=>0,
            'des_notif' => "Kontrak : Job: {$kontrak->free_name}, client : {$kontrak->judul_job}"
        ]);

        $notif = NotifModel::create([
            'id_user' => $kontrak->id_free,
            'judul_notif' => "Kontrak telah diakhiri!",
            'bagian' => 2,
            'status'=>0,
            'des_notif' => "Kontrak : Job: {$kontrak->client_name}, freelancer : {$kontrak->judul_job}"
        ]);

        if($kontrak && $pay){
            return response()->json([
                
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        }   
    }

    function detKontrak(Request $request){
        $id_kontrak = $request->query('id_kontrak');
    
        $kontrak = KontrakModel::select(
            'tb_kontrak.*',
            'freelancer.username as free_name',
            'sta.status as status_name',
            'jobs.judul as judul_job',
            'pay.poto_client as poto_client',
            'pay.id_pay as id_pay',
            

        )
        ->join('users as freelancer', 'tb_kontrak.id_free', '=', 'freelancer.id_user')
        ->join('tb_status as sta', 'tb_kontrak.status', '=', 'sta.id_status') 
        ->join('tb_job as jobs', 'tb_kontrak.id_job', '=', 'jobs.id_job')
        ->join('tb_pay as pay', 'tb_kontrak.id_kontrak', '=', 'pay.id_kontrak')
        ->where('tb_kontrak.id_kontrak', $id_kontrak)
        ->first(); 
    
    
        if ($kontrak ) {
            return response()->json([
                'response_code' => 200,
                'message' => 'Suksess Boi!!!',
                'content' => $kontrak
            ]);
        } else {
            return response()->json([
                'response_code' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    function potoClient(Request $request){
        $request->validate([
            'poto' => 'nullable|file|image|max:10240', 
        ]);

        $kontrak = kontrakModel::where('id_kontrak', $request->id_kontrak)->first();
    
        $pay = PayModel::where('id_pay', $request->id_pay)->first();
        if (!$pay) {
            return response()->json([
                'response_code' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        $status = $pay->status;

    
        $file_name_client = $pay->poto_client; 
    
        if ($request->hasFile('poto')) {
            $file = $request->file('poto');
            $file_name_client = date('Y-m-d-H-i-s') . '-' . $file->getClientOriginalName();
            
            if (!empty($pay->poto_client) && file_exists(public_path('imageup/' . $pay->poto_client))) {
                unlink(public_path('imageup/' . $pay->poto_client));
            }
    
            $file->move(public_path('imageup'), $file_name_client);

            if (!empty($kontrak->delivarable)) {
                $status = 1;
            }
        }

        
    
        $pay->update([
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
        
    
        if ($pay ) {
            return response()->json([
                'response_code' => 200,
                'message' => 'Suksess Boi!!!',
                'content' => $pay
            ]);
        } else {
            return response()->json([
                'response_code' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    function fileKontrak(Request $request){

        $id_kontrak = $request->query('id_kontrak');

        $file = FilekontrakModel::where('id_kontrak', $id_kontrak)->get();

        if ($file) {
            return response()->json([
                'response_code' => 200,
                'message' => 'Suksess Boi!!!',
                'content' => $file
            ]);
        } elseif($file) {
            return response()->json([
                'response_code' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }

    }

    function hapusFileKontrak(Request $request){

        $id_file = $request->query('id_file');

        $file = FilekontrakModel::where('id_file', $id_file)->first();

        $existingfile = $file->file;

        $destinationPath = public_path('imageup');

        unlink($destinationPath . '/' . $existingfile);

        $file->delete();

        if ($file ) {
            return response()->json([
                'response_code' => 200,
                'message' => 'Suksess Boi!!!',
            ]);
        } else {
            return response()->json([
                'response_code' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }

    }

    function inputFileKontrak(Request $request) {

        $id_kontrak = $request->id_kontrak;

        if ($request->hasFile('file')) {
            $file = $request->file('file'); 
            $tujuan_upload = public_path('imageup');
    
            $file_name =date('Y-m-d-H-i-s') . '-' .$file->getClientOriginalName(); 
            $file->move($tujuan_upload, $file_name); 
    
            
        }
        $file = FilekontrakModel::create([
                        'id_kontrak' => $id_kontrak,
                        'file' => $file_name
                    ]);

        if ($file ) {
            return response()->json([
                'response_code' => 200,
                'message' => 'Suksess Boi!!!',
                'content' => [$file]
            ]);
        } else {
            return response()->json([
                'response_code' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    
    }

    function deadLine(Request $request){


        $deadline = KontrakModel::where('id_kontrak', $request->id_kontrak)->update([
            'deadline'=>$request->deadline
        ]);

        if ($deadline ) {
            return response()->json([
                'response_code' => 200,
                'message' => 'Suksess Boi!!!',
                'content' => $deadline
            ]);
        } else {
            return response()->json([
                'response_code' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    function downloadDeliv(Request $request) {
        $id_kontrak = $request->query('id_kontrak');
    
        $kontrak = KontrakModel::where('id_kontrak', $id_kontrak)->first();

        // Periksa apakah data kontrak ada
        if (!$kontrak) {
            return response()->json([
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        // Dapatkan nama file dan lokasi folder
        $filename = $kontrak->delivarable;
        $filePath = public_path('imageup/' . $filename); // Lokasi file

        // Periksa apakah file benar-benar ada di server
        if (file_exists($filePath)) {
            // Kembalikan file untuk diunduh
            return response()->download($filePath);
        } else {
            return response()->json([
                'message' => 'File tidak ditemukan di server!'
            ], 404);
        }
    } 

    function inputDeliv(Request $request){
        $id_kontrak = $request->id_kontrak;

        $request->validate([
            'deliv' => 'nullable|file|max:204800', // 200MB = 204800KB
        ]);

        $kontrak = KontrakModel::select('tb_kontrak.*',
         'freelancer.username as free_name',
         'jobs.judul as judul_job')

        ->join('users as freelancer', 'tb_kontrak.id_free', '=', 'freelancer.id_user')
        ->join('tb_job as jobs', 'tb_kontrak.id_job', '=', 'jobs.id_job')
        
        ->where('id_kontrak',$id_kontrak )
        ->first();

        if (!$kontrak) {
            return response()->json([
                'response_code' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        $notif = NotifModel::create([
            'id_user' => $kontrak->id_client,
            'judul_notif' => "Delivarable udah ada loh!!",
            'bagian' => 2,
            'status'=>0,
            'des_notif' => "{$kontrak->free_name} telah mengirim delivarable utk job {$kontrak->judul_job}"
        ]);

        $existingDelivarable = $kontrak->delivarable;
        $file_name = $existingDelivarable;

        if ($request->hasFile('deliv')) {
            $file = $request->file('deliv');

            $file_name = date('Y-m-d-H-i-s') . '-' . $file->getClientOriginalName();

            $destinationPath = public_path('imageup');

            if ($existingDelivarable && file_exists($destinationPath . '/' . $existingDelivarable)) {
                unlink($destinationPath . '/' . $existingDelivarable);
            }

            $file->move($destinationPath, $file_name);
        }

        $deliv = KontrakModel::where('id_kontrak', $id_kontrak)->update([
                'id_kontrak' => $id_kontrak,
                'delivarable' => $file_name
            ]);


        $pay = PayModel::where('id_kontrak',$id_kontrak)->first();

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

        

        if ($deliv) {
            return response()->json([
                'response_code' => 200,
                'message' => 'Suksess Boi!!!',
            ]);
        } else {
            return response()->json([
                'response_code' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }

    }

    function downloadFile(Request $request) {
        $id_file = $request->query('id_file');
    
        $file = FilekontrakModel::where('id_file', $id_file)->first();

        // Periksa apakah data kontrak ada
        if (!$file) {
            return response()->json([
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        // Dapatkan nama file dan lokasi folder
        $filename = $file->file;
        $filePath = public_path('imageup/' . $filename); // Lokasi file

        // Periksa apakah file benar-benar ada di server
        if (file_exists($filePath)) {
            // Kembalikan file untuk diunduh
            return response()->download($filePath);
        } else {
            return response()->json([
                'message' => 'File tidak ditemukan di server!'
            ], 404);
        }
    } 

    function ulasan (Request $request){

        $ulasan = UlasanModel::create([
            'id_penulis'=>$request->id_penulis,
            'id_user'=>$request->id_user,
            'ulasan'=>$request->ulasan,
            'rating'=>$request->rating
        ]);

        if ($ulasan) {
            return response()->json([
                'response_code' => 200,
                'message' => 'Suksess Boi!!!',
            ]);
        } else {
            return response()->json([
                'response_code' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    function ulasanTampil (Request $request){
        $id_user = $request->query('id_user');

        $ulasan= UlasanModel::select('tb_ulasan.*',
        'prof.nm_depan as nm_depan',
        'prof.nm_belakang as nm_belakang',
        'prof.foto_profile as pp')

        ->join('tb_profile as prof', 'tb_ulasan.id_penulis', '=', 'prof.id_user')

        ->where('tb_ulasan.id_user', $id_user)
        ->get();



        if ($ulasan) {
            return response()->json([
                'response_code' => 200,
                'message' => 'Suksess Boi!!!',
                'content' => $ulasan
            ]);
        } else {
            return response()->json([
                'response_code' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    function tampilProfile(Request $request){
        $id_user = $request->query('id_user');

        $profile= ProfileModel::select('tb_profile.*',
        'user.email as email_user',
        'user.role as role_user',
        'bid.bidang as bidang_name')

        ->join('users as user', 'tb_profile.id_user', '=', 'user.id_user')
        ->join('tb_bidang as bid', 'tb_profile.bidang', '=', 'bid.id_bidang')
        

        ->where('tb_profile.id_user', $id_user)
        ->first();

        $avgRating = UlasanModel::where('id_user', $id_user)->avg('rating');

        $profile->avg_rating = $avgRating;


        if ($profile) {
            return response()->json([
                'response_code' => 200,
                'message' => 'Suksess Boi!!!',
                'content'=>$profile
            ]);
        } else {
            return response()->json([
                'response_code' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    function inputProfile (Request $request){

        $file = $request->file('foto_profile');

        $tujuan_upload = 'imageup';

        $file_name = date('Y-m-d H:i:s').'-'.$file->getClientOriginalName();

        $file->move($tujuan_upload,$file_name);
         
        $profile = ProfileModel::create([
            'id_user' =>$request->id_user,
            'nm_depan' =>$request->nm_depan,
            'nm_belakang'=>$request->nm_belakang,
            'des_singkat'=>$request->des_singkat,
            'jns_kelamin'=>$request->jns_kelamin,
            'alamat'=>$request->alamat,
            'tgl_lahir'=>$request->tgl_lahir,
            'bidang'=>$request->bidang,
            'bio'=>$request->bio,
            'no_wa'=>$request->no_wa,
            'foto_profile'=>$file_name,
            'nm_rek'=>$request->nm_rek,
            'no_rek'=>$request->no_rek

        ]);

        $user = User::where('id_user', $request->id_user)->update(['status'=>1]);

        if ($profile) {
            return response()->json([
                'response_code' => 200,
                'message' => 'Suksess Boi!!!',
            ]);
        } else {
            return response()->json([
                'response_code' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    function editProfile(Request $request) {

        $pro = ProfileModel::where('id_profile', $request->id_profile)->first();

    
        if ($request->hasFile('foto_profile')) {
            $file = $request->file('foto_profile');
            $tujuan_upload = public_path('imageup'); 
            $file_name = date('Y-m-d_H-i-s') . '-' . $file->getClientOriginalName();

            if ($pro->foto_profile && file_exists($tujuan_upload . '/' . $pro->foto_profile)) {
                unlink($tujuan_upload . '/' . $pro->foto_profile);
            }

            $file->move($tujuan_upload, $file_name);
        } else {
            $file_name = $pro->foto_profile;
        }
    
        $profile = ProfileModel::where('id_profile', $request->id_profile)->update([
            'id_user' => $request->id_user,
            'nm_depan' => $request->nm_depan,
            'nm_belakang' => $request->nm_belakang,
            'des_singkat' => $request->des_singkat,
            'jns_kelamin' => $request->jns_kelamin,
            'alamat' => $request->alamat,
            'tgl_lahir' => $request->tgl_lahir,
            'bidang' => $request->bidang,
            'bio' => $request->bio,
            'no_wa'=>$request->no_wa,
            'foto_profile' => $file_name,
            'nm_rek' => $request->nm_rek,
            'no_rek' => $request->no_rek
        ]);

        $isiprofile = ProfileModel::where('id_profile', $request->id_profile)->first();


        if ($isiprofile) {
            return response()->json([
                'response_code' => 200,
                'message' => 'Suksess Boi!!!',
                'content'=>$isiprofile
            ]);
        } else {
            return response()->json([
                'response_code' => 404,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    
        
    }

    function dataHomeclient(Request $request){
        $id_user = $request->query('id_user');

        $profile = ProfileModel::where('id_user', $id_user)->first();

        $job = JobModel::where('id_client', $id_user)->whereNotIn('status', [8, 10])->count();
        $kontrak = kontrakModel::where('id_client', $id_user)->where('status', 2)->count();
        $penawaran = PenawaranModel::where('id_client', $id_user)->where('status', 3)->count(); // <<< ganti whereIn ke where

        $data = [
            'ft_profile' => $profile?->foto_profile, 
            'jumlah_job' => $job,
            'jumlah_kontrak' => $kontrak,
            'jumlah_penawaran' => $penawaran
        ];

        if($data){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$data
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        }  

    }

    function dataHomefree(Request $request){
        $id_user = $request->query('id_user');

        $profile = ProfileModel::where('id_user', $id_user)->first();
        $average_rating = UlasanModel::where('id_user', $id_user)->avg('rating');

        $kontrak = kontrakModel::where('id_free', $id_user)->where('status', 2)->count();
        $penawaran = PenawaranModel::where('id_free', $id_user)->where('status', 3)->count(); // <<< ganti whereIn ke where

        $data = [
            'ft_profile' => $profile?->foto_profile,
            'jumlah_penawaran' => $penawaran,
            'jumlah_kontrak' => $kontrak,
            'rata_rating' => $average_rating
        ];

        if($data){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$data
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        }  

    }

    function newsTampil(){

        $news = NewsModel::select('*')->get();

        if($news){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$news
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        } 
    }

    public function hapusNawarhis(Request $request){

        $id_penawaran = $request->query('id_penawaran');
        $role_user = $request->query('role_user');

        $nawar = PenawaranModel::where('id_penawaran', $id_penawaran)->first();

        if ($role_user == 'freelancer') {
            if($nawar->status == 8){
                $nawar = PenawaranModel::where('id_penawaran', $id_penawaran)->update(['status'=>10]);
            }
            elseif($nawar->status == 9){
                $nawar = PenawaranModel::where('id_penawaran', $id_penawaran)->update(['status'=>11]);
            }
            else{
                $nawar = PenawaranModel::where('id_penawaran', $id_penawaran)->delete();
            }
        }
        elseif ($role_user == 'client') {
            if($nawar->status == 8){
                $nawar = PenawaranModel::where('id_penawaran', $id_penawaran)->update(['status'=>12]);
            }
            elseif($nawar->status == 9){
                $nawar = PenawaranModel::where('id_penawaran', $id_penawaran)->update(['status'=>13]);
            }
            else{
                $nawar = PenawaranModel::where('id_penawaran', $id_penawaran)->delete();
            }
        }

        if($nawar){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        } 

        

    }

    public function hapusKontrakhis(Request $request){
        $id_kontrak = $request->query('id_kontrak');
        $role_user = $request->query('role_user');

        $kontrak = KontrakModel::where('id_kontrak', $id_kontrak)->first();

        if ($role_user == 'freelancer') {
            if($kontrak->status == 8){
                $kontrak = KontrakModel::where('id_kontrak', $id_kontrak)->update(['status'=>10]);
                $pay = PayModel::where('id_kontrak', $id_kontrak)->update(['status'=>10]);
            }
            else{
                $kontrak = KontrakModel::where('id_kontrak', $id_kontrak)->delete();
                $pay = PayModel::where('id_kontrak', $id_kontrak)->delete();
            }
        }
        else {
            if($kontrak->status == 8){
                $kontrak = KontrakModel::where('id_kontrak', $id_kontrak)->update(['status'=>11]);
                $pay = PayModel::where('id_kontrak', $id_kontrak)->update(['status'=>11]);
            }
            else{
                $kontrak = KontrakModel::where('id_kontrak', $id_kontrak)->delete();
                $pay = PayModel::where('id_kontrak', $iid_kontrakd)->delete();
            }
        }        
        
        if($kontrak){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        } 

        

    }

    public function hapusJobhis(Request $request){
        $id_job = $request->query('id_job');

        $job = JobModel::where('id_job', $id_job)->update(['status'=>10]);

        if($job){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        } 

    }

    public function searchJob(Request $request){
        $search = $request->query('search');

        $job = JobModel::select('tb_job.*',
         'client.username as client_name',
         'profile.foto_profile as pp_client',
         'bid.bidang as bidang_name',
         'sta.status as status_name')

        ->join('users as client', 'tb_job.id_client', '=', 'client.id_user')
        ->join('tb_profile as profile', 'tb_job.id_client', '=', 'profile.id_user')
        ->join('tb_bidang as bid', 'tb_job.bidang', '=', 'bid.id_bidang') 
        ->join('tb_status as sta', 'tb_job.status', '=', 'sta.id_status') 

        ->whereRaw('LOWER(TRIM(judul)) LIKE ?', [strtolower(trim($search)) . '%'])
        ->where('tb_job.status','!=', 8)

        ->orderBy('tb_job.judul')
        ->get();

    
        if($job){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$job
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        } 


    }

    public function searchJobclient(Request $request){
        $search = $request->query('search');
        $id_user = $request->query('id_user');
        $source = $request->query('source');

        $job = JobModel::select('tb_job.*',
         'client.username as client_name',
         'profile.foto_profile as pp_client',
         'bid.bidang as bidang_name',
         'sta.status as status_name')

        ->join('users as client', 'tb_job.id_client', '=', 'client.id_user')
        ->join('tb_profile as profile', 'tb_job.id_client', '=', 'profile.id_user')
        ->join('tb_bidang as bid', 'tb_job.bidang', '=', 'bid.id_bidang') 
        ->join('tb_status as sta', 'tb_job.status', '=', 'sta.id_status') 

        ->whereRaw('LOWER(TRIM(judul)) LIKE ?', [strtolower(trim($search)) . '%'])

        ->where('tb_job.id_client', $id_user);

        if ($source == "history") {
            $job->where('tb_job.status', 8);
        }
        else {
            $job->where('tb_job.status', '!=', 8);
        }

        $result = $job->get();

        if($result){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$result
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        } 


    }

    public function searchPenawaran(Request $request){
        $search = $request->query('search');
        $id_user = $request->query('id_user');
        $role_user = $request->query('role_user');
        $source = $request->query('source');

        $penawaran = PenawaranModel::select('tb_penawaran.*',
         'freelancer.username as free_name',
         'sta.status as status_name',
         'prof.nm_rek as nm_rek_free',
         'prof.foto_profile as pp_free',
         'prof.no_rek as no_rek_free',
         'job.judul as judul_job')

        ->join('users as freelancer', 'tb_penawaran.id_free', '=', 'freelancer.id_user')
        ->join('tb_status as sta', 'tb_penawaran.status', '=', 'sta.id_status') 
        ->join('tb_profile as prof', 'tb_penawaran.id_free', '=', 'prof.id_user') 
        ->join('tb_job as job', 'tb_penawaran.id_job', '=', 'job.id_job') 


        ->where(function ($query) use ($search) {
            $query->WhereRaw('LOWER(TRIM(job.judul)) LIKE ?', [strtolower(trim($search)) . '%'])
                  ->orWhereRaw('LOWER(TRIM(freelancer.username)) LIKE ?', [strtolower(trim($search)) . '%']);
        });

        if ($source == "history") {
            if ($role_user == "freelancer") {
                
                $penawaran->where('tb_penawaran.id_free', $id_user)->whereIn('tb_penawaran.status', [8,9,12,13]);
            }
            else {
                $penawaran->where('tb_penawaran.id_client', $id_user)->whereIn('tb_penawaran.status', [8, 9, 10, 11]);
            }
        }
        else {
            if ($role_user == "freelancer") {
                
                $penawaran->where('tb_penawaran.id_free', $id_user)->where('tb_penawaran.status', '=', 3);
            }
            else {
                $penawaran->where('tb_penawaran.id_client', $id_user)->where('tb_penawaran.status', '=', 3);
            }
        }

        $result = $penawaran->get();

        if($result){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$result
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        } 
    }

    public function searchKontrak(Request $request){
        $search = $request->query('search');
        $id_user = $request->query('id_user');
        $source = $request->query('source');
        $role_user = $request->query('role_user');

        $kontrak = KontrakModel::select('tb_kontrak.*',
         'freelancer.username as free_name',
         'client.username as client_name',
         'sta.status as status_name',
         'jobs.judul as judul_job',
         'pay.poto_client as poto_client',
         'pay.poto as poto_admin',
         'pay.id_pay as id_pay',
         'pay.status as status_pay',
         'profFree.foto_profile as pp_free',
         'profFree.no_wa as wa_free',
         'profClient.foto_profile as pp_client',
         'profClient.no_wa as wa_client',
         'admin.email as admin_email',
         'profAdmin.no_wa as wa_admin')

        ->join('users as freelancer', 'tb_kontrak.id_free', '=', 'freelancer.id_user')
        ->join('users as client', 'tb_kontrak.id_client', '=', 'client.id_user')
        ->join('tb_status as sta', 'tb_kontrak.status', '=', 'sta.id_status') 
        ->join('tb_job as jobs', 'tb_kontrak.id_job', '=', 'jobs.id_job')
        ->join('tb_pay as pay', 'tb_kontrak.id_kontrak', '=', 'pay.id_kontrak')
        ->leftjoin('users as admin', 'pay.id_admin', '=', 'admin.id_user')
        ->join('tb_profile as profFree', 'tb_kontrak.id_free', '=', 'profFree.id_user')
        ->join('tb_profile as profClient', 'tb_kontrak.id_client', '=', 'profClient.id_user')
        ->leftjoin('tb_profile as profAdmin', 'admin.id_user', '=', 'profAdmin.id_user')

        ->where(function ($query) use ($search) {
            $query->whereRaw('LOWER(TRIM(jobs.judul)) LIKE ?', [strtolower(trim($search)) . '%'])
                  ->orWhereRaw('LOWER(TRIM(freelancer.username)) LIKE ?', [strtolower(trim($search)) . '%']);
        });

        if ($source == "history") {
            if ($role_user == "freelancer") {
                $kontrak->where('tb_kontrak.id_free', $id_user)->whereIn('tb_kontrak.status', [8,11]);
            }
            else {
                $kontrak->where('tb_kontrak.id_client', $id_user)->whereIn('tb_kontrak.status', [8,10]);
            }
        }
        else {
            if ($role_user == "freelancer") {
                $kontrak->where('tb_kontrak.id_free', $id_user)->where('tb_kontrak.status', '!=', 8);
            }
            else {
                $kontrak->where('tb_kontrak.id_client', $id_user)->where('tb_kontrak.status', '!=', 8);
            }
        }

        $result = $kontrak->get();

        if($result){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$result
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        } 
    }

    public function tampilNotif(Request $request){
        $id_user = $request->query('id_user');
       

        $notif = NotifModel::where('id_user',$id_user)->get();

        if($notif){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!',
                'content'=>$notif
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        } 
    }

    public function readNotif(Request $request)
    {
        $id_notif = $request->query('id_notif');
        $notif = NotifModel::where('id_notif',$id_notif)->first();
        if ($notif) {
            $notif->status = 1;
            $notif->save();
        }

        if($notif){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!'
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        } 
    }

    public function hapusNotif(Request $request)
    {
        $id_notif = $request->query('id_notif');

        $notif = NotifModel::where('id_notif', $id_notif)->delete();
        
        if($notif){
            return response()->json([
                'response_code'=> 200,
                'message'=>'Suksess Boi!!!'
            ]);
        }
        else{
            return response()->json([
                'response_code'=>200,
                'message'=>'Internal Error'
            ]);
        } 
    }

}
