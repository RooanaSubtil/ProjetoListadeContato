<?php

namespace App\Business;

use App\Repositories\ContatosRepositories;
class ContatosBusiness extends Business
{
    /** @var ContatosRepositories $contatosRepositories */
    private $contatosRepositories;

    public function __construct(ContatosRepositories  $contatosRepositories){
        $this->contatosRepositories = $contatosRepositories;
    }

    /**
     * Salvar os contatos
     * @param array $dados
     * @return
     */
    public function salvar(array $dados)
    {
        return $this->contatosRepositories->salvar($dados);
    }

    /**
     * Listar os contatos
     * @return
     */
    public function listar()
    {
        return $this->contatosRepositories->all();
    }
}
