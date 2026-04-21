<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'san_pham';

    protected $fillable = [
        'tieu_de',
        'gia',
        'hinh_anh',
        'id_danh_muc',
        'status'
    ];
}