<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenawaranModel extends Model
{
    use HasFactory;
    protected $table = 'tb_penawaran';
    protected $primaryKey = 'id_penawaran';
    protected $fillable = ['id_job', 'id_free', 'id_client', 'des_tawaran', 'status'];
}
