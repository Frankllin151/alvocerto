<x-app-layout>
    <x-slot name="header">
      
         <h2 class="text-2xl font-bold text-gray-800" id="page-title"> {{ __('Inicio') }}</h2>
    </x-slot>
 <div class="flex justify-between">
   <h2 class="text-xl font-semibold mb-4">Detalhes do Cliente</h2>
   <div>
    <x-primary-button id="modalAddButton">
        Editar
    </x-primary-button>
    <x-primary-button 
    class="bg-red-500"
    onclick="window.location=''">
        Excluir
    </x-primary-button>
   </div>
 </div>
    <div class="bg-white shadow-md rounded-xl p-3">
        <h3 class="text-lg font-bold">Empresa: {{ $cliente['nomedaempresa'] }}</h3>
        <p><strong>Responsável:</strong> {{ $cliente['nomedoresponsavel'] }}</p>
        <p><strong>Email:</strong> {{ $cliente['email'] }}</p>
        <p><strong>Telefone:</strong> {{ $cliente['telefone'] }}</p>
        <p><strong>Estágio:</strong> {{ $cliente['estagio_de_contato'] ?? 'Sem estágio' }}</p>
        <p><strong>Último contato:</strong> {{ $cliente['ultimoContato'] ?? 'Sem registro' }}</p>
        <p><strong>Resultado do último contato:</strong> {{ $cliente['ultimo_contato_resultado'] }}</p>
        <p><strong>Quantidade de contatos:</strong> {{ $cliente['quantidadeDeContato'] }}</p>
        <p><strong>Nicho:</strong> {{ $cliente['nicho']['nicho'] }}</p>
        <p><strong>Observação:</strong> {{ $cliente['observacao'] }}</p>
    </div>



    <x-modal-client :cliente="$cliente" />
    </x-app-layout>