<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Exception;

abstract class Repositories
{
    /** @var Model $model */
    protected $model;

    public function pk(){
        return $this->model->getKeyName();
    }
    public function salvar(array $dados){
        try{
            return $this->model->create($dados);
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function atualizar(int $id, array $dados){
        try{
            $this->model = $this->recuperarModelo($id);
            return $this->model->update($dados);
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function excluir(int $id)
    {
        $this->model = $this->recuperarModelo($id);
        return $this->model->delete();
    }
    public function recuperarModelo(int $id){
        try{
            $modelo = $this->model
                ->where($this->model->getForeignKey(), $id);
            if($modelo->count() > 0){
                return $modelo->first();
            }
            return null;
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}
