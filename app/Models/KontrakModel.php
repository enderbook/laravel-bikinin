<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontrakModel extends Model
{
    use HasFactory;
    protected $table = 'tb_kontrak';
    protected $primaryKey = 'id_kontrak';
    protected $fillable = ['id_job', 'id_client', 'id_free', 'status','deadline','delivarable','kd_kontrak'];
}
