<?php

namespace App\Http\Controllers;

use App\Models\Producao;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProducaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($propriedade): Response
    {
        return Inertia::render('Propriedade/Producao', ['propriedade' => $propriedade]);
    }

    public function getProducoes($propriedade)
    {
        return response()->json(['propriedade'=>$propriedade,
                                 'produtos' => Produto::all(),
                                 'producao' => Producao::where('COD_PROPRIED', $propriedade)
                                               ->orderBy('COD_PRODUCAO','DESC')->get()], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'cod_propried' => 'required',
                'cod_prod' => 'required',
                'mes_ini_colheita_prov' => 'required|date',
                'mes_fim_colheita_prov' => 'required|date',
                'qtd_prov_colheita' => 'required|max:10',
                'mes_ini_colheita_real' => 'nullable|date',
                'mes_fim_colheita_real' => 'nullable|date',
                'qtd_real_colhida' => 'nullable|max:10'
            ]);

        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 400);
        }

        Producao::create([
            'COD_PROPRIED' => $request->cod_propried,
            'COD_PROD' => $request->cod_prod,
            'MES_INI_COLHEITA_PROV' => $request->mes_ini_colheita_prov,
            'MES_FIM_COLHEITA_PROV' => $request->mes_fim_colheita_prov,
            'QTD_PROV_COLHEITA' => $request->qtd_prov_colheita,
            'MES_INI_COLHEITA_REAL' => $request->mes_ini_colheita_real,
            'MES_FIM_COLHEITA_REAL' => $request->mes_fim_colheita_real,
            'QTD_REAL_COLHIDA' => $request->qtd_real_colhida
        ]);

        return response()->json(['message' => 'Producao criada com sucesso'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'cod_producao' => 'required',
                'cod_propried' => 'required',
                'cod_prod' => 'required',
                'mes_ini_colheita_prov' => 'nullable|date',
                'mes_fim_colheita_prov' => 'nullable|date',
                'qtd_prov_colheita' => 'nullable|max:10',
                'mes_ini_colheita_real' => 'nullable|date',
                'mes_fim_colheita_real' => 'nullable|date',
                'qtd_real_colhida' => 'nullable|max:10'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        try {
            $producao = Producao::find($request->cod_producao);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Producao nao encontrada'], 400);
        }

        if ($request->cod_propried) {
            $producao->COD_PROPRIED = $request->cod_propried;
        }
        if ($request->cod_prod) {
            $producao->COD_PROD = $request->cod_prod;
        }
        if ($request->mes_ini_colheita_prov) {
            $producao->MES_INI_COLHEITA_PROV = $request->mes_ini_colheita_prov;
        }
        if ($request->mes_fim_colheita_prov) {
            $producao->MES_FIM_COLHEITA_PROV = $request->mes_fim_colheita_prov;
        }
        if ($request->qtd_prov_colheita) {
            $producao->QTD_PROV_COLHEITA = $request->qtd_prov_colheita;
        }
        if ($request->mes_ini_colheita_real) {
            $producao->MES_INI_COLHEITA_REAL = $request->mes_ini_colheita_real;
        }
        if ($request->mes_fim_colheita_real) {
            $producao->MES_FIM_COLHEITA_REAL = $request->mes_fim_colheita_real;
        }
        if ($request->qtd_real_colhida) {
            $producao->QTD_REAL_COLHIDA = $request->qtd_real_colhida;
        }

        $producao->save();

        return response()->json(['message' => 'Producao Atualizada com sucesso'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $producao = Producao::find($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Producao nao encontrada'], 404);
        }

        $producao->delete();

        return response()->json([
            'message' => 'Producao deletada com sucesso',
        ], 200);
    }
}
