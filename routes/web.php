<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ContatosController;
use Illuminate\Support\Facades\Route;

Route::get('/health/status/elb', function () {
    return response()->json(['status' => 'OK']);
});

Route::middleware([])->post('user/salvar', [UserController::class, 'salvar']);
Route::middleware([])->put('user/atualizar/{id}', [UserController::class, 'atualizar']);
Route::middleware([])->delete('user/excluir/{id}', [UserController::class, 'excluir']);
Route::middleware([])->post('contatos/salvar', [ContatosController::class, 'salvar']);
Route::middleware([])->get('contatos/listar', [ContatosController::class, 'listar']);

