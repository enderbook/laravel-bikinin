<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanModel extends Model
{
    use HasFactory;
    protected $table = 'tb_pesan';
    protected $primaryKey = 'id_pesan';
    protected $fillable = ['id_chat', 'id_user', 'pesan', 'waktu'];
}
