<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ContatosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::view('/', 'welcome')->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/contatos/listar');
    }

    return back()->with('error', 'E-mail ou senha inválidos.');
})->name('login.process');

Route::get('/health/status/elb', function () {
    return response()->json(['status' => 'OK']);
});

Route::middleware([])->get('user', [UserController::class, 'index'])->name('user.index');
Route::middleware([])->post('user/salvar', [UserController::class, 'salvar']);
Route::middleware([])->get('/user/{id}', [UserController::class, 'show']);
Route::middleware([])->get('user/listar', [UserController::class, 'listar']);
Route::middleware([])->put('user/atualizar/{id}', [UserController::class, 'atualizar']);
Route::middleware([])->delete('user/excluir/{id}', [UserController::class, 'excluir']);
Route::middleware([])->post('contatos/salvar', [ContatosController::class, 'salvar']);
Route::middleware([])->get('contatos/listar', [ContatosController::class, 'listar']);

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/register', function () {
    return view('auth.register'); //
})->name('register');
