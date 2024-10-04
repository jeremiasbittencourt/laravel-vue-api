<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
 
    public function index(Request $request)
    {
        $query = Cliente::query();

        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('cidade_id')) {
            $query->where('cidade_id', $request->cidade_id);
        }

        $clientes = $query->with('cidade')->get();

        return response()->json($clientes);

    }

 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cpfCnpj' => 'required|string|max:14',
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes',
            'celular' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'sexo' => 'required|string|in:Masculino,Feminino',
            'cidade_id' => 'required|exists:cidades,id'
        ]);

        $cliente = Cliente::create($validated);
    
        return response()->json($cliente, 201); 
    }


    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return response()->json($cliente);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cpfCnpj' => 'required|string|max:14',
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes,email,' . $id,
            'celular' => 'required|string|max:255',
            'cidade_id' => 'required|exists:cidades,id',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return response()->json(['message' => 'Cliente atualizado com sucesso!']);
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return response()->json(null, 204); 
    }
}
