<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifModel extends Model
{
    use HasFactory;
    protected $table = 'tb_notif';
    protected $primaryKey = 'id_notif';
    protected $fillable = ['id_user','bagian','judul_notif', 'des_notif','status'];
}
