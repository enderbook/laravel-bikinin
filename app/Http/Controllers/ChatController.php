<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Http;


use App\Events\PesanBaru;


use App\Models\ChatModel;
use App\Models\PesanModel;
use App\Models\JobModel;
use App\Models\ProfileModel;
use Auth;

class ChatController extends Controller
{
    public function listChat(){
        $user = auth()->user();
        $id_user = $user->id_user;

        $chat = ChatModel::select('tb_chat.*',
            'users.username as user_name')

            ->join('users', 'tb_chat.id_lawan', '=', 'users.id_user')
            ->where(function($query) use ($id_user) {
                $query->where('tb_chat.id_user', $id_user)
                      ->orWhere('tb_chat.id_lawan', $id_user);
                })
            ->get();

        $profile = ProfileModel::where('id_user', $id_user)->first();


            if(!$profile){
                $profile = ProfileModel::where('id_user', $chat->id_lawan)->first();
            }

        return view('tampillistchat', compact('chat','profile'));
    }

    public function inputPesan(Request $request)
    {
        $user = auth()->user();
        $id_user = $user->id_user;
        

        $pesan = PesanModel::create([
            'id_chat' => $request->id_chat,
            'id_user' => $id_user,
            'pesan' => $request->pesan
        ]);

        broadcast(new PesanBaru($pesan))->toOthers();

        \Log::info('Pesan terkirim:', $pesan->toArray());


        return response()->json(['message' => 'Pesan terkirim!']);
    }

    public function pesanChat($id) {
        $user = auth()->user();
        $id_user = $user->id_user;

        $chat = ChatModel::select('tb_chat.*', 
            'user1.username as profile_user', 
            'user2.username as profile_user2')
            ->join('users as user1', 'tb_chat.id_user', '=', 'user1.id_user')
            ->join('users as user2', 'tb_chat.id_lawan', '=', 'user2.id_user')
            ->where('tb_chat.id_chat', $id)
            ->first();

        $profile = ProfileModel::where('id_user', $chat->id_user)->first();


        if(!$profile){
            $profile = ProfileModel::where('id_user', $chat->id_lawan)->first();
        }
        
    
        $pesan = PesanModel::where('id_chat', $id)->get();
    
        return view('chatview', compact('chat', 'pesan','profile'));
    }
    
    public function tambahChat(Request $request){
        
        $user = auth()->user();
        $id_user = $user->id_user;

        $chat = ChatModel::create([
            'id_user'=>$id_user,
            'id_lawan'=>$request->id_lawan
        ]);

        return redirect('chat');
    }

    public function tambahPesan(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();
            $id_user = $user->id_user;

            $pesan = PesanModel::create([
                'id_user' => $id_user,
                'id_chat' => $request->id_chat,
                'pesan' => $request->pesan
            ]);

            return response()->json([
                'pesan' => $pesan->pesan,
                'time' => $pesan->created_at->format('H:i A')
            ]);
        }

        return response()->json(['error' => 'Request is not AJAX'], 400);
    }

    

    
    
}
