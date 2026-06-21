<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

        $tarefa = Task::create(['titulo' => $request->titulo]);

        $this->notificarTelegram("🆕 Nova tarefa adicionada:\n{$tarefa->titulo}");

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
        $dados = $request->validate([
            'titulo' => 'required|string|max:255',
        ], [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título pode ter no máximo 255 caracteres.',
        ]);

        $estavaFeito = (bool) $tarefa->feito;
        $novoFeito = $request->has('feito');

        $tarefa->update([
            'titulo' => $dados['titulo'],
            'feito' => $novoFeito,
        ]);

        if ($estavaFeito !== $novoFeito) {
            $mensagem = $novoFeito
                ? "✅ Tarefa concluída:\n{$tarefa->titulo}"
                : "↩️ Tarefa reaberta:\n{$tarefa->titulo}";
        } else {
            $mensagem = "✏️ Tarefa editada:\n{$tarefa->titulo}";
        }
        $this->notificarTelegram($mensagem);

        return redirect()->route('tarefas.index')->with('mensagem', 'Tarefa atualizada!');
    }

    public function toggle(Task $tarefa)
    {
        $tarefa->update(['feito' => !$tarefa->feito]);

        $mensagem = $tarefa->feito
            ? "✅ Tarefa concluída:\n{$tarefa->titulo}"
            : "↩️ Tarefa reaberta:\n{$tarefa->titulo}";
        $this->notificarTelegram($mensagem);

        return redirect()->route('tarefas.index')->with('mensagem', 'Tarefa atualizada!');
    }

    public function destroy(Task $tarefa)
    {
        $titulo = $tarefa->titulo;
        $tarefa->delete();

        $this->notificarTelegram("🗑️ Tarefa removida:\n{$titulo}");

        return redirect()->route('tarefas.index')->with('mensagem', 'Tarefa deletada!');
    }

    private function notificarTelegram(string $mensagem): void
    {
        $token = config('services.telegram.token');
        $chatId = config('services.telegram.chat_id');

        if (!$token || !$chatId) {
            return;
        }

        try {
            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $mensagem,
            ]);
        } catch (\Exception $e) {
            // se o Telegram falhar, não quebra o app
        }
    }
}