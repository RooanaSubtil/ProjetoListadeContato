<?php

namespace App\Models;

class User extends ApiModel
{
    /** Nome da tabela */
    protected $table = 'users';

    /** Chave primária  */
    protected $primaryKey = 'id';

    /**
     * Atributos permitidos
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'cpf',
        'remember_token',
    ];
}
