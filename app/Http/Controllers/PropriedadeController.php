<?php

namespace App\Http\Controllers;

use App\Models\Propriedade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class PropriedadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Propriedade/Index');
    }

    public function getPropriedades()
    {
        return Propriedade::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nome_propriedade' => 'required|max:100',
                'area' => 'required|max:8',
                'distancia_do_munic' => 'required|max:8',
                'valor_aquisicao' => 'required|max:12',
            ]);
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 400);
        }

        return Propriedade::create([
            'NOME_PROPRIEDADE' => $request->nome_propriedade,
            'AREA' => $request->area,
            'DISTANCIA_DO_MUNIC' => $request->distancia_do_munic,
            'VALOR_AQUISICAO' => $request->valor_aquisicao,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'cod_propriedade' => 'required',
                'nome_propriedade' => 'nullable|max:100',
                'area' => 'nullable|max:9',
                'distancia_do_munic' => 'nullable|max:9',
                'valor_aquisicao' => 'nullable|max:13',
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        try {
            $propriedade = Propriedade::find($request->cod_propriedade);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Propriedade nao encontrada'], 400);
        }

        if ($request->nome_propriedade) {
            $propriedade->NOME_PROPRIEDADE = $request->nome_propriedade;
        }
        if ($request->area) {
            $propriedade->AREA = $request->area;
        }
        if ($request->distancia_do_munic) {
            $propriedade->DISTANCIA_DO_MUNIC = $request->distancia_do_munic;
        }
        if ($request->valor_aquisicao) {
            $propriedade->VALOR_AQUISICAO = $request->valor_aquisicao;
        }

        $propriedade->save();

        return response()->json(['message' => 'Propriedade Atualizada com sucesso'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $propriedade = Propriedade::find($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Propriedade nao encontrada'], 404);
        }

        if($propriedade->producoes()->exists())
        {
            return response()->json(['message' => 'Propriedade nao pode ser deletada pois possui producoes'], 400);
        }

        $propriedade->delete();

        return response()->json([
            'message' => 'Propriedade deletada com sucesso',
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Propriedade $propriedade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Propriedade $propriedade)
    {

        //
    }
}