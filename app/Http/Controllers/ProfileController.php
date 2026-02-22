<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProfileModel;
use App\Models\ChatModel;
use App\Models\BidangModel;
use App\Models\UlasanModel;
use App\Models\User;
use Session;


class ProfileController extends Controller
{
    public function profileTampil($id){

        $user = auth()->user();
        $id_user = $user->id_user;

        $profile= ProfileModel::select('tb_profile.*',
        'user.email as email_user',
        'user.role as role_user',
        'bid.bidang as bidang_name')
        ->join('users as user', 'tb_profile.id_user', '=', 'user.id_user')

        ->join('tb_bidang as bid', 'tb_profile.bidang', '=', 'bid.id_bidang')

        ->where('tb_profile.id_user', $id)
        ->first();

        $users=User::select('*')->get();
        $lawan = $users->pluck('id_user'); 


        $ulasan= UlasanModel::select('tb_ulasan.*',
        'prof.nm_depan as nm_depan',
        'prof.nm_belakang as nm_belakang',
        'prof.foto_profile as pp')

        ->join('tb_profile as prof', 'tb_ulasan.id_penulis', '=', 'prof.id_user')

        ->where('tb_ulasan.id_user', $id)
        ->get();

        $average_rating = UlasanModel::where('id_user', $profile->id_user)->avg('rating');

        return view('profile', compact('profile','ulasan','average_rating'));
    }

    public function bikinProfile(){
        return view ('inputprofile');
    }

    public function inputProfile(Request $request){

        $file = $request->file('foto_profile');

        $tujuan_upload = 'imageup';

        $file_name = date('Y-m-d H:i:s').'-'.$file->getClientOriginalName();

        $file->move($tujuan_upload,$file_name);

        $status = User::where('id_user', $request->id_user)->update([
            'status'=>1
        ]);
         
        $profile = ProfileModel::create([
            'id_profile'=>$request->id_profile,
            'id_user' =>$request->id_user,
            'nm_depan' =>$request->nm_depan,
            'nm_belakang'=>$request->nm_belakang,
            'des_singkat'=>$request->des_singkat,
            'jns_kelamin'=>$request->jns_kelamin,
            'alamat'=>$request->alamat,
            'no_wa'=>$request->no_wa,
            'tgl_lahir'=>$request->tgl_lahir,
            'bidang'=>$request->bidang,
            'bio'=>$request->bio,
            'foto_profile'=>$file_name,
            'nm_rek'=>$request->nm_rek,
            'no_rek'=>$request->no_rek

        ]);

        

        return redirect('profile/'.$profile->id_user);

    }

    public function editProfile($id){
        $profile = ProfileModel::where('id_profile', $id)->first();
        $bidang = BidangModel::select('*')->get();


        return view ('editprofile',compact('profile','bidang'));
    }

    public function ubahProfile(Request $request) {

        $pro = ProfileModel::where('id_profile', $request->id_profile)->first();

        if (!$pro) {
            return redirect()->back()->with('error', 'Profile not found');
        }

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
            'foto_profile' => $file_name,
            'nm_rek' => $request->nm_rek,
            'no_rek' => $request->no_rek
        ]);

        
    
        return redirect('profile/' . $request->id_user);
    }
    
}
