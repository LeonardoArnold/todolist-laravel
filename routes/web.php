<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect()->route('tarefas.index');
Route::get('/rodar-migrations-9382', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    return '<pre>' . \Illuminate\Support\Facades\Artisan::output() . '</pre>';
});    
});

Route::put('/tarefas/{tarefa}/toggle', [TaskController::class, 'toggle'])->name('tarefas.toggle');
Route::resource('tarefas', TaskController::class);