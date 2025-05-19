<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\IncricaoController;
use App\Http\Controllers\Login;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsAdmin;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use App\Http\Middleware\CheckIsUser;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

// Rotas públicas (usuário não pode estar logado)
Route::middleware([CheckIsNotLogged::class])->group(function () {
    Route::get('/login', [Login::class, 'login'])->name('login');
    Route::post('/loginSubmit', [Login::class, 'LoginSubmit'])->name('loginSubmit');
});

// Rotas que exigem que o usuário esteja logado
Route::middleware([CheckIsLogged::class])->group(function () {

    // Apenas admin
    Route::middleware([CheckIsAdmin::class])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
        Route::post('/aprovar/{id}',[AdminController::class,'aprovar'])->name('aprovar');
        Route::post('/deletar/{id}',[AdminController::class,'deletar'])->name('deletar');
        Route::get('/editar/{id}', [AdminController::class, 'editar'])->name('editar');
        Route::post('/editarSubmit/{id}',[AdminController::class, 'editarSubmit'])->name('editarSubmit');
        Route::get('/relatorio',[AdminController::class, 'relatorio'])->name('relatorio');
    });

    // Apenas usuário comum (não admin)
    Route::middleware([CheckIsUser::class])->group(function () {
        Route::get('/confirmarLoginInscricao', [IncricaoController::class, 'confirmarLoginInscricao'])->name('confirmarLoginInscricao');
        Route::post('/concluirLogInscricao', [IncricaoController::class, 'concluirLogInscricao'])->name('concluirLogInscricao');
    });

    // Rota de logout acessível a qualquer logado
    Route::get('/logout', [Login::class, 'logout'])->name('logout');
});

// Rotas públicas de inscrição (antes de logar)


Route::post('/esqueciConfirma',[Login::class,'esqueciConfirma'])->name('esqueciConfirma');
Route::get('/esqueciSenha',[Login::class,'esqueciSenha'])->name('esqueciSenha');
Route::get('/esqueciMinhaSenha',[Login::class, 'esqueciMinhaSenha'])->name('esqueciMinhaSenha');
Route::post('/esqueciMinhaSenhaSubmit',[Login::class, 'esqueciMinhaSenhaSubmit'])->name('esqueciMinhaSenhaSubmit');

Route::get('/emailConfirma', [IncricaoController::class, 'emailConfirma'])->name('emailConfirma');
Route::get('/inscricao', [IncricaoController::class, 'index'])->name('inscricao');
Route::post('/confirmaEmail',[IncricaoController::class, 'confirmaEmail'])->name('confirmaEmail');
Route::get('/termos',[IncricaoController::class, 'termos'])->name('termos');
Route::post('/inscricaoSubmit', [IncricaoController::class, 'inscricaoSubmit'])->name('inscricaoSubmit');
Route::get('/conclusaoInscricao/{nome}', [IncricaoController::class, 'conclusaoInscricao'])->name('conclusaoInscricao');

// Página inicial
Route::get('/', [MainController::class, 'index'])->name('inicial');


