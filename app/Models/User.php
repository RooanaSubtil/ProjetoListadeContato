<?php


namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
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
