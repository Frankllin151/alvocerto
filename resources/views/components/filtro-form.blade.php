@props(['nicho', 'estagioContato'])

<div class="p-6 bg-white shadow-md rounded-lg">
    {{-- O método GET garante que os dados sejam enviados na query string da URL --}}
    <form method="GET" action="{{ url()->current() }}" class="space-y-4">
        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">
            <i class="fas fa-filter mr-2"></i> Filtros
        </h3>

        {{-- 1. Estágio de Contato (Select) --}}
        <div>
            <x-input-label for="estagio_contato" :value="__('Estágio de Contato')" />
            <select name="estagio_contato" id="estagio_contato" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                {{-- Opção para limpar o filtro --}}
                <option value="">Todos os Estágios</option>
                
                @foreach ($estagioContato as $estagio)
                    {{-- Usamos request('nome_do_campo') para preencher o valor selecionado da URL --}}
                    <option value="{{ $estagio->nome }}" {{ (string) $estagio->id === request('estagio_contato') ? 'selected' : '' }}>
                        {{ $estagio->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 2. Quantidade de Contato (Select/Input com Validação) --}}
        <div>
            <x-input-label for="quantidade_contato" :value="__('Qtd. de Contatos (0 a 10)')" />
            <select name="quantidade_contato" id="quantidade_contato" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">Todas as Quantidades</option>
                @for ($i = 0; $i <= 10; $i++)
                    <option value="{{ $i }}" {{ (string) $i === request('quantidade_contato') ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
        </div>

        {{-- 3. Data do Último Contato (Date Input) --}}
        <div>
            <x-input-label for="data_contato" :value="__('Data do Último Contato')" />
            {{-- O type="date" e o value com request() garantem o preenchimento automático --}}
            <x-text-input 
                id="data_contato" 
                name="data_contato" 
                type="date" 
                class="mt-1 block w-full" 
                :value="request('data_contato')" 
            />
        </div>

        {{-- 4. Nicho (Select) --}}
        <div>
            <x-input-label for="nicho" :value="__('Nicho')" />
            <select name="nicho" id="nicho" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">Todos os Nichos</option>
                @foreach ($nicho as $item)
                    <option value="{{ $item->id }}" {{ (string) $item->id === request('nicho') ? 'selected' : '' }}>
                        {{ $item->nicho}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-between items-center">
            @php
    use Carbon\Carbon;
    Carbon::setLocale('pt_BR');
@endphp
            <div>  <x-input-label for="mes" :value="__('Mês')" />
    <select name="mes" id="mes" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="">Todos os Meses</option>
        @for ($m = 1; $m <= 12; $m++)
            <option value="{{ $m }}" {{ (string) $m === request('mes') ? 'selected' : '' }}>
                {{ Carbon::createFromDate(null, $m, 1)->translatedFormat('F') }}
            </option>
        @endfor
    </select></div>
 <div>
    <x-input-label for="ano" :value="__('Ano')" />
    <select name="ano" id="ano" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="">Todos os Anos</option>
        @php
            $anoAtual = now()->year;
        @endphp
        @for ($ano = $anoAtual; $ano >= $anoAtual - 5; $ano--)
            <option value="{{ $ano }}" {{ (string) $ano === request('ano') ? 'selected' : '' }}>
                {{ $ano }}
            </option>
        @endfor
    </select>
</div>

        </div>


        {{-- Botões de Ação --}}
        <div class="flex justify-between pt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Aplicar Filtros
            </button>
            
            {{-- Botão para Limpar os Filtros: Redireciona para a URL base --}}
            @if (request()->query())
                <a href="{{ url()->current() }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    Limpar Filtros
                </a>
            @endif
        </div>
    </form>
</div>