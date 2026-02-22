<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayModel;
use App\Models\NotifModel;
use App\Models\HistoryPayModel;
use App\Models\User;
use App\Models\KontrakModel;


class PayController extends Controller
{
    public function pay(){
        $user = auth()->user();
        $id_user = $user->id_user;

        $pay = PayModel::select('tb_pay.*',
            'client.username as client_name',
            'freelancer.username as freelancer_name',
            'jobs.judul as judul_name',
            'sta.status as status_name',
            'kontrak.delivarable as del_kontrak',
            'kontrak.kd_kontrak as kd_kon',

            'profClient.no_wa as wa_client',
            'prorFree.no_wa as wa_free')

            ->join('users as client', 'tb_pay.id_client', '=', 'client.id_user')
            ->join('users as freelancer', 'tb_pay.id_free', '=', 'freelancer.id_user')
            ->join('tb_job as jobs', 'tb_pay.judul', '=', 'jobs.id_job')
            ->join('tb_status as sta', 'tb_pay.status', '=', 'sta.id_status')
            ->join('tb_kontrak as kontrak', 'tb_pay.id_kontrak', '=', 'kontrak.id_kontrak')
            ->join('tb_profile as profClient', 'tb_pay.id_client', '=', 'profClient.id_user')  
            ->join('tb_profile as prorFree', 'tb_pay.id_free', '=', 'prorFree.id_user') 

            ->where('tb_pay.status', '!=',8)
            ->where('tb_pay.id_admin', $id_user)

            ->get();

        


        return view('payment', compact('pay'));
    }

    public function historiPay($id){
        
        $hispay = HistoryPayModel::select('tb_histori_pay.*',
            'profClient.no_wa as wa_client',
            'prorFree.no_wa as wa_free')

            ->join('tb_profile as profClient', 'tb_histori_pay.no_client', '=', 'profClient.id_user')  
            ->join('tb_profile as prorFree', 'tb_histori_pay.no_free', '=', 'prorFree.id_user') 
            ->where('tb_histori_pay.id_user', $id)
            ->where('tb_histori_pay.status',8)->get();

        return view('historiadmin', compact('hispay'));
    }

    public function payDone($id){
        
        
        $pay = PayModel::select('tb_pay.*',
            'freelancer.username as freelancer_name',
            'client.username as client_name',
            'jobs.judul as judul_name',
            'profFree.no_wa as wa_free',
            'profFree.no_rek as no_rek_free',
            'profFree.nm_rek as nm_rek_free',
            'profClient.no_wa as wa_client')

            ->join('users as freelancer', 'tb_pay.id_free', '=', 'freelancer.id_user')
            ->join('users as client', 'tb_pay.id_client', '=', 'client.id_user')
            ->join('tb_profile as profFree', 'tb_pay.id_free', '=', 'profFree.id_user')
            ->join('tb_profile as profClient', 'tb_pay.id_client', '=', 'profClient.id_user')
            ->join('tb_job as jobs', 'tb_pay.judul', '=', 'jobs.id_job')
    
            ->where('tb_pay.id_pay', $id)->first();

        $user = User::select('users.*',
        'profile.no_wa as wa_user')

        ->join('tb_profile as profile', 'users.id_user', '=', 'profile.id_user')        
        ->where('users.role','admin')->get();


        $kontrak = KontrakModel::where('id_kontrak', $pay->id_kontrak)->first();

        return view('inputpay', compact('pay', 'kontrak'));
    }

    public function payBatal($id){
        
        
        $pay = PayModel::where('id_pay', $id)->first();

        $kontrak = KontrakModel::where('id_kontrak', $pay->id_kontrak)->update(['status' =>8]);

        $pay = PayModel::where('id_pay', $id)->update(['status' =>8]);

        return redirect('admin/pay');
    }

    public function hispayHapus($id){
        $user = auth()->user();
        $id_user = $user->id_user;

        $pay = HistoryPayModel::where('id_hispay', $id)->update(['status'=>9]);

        
        // $pay = HistoryPayModel::where('id_hispay', $id)->first();
        // unlink(public_path('imageup/' . $pay->poto_admin)); 
        // unlink(public_path('imageup/' . $pay->poto_client)); 
        // $pay = HistoryPayModel::where('id_hispay', $id)->delete();
        return redirect('history/admin/'.$id_user);
    }

    public function payHapus($id){
        
        
        $hispay = PayModel::where('id_pay', $id)->first();

        $kontrak = KontrakModel::where('id_kontrak', $pay->id_kontrak)->update(['status' =>8]);

        $pay = PayModel::where('id_pay', $id)->update(['status' =>8]);

        return redirect('history/admin');
    }

    public function paydoneAction(Request $request){
        $user = auth()->user();
        $id_user = $user->id_user;
        
        $file_name = $request->potoAda;  

            $status = 4;

            if ($request->hasFile('poto')) {
                if ($file_name && file_exists(public_path('imageup/' . $file_name))) {
                    unlink(public_path('imageup/' . $file_name)); 
                }

                $file = $request->file('poto');
                $file_name = date('Y-m-d-H-i-s') . '-' . $file->getClientOriginalName(); 
                $destinationPath = public_path('imageup');
                $file->move($destinationPath, $file_name);
            }

            $pay = PayModel::where('id_pay', $request->id_pay)->update([
                'status' => $status,
                'poto' => $file_name 
            ]);



        $pay = PayModel::select('tb_pay.*',
            'freelancer.username as freelancer_name',
            'client.username as client_name',
            'jobs.judul as judul_name',
            'profFree.no_wa as wa_free',
            'kontrak.kd_kontrak as kd',
            'profClient.no_wa as wa_client')

            ->join('users as freelancer', 'tb_pay.id_free', '=', 'freelancer.id_user')
            ->join('users as client', 'tb_pay.id_client', '=', 'client.id_user')
            ->join('tb_profile as profFree', 'tb_pay.id_free', '=', 'profFree.id_user')
            ->join('tb_kontrak as kontrak', 'tb_pay.id_kontrak', '=', 'kontrak.id_kontrak')
            ->join('tb_profile as profClient', 'tb_pay.id_client', '=', 'profClient.id_user')
            ->join('tb_job as jobs', 'tb_pay.judul', '=', 'jobs.id_job')
    
            ->where('tb_pay.id_pay', $request->id_pay)->first();

       

        $notif = NotifModel::create([
            'id_user' => $request->id_free,
            'judul_notif' => "Uang telah dikirm loh!!",
            'bagian' => 2,
            'status'=>0,
            'des_notif' => "Admin telah mengirim delivarable utk kontrak dari job : {$pay->judul_name}"
        ]);

        // Duplikat poto_admin
        $srcAdmin = public_path('imageup/' . $pay->poto);
        $admin_pt = date('Y-m-d-H-i-s') . '-admin-' . basename($pay->poto);
        $destAdmin = public_path('imageup/' . $admin_pt);
        copy($srcAdmin, $destAdmin);

        // Duplikat poto_client
        $srcClient = public_path('imageup/' . $pay->poto_client);
        $client_pt = date('Y-m-d-H-i-s') . '-client-' . basename($pay->poto_client);
        $destClient = public_path('imageup/' . $client_pt);
        copy($srcClient, $destClient);

        $hispay = HistoryPayModel::create([
            'id_user' => $pay->id_admin,
            'kode_kontrak' => $pay->kd,
            'no_free' => $pay->id_free,
            'no_client'=>$pay->id_client,
            'poto_admin' => $admin_pt, 
            'poto_client' => $client_pt,
            'status' =>8
        ]);

        return redirect('history/admin/'.$id_user);
    }

    
}
