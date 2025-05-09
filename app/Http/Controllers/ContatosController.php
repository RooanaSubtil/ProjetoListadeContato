<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\ContatosBusiness;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Rules\Cpf;

class ContatosController extends Controller
{
    protected $business;

    public function __construct(ContatosBusiness  $business){
        $this->business = $business;
    }
    public function salvar(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'nome' => 'required',
                'cpf' => ['required', new Cpf, 'unique:users,cpf'],
                'telefone' => 'required',
                'logradouro' => 'required',
                'numero' => 'required',
                'bairro' => 'required',
                'cidade' => 'required',
                'estado' => 'required',
                'cep' => 'required',
                'posicao_geografica' => 'required',
            ], [
                'cpf.unique' => 'O CPF informado já existe na base de dados!',
            ]);

            if ($validation->fails()) {
                return response()->json(['errors' => $validation->errors()], 422);
            }

            $contato = $this->business->salvar($request->all());

            return response()->json([
                'mensagem' => 'Contato salvo com sucesso',
                'contato' => $contato
            ], 201);
        }
        catch (\Exception $e){
            return $e->getMessage();
        }
    }


    public function listar()
    {
        try {
            $contatos = $this->business->listar();
            return view('contatos.listar', ['contatos' => $contatos]);
        }
        catch (\Exception $e){
            return $e->getMessage();
        }
    }
}
