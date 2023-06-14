<?php

namespace App\Http\Controllers;

use App\Models\DonoPJ;
use Illuminate\Http\Request;
use DB;
use App\Models\Propriedade;
use App\Models\Producao;
use App\Models\Produto;
use App\Models\Proprietario;
use App\Models\ProprietarioPropriedade;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function anual()
    {
        return $this->producoes(2022,null);
    }

    public function producoes($ano,$prop)
    {
        try {
            if($prop != null){
                $props = Propriedade::with('producoes.produto')->where('COD_PROPRIEDADE',$prop)->get();

            }else{
                $props = Propriedade::with('producoes.produto')->get();

            }


        } catch (\Throwable $th) {
            dd($th);
        }
        $ret = [];
        foreach ($props as $key => $value) {
            $colheita = [];
            foreach ($value->producoes as $key2 => $value2) {
                if (date('Y', strtotime($value2->MES_FIM_COLHEITA_REAL)) == $ano) {
                    if (isset($colheita[$value2->COD_PROD])) {

                        $colheita[$value2->COD_PROD]['qtd'] += $value2->QTD_REAL_COLHIDA;
                        $colheita[$value2->COD_PROD]['data_prod'] = $colheita[$value2->COD_PROD]['data_prod'] > $value2->MES_FIM_COLHEITA_REAL ? $value->MES_FIM_COLHEITA_REAL : $colheita[$value2->COD_PROD]['data_prod'];
                    } else {

                        $colheita[$value2->COD_PROD] = array(
                            "nome_prod" => $value2->produto->DESC_PRODUTO,
                            "qtd" => $value2->QTD_REAL_COLHIDA,
                            "data_prod" => $value2->MES_FIM_COLHEITA_REAL
                        );
                    }
                }
            }
            $ret[] = array(
                "nome_prop" => $value->NOME_PROPRIEDADE,
                "tamanho" => $value->AREA,
                "colheita" => $colheita
            );
        }
        return $ret;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function juridica()
    {
        //$props = Proprietario::with('pessoaJ')->get();
        $props = Propriedade::get();
        $ret = [];
        foreach ($props as $key => $value) {
            $donos = ProprietarioPropriedade::where('COD_PROPRIED', $value->COD_PROPRIEDADE)->get();
            $prpt = Proprietario::with('pessoaJ')->whereIn('COD_PROPRIETARIO', $donos->pluck('COD_PROPRIET'))->where('TIPO', '=', 'PJ')->get();
            if (!$prpt->isEmpty()) {
                $donopj = DonoPJ::whereIn('COD_PROP_PJ', $prpt->pluck('COD_PROPRIETARIO'))->get();
                $nomes = Proprietario::with('pessoaF')->whereIn('COD_PROPRIETARIO', $donopj->pluck('COD_PROP_PF'))->where('TIPO', '=', 'PF')->get();
                $aux = [];

                foreach ($nomes as $key2 => $value2) {
                    $aux[] = array('nome' => $value2->pessoaF->NOME_PF, 'cpf' => $value2->pessoaF->CPF_PROP);
                }
                $ret[] = array(
                    "nome_prop" => $value->NOME_PROPRIEDADE,
                    "tamanho" => $value->AREA,
                    "aquisicao" => $donos[0]->DT_AQUISICAO,
                    "proprietarios" => $aux
                );
            }
        }
        return $ret;
    }

    public function milho()
    {
        //$props = Proprietario::with('pessoaJ')->get();
        $props = Propriedade::with('producoes')->get();
        $ret = [];
        foreach ($props as $key => $value) {
            if ($value->producoes->where('COD_PROD', 6)->count() > 0) {
                $donos = ProprietarioPropriedade::where('COD_PROPRIED', $value->COD_PROPRIEDADE)->get();
                $prpt = Proprietario::with('pessoaJ')->whereIn('COD_PROPRIETARIO', $donos->pluck('COD_PROPRIET'))->where('TIPO', '=', 'PJ')->get();
                $donopj = DonoPJ::whereIn('COD_PROP_PJ', $prpt->pluck('COD_PROPRIETARIO'))->get();
                $nomes = Proprietario::with('pessoaF')->whereIn('COD_PROPRIETARIO', $donopj->pluck('COD_PROP_PF'))->where('TIPO', '=', 'PF')->get();
                $aux = [];
                foreach ($nomes as $key2 => $value2) {
                    $aux[] = array('nome' => $value2->pessoaF->NOME_PF, 'cpf' => $value2->pessoaF->CPF_PROP);
                }
                $colheita = $this->producoes(2022,$value->COD_PROPRIEDADE);
                $ret[] = array(
                    "nome_prop" => $value->NOME_PROPRIEDADE,
                    "rendimento" => $colheita[0]['colheita'][6]['qtd'] / $value->AREA,
                    "donos" => $aux
                );
            }
        }
        dd($ret);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
