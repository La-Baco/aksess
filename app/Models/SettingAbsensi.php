<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingAbsensi extends Model
{
    protected $table = 'setting_absensi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'jam_mulai',
        'jam_selesai',
        'lokasi_lat',
        'lokasi_long',
        'radius_meter',
    ];

    public $timestamps = true;
}
