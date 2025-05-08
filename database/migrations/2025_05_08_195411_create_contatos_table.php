<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContatosTable extends Migration
{
    public function up()
    {
        Schema::create('contatos', function (Blueprint $table) {
            $table->id(); // Chave primária auto-incrementada
            $table->string('nome'); // Nome do contato
            $table->string('cpf')->unique(); // CPF único
            $table->string('telefone'); // Número de telefone
            $table->string('logradouro'); // Logradouro (endereço)
            $table->string('numero'); // Número do endereço
            $table->string('complemento')->nullable(); // Complemento do endereço (opcional)
            $table->string('bairro'); // Bairro
            $table->string('cidade'); // Cidade
            $table->string('estado'); // Estado
            $table->string('cep'); // CEP
            $table->string('posicao_geografica'); // Posição geográfica (latitude e longitude)
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('contatos');
    }
}
