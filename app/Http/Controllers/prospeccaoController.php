<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Container\Attributes\Log;

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
        return redirect()->back()
                         ->withErrors($e->errors())
                         ->withInput();

    } catch (\Exception $e) {
        // Trata 500 - Qualquer outro erro interno
        return dd($e->getMessage());
    }
}



public function destroy($id) {
    try {
        // Tenta encontrar o cliente
        $cliente = Cliente::findOrFail($id);

        // Deleta o cliente
        $cliente->delete();

        // Redireciona com mensagem de sucesso
        return redirect()->route('dashboard')
                         ->with('success', 'Cliente deletado com sucesso.');

    } catch (ModelNotFoundException $e) {
        // Redireciona com mensagem de erro se o cliente não for encontrado
        return redirect()->route('dashboard')
                         ->with('error', 'Cliente não encontrado.');

    } catch (\Exception $e) {
        // Redireciona com mensagem de erro para qualquer outro problema
        return redirect()->route('dashboard')
                         ->with('error', 'Ocorreu um erro ao deletar o cliente. Tente novamente.');
    }
}

public function importar(Request $request)
{
   

    try {
     
        $request->validate([
          
            'arquivo_excel' => 'required|file|mimes:xlsx,xls,csv', 
            'nicho_id' => 'required|exists:nichos,id',
        ]);

        $file = $request->file('arquivo_excel');

      
        $path = $file->getRealPath();
      
        $data = \Maatwebsite\Excel\Facades\Excel::toArray([], $file);

       
        $rows = $data[0];

        foreach ($rows as $index => $row) {
       
            if ($index === 0) {
                continue;
            }

         
            Cliente::create([
                'nomedaempresa' => $row[0] ?? null,
                'email' => $row[1] ?? null,
                'telefone' => $row[2] ?? null,
                'nomedoresponsavel' => $row[3] ?? null,
                'estagio_de_contato' => $row[4] ?? null,
                'ultimo_contato_resultado' => $row[5] ?? null,
            
                'ultimoContato' => isset($row[6]) && $row[6] ? \Carbon\Carbon::parse($row[6]) : null,
                'quantidadeDeContato' => $row[7] ?? null,
                'nicho_id' => $request->input('nicho_id'),
            
                'observacao' => $row[8] ?? null, 
            ]);
        }

        // 3. Sucesso
        return redirect()->route('dashboard')
                         ->with('success', 'Clientes importados com sucesso!');

    } catch (ValidationException $e) {
       
        return redirect()->back()
                         ->withErrors($e->errors())
                         ->withInput()->with('error', 'Erro na validação do arquivo. Verifique os dados e tente novamente.' );

    } catch (\Exception $e) {
        
        return redirect()->back()
                         ->with('error', 'Ocorreu um erro ao processar os dados do arquivo. Verifique o log para detalhes.' . $e->getMessage());
    }
}

}