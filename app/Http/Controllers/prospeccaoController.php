<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Validation\ValidationException;

class prospeccaoController extends Controller
{
    public function index()
    {
        $cliente= Cliente::all();
      
        // Passa para a view
        return view('dashboard', ['cliente' => $cliente]);
    }

   public function create(Request $request)
{
    // Define as regras de validação
    $rules = [
        '_token' => 'required|string', 
        'nomedaempresa' => 'required|string|max:255', 
        'email' => 'required|email|max:255', 
        'telefone' => 'nullable|string|max:15', 
        'nomedoresponsavel' => 'required|string|max:255', 
        
        'estagio_de_contato' => 'nullable|string|max:50', 
        'ultimo_contato_resultado' => 'nullable|string|in:Sem contato,Sucesso,Falha,Outro', 
        'ultimoContato' => 'nullable|date', 
        'quantidadeDeContato' => 'nullable|integer|min:0', 
        'nicho_id' => 'nullable|integer|exists:nichos,id', 
        'observacao' => 'nullable|string',
    ];

    // Define as mensagens personalizadas
    $messages = [
        'required' => 'O campo :attribute é obrigatório.',
        'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
        'integer' => 'O campo :attribute deve ser um número inteiro.',
        'max' => 'O campo :attribute não pode ter mais que :max caracteres.',
        'date' => 'O campo :attribute deve ser uma data válida.',
        'exists' => 'O :attribute selecionado é inválido.',
        'ultimo_contato_resultado.in' => 'O valor selecionado para :attribute é inválido.',
    ];

    // **1. VALIDAÇÃO:**
    // Se falhar, o Laravel **automaticamente** redireciona para a página anterior
    // com os erros ($errors) e os dados antigos (old()).
    $validatedData = $request->validate($rules, $messages);

   
    unset($validatedData['_token']);
    
    try {
      
        Cliente::create($validatedData); 
    
        return redirect()->route('dashboard')
                         ->with('success', 'Nova prospecção de cliente adicionada com sucesso!');

    } catch (\Exception $e) {
       
        return redirect()->back()
                         ->withInput()
                         ->with('error', 'Ocorreu um erro ao salvar a prospecção. Tente novamente. Detalhe: ' . $e->getMessage());
    }
}
}
