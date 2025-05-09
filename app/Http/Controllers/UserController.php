<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\UserBusiness;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Rules\Cpf;
use App\Models\User;

class UserController extends Controller
{
    protected $business;

    public function __construct(UserBusiness  $business){
        $this->business = $business;
    }

    public function index()
    {
        $users = User::all();
        return view('users', ['users' => $users]);

    }
    public function salvar(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email',
                'cpf' => ['required', 'unique:users,cpf'],
                'name' => 'required|string', // Verifique se o nome está sendo validado corretamente
            ], [
                'email.unique' => 'O email informado já existe na base de dados!',
                'cpf.unique' => 'O CPF informado já existe na base de dados!',
            ]);

            if ($validation->fails()) {
                return response()->json(['errors' => $validation->errors()], 422);
            }

            $user = $this->business->salvar($request->all());

            return response()->json([
                'mensagem' => 'Usuário salvo com sucesso',
                'usuario' => $user
            ], 201);
        }
        catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function atualizar(Request $request, $id)
    {
        try {
            $user = $request->all();
            return $this->business->atualizar($id, $user);
        }
        catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function excluir(Request $request, $id)
    {
        try {
            $user = $request->all();
            return $this->business->deletar($id, $user);
        }
        catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
