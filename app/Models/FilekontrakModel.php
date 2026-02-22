<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilekontrakModel extends Model
{
    use HasFactory;
    protected $table = 'tb_file_kontrak';
    protected $primaryKey = 'id_file';
    protected $fillable = ['id_kontrak', 'file'];
}
