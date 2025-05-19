<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class InscritoSeeder extends Seeder
{
    public function run()
    {
        // Adicionando alguns registros fictícios
        DB::table('inscritos')->insert([
            [
                'nome' => 'João Silva',
                'cpf' => '123.456.789-00',
                'email' => 'joao.silva@example.com',
                'senha' => Hash::make('123456'),
                'telefone' => '(11) 98765-4321',
                'telefone_emergencia' => '(11) 98765-4321',
                'data_nascimento' => Carbon::parse('1990-04-15'),
                'cep' => '01234-567',  
                'logradouro' => 'Rua Fictícia',
                'numero' => '123', 
                'complemento' => 'Apartamento 45',
                'bairro' => 'Centro',
                'cidade' => 'São Paulo',
                'uf' => 'SP',
                'restricoes_alimentar' => 'Vegetariano',
                'alergia' => 'Pólen',
                'remedio_controlado' => 'Nenhum',
                'igreja' => '3º Presbiteriana Renovada',
                'ministerio' => 'Louvor',
                'camisa' => 'sim',
                'tamanho_camisa' => NULL,
                'forma_pagamento' => 'PIX',
                'status_pagamento' => 'Pago',
                'nome_responsavel' => 'Maria Silva',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}