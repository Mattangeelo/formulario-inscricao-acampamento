<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
   
    public function run(): void
    {
        DB::table('usuarios')->insert([
            'email' => 'admin.movjovem@hotmail.com',
            'senha' => Hash::make('Macio@2025'),
            'is_admin' => true,
            'ativo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
