<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsModel extends Model
{
    use HasFactory;
    protected $table = 'tb_news';
    protected $primaryKey = 'id_news';
    protected $fillable = ['id_admin','judul_news','img_news', 'link','status'];
}
