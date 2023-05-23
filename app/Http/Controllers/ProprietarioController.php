<?php

namespace App\Http\Controllers;

use App\Models\Proprietario;
use App\Models\DonoPJ;
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
        //get all proprietarios and her pessoaF or pessoaJ
        $proprietarios = Proprietario::with(['pessoaF', 'pessoaJ'])->get();

        return response()->json($proprietarios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if ($request->validate(['tipo' => 'required|in:PF,PJ']))

                if ($request->tipo == 'PF') {
                    $request->validate([
                        'nome_proprietario' => 'required|string',
                        'fone1' => 'required|string',
                        'fone2' => 'required|string',
                        'fone3' => 'required|string',
                        'tipo' => 'required|in:PF,PJ',
                        'pessoaF.cpf_prop' => 'required|max:11',
                        'pessoaF.nome_pf' => 'required|string',
                        'pessoaF.dt_nasc_pf' => 'required|date',
                        'pessoaF.rg_pf' => 'required|string',
                        'pessoaF.cod_prop_conjuge' => 'nullable',
                    ]);
                } else {
                    $request->validate([
                        'nome_proprietario' => 'required|string',
                        'fone1' => 'required|string',
                        'fone2' => 'required|string',
                        'fone3' => 'required|string',
                        'tipo' => 'required|in:PF,PJ',
                        'pessoaJ.cnpj' => 'required|max:14',
                        'pessoaJ.dt_cria_pj' => 'required|date',
                        'pessoaJ.razao_social_pj' => 'required|string',
                    ]);
                }
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 400);
        }

        $proprietario = Proprietario::create([
            'NOME_PROPRIETARIO' => $request->nome_proprietario,
            'FONE1' => $request->fone1,
            'FONE2' => $request->fone2,
            'FONE3' => $request->fone3,
            'TIPO' => $request->tipo

        ]);
        if ($request->tipo == 'PF') {

            $proprietario->pessoaF()->create([
                'CPF_PROP' => $request->pessoaF['cpf_prop'],
                'NOME_PF' => $request->pessoaF['nome_pf'],
                'DT_NASC_PF' => $request->pessoaF['dt_nasc_pf'],
                'RG_PF' => $request->pessoaF['rg_pf'],
                'COD_PROP_CONJUGE' => $request->pessoaF['cod_prop_conjuge'],
            ]);
        } else {
            $proprietario->pessoaJ()->create([
                'CNPJ' => $request->pessoaJ['cnpj'],
                'DT_CRIA_PJ' => $request->pessoaJ['dt_cria_pj'],
                'RAZAO_SOCIAL_PJ' => $request->pessoaJ['razao_social_pj'],
            ]);
        }

        return response()->json(['message' => 'Proprietario criado com sucesso'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            if ($request->validate(['tipo' => 'required|in:PF,PJ']))

                if ($request->tipo == 'PF') {
                    $request->validate([
                        'cod_proprietario' => 'required|integer',
                        'nome_proprietario' => 'required|string',
                        'fone1' => 'required|string',
                        'fone2' => 'required|string',
                        'fone3' => 'required|string',
                        'tipo' => 'required|in:PF,PJ',
                        'pessoaF.cpf_prop' => 'required|max:11',
                        'pessoaF.nome_pf' => 'required|string',
                        'pessoaF.dt_nasc_pf' => 'required|date',
                        'pessoaF.rg_pf' => 'required|string',
                        'pessoaF.cod_prop_conjuge' => 'nullable',
                    ]);
                } else {
                    $request->validate([
                        'cod_proprietario' => 'required|integer',
                        'nome_proprietario' => 'required|string',
                        'fone1' => 'required|string',
                        'fone2' => 'required|string',
                        'fone3' => 'required|string',
                        'tipo' => 'required|in:PF,PJ',
                        'pessoaJ.cnpj' => 'required|max:14',
                        'pessoaJ.dt_cria_pj' => 'required|date',
                        'pessoaJ.razao_social_pj' => 'required|string',
                    ]);
                }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        try {
            $proprietario = Proprietario::find($request->cod_proprietario)->with(['pessoaF', 'pessoaJ'])->first();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Proprietario nao encontrada'], 400);
        }

        if ($request->tipo == 'PF') {
            $proprietario->pessoaF()->update([
                'CPF_PROP' => $request->pessoaF['cpf_prop'],
                'NOME_PF' => $request->pessoaF['nome_pf'],
                'DT_NASC_PF' => $request->pessoaF['dt_nasc_pf'],
                'RG_PF' => $request->pessoaF['rg_pf'],
                'COD_PROP_CONJUGE' => $request->pessoaF['cod_prop_conjuge'],
            ]);
        } else {
            $proprietario->pessoaJ()->update([
                'CNPJ' => $request->pessoaJ['cnpj'],
                'DT_CRIA_PJ' => $request->pessoaJ['dt_cria_pj'],
                'RAZAO_SOCIAL_PJ' => $request->pessoaJ['razao_social_pj'],
            ]);
        }


        $proprietario->NOME_PROPRIETARIO = $request->nome_proprietario;
        $proprietario->FONE1 = $request->fone1;
        $proprietario->FONE2 = $request->fone2;
        $proprietario->FONE3 = $request->fone3;

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

        if ($proprietario->pessoaF) {
            $proprietario->pessoaF->delete();
        } else {
            $proprietario->pessoaJ->delete();
        }

        $proprietario->delete();

        return response()->json([
            'message' => 'Proprietario deletada com sucesso',
        ], 200);
    }

    public function getProprietariosPJ($id)
    {
        return DonoPJ::where('COD_PROP_PJ', $id)->get();

    }

    public function destroyPJ(Request $request)
    {
        try {
            $request->validate([
                'cod_prop_pj' => 'required|integer',
                'cod_prop_pf' => 'required|integer'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        try {
            $donopj = DonoPJ::where('COD_PROP_PJ', $request->cod_prop_pj)
                ->where('COD_PROP_PF', $request->cod_prop_pf)->first();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Dono nao encontrada'], 404);
        }

        $donopj->delete();
    }

    public function storePJ(Request $request)
    {
        try {
            $request->validate([
                'cod_prop_pj' => 'required|integer',
                'cod_prop_pf' => 'required|integer'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        try {
            DonoPJ::create([
                'COD_PROP_PJ' => $request->cod_prop_pj,
                'COD_PROP_PF' => $request->cod_prop_pf
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 404);
        }

        return response()->json(['message' => 'Dono criado com sucesso'], 200);
    }
}
