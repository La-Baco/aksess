<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

    protected $table = 'izins';

    protected $fillable = [
        'user_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'status',
        'disetujui_oleh',
        'ditolak_alasan',
    ];

    // Relasi ke user yang mengajukan izin (siswa/guru/kepsek)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke user yang menyetujui izin (guru wali/kepsek/admin)
    public function disetujuiOleh()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    // Accessor untuk status agar mudah dipakai
    public function isDisetujui()
    {
        return $this->status === 'Disetujui';
    }

    public function isDitolak()
    {
        return $this->status === 'Ditolak';
    }

    public function isMenunggu()
    {
        return $this->status === 'Menunggu';
    }
}
