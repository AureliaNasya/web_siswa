<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SiswaModel extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = ['id_siswa'];

    public function kota() {
        return $this->belongsTo(KotaModel::class, 'id_kota', 'id_kota');
    }

    static function scopeFilter(Builder $query, $request) {
        $query->when($request['q'] ?? false, function(Builder $query, $search) {
            $query
            ->orWhere('nama_siswa', 'LIKE', "%$search%")
            ->orWhere('nis', 'LIKE', "%$search%");
        });
    }
}
