<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use App\Models\Propriedade;
use App\Models\Proprietario;
use App\Models\ProprietarioPropriedade;
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
        $propriedade = Propriedade::all();
        return response()->json([
            'propriedades' => $propriedade,
            'municipios' => Municipio::all()
        ], 200);
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
                'cod_mun' => 'required',
            ]);
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 400);
        }

        return Propriedade::create([
            'NOME_PROPRIEDADE' => $request->nome_propriedade,
            'AREA' => $request->area,
            'DISTANCIA_DO_MUNIC' => $request->distancia_do_munic,
            'VALOR_AQUISICAO' => $request->valor_aquisicao,
            'COD_MUN' => $request->cod_mun,
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
                'cod_mun' => 'required',
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

        if ($request->cod_mun) {
            $propriedade->COD_MUN = $request->cod_mun;
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

        if ($propriedade->producoes()->exists()) {
            return response()->json(['message' => 'Propriedade nao pode ser deletada pois possui producoes'], 400);
        }

        if (ProprietarioPropriedade::where('COD_PROPRIED', $propriedade->COD_PROPRIEDADE)->count() > 0) {
            return response()->json(['message' => 'Propriedade nao pode ser deletado pois possui Donos vinculados'], 400);
        }

        $propriedade->delete();

        return response()->json([
            'message' => 'Propriedade deletada com sucesso',
        ], 200);
    }
}
