<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Produto/Index');
    }

    public function getProdutos()
    {
        return Produto::orderBy('DESC_PRODUTO', 'ASC')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'desc_produto' => 'required|max:100'
            ]);
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 400);
        }

        Produto::create([
            'DESC_PRODUTO' => $request->desc_produto,
        ]);

        return response()->json(['message' => 'Produto criado com sucesso'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'cod_produto' => 'required',
                'desc_produto' => 'nullable|max:100'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        try {
            $produto = Produto::find($request->cod_produto);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Produto nao encontrada'], 400);
        }

        $produto->DESC_PRODUTO = $request->desc_produto;

        $produto->save();

        return response()->json(['message' => 'Produto Atualizada com sucesso'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $produto = Produto::find($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Produto nao encontrada'], 404);
        }

        if($produto->producoes()->exists()){
            return response()->json(['message' => 'Produto nao pode ser deletada pois possui producoes'], 400);
        }

        $produto->delete();

        return response()->json([
            'message' => 'Produto deletada com sucesso',
        ], 200);
    }
}
