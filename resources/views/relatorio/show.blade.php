<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<x-slot name="header">
      
         <h2 class="text-2xl font-bold text-gray-800" id="page-title"> {{ __('Relatório') }}</h2>
    </x-slot>

   <div class="flex gap-4 w-full">

    <!-- Lado Esquerdo - nichoChart -->
    <div class="w-1/2 bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold mb-2">Nichos</h2>
        @if(!empty($labelsNicho) && !empty($valuesNicho))
      
           <div id="nichoEmpty" class="text-center text-gray-500 py-12">Dados ainda não existem</div>
        @else 
              <canvas id="nichoChart"></canvas>
        @endif

       
    </div>

    <!-- Lado Direito - nichoChart-->
    <div class="w-1/2 bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold mb-2">Estagio de Contato</h2>
         @if(!empty($labels) && !empty($values))
          <div id="nichoEmpty"  class="text-center text-gray-500 py-12">Dados ainda não existem</div>
         @else 
        <canvas id="EstagioContatoChart"></canvas>
         @endif

     
    </div>

</div>

<div class="flex gap-4 w-full">
<!-- Lado Esquerdo - nichoChart -->
    <div class="w-1/2 bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold mb-2">Mensal Nichos</h2>
        <canvas id="mensalChartAnual"></canvas>
    </div>

    <!-- Lado Direito - nichoChart-->
    <div class="w-1/2 bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold mb-2">Mensal Estagio de Contato por anos</h2>
        <canvas id="chart10Anos"></canvas>
    </div>
</div>



<script>
    // ---------- NICHO  CHART ----------
    const pieCtx = document.getElementById('nichoChart');
const nichoLabels = {!! json_encode($labelsNicho ?? []) !!};
    const nichoValues = {!! json_encode($valuesNicho ?? []) !!};
    
    
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: nichoLabels,
            datasets: [{
                data:nichoValues,
                backgroundColor: [
                    '#6366F1',
                    '#10B981',
                    '#F59E0B',
                    '#EF4444'
                ]
            }]
        }
    });



    // ---------- ESTAGIOCONTATOCHART CHART ----------
    const polarCtx = document.getElementById('EstagioContatoChart');
const chartLabels = {!! json_encode($labels) !!};
    const chartValues = {!! json_encode($values) !!};
    new Chart(polarCtx, {
        type: 'polarArea',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartValues,
                backgroundColor: [
                    '#3B82F6',
                    '#F97316',
                    '#34D399'
                ]
            }]
        }
    });

// ---------- MENSAL CHART ----------
 const ctx = document.getElementById("mensalChartAnual");
 const nichoDataMensal = {!! json_encode($dadosNichosMensal) !!}; 

 const dadoNichoMensal = nichoDataMensal.map(nicho => ({
    label: nicho.label,
    data: nicho.data,
    borderWidth: 2,
    tension: 0.4,
    borderColor: getRandomColor(),
    backgroundColor: "transparent",
    pointRadius: 3
}));


function getRandomColor() {
    return `hsl(${Math.floor(Math.random() * 360)}, 70%, 50%)`;
}

new Chart(ctx, {
    type: 'line',
    data: {
        labels: [
            'Jan', 'Fev', 'Mar', 'Abr', 'Maio', 'Jun',
            'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
        ],
        datasets: dadoNichoMensal 
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

    // ------- Chart 10 anos ------
    const ctx10 = document.getElementById('chart10Anos');

    // Dados vindo do backend
    const estagios = {!! json_encode($EstagioDeContatoDezAnos) !!};

    console.log(estagios);

    // Meses fixos
    const meses = [
        'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
        'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
    ];

    // 10 cores
    const cores = [
        '#3B82F6', '#EF4444', '#10B981', '#F59E0B',
        '#6366F1', '#EC4899', '#14B8A6', '#8B5CF6',
        '#F43F5E', '#0EA5E9'
    ];

    // Você quer exibir SOMENTE UM estágio por vez (melhor UX)
    // Então vamos pegar o primeiro estágio como exemplo:
    const estagio = estagios[0];

    const anos = Object.keys(estagio.data);

    // Criar datasets reais
    const datasets = anos.map((ano, index) => ({
        label: ano,
        data: estagio.data[ano], // valores reais
        borderColor: cores[index % cores.length],
        backgroundColor: cores[index % cores.length] + "33",
        borderWidth: 2,
        tension: 0.4,
        pointRadius: 3,
        pointBackgroundColor: cores[index % cores.length]
    }));

    // Criar gráfico
    new Chart(ctx10, {
        type: 'line',
        data: {
            labels: meses,
            datasets: datasets
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
  
</script>
</x-app-layout>