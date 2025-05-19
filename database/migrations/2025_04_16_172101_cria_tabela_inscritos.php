<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {

        Schema::create('inscritos', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('email',50)->unique()->nullable();
            $table->string('senha',200)->nullable();
            $table->string('nome',200);
	        $table->string('nome_responsavel',200);
            $table->string('telefone',20);
	        $table->string('telefone_emergencia',20);
            $table->date('data_nascimento');
            $table->string('cpf', 14)->unique();
            $table->char('cep', 9); 
            $table->string('logradouro', 100);
            $table->string('numero', 10)->nullable();
            $table->string('complemento', 100)->nullable();
            $table->string('bairro', 60);
            $table->string('cidade', 60);
            $table->char('uf', 2); 
            $table->text('restricoes_alimentar')->nullable();
            $table->text('alergia')->nullable();
            $table->text('remedio_controlado')->nullable();
            $table->string('igreja',50)->nullable();
            $table->string('ministerio',50)->nullable();
            $table->string('camisa', 5);
            $table->string('tamanho_camisa', 5)->nullable();
            $table->string('forma_pagamento',20);
            $table->string('status_pagamento',20);
            $table->boolean('aceitou_termo')->default(false);
            $table->timestamp('data_aceite_termo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('inscritos');
    }
};
