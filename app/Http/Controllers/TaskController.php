<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $filtro = $request->query('filtro', 'todas');

        $query = Task::query();
        if ($filtro === 'pendentes') {
            $query->where('feito', false);
        } elseif ($filtro === 'feitas') {
            $query->where('feito', true);
        }
        $tarefas = $query->latest()->get();

        $totalPendentes = Task::where('feito', false)->count();

        return view('tarefas.index', compact('tarefas', 'filtro', 'totalPendentes'));
    }

    public function create()
    {
        return view('tarefas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|min:3|max:255',
        ], [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.min' => 'O título precisa ter pelo menos 3 caracteres.',
            'titulo.max' => 'O título pode ter no máximo 255 caracteres.',
        ]);

        Task::create(['titulo' => $request->titulo]);
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