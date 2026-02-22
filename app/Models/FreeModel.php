<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeModel extends Model
{
    use HasFactory;
    protected $table ='tb_free';
    protected $primaryKey = 'id_free';
    protected $fillable = ['id_user', 'bidang',];
}
