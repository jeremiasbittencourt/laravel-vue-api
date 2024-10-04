<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Representante;


class RepresentanteController extends Controller
{

    public function index(Request $request)
    {
        $query = Representante::query();

        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }
        if ($request->filled('cidade_id')) {
            $query->where('cidade_id', $request->cidade_id);
        }

        $representantes = $query->with('cidade')->get();
        return response()->json($representantes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:representantes',
            'celular' => 'required|string|max:255',
            'local_trabalho' => 'required|string|max:255',
            'cidade_id' => 'required|exists:cidades,id'
        ]);

        $representante = Representante::create($validated);

        return response()->json($representante, 201); 
    }


    public function edit($id)
    {
        $representante = Representante::findOrFail($id);
        return response()->json($representante);
    }

   
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:representantes,email,' . $id,
            'celular' => 'required|string|max:255',
            'local_trabalho' => 'required|string|max:255',
            'cidade_id' => 'required|exists:cidades,id',
        ]);

        $representante = Representante::findOrFail($id);
        $representante->update($request->all());

        return response()->json(['message' => 'Representante atualizado com sucesso!']);
    }

    public function destroy($id)
    {
        $representante = Representante::findOrFail($id);
        $representante->delete();

        return response()->json(['message' => 'Representante excluído com sucesso!']);
    }
}
