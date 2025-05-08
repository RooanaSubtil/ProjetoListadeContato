<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contatos extends ApiModel
{
    use HasFactory;

    /** Nome da tabela */
    protected $table = 'contatos';

    /** Chave primária  */
    protected $primaryKey = 'id';

    /**
     * Atributos permitidos
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'posicao_geografica'
    ];
}
