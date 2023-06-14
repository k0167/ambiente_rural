<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Propriedade;
use App\Models\Producao;
use App\Models\Produto;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function anual()
    {
        try {

            $props = Propriedade::with('producoes.produto')
            ->get();
        } catch (\Throwable $th) {
           dd($th);
        }
        $ret;
        foreach ($props as $key => $value) {
            $colheita=[];
            foreach ($value->producoes as $key2 => $value2) {
                if(isset($colheita[$value2->COD_PROD])){
                    $colheita[$value2->COD_PROD]['qtd'] += $value2->QTD_REAL_COLHIDA;
                    $colheita[$value2->COD_PROD]['data_prod'] = $colheita[$value2->COD_PROD]['data_prod'] > $value2->MES_FIM_COLHEITA_REAL?$value->MES_FIM_COLHEITA_REAL:$colheita[$value2->COD_PROD]['data_prod'];
                }else{
                    $colheita[$value2->COD_PROD] = array(
                        "nome_prod" => $value2->produto->DESC_PRODUTO,
                        "qtd" => $value2->QTD_REAL_COLHIDA,
                        "data_prod" => $value->MES_FIM_COLHEITA_REAL
                    );
                }

            }

            $ret[] = array(
                "nome_prop" => $value->NOME_PROPRIEDADE,
                "tamanho" =>$value->AREA,
                "colheita"=>$colheita
            );

        }

        dd($ret);

        return $props;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
