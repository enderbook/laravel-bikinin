<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileModel extends Model
{
    use HasFactory;
    protected $table = 'tb_profile';
    protected $primaryKey = 'id_profile';
    protected $fillable = ['id_user', 'nm_depan', 'nm_belakang','des_singkat','jns_kelamin', 'alamat', 'tgl_lahir','bidang', 'bio', 'foto_profile', 'no_wa', 'nm_rek', 'no_rek']; 
}
