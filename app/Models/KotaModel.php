<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class KotaModel extends Model
{
    use HasFactory, HasUlids;
    
    protected $guarded = ['id_kota'];

    public function siswa() {
        return $this->hasMany(SiswaModel::class, 'id_kota', 'id_kota');
    }
}
