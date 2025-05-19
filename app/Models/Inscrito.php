<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscrito extends Model
{
    protected $fillable = [
        'nome',
        'nome_responsavel',
        'email',
        'senha',
        'cpf',
        'telefone',
        'data_nascimento',
        'camisa',
        'tamanho_camisa',
        'telefone_emergencia',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'restricoes_alimentar',
        'alergia',
        'remedio_controlado',
        'igreja',
        'ministerio',
        'forma_pagamento',
        'status_pagamento',
        'aceitou_termo',
        'data_aceite_termo'
        
    ];
}
