<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotifModel;


class NotificationController extends Controller
{
    public function tampilNotif()
    {
        $user = auth()->user();
        $id_user = $user->id_user;

        $notifs = NotifModel::where('id_user', $id_user)->get();

        return response()->json([
            'notifications' => $notifs
        ]);
    }

    public function readNotif($id)
    {
        $notif = NotifModel::where('id_notif',$id)->first();
        if ($notif) {
            $notif->status = 1;
            $notif->save();
        }
        return response()->json(['success' => true]);
    }

    public function hapusNotif($id)
    {
        $notif = NotifModel::where('id_notif', $id)->delete();
        
        return response()->json(['success' => true]);
    }
}
