<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EstagioContato;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
class EstagioContatoController extends Controller
{
 
 
 public function index()
 {

    $data = EstagioContato::orderBy('updated_at', 'desc')->get();
        return view('estagio_de_contato.show', ['estagios' => $data]);
 }
 public function create(Request $request)
 { 
  $request->validate([
      'estagio-contato' => 'required|string|max:255|unique:estagio_contato,nome',
  ]);
  try {
      // Tenta criar o estágio de contato
      EstagioContato::create([
          'nome' => $request->input('estagio-contato'),
      ]);

      // Redireciona com sucesso
      return redirect()->route('estagio.de.contato.index')
          ->with('success', 'Estágio de Contato criado com sucesso.');
  } catch (\Exception $e) {
      // Em caso de erro, redireciona com mensagem de erro
      return redirect()->route('estagio.de.contato.index')
          ->with('error', 'Ocorreu um erro ao criar o Estágio de Contato. Tente novamente.');
  }

}
 
   public function update(Request $request, $id)
{
    
    try {
       
        $request->validate([ 
            'estagio-contato' => 'required|string|max:255', 
        ]);

       
        $item = EstagioContato::findOrFail($id);

        
        $item->update([
            'nome' => $request->input('estagio-contato'), 
           
        ]);

        return redirect()->route('estagio.de.contato.index')
                         ->with('success', 'Estágio  foi atualizado com sucesso!');

    } catch (ModelNotFoundException $e) {
       
        return redirect()->route('estagio.de.contato.index')
                         ->with('error', 'Erro: Estágio que você tentou atualizar não foi encontrado.');

    } catch (\Exception $e) {
       
        return dd($e->getMessage());
    }
}


public function destroy($id)
{
    try {
        
        $estagio = EstagioContato::findOrFail($id);

        $estagio->delete();

        return redirect()->route('estagio.de.contato.index')
            ->with('success', 'Estágio de Contato deletado com sucesso.');

    } catch (ModelNotFoundException $e) {
        
        return redirect()->route('estagio.de.contato.index')
            ->with('error', 'Estágio de Contato não encontrado.');

    } catch (Exception $e) {
       
        return redirect()->route('estagio.de.contato.index')
            ->with('error', 'Ocorreu um erro ao deletar o Estágio de Contato. Tente novamente.');
    }
}


}
