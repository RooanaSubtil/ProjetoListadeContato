<?php

namespace App\Repositories;

use App\Models\User;
class UserRepositories extends Repositories
{
    public function __construct(User $user){
        $this->model = $user;
    }

    public function all(){
        return $this->model->all();
    }

    public function salvar($dados){
        $dados['password'] = bcrypt($dados['password']);
        return $this->model->create($dados);
    }

    public function atualizar($id, $dados){
        $dados['password'] = bcrypt($dados['password']);
        return $this->model->where('id', $id)->update($dados);
    }

    public function excluir($id)
    {
        try {
            $user = $this->model->find($id);
            if (!$user) {
                throw new \Exception('Usuário não encontrado');
            }
            return $this->model->destroy($id);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
