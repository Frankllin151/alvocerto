@props(['cliente' => null, 'nichos' => []])

<div id="modalAdd" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-xl p-6 relative">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">
            {{ $cliente ? 'Editar Cliente' : 'Adicionar Novo Cliente' }}
        </h2>

        <form method="POST"
              action="{{ $cliente ? route('clientes.update', $cliente->id) : route('clientes.create') }}">
            @csrf
            @if($cliente)
                @method('PUT')
            @endif

            <div class="space-y-4">
                {{-- Nome da Empresa e Email --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nomedaempresa" class="text-sm font-medium text-gray-700">Nome da Empresa</label>
                        <input type="text" id="nomedaempresa" name="nomedaempresa"
                               value="{{ old('nomedaempresa', $cliente->nomedaempresa ?? '') }}"
                               class="w-full border-gray-300 rounded-lg mt-1 p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email', $cliente->email ?? '') }}"
                               class="w-full border-gray-300 rounded-lg mt-1 p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                {{-- Telefone e Responsável --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="telefone" class="text-sm font-medium text-gray-700">Telefone</label>
                        <input type="text" id="telefone" name="telefone"
                               value="{{ old('telefone', $cliente->telefone ?? '') }}"
                               class="w-full border-gray-300 rounded-lg mt-1 p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="nomedoresponsavel" class="text-sm font-medium text-gray-700">Responsável</label>
                        <input type="text" id="nomedoresponsavel" name="nomedoresponsavel"
                               value="{{ old('nomedoresponsavel', $cliente->nomedoresponsavel ?? '') }}"
                               class="w-full border-gray-300 rounded-lg mt-1 p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                {{-- Estágio e Último Contato --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="estagio_de_contato" class="text-sm font-medium text-gray-700">Estágio de Contato</label>
                        <select id="estagio_de_contato" name="estagio_de_contato"
                                class="w-full border-gray-300 rounded-lg mt-1 p-2.5 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Selecione um Estágio</option>
                            @foreach (['lead'=>'Lead','prospeccao'=>'Prospecção','negociacao'=>'Negociação','cliente'=>'Cliente'] as $key => $label)
                                <option value="{{ $key }}" {{ old('estagio_de_contato', $cliente->estagio_de_contato ?? '') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="ultimo_contato_resultado" class="text-sm font-medium text-gray-700">Resultado Último Contato</label>
                        <input type="text" id="ultimo_contato_resultado" name="ultimo_contato_resultado"
                               value="{{ old('ultimo_contato_resultado', $cliente->ultimo_contato_resultado ?? '') }}"
                               class="w-full border-gray-300 rounded-lg mt-1 p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                {{-- Data, Quantidade e Nicho --}}
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="ultimoContato" class="text-sm font-medium text-gray-700">Data Último Contato</label>
                        <input type="date" id="ultimoContato" name="ultimoContato"
                               value="{{ old('ultimoContato', isset($cliente->ultimoContato) ? \Carbon\Carbon::parse($cliente->ultimoContato)->format('Y-m-d') : '') }}"
                               class="w-full border-gray-300 rounded-lg mt-1 p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="quantidadeDeContato" class="text-sm font-medium text-gray-700">Quant. Contatos</label>
                        <input type="number" id="quantidadeDeContato" name="quantidadeDeContato"
                               value="{{ old('quantidadeDeContato', $cliente->quantidadeDeContato ?? 0) }}"
                               min="0"
                               class="w-full border-gray-300 rounded-lg mt-1 p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label for="nicho_id" class="text-sm font-medium text-gray-700">Nicho</label>
                        <select id="nicho_id" name="nicho_id"
                                class="w-full border-gray-300 rounded-lg mt-1 p-2.5 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Selecione o Nicho</option>
                            @foreach ($nichos as $nicho)
                                <option value="{{ $nicho->id }}" {{ old('nicho_id', $cliente->nicho_id ?? '') == $nicho->id ? 'selected' : '' }}>
                                    {{ $nicho->nicho ?? $nicho->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Observação --}}
                <div>
                    <label for="observacao" class="text-sm font-medium text-gray-700">Observação</label>
                    <textarea id="observacao" name="observacao" rows="3"
                              class="w-full border-gray-300 rounded-lg mt-1 p-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('observacao', $cliente->observacao ?? '') }}</textarea>
                </div>
            </div>

            {{-- Botões --}}
            <div class="flex justify-end gap-3 mt-8">
                <x-secondary-button type="button" id="closeModal">
                      {{ __('Cancelar') }}
                </x-secondary-button>
               

                <x-primary-button>
                    {{ $cliente ? __('Atualizar') : __('Salvar') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>


<script>
// Abre modal
    document.getElementById('modalAddButton').addEventListener('click', () => {
        
        document.getElementById('modalAdd').classList.remove('hidden');
    });

   

    
</script>