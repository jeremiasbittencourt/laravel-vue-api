<?php

namespace App\Http\Controllers;
use App\Models\Cidade;

use Illuminate\Http\Request;

class CidadeController extends Controller
{

    public function index(Request $request)
    {
        $query = Cidade::query();
    
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }
    
        if ($request->filled('estado')) {
            $query->where('estado', 'like', '%' . $request->estado . '%');
        }
    
        $cidades = $query->get();
    
        return response()->json($cidades);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
        ]);
    
        $cidade = Cidade::create($validated);
    
        return response()->json($cidade, 201); 
    }

   
    public function edit($id)
    {
        $cidade = Cidade::findOrFail($id);
        return response()->json($cidade);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
        ]);

        $cidade = Cidade::findOrFail($id);
        $cidade->update($request->all());

        return response()->json(['message' => 'Cidade atualizada com sucesso!']);
    }

    public function destroy($id)
    {
        $cidade = Cidade::findOrFail($id);
        $cidade->delete();

        return response()->json(['message' => 'Cidade excluída com sucesso!']);
    }
}
