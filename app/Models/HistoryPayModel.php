<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPayModel extends Model
{
    use HasFactory;
    protected $table = 'tb_histori_pay';
    protected $primaryKey = 'id_hispay';
    protected $fillable = ['id_user','kode_kontrak','no_free','no_client', 'poto_admin','poto_client','status'];
}