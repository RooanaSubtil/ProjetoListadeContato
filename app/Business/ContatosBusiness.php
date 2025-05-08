<?php

namespace App\Business;

use App\Business\Business;
use App\Repositories\ContatosRepositories;
use Illuminate\Support\Facades\DB;
class ContatosBusiness extends Business
{
    /** @var ContatosRepositories $contatosRepositories */
    private $contatosRepositories;

    public function __construct(ContatosRepositories  $contatosRepositories){
        $this->contatosRepositories = $contatosRepositories;
    }

    /**
     * Salvar
     * @param array $dados
     * @return
     */
    public function salvar(array $dados)
    {
        return $this->contatosRepositories->salvar($dados);
    }

    /**
     * Atualizar
     * @param int $id
     * @param array $dados
     * @return
     */
    public function listar()
    {
        return $this->contatosRepositories->all();
    }
}
