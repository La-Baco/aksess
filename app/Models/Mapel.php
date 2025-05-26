<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $fillable = ['nama_mapel', 'guru_id'];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}

