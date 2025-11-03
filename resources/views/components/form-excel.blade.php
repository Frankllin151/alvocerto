<div class="p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">
        Importar Clientes via Planilha Excel
    </h3>

    {{-- 1. Definição do Formulário --}}
    {{-- Importante: use 'enctype="multipart/form-data"' para permitir o upload de arquivos --}}
    <form action="{{route("clientes.importar")}}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Campo de Seleção de Nicho --}}
        <div>
            <label for="nicho_id" class="block text-sm font-medium text-gray-700">
                Selecione o Nicho
            </label>
            <select id="nicho_id" name="nicho_id"
                class="w-full border-gray-300 rounded-lg mt-1 p-2.5 focus:ring-indigo-500 focus:border-indigo-500 @error('nicho_id') border-red-500 @enderror">
                <option value="">Selecione o Nicho</option>
                {{-- Aqui você itera sobre os nichos que você já passa para a view --}}
                @foreach ($nichos as $nicho)
                    {{-- Ajuste aqui: use $nicho->nome ou $nicho->nicho, dependendo da sua coluna real --}}
                    <option value="{{ $nicho->id }}" {{ old('nicho_id') == $nicho->id ? 'selected' : '' }}>
                        {{ $nicho->nome ?? $nicho->nicho }}
                    </option>
                @endforeach
            </select>
            @error('nicho_id')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Campo de Upload do Arquivo --}}
        <div>
            <label for="arquivo_excel" class="block text-sm font-medium text-gray-700">
                Arquivo Excel (.xlsx, .xls)
            </label>
            <input type="file" id="arquivo_excel" name="arquivo_excel" accept=".xlsx, .xls"
                class="w-full border-gray-300 rounded-lg mt-1 p-2.5 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('arquivo_excel') border-red-500 @enderror">
            
            @error('arquivo_excel')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Botão de Submissão --}}
        <div class="flex justify-between items-center">
            <x-secondary-button
                type="button"
                @click="$dispatch('close-modal', 'import-modal')"
            >Cancelar</x-secondary-button>
           <x-primary-button type="submit">
                Importar Clientes
            </x-primary-button>
        </div>
    </form>
</div>