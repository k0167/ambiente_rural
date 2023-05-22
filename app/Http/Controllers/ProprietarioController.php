<?php

namespace App\Http\Controllers;

use App\Models\Proprietario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProprietarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Proprietario/Index');
    }

    public function getProprietarios()
    {
        return Proprietario::orderBy('NOME_PROPRIETARIO', 'ASC')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nome_proprietario' => 'required|max:100',
                'fone1' => 'nullable|max:20',
                'fone2' => 'nullable|max:20',
                'fone3' => 'nullable|max:20',
                'tipo' => 'required|max:2'
            ]);
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 400);
        }

        Proprietario::create([
            'NOME_PROPRIETARIO' => $request->nome_proprietario,
            'FONE1' => $request->fone1,
            'FONE2' => $request->fone2,
            'FONE3' => $request->fone3,
            'TIPO' => $request->tipo

        ]);

        return response()->json(['message' => 'Proprietario criado com sucesso'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'cod_proprietario' => 'required|integer',
                'nome_proprietario' => 'nullable|max:100',
                'fone1' => 'nullable|max:20',
                'fone2' => 'nullable|max:20',
                'fone3' => 'nullable|max:20',
                'tipo' => 'required|max:2'

            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        try {
            $proprietario = Proprietario::find($request->cod_proprietario);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Proprietario nao encontrada'], 400);
        }

        if ($request->nome_proprietario) {
            $proprietario->NOME_PROPRIETARIO = $request->nome_proprietario;
        }
        if ($request->fone1) {
            $proprietario->FONE1 = $request->fone1;
        }
        if ($request->fone2) {
            $proprietario->FONE2 = $request->fone2;
        }
        if ($request->fone3) {
            $proprietario->FONE3 = $request->fone3;
        }
        if ($request->tipo) {
            $proprietario->TIPO = $request->tipo;
        }


        $proprietario->save();

        return response()->json(['message' => 'Proprietario Atualizada com sucesso'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $proprietario = Proprietario::find($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Proprietario nao encontrada'], 404);
        }

        $proprietario->delete();

        return response()->json([
            'message' => 'Proprietario deletada com sucesso',
        ], 200);
    }
}
