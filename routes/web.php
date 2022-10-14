<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => ['auth']], function () { 
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/ticket', [App\Http\Controllers\TicketController::class, 'index']);
    Route::get('/reqticket',  [App\Http\Controllers\TicketController::class, 'reqticket'])->name('reqticket');
    Route::post('/store', [App\Http\Controllers\TicketController::class, 'storeticket'])->name('storeticket');
    Route::post('/take', [App\Http\Controllers\TicketController::class, 'taketicket'])->name('taketicket');
    Route::get('/finish/{id}', [App\Http\Controllers\TicketController::class, 'finish']);
    Route::post('/done', [App\Http\Controllers\TicketController::class, 'doneticket'])->name('doneticket');
    Route::get('/detail/{id}', [App\Http\Controllers\TicketController::class, 'detail'])->name('detail');
    Route::get('/setpetugas/{id}', [App\Http\Controllers\TicketController::class, 'setpetugas'])->name('setpetugas');
    Route::post('/tes', [App\Http\Controllers\TicketController::class, 'tes']);
    Route::get('/detailprint/{id}', [App\Http\Controllers\TicketController::class, 'detailprint']);
});

Route::get('print', [App\Http\Controllers\HomeController::class, 'print'])->name('print');