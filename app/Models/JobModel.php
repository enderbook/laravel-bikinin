<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobModel extends Model
{
    use HasFactory;
    protected $table = 'tb_job';
    protected $primaryKey = 'id_job';
    protected $fillable = ['id_client', 'id_free','judul','deskripsi','tgl_mulai', 'tgl_akhir','harga','status','bidang'];
}
