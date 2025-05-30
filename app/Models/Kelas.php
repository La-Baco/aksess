<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $fillable = ['nama_kelas', 'kapasitas'];

    // Di model Kelas
    public function siswa()
    {
        return $this->hasMany(User::class, 'kelas_id')->where('role', 'siswa');
    }


    public function guruWali()
    {
        return $this->belongsToMany(User::class, 'guru_kelas', 'kelas_id', 'guru_id')
            ->withPivot('tahun_ajaran')
            ->withTimestamps();
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
    public function mapel()
{
    return $this->belongsToMany(Mapel::class, 'jadwals', 'kelas_id', 'mapel_id')->distinct();
}

}
