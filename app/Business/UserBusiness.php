<?php

namespace App\Business;

use App\Repositories\UserRepositories;
class UserBusiness extends Business
{
    /** @var UserRepositories $userRepositories */
    private $userRepositories;

    public function __construct(UserRepositories  $userRepositories){
        $this->userRepositories = $userRepositories;
    }

    /**
     * Salvar
     * @param array $dados
     * @return
     */
    public function salvar(array $dados)
    {
        return $this->userRepositories->salvar($dados);
    }

    /**
     * Atualizar
     * @param int $id
     * @param array $dados
     * @return
     */
    public function atualizar(int $id, array $dados)
    {
        return $this->userRepositories->atualizar($id, $dados);
    }

    /**
     * deletar
     * @param int $id
     * return
     */
    public function excluir(int $id){
        return $this->userRepositories->excluir($id);
    }
}
