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

   



  }
  public  function getPorMensalAnosEstagiosContato()
  {
    // Grafico por anos com variedade de Estagios de Contatos 
  }
}