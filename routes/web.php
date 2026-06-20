<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect()->route('tarefas.index');
});

Route::put('/tarefas/{tarefa}/toggle', [TaskController::class, 'toggle'])->name('tarefas.toggle');
Route::resource('tarefas', TaskController::class);