<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangModel extends Model
{
    use HasFactory;
    protected $table='tb_bidang';
    protected $primaryKey='id_bidang';
    protected $fillable=['bidang'];
}
