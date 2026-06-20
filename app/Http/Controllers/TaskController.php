<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tarefas = Task::all();
        return view('tarefas.index', compact('tarefas'));
    }

    public function create()
    {
        return view('tarefas.create');
    }

    public function store(Request $request)
    {
        Task::create($request->validate([
            'titulo' => 'required|string|max:255',
        ]));
        return redirect()->route('tarefas.index')->with('mensagem', 'Tarefa criada!');
    }

    public function show(Task $tarefa)
    {
        return view('tarefas.show', compact('tarefa'));
    }

    public function edit(Task $tarefa)
    {
        return view('tarefas.edit', compact('tarefa'));
    }

    public function update(Request $request, Task $tarefa)
    {
        $tarefa->update([
            'titulo' => $request->validate(['titulo' => 'required|string|max:255'])['titulo'],
            'feito' => $request->has('feito'),
        ]);

        return redirect()->route('tarefas.index')->with('mensagem', 'Tarefa atualizada!');
    }

    public function toggle(Task $tarefa)
    {
        $tarefa->update(['feito' => !$tarefa->feito]);
        return redirect()->route('tarefas.index')->with('mensagem', 'Tarefa atualizada!');
    }

    public function destroy(Task $tarefa)
    {
        $tarefa->delete();
        return redirect()->route('tarefas.index')->with('mensagem', 'Tarefa deletada!');
    }
}