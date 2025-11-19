<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EstagioContato;
use App\Models\Nicho;
use App\Models\Cliente;
use App\Services\RelatorioService;
class relatorioController extends Controller
{
    protected $relatorioService; 

    public function __construct(RelatorioService $relatorioService)
    {
     $this->relatorioService = $relatorioService;
    }

    
    public function index()
    {
      $dadoEstagio = $this->relatorioService->getEstagiosContato();
      $dadoNicho = $this->relatorioService->getNichos();

     return view("relatorio.show", ["labels" => $dadoEstagio["labels"]
     , "values" => $dadoEstagio["values"],
     "labelsNicho" => $dadoNicho["labelsNicho"] ,
     "valuesNicho" => $dadoNicho["valuesNicho"]
    ]);
    }
}
