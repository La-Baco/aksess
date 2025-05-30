<?php

namespace App\Models;

use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    use HasFactory;
protected $table = 'jadwals';
    protected $fillable = [
        'kelas_id',
        'mapel_id',
        'hari',
        'waktu_mulai',
        'waktu_selesai',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}

