<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ContatosController;
use Illuminate\Support\Facades\Route;

Route::get('/health/status/elb', function () {
    return response()->json(['status' => 'OK']);
});

Route::middleware([])->post('user', [UserController::class, 'salvar']);
Route::middleware([])->put('user/{id}', [UserController::class, 'atualizar']);
Route::middleware([])->delete('user/{id}', [UserController::class, 'excluir']);
Route::middleware([])->put('contatos', [ContatosController::class, 'salvar']);
Route::middleware([])->delete('contatos', [ContatosController::class, 'listar']);

