<?php

use App\Http\Controllers\MainController;
use App\Http\Middleware\hasSubscription;
use App\Http\Middleware\isGuest;
use App\Http\Middleware\isUser;
use App\Http\Middleware\noSubscription;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas de Visitantes (Não Autenticados)
|--------------------------------------------------------------------------
*/
Route::middleware([isGuest::class])->group(function () {

    Route::redirect('/', '/login');

    Route::get('/login', [MainController::class, 'loginPage'])->name('login');
    Route::get('/login/{id}', [MainController::class, 'loginSubmit'])->name('login.submit');
});


/*
|--------------------------------------------------------------------------
| Rotas de Usuários Autenticados
|--------------------------------------------------------------------------
| Rotas que exigem que o usuário esteja logado.
*/
Route::middleware([isUser::class])->group(function () {


    Route::get('/logout', [MainController::class, 'logout'])->name('logout');

    Route::middleware([noSubscription::class])->group(function () {
        Route::get('/plans', [MainController::class, 'plans'])->name('plans');
    });


    Route::middleware([hasSubscription::class])->group(function () {
        Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');
        Route::get('/invoice/{id}', [MainController::class, 'invoiceDownload'])->name('invoice.download');
    });

    Route::get('/plan_selected/{id}', [MainController::class, 'planSelected'])->name('plan.selected');
    Route::get('/subscription/success', [MainController::class, 'subscriptionSuccess'])->name('subscription.success');
});