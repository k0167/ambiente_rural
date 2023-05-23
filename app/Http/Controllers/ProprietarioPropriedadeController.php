<?php

namespace App\Http\Controllers;

use App\Models\Propriedade;
use App\Models\ProprietarioPropriedade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProprietarioPropriedadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id): Response
    {
        return Inertia::render('Proprietario/PropProprietario', ['proprietario' => $id]);
    }

    public function getPropPropriedades($id)
    {
        return response()->json(['propriedade'=> ProprietarioPropriedade::where('COD_PROPRIET', $id)->get(),
                                 'propriedades' => Propriedade::all()
                                 ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'cod_propried' => 'required',
                'cod_propriet' => 'required',
                'data_aquisicao' => 'required|date'
            ]);

        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 400);
        }

        ProprietarioPropriedade::create([
            'COD_PROPRIED' => $request->cod_propried,
            'COD_PROPRIET' => $request->cod_propriet,
            'DT_AQUISICAO' => $request->data_aquisicao
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
                'cod_prop_propried' => 'required',
                'cod_propried' => 'required',
                'cod_propriet' => 'required',
                'data_aquisicao' => 'nullable|date'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        try {
            $propPropried = ProprietarioPropriedade::find($request->cod_prop_propried);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Producao nao encontrada'], 400);
        }

        if ($request->cod_propried) {
            $propPropried->COD_PROPRIED = $request->cod_propried;
        }

        if ($request->cod_propriet) {
            $propPropried->COD_PROPRIET = $request->cod_propriet;
        }

        if ($request->data_aquisicao) {
            $propPropried->DT_AQUISICAO = $request->data_aquisicao;
        }

        $propPropried->save();

        return response()->json(['message' => 'Producao Atualizada com sucesso'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $propPropried = ProprietarioPropriedade::find($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Producao nao encontrada'], 404);
        }

        $propPropried->delete();

        return response()->json([
            'message' => 'Producao deletada com sucesso',
        ], 200);
    }
}
