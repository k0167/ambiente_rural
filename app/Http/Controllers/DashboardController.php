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
    //Consulta questão 1
    public function anual()
    {
        return $this->producoes(2022,null);
    }

    //função para questão 1 e 3, realiza a consulta das produções de uma propriedade ou de todas as propriedades em um ano
    public function producoes($ano,$prop)
    {
        try {
            if($prop != null){
                $props = Propriedade::with('producoes.produto')->where('COD_PROPRIEDADE',$prop)->get();

            }else{
                $props = Propriedade::with('producoes.produto')->get();

            }


        } catch (\Throwable $th) {
            dd($th); //err handler
        }
        $ret = [];
        foreach ($props as $key => $value) {
            $colheita = [];
            //busca todas as colheitas da propriedade
            foreach ($value->producoes as $key2 => $value2) {
                //filtra as produções pelo seu ano
                if (date('Y', strtotime($value2->MES_FIM_COLHEITA_REAL)) == $ano) {
                    //verifica se o array ja está preenchido, se sim, soma a quantidade, se não, cria o array
                    if (isset($colheita[$value2->COD_PROD])) {
                        //soma a quantidade
                        $colheita[$value2->COD_PROD]['qtd'] += $value2->QTD_REAL_COLHIDA;
                        //seleciona a ultima data
                        $colheita[$value2->COD_PROD]['data_prod'] = $colheita[$value2->COD_PROD]['data_prod'] > $value2->MES_FIM_COLHEITA_REAL ? $value->MES_FIM_COLHEITA_REAL : $colheita[$value2->COD_PROD]['data_prod'];
                    } else {
                        //cria o array
                        $colheita[$value2->COD_PROD] = array(
                            "nome_prod" => $value2->produto->DESC_PRODUTO,
                            "qtd" => $value2->QTD_REAL_COLHIDA,
                            "data_prod" => $value2->MES_FIM_COLHEITA_REAL
                        );
                    }
                }
            }
            //retorna a propriedade
            $ret[] = array(
                "nome_prop" => $value->NOME_PROPRIEDADE,
                "tamanho" => $value->AREA,
                "colheita" => $colheita
            );
        }
        return $ret;
    }

    public function juridica()
    {
        //$props = Proprietario::with('pessoaJ')->get();
        $props = Propriedade::get();
        $ret = [];
        foreach ($props as $key => $value) {
            //busca os donos da propriedade
            $donos = ProprietarioPropriedade::where('COD_PROPRIED', $value->COD_PROPRIEDADE)->get();
            //busca qual o seu COD_PROPRIETARIO e filtra somente pelo que é PJ
            $prpt = Proprietario::with('pessoaJ')->whereIn('COD_PROPRIETARIO', $donos->pluck('COD_PROPRIET'))->where('TIPO', '=', 'PJ')->get();
            if (!$prpt->isEmpty()) {
                //busca os donos da PJ
                $donopj = DonoPJ::whereIn('COD_PROP_PJ', $prpt->pluck('COD_PROPRIETARIO'))->get();
                //busca os nomes dos donos
                $nomes = Proprietario::with('pessoaF')->whereIn('COD_PROPRIETARIO', $donopj->pluck('COD_PROP_PF'))->where('TIPO', '=', 'PF')->get();
                $aux = [];
                //array dos nomes
                foreach ($nomes as $key2 => $value2) {
                    $aux[] = array('nome' => $value2->pessoaF->NOME_PF, 'cpf' => $value2->pessoaF->CPF_PROP);
                }
                //retorna as propriedades e seus donos
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
        $props = Propriedade::with('producoes')->get();
        $ret = [];
        foreach ($props as $key => $value) {
            //filtra todas as propriedades que um dia produziram milho
            if ($value->producoes->where('COD_PROD', 6)->count() > 0) {
                //busca os donos da propriedade
                $donos = ProprietarioPropriedade::where('COD_PROPRIED', $value->COD_PROPRIEDADE)->get();
                $prpt = Proprietario::with('pessoaJ')->whereIn('COD_PROPRIETARIO', $donos->pluck('COD_PROPRIET'))->where('TIPO', '=', 'PJ')->get();
                $donopj = DonoPJ::whereIn('COD_PROP_PJ', $prpt->pluck('COD_PROPRIETARIO'))->get();
                $nomes = Proprietario::with('pessoaF')->whereIn('COD_PROPRIETARIO', $donopj->pluck('COD_PROP_PF'))->where('TIPO', '=', 'PF')->get();
                $aux = [];
                foreach ($nomes as $key2 => $value2) {
                    $aux[] = array('nome' => $value2->pessoaF->NOME_PF, 'cpf' => $value2->pessoaF->CPF_PROP);
                }
                //busca as produções da propriedade
                $colheita = $this->producoes(2022,$value->COD_PROPRIEDADE);
                //testa se existem produções para 2022 naquela propriedade
                if(isset($colheita[0]['colheita'][6])){
                    //array de retorno
                    $ret[] = array(
                        "nome_prop" => $value->NOME_PROPRIEDADE,
                        "rendimento" => $colheita[0]['colheita'][6]['qtd'] / $value->AREA,
                        "donos" => $aux
                    );
                }
            }
        }
    }
}
