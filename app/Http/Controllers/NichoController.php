<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nicho;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NichoController extends Controller
{
    public function index()
    {
        $nichos = Nicho::orderBy('created_at', 'desc')->get()
        ->makeHidden(['created_at', 'updated_at']);
        return view('nicho.show', ['nichos' => $nichos]);
    }

    public function create(Request $request)
{
    // Validação
    $request->validate([
        'nicho' => 'required|string|max:255|unique:nichos,nicho',
    ]);

    try {
        // Tenta criar o nicho
        Nicho::create([
            'nicho' => $request->nicho,
        ]);

        // Redireciona com sucesso
        return redirect()->route('nichos.index')
            ->with('success', 'Nicho criado com sucesso.');
    } catch (\Exception $e) {
        // Em caso de erro, redireciona com mensagem de erro
        return redirect()->route('nichos.index')
            ->with('error', 'Ocorreu um erro ao criar o nicho. Tente novamente.');
    }
}


public function update(Request $request, $id)
{
    try {
        // 🔹 Validação dos campos recebidos
        $request->validate([
            'nicho' => 'required|string|max:255|unique:nichos,nicho,' . $id,
        ]);

        // 🔹 Busca o nicho, se não encontrar lança ModelNotFoundException
        $nicho = Nicho::findOrFail($id);

        // 🔹 Atualiza o registro
        $nicho->update([
            'nicho' => $request->nicho,
        ]);

        // 🔹 Retorna com mensagem de sucesso
        return redirect()
            ->route('nichos.index')
            ->with('success', 'Nicho atualizado com sucesso.');

    } catch (ValidationException $e) {
        // 🔸 Erros de validação
        return redirect()
            ->back()
            ->withErrors($e->validator)
            ->withInput();

    } catch (ModelNotFoundException $e) {
        // 🔸 Nicho não encontrado
        return redirect()
            ->route('nichos.index')
            ->with('error', 'Nicho não encontrado.');

    } catch (\Exception $e) {
        // 🔸 Qualquer outro erro inesperado
        return redirect()
            ->back()
            ->with('error', 'Erro ao atualizar o nicho: ' . $e->getMessage());
    }
}


public function destroy($id)
{
    try {
        // Tenta encontrar o nicho pelo ID
        $nicho = Nicho::findOrFail($id);

        // Tenta deletar o nicho
        $nicho->delete();

        // Redireciona com sucesso
        return redirect()->route('nichos.index')
                         ->with('success', 'Nicho deletado com sucesso.');

    } catch (ModelNotFoundException $e) {
        // Nicho não encontrado
        return redirect()->route('nichos.index')
                         ->with('error', 'Nicho não encontrado.');

    } catch (\Exception $e) {
        // Outro erro ao tentar deletar
        return redirect()->route('nichos.index')
                         ->with('error', 'Ocorreu um erro ao deletar o nicho. Tente novamente. Detalhe: ' . $e->getMessage());
    }
}

}
