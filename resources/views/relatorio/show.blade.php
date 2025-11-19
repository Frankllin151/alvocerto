<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<x-slot name="header">
      
         <h2 class="text-2xl font-bold text-gray-800" id="page-title"> {{ __('Relatório') }}</h2>
    </x-slot>

   <div class="flex gap-4 w-full">

    <!-- Lado Esquerdo - nichoChart -->
    <div class="w-1/2 bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold mb-2">Nichos</h2>
        
        <canvas id="nichoChart"></canvas>
    </div>

    <!-- Lado Direito - nichoChart-->
    <div class="w-1/2 bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold mb-2">Estagio de Contato</h2>

        <canvas id="EstagioContatoChart"></canvas>
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
const nichoLabels = {!! json_encode($labelsNicho) !!};
    const nichoValues = {!! json_encode($valuesNicho) !!};
    console.log(nichoValues);
    
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


 new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                'Jan', 'Fev', 'Mar', 'Abr', 'Maio', 'Jun',
                'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
            ],
            datasets: [{
                label: 'Clientes por mês',
                data: [12, 19, 3, 5, 2, 15, 22, 30, 25, 18, 12, 20], // valores fictícios
                borderWidth: 1,
                tension: 0.4, // curva suave
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                pointRadius: 3,
                pointBackgroundColor: '#1D4ED8',
            }]
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

    // Meses fixos
    const meses = [
        'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
        'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
    ];

    // 10 cores
    const cores = [
        '#3B82F6', // azul
        '#EF4444', // vermelho
        '#10B981', // verde
        '#F59E0B', // amarelo
        '#6366F1', // roxo
        '#EC4899', // rosa
        '#14B8A6', // teal
        '#8B5CF6', // roxo claro
        '#F43F5E', // pink escuro
        '#0EA5E9'  // azul claro
    ];

    // Função para gerar valores fake de janeiro a dezembro
    function gerarValoresFake() {
        return Array.from({ length: 12 }, () => Math.floor(Math.random() * 50) + 10);
    }

    // Anos (últimos 10 anos)
    const anoAtual = new Date().getFullYear();
    const anos = Array.from({ length: 10 }, (_, i) => anoAtual - i);

    // Gerar datasets
    const datasets = anos.map((ano, index) => ({
        label: ano.toString(),
        data: gerarValoresFake(),
        borderColor: cores[index],
        backgroundColor: cores[index] + '33', // cor transparente
        borderWidth: 1,
        tension: 0.4,
        pointRadius: 3,
        pointBackgroundColor: cores[index]
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
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
  
</script>
</x-app-layout>