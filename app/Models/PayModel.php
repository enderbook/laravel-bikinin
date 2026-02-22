<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayModel extends Model
{
    use HasFactory;
    protected $table = 'tb_pay';
    protected $primaryKey = 'id_pay';
    protected $fillable= ['id_kontrak','id_client', 'id_free','id_admin', 'judul', 'bidang', 'status', 'poto','poto_client','nm_rek', 'no_rek'];
}
