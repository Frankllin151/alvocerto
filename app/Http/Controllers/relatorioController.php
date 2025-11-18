<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class relatorioController extends Controller
{
    public function index()
    {
        return view("relatorio.show");
    }
}
