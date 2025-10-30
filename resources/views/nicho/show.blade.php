<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Todos os Nichos') }}
        </h2>
    </x-slot>

@if (session('success') || session('error'))
    <div 
        x-data="{ show: true }" 
        x-show="show"
        x-init="setTimeout(() => show = false, 5000)"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-[-10px]"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-[-10px]"
        class="fixed top-4 right-4 z-50 w-auto max-w-sm rounded-lg shadow-lg p-4
            {{ session('success') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
    >
        <div class="flex items-center justify-between">
            <p class="font-medium text-sm">
                {{ session('success') ?? session('error') }}
            </p>

            <button 
                @click="show = false"
                class="ml-3 text-gray-500 hover:text-gray-700"
            >
                x
            </button>
        </div>
    </div>
@endif
<div class="flex justify-between items-center">
     <h1 class="text-2xl font-bold mb-4">Nichos</h1>
    <x-primary-button 
    x-data
    @click="$dispatch('open-modal', 'modal-add-nicho')"
    >
                {{ __('Novo') }}
            </x-primary-button>
 </div>
 
 
 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($nichos as $nicho)
        <div class="bg-white shadow-md rounded-2xl p-5 mb-4 flex flex-col justify-between relative hover:shadow-lg transition-shadow duration-300">
            
            <!-- Título do nicho -->
            <p class="text-lg  text-gray-800 mb-2">
                {{ $nicho->nicho ?? 'Não informado' }}
            </p>

            <!-- Dropdown de ações -->
            <div class="relative mt-auto flex justify-end">
                <button
                    onclick="toggleDropdown(this)"
                    class="px-3 py-1 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200"
                >
                    ⋮
                </button>

                <div class="hidden absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-xl shadow-lg z-10">
                    <button
                        class="w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-blue-50"
                       x-data
                        @click="$dispatch('open-modal', '{{ 'edita-nicho' . $nicho->id }}')"
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                        onclick="EditarNicho({{ $nicho->id }})"
                    >
                        ✏️ Editar
                    </button>
                    <button
                        x-data
                        @click="$dispatch('open-modal', '{{ 'confirm-delete-' . $nicho->id }}')"
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                        onclick="excluirNicho({{ $nicho->id }})"
                    >
                        🗑️ Excluir
                    </button>
                </div>
            </div>

        </div>
           <!--- Modal de confirmação de exclusão -->
        <x-modal name="confirm-delete-{{ $nicho->id }}" maxWidth="md">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-800">
                    Confirmar exclusão
                </h2>

                <p class="mt-2 text-sm text-gray-600">
                    Tem certeza que deseja excluir o nicho <strong>{{ $nicho->nicho ?? 'sem nome' }}</strong>?
                    Essa ação <span class="text-red-600 font-semibold">não poderá ser desfeita</span>.
                </p>

                <div class="mt-6 flex justify-end gap-3">
                    <!-- Botão cancelar -->
                    <x-secondary-button type="button" @click="$dispatch('close-modal', 'confirm-delete-{{ $nicho->id }}')">
                        {{ __('Cancelar') }}
                    </x-secondary-button>
                    <!-- Formulário de exclusão -->
                    <form method="POST" action="{{route('nichos.destroy', $nicho->id)}}">
                        @csrf
                        @method('DELETE')
                        <x-primary-button type="submit">
                            {{ __('Excluir') }}
                        </x-primary-button>
                       
                    </form>
                </div>
            </div>
        </x-modal>
         <!--- Modal de confirmação de exclusão final -->
        <!--- Modal de edição de nicho -->
        <x-modal name="edita-nicho{{ $nicho->id }}" maxWidth="md">
             <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                   Editar Nicho
                </h2>

                <form method="POST" action="{{ route('nichos.update', $nicho->id) }}">
                     @method('PUT')
                    @csrf

                    <div class="mb-4">
                        <label for="nicho" class="block text-sm font-medium text-gray-700">Nicho</label>
                        <input type="text" name="nicho" id="nicho" required
                        value="{{$nicho->nicho}}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="flex justify-end">
                        <x-secondary-button type="button" @click="$dispatch('close-modal', 'edita-nicho{{$nicho->id}}')" class="mr-2">
                            {{ __('Cancelar') }}
                        </x-secondary-button>
                       <x-primary-button type="submit">
                            {{ __('Salvar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>   
        
    @endforeach
</div>


 <x-modal name="modal-add-nicho" maxWidth="md">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Adicionar Novo Nicho
                </h2>

                <form method="POST" action="{{ route('nichos.create') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="nicho" class="block text-sm font-medium text-gray-700">Nicho</label>
                        <input type="text" name="nicho" id="nicho" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="flex justify-end">
                        <x-secondary-button type="button" @click="$dispatch('close-modal', 'modal-add-nicho')" class="mr-2">
                            {{ __('Cancelar') }}
                        </x-secondary-button>
                       <x-primary-button type="submit">
                            {{ __('Salvar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>

<script>
    function toggleDropdown(button) {
        const dropdown = button.nextElementSibling;
        dropdown.classList.toggle("hidden");

        // Fecha outros dropdowns abertos
        document.querySelectorAll(".relative .absolute").forEach((el) => {
            if (el !== dropdown) el.classList.add("hidden");
        });
    }

    // Fecha dropdown ao clicar fora
    document.addEventListener("click", function (e) {
        const isDropdown = e.target.closest(".relative");
        if (!isDropdown) {
            document.querySelectorAll(".relative .absolute").forEach((el) => {
                el.classList.add("hidden");
            });
        }
    });
</script>
</x-app-layout>