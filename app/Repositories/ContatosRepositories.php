<?php

namespace App\Repositories;

use App\Models\Contatos;
use App\Repositories\Repositories;
class ContatosRepositories extends Repositories
{
    public function __construct(Contatos $contatos){
        $this->model = $contatos;
    }

    public function all(){
        return $this->model->all();
    }

    public function salvar($dados){
        return $this->model->create($dados);
    }

    public function atualizar($id, $dados){
        return $this->model->where('id', $id)->update($dados);
    }

    public function excluir($id){
        return $this->model->destroy($id);
    }
}
