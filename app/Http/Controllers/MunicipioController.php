<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Municipio/Index');
    }

    public function getMunicipios()
    {
        return Municipio::orderBy('UF_MUN', 'ASC')->orderBy('NOME_MUN','ASC')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nome_mun' => 'required|max:100',
                'uf_mun' => 'required|max:2'
            ]);
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 400);
        }

        Municipio::create([
            'UF_MUN' => $request->uf_mun,
            'NOME_MUN' => $request->nome_mun
        ]);

        return response()->json(['message' => 'Municipio criado com sucesso'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'cod_mun' => 'required',
                'nome_mun' => 'nullable|max:100',
                'uf_mun' => 'nullable|max:2'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        try {
            $municipio = Municipio::find($request->cod_mun);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Municipio nao encontrada'], 400);
        }

        if($request->nome_mun){
            $municipio->NOME_MUN = $request->nome_mun;
    }

        if($request->uf_mun){
            $municipio->UF_MUN = $request->uf_mun;
        }

        $municipio->save();

        return response()->json(['message' => 'Municipio Atualizada com sucesso'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $municipio = Municipio::find($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Municipio nao encontrada'], 404);
        }

        $municipio->delete();

        return response()->json([
            'message' => 'Municipio deletada com sucesso',
        ], 200);
    }
}
