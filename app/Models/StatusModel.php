<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusModel extends Model
{
    use HasFactory;
    protected $table='tb_status';
    protected $primarykey = 'id_status';
    protected $fillable=['status'];
}
