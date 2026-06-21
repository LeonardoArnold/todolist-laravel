<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-2xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-2">Minhas Tarefas</h1>

        <p class="text-gray-600 mb-6">
            Você tem <strong>{{ $totalPendentes }}</strong>
            {{ $totalPendentes == 1 ? 'tarefa pendente' : 'tarefas pendentes' }}.
        </p>

        @if (session('mensagem'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('mensagem') }}
            </div>
        @endif

        <a href="{{ route('tarefas.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
            + Nova Tarefa
        </a>

        <div class="flex gap-2 mb-4">
            <a href="{{ route('tarefas.index', ['filtro' => 'todas']) }}"
               class="px-3 py-1 rounded text-sm {{ $filtro === 'todas' ? 'bg-gray-800 text-white' : 'bg-white text-gray-700 border' }}">
                Todas
            </a>
            <a href="{{ route('tarefas.index', ['filtro' => 'pendentes']) }}"
               class="px-3 py-1 rounded text-sm {{ $filtro === 'pendentes' ? 'bg-gray-800 text-white' : 'bg-white text-gray-700 border' }}">
                Pendentes
            </a>
            <a href="{{ route('tarefas.index', ['filtro' => 'feitas']) }}"
               class="px-3 py-1 rounded text-sm {{ $filtro === 'feitas' ? 'bg-gray-800 text-white' : 'bg-white text-gray-700 border' }}">
                Feitas
            </a>
        </div>

        <div class="space-y-2">
            @foreach ($tarefas as $tarefa)
                <div class="bg-white p-4 rounded shadow flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold {{ $tarefa->feito ? 'line-through text-gray-400' : '' }}">
                            {{ $tarefa->titulo }}
                        </h3>
                        <p class="text-sm text-gray-500">{{ $tarefa->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <form action="{{ route('tarefas.toggle', $tarefa) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm">
                                {{ $tarefa->feito ? 'Desmarcar' : 'Feito' }}
                            </button>
                        </form>
                        <a href="{{ route('tarefas.edit', $tarefa) }}" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                            Editar
                        </a>
                        <form action="{{ route('tarefas.destroy', $tarefa) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm" onclick="return confirm('Tem certeza?')">
                                Deletar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($tarefas->isEmpty())
            <p class="text-gray-500 text-center mt-8">Nenhuma tarefa nesse filtro. <a href="{{ route('tarefas.create') }}" class="text-blue-500">Crie uma!</a></p>
        @endif
    </div>
</body>
</html>