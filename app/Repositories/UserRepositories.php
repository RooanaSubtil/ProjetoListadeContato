<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Repositories;
class UserRepositories extends Repositories
{
    public function __construct(User $user){
        $this->model = $user;
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
