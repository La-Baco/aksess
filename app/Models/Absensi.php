<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis';

    protected $fillable = [
        'user_id',
        'tanggal',
        'status',
        'lat',
        'long',
        'dibuat_oleh',
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
