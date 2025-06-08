<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens as SanctumHasApiTokens;

class AdminModel extends Model
{
    use HasFactory, HasUlids, SanctumHasApiTokens;

    protected $guarded = 'admin';
    protected $fillable = ['nama_adm', 'username', 'password'];
    protected $hidden = ['password'];
}
