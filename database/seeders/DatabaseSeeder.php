<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin')->insert([
            'id_adm' => (string) Str::ulid(),
            'nama_adm' => 'Admin Web',
            'username' => 'admin',
            'password' => Hash::make('12345'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
