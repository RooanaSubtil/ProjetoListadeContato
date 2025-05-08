<?php

namespace App\Business;

abstract class Business
{
    /** @var $repository */
    protected $repository;

    /**
     * Salvar
     *
     * @param array $dados
     * @return
     */
    public function salvar(array $dados)
    {
        $this->repository->salvar($dados);
    }

    /**
     * Atualizar
     *
     * @param int $id
     * @param array $dados
     * @return
     */
    public function atualizar(int $id, array $dados)
    {
        return $this->repository->atualizar($id, $dados);
    }

    /**
     * excluir
     *
     * @param int $id
     * @return
     */
    public function excluir(int $id)
    {
        return $this->repository->excluir($id);
    }


}
