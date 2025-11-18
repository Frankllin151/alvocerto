<x-app-layout>
<x-slot name="header">
      
         <h2 class="text-2xl font-bold text-gray-800" id="page-title"> {{ __('Relatório') }}</h2>
    </x-slot>

    <div class="flex gap-4 w-full">
        <!--Lado esquerdo-->
     <div class="w-1/2 bg-white p-6 rounded-xl shadow-md ">
    <h2 class="text-xl font-semibold mb-2">Esquerda</h2>
        <p class="text-slate-600">Conteúdo da div da esquerda...</p>
    </div>

    <!---Lado direito-->
    <div class="w-1/2 bg-white p-6 rounded-xl shadow-md">
    <h2 class="text-xl font-semibold mb-2">Direita</h2>
        <p class="text-slate-600">Conteúdo da div da direita...</p>
    
    </div>
    </div>
</x-app-layout>