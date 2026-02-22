<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobModel;
use App\Models\PayModel;
use App\Models\User;
use App\Models\BidangModel;
use App\Models\StatusModel;
use App\Models\FreeModel;
use App\Models\PenawaranModel;
use App\Models\KontrakModel;
use App\Models\ChatModel;
use App\Models\PesanModel;


use Auth;

class JobclientCt extends Controller
{
    public function jobClient(){

        $user = auth()->user();
        $id_user = $user->id_user;

        $job = JobModel::select('tb_job.*',
         'client.username as client_name',
         'bid.bidang as bidang_name',
         'sta.status as status_name')

        ->join('users as client', 'tb_job.id_client', '=', 'client.id_user')
        ->join('tb_bidang as bid', 'tb_job.bidang', '=', 'bid.id_bidang') 
        ->join('tb_status as sta', 'tb_job.status', '=', 'sta.id_status') 
        ->where('tb_job.id_client', $id_user)
        ->where('tb_job.status','!=', 8)


        ->get();

        $kontrak = KontrakModel::where('status', '!=', 8)->pluck('id_job')->toArray();

        return view('tampiljobclient', compact('job', 'kontrak'));
    }

    public function addJob(){
        $job = JobModel::select('*')->get();
        $bidang = BidangModel::select('*')->get();
        

        return view('addjob', compact('job', 'bidang'));


    }

    public function editJob($id){
        $job = JobModel::where('id_job', $id)->first();
        $bidang = BidangModel::select('*')->get();

        return view('editjobclient', compact('job', 'bidang'));


    }

    public function editjobAction(Request $request){
        $job = JobModel::where('id_job', $request->id_job)->update([
            'id_client'=>$request->id_client,
            'judul'=>$request->judul,
            'deskripsi'=>$request->deskripsi,
            'tgl_mulai'=>$request->tgl_mulai,
            'tgl_akhir'=>$request->tgl_akhir,
            'status'=>$request->status,
            'bidang'=>$request->bidang,
            'harga'=>$request->harga
        ]);

        return redirect('client/job');
    }

    public function hapusJob($id){
        $job= JobModel::where('id_job', $id)->update([
            'status' =>8
        ]);
        
        return redirect()->back();
    }

    public function inputJob(Request $request){
        $job = JobModel::create([
            'id_job'=>$request->id_job,
            'id_client'=>$request->id_client,
            'judul'=>$request->judul,
            'deskripsi'=>$request->deskripsi,
            'tgl_mulai'=>$request->tgl_mulai,
            'tgl_akhir'=>$request->tgl_akhir,
            'status'=>$request->status,
            'bidang'=>$request->bidang,
            'harga'=>$request->harga

        ]);

        return redirect('client/job');
    }


    
}
