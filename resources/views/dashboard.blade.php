<x-app-layout>
    <x-slot name="header">
      
         <h2 class="text-2xl font-bold text-gray-800" id="page-title"> {{ __('Inicio') }}</h2>
    </x-slot>
@props(['clienteId' => null])
<div class="flex justify-between items-center">
     <h1 class="text-2xl font-bold mb-4">Clientes</h1>
    <x-primary-button id="modalAddButton">
                {{ __('Novo') }}
            </x-primary-button>
 </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($cliente as $c)
        <div class="bg-white shadow-md rounded-2xl p-5 mb-4 flex justify-between items-start relative">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Empresa: {{ $c->nomedaempresa ?? 'Não informado' }}
                </h2>
                <p class="text-sm text-gray-500">Responsável: {{ $c->nomedoresponsavel ?? '—' }}</p>
                <p class="text-sm text-gray-500">Email: {{ $c->email ?? '—' }}</p>
                <p class="text-sm text-gray-500">Telefone: {{ $c->telefone ?? '—' }}</p>
                <p class="text-sm text-gray-500 mt-1">
                    Estágio:
                    <span class="font-medium text-blue-600">
                        {{ $c->estagio_de_contato ?? 'Sem estágio' }}
                    </span>
                </p>
                <p class="text-sm text-gray-500">
    Último Contato:
    {{ 
        $c->ultimoContato 
        ? $c->ultimoContato->format('d/m/Y H:i') 
        : 'N/A' 
    }}
</p>
            </div>

            <!-- Botão 3 pontinhos -->
            <div class="relative">
                <button
                    class="text-gray-500 hover:text-gray-700 focus:outline-none"
                    onclick="toggleDropdown(this)"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 12h.01M12 12h.01M18 12h.01" />
                    </svg>
                </button>

                <!-- Dropdown -->
                <div
                    class="hidden absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-xl shadow-lg z-10"
                >
                    <button
                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        onclick="visualizarCliente({{ $c->id }})"
                    >
                        👁️ Visualizar
                    </button>
                    <button
                        class="w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-blue-50"
                        onclick="editarCliente({{ $c->id }})"
                    >
                        ✏️ Editar
                    </button>
                    <button
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                        onclick="excluirCliente({{ $c->id }})"
                    >
                        🗑️ Excluir
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    
<x-modal-client :cliente="$clienteId"  />
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

    // Ações (exemplo — você pode substituir por modais ou rotas)
    function visualizarCliente(id) {
        window.location.href = `dashboard/clientes/${id}`;
    }

    function editarCliente(id) {
    // Alterna a classe e guarda o estado (true = modal visível)
    const modal = document.getElementById('modalAdd');
    const isVisible = !modal.classList.contains('hidden');
    
    // Salva o estado como string "true" ou "false"
    localStorage.setItem('stateModal', isVisible ? 'false' : 'true');
    
    // Redireciona depois de salvar
    window.location.href = `dashboard?id=${id}`;
}

// Essa função deve ser chamada quando a página carregar
function editaModal() {
    const modal = document.getElementById('modalAdd');
    const stateModal = localStorage.getItem('stateModal');

    if (stateModal === 'true') {
        modal.classList.remove('hidden'); 
    } else {
        modal.classList.add('hidden'); 
    }

    
    localStorage.removeItem('stateModal');
}

// Chama quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', editaModal);



    function excluirCliente(id) {
        if (confirm('Tem certeza que deseja excluir este cliente?')) {
            fetch(`/clientes/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            }).then(res => location.reload());
        }
    }
 // Fecha modal
    document.getElementById('closeModal').addEventListener('click', () => {
        document.getElementById('modalAdd').classList.add('hidden');
          window.location.href = `dashboard`;
    });

</script>
</x-app-layout>
