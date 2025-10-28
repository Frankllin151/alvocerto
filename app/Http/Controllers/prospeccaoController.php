<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PhpParser\Node\Expr\AssignOp\Mod;

class prospeccaoController extends Controller
{
    public function index(Request $request)
    {

        $clienteId = $request->query("id");

        if($clienteId){
            try {
                 $clienteId = Cliente::with("nicho")->findOrFail($clienteId);
                   return view('dashboard', ['clienteId' => $clienteId , 'cliente' => Cliente::all()]);
            } catch(ModelNotFoundException $e){
                 return redirect()->route('dashboard')->with('error', 'Cliente não encontrado.');
            }
        }

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



    public function show($id)
    {
        $cliente = Cliente::with("nicho")->findOrFail($id);
        return view('visualizar', ['cliente' => $cliente]);
    }

  public function update(Request $request, $id)
{

  
    try {
        // 1. Tenta encontrar o cliente (lança ModelNotFoundException se não existir)
        $cliente = Cliente::findOrFail($id);

        // 2. Validação dos Dados (lança ValidationException se falhar)
        $validatedData = $request->validate([
            'nomedaempresa' => 'required|string|max:255',
            'email' => 'nullable|string|max:200' ,
            'telefone' => 'nullable|string|max:20',
            'nomedoresponsavel' => 'required|string|max:255',
            'estagio_de_contato' => 'required|string',
            'ultimo_contato_resultado' => 'nullable|string|max:255',
            'ultimoContato' => 'nullable|date',
            'quantidadeDeContato' => 'nullable|integer|min:0',
            'observacao' => 'nullable|string',
            'nicho_id' => 'nullable|integer|exists:nichos,id',
        ]);

        // 3. Atualiza o cliente com os dados validados
        $cliente->update($validatedData);

        // 4. Retorno de Sucesso
        return redirect()->route('clientes.show', ['id' => $id])
                         ->with('success', 'Cliente atualizado com sucesso.');

    } catch (ModelNotFoundException $e) {
        // Trata 404 - Cliente não encontrado
        return redirect()->route('dashboard')
                         ->with('error', 'Cliente não encontrado.');

    } catch (ValidationException $e) {
        // Trata 422 - Erros de validação
        return dd($e->errors());

    } catch (\Exception $e) {
        // Trata 500 - Qualquer outro erro interno
        return dd($e->getMessage());
    }
}
}
