<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatModel extends Model
{
    use HasFactory;
    protected $table = 'tb_chat';
    protected $primaryKey = 'id_chat';
    protected $fillable = ['id_user', 'id_lawan'];
}
