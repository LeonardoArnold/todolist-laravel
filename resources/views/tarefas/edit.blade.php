<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarefa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-2xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Editar Tarefa</h1>

        <form action="{{ route('tarefas.update', $tarefa) }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="titulo" class="block text-sm font-semibold mb-2">Título</label>
                <input type="text" id="titulo" name="titulo" value="{{ $tarefa->titulo }}" required class="w-full border border-gray-300 rounded px-3 py-2">
                @error('titulo')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="feito" class="flex items-center">
                    <input type="checkbox" id="feito" name="feito" value="1" {{ $tarefa->feito ? 'checked' : '' }} class="mr-2">
                    <span>Tarefa concluída?</span>
                </label>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                <a href="{{ route('tarefas.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>