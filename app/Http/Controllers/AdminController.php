<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\NewsModel;
use App\Models\BidangModel;
use App\Models\PayModel;
use Session;
use Carbon\Carbon;


class AdminController extends Controller
{
    public function user(){
        $user = User::where('role', '!=', 'admin')->get();
        return view('user', compact('user'));
    }

    public function hapusUser($id){
        $user= User::where('id_user', $id)->delete();

        return redirect('admin/user');
    }

    public function editUser($id){
        $user= User::where('id_user', $id)->get();

        return view('edituser', compact('user'));
    }

    public function editactionUser(Request $request){
        $user = User::where('id_user', $request->id_user)->update([
            'username'=>$request->username,
            'email'=>$request->email,
            'role'=>$request->role,
            'status'=>$request->status
        ]);
        return redirect('admin/user');
    }

    public function blokUser(Request $request){
        $now = Carbon::now();

        $user = User::where('id_user', $request->id_user)->update([
            'status'=>$request->status,
            'blocked_at'=>$now
        ]);
        return redirect('admin/user');
    }

    public function adminKetua($id)
    {
        $user = User::where('id_user', $id)->update(['status' => 0]);
        return redirect('rekrut');
    }

    public function adminAnggota($id)
    {
        $user = User::where('id_user', $id)->update(['status' => 1]);
        return redirect('rekrut');
    }


    public function adminPecat($id)
    {
        $admins = User::where('role', 'admin')->where('id_user', '!=', $id)->get();

        if ($admins->isEmpty()) {
            return redirect('rekrut')->with('error', 'Gagal: Tidak ada admin lain.');
        }

        $pays = PayModel::where('id_admin', $id)->get();

        $adminIndex = 0;
        $adminCount = $admins->count();

        foreach ($pays as $pay) {
            $adminBaru = $admins[$adminIndex];
            
            $pay->update([
                'id_admin' => $adminBaru->id_user,
            ]);

            $adminIndex++;
            if ($adminIndex >= $adminCount) {
                $adminIndex = 0; 
            }
        }

        User::where('id_user', $id)->delete();

        return redirect('rekrut')->with('success', 'Admin berhasil dipecat, payment sudah dibagi rata.');
    }

    public function newsTampil(){
        $news = NewsModel::select('tb_news.*',
        'admin.username as admin_name')
        
        ->join('users as admin', 'tb_news.id_admin', '=', 'admin.id_user')
        ->get();

        return view('news',compact('news'));
    }

    public function newsHapus($id){
        
        $news = NewsModel::where('id_news', $id)->first();

        $existingfile = $news->img_news;

        $destinationPath = public_path('imageup');

        unlink($destinationPath . '/' . $existingfile);

        $news->delete();
        
        return redirect('admin/news');
    }

    public function newsInput(){
        $news = NewsModel::select('tb_news.*',
        'admin.username as admin_name')
        
        ->join('users as admin', 'tb_news.id_admin', '=', 'admin.id_user')
        ->first();

        return view('inputnews',compact('news'));
    }

    public function newsMasuk(Request $request)
    {
        $request->validate([
            'judul_news' => 'required|string',
            'img_news' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'required|url',
        ]);

        $user = auth()->user();
        $id_user = $user->id_user;
    
        if ($request->hasFile('img_news')) {
            $image = $request->file('img_news');
            $filename = time() . '.' . $image->getClientOriginalExtension(); 
            $image->move(public_path('imageup'), $filename); 
        } else {
            $filename = null; 
        }
    
        $news = NewsModel::create([
            'judul_news' => $request->judul_news,
            'img_news' => $filename,
            'link' => $request->link,
            'id_admin'=>$id_user,
            'status' => 1,
        ]);
    
        return redirect('admin/news')->with('success', 'News berhasil ditambahkan!');
    }
    
    public function newsEdit($id){
        $news = NewsModel::select('tb_news.*',
        'admin.username as admin_name')
        
        ->join('users as admin', 'tb_news.id_admin', '=', 'admin.id_user')
        ->where('id_news', $id)
        ->first();

        return view('editnews',compact('news'));
    }

    public function newsUpdate(Request $request)
    {
        $news = NewsModel::where('id_news', $request->id_news)->first();

        if (!$news) {
            return redirect('admin/news')->with('error', 'Data news tidak ditemukan!');
        }

        $filename = $news->img_news; // default: pakai gambar lama

        if ($request->hasFile('img_news')) {
            $image = $request->file('img_news');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('imageup'), $filename);

            if ($news->img_news && file_exists(public_path('imageup/' . $news->img_news))) {
                unlink(public_path('imageup/' . $news->img_news));
            }
        }

        $user = auth()->user();
        $id_user = $user->id_user;

        $news->update([
            'judul_news' => $request->judul_news,
            'img_news' => $filename,
            'link' => $request->link,
            'id_admin' => $id_user,
            'status' => 2
        ]);

        return redirect('admin/news')->with('success', 'News berhasil diupdate!');
    }


    public function bidangTampil(){
        $bidang = BidangModel::select('*')->get();

        return view('bidang',compact('bidang'));
    }

    public function bidangInput(){

        return view('inputbidang');
    }

    public function bidangSubmit(Request $request)
    {
    
        $bidang = BidangModel::create([
            'bidang' => $request->bidang
            
        ]);
    
        return redirect('admin/bidang')->with('success', 'Bidang berhasil ditambahkan!');
    }

    
}
