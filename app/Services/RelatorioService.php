<?php 

namespace App\Services;

use App\Models\Cliente;
use App\Models\Nicho;
use App\Models\EstagioContato;
use Illuminate\Support\Facades\DB;

class RelatorioService 
{
    public function getEstagiosContato()
    {
       $anoAtual = date("Y");

    $quantidades = Cliente::select("estagio_de_contato", DB::raw("COUNT(*) as total"))
        ->whereYear("updated_at", $anoAtual)
        ->groupBy("estagio_de_contato")
        ->pluck("total", "estagio_de_contato")
        ->toArray();

    return [
        "labels" => array_keys($quantidades),
        "values" => array_values($quantidades),
    ];
    }

   public function getNichos()
   {
    $nicho = Nicho::all();
      $anoAtual = date("Y");
      
  $labelsNicho = [];
$valuesNicho = [];

foreach($nicho as $n){
    $labelsNicho[] = $n->nicho; 

    $total = Cliente::where("nicho_id", $n->id)
    ->whereYear("updated_at", $anoAtual)->count();

    $valuesNicho[] = $total;
}


  return [
    "labelsNicho" => $labelsNicho , 
    "valuesNicho" => $valuesNicho
  ];
   }


  public function getMensalNichos()
  {
    /// Grafico  por ano atual com variedade de nichos pelo 12 meses
   $ano = date("Y");

   $nichos = Nicho::all();

   $meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

   $datasets = [];

   foreach($nichos as $nicho){
    $totaisPorMes = array_fill(0,12,0); 

    $resultados = Cliente::select(
                DB::raw("MONTH(ultimoContato) as mes"),
                DB::raw("COUNT(*) as total")
            )
            ->where("nicho_id", $nicho->id)
            ->whereYear("ultimoContato", $ano)
            ->groupBy(DB::raw("MONTH(ultimoContato)"))
            ->get();

            foreach ($resultados as $r) {
            $totaisPorMes[$r->mes - 1] = $r->total;
        }

        $datasets[] = [
            "label" => $nicho->nicho,
            "data"  => $totaisPorMes,
        ];

   }

   return $datasets;

  }
  public function getPorMensalAnosEstagiosContato()
{
    $anoAtual = date("Y");
    $anos = range($anoAtual - 9, $anoAtual); // últimos 10 anos

    $estagios = Cliente::select("estagio_de_contato")
        ->distinct()
        ->pluck("estagio_de_contato");

    $resultado = [];

    foreach ($estagios as $estagio) {

        $dataset = [
            "label" => $estagio,
            "data"  => []
        ];

        foreach ($anos as $ano) {

            // valores Jan..Dez -> array de 12 posições
            $mensal = Cliente::select(DB::raw("MONTH(ultimoContato) as mes"), DB::raw("COUNT(*) as total"))
                ->where("estagio_de_contato", $estagio)
                ->whereYear("ultimoContato", $ano)
                ->groupBy("mes")
                ->pluck("total", "mes")
                ->toArray();

            // preencher 12 posições
            $dadosMes = [];
            for ($m = 1; $m <= 12; $m++) {
                $dadosMes[] = $mensal[$m] ?? 0;
            }

            // adiciona o array de um ano dentro do dataset
            $dataset["data"][$ano] = $dadosMes;
        }

        $resultado[] = $dataset;
    }

    return $resultado;
}
}