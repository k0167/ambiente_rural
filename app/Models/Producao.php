<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producao extends Model
{
    use HasFactory;
    protected $table = 'public.PRODUCAO';
    protected $primaryKey = 'COD_PRODUCAO';
    public $fillable = [
        'COD_PROPRIED',
        'COD_PROD',
        'MES_INI_COLHEITA_PROV',
        'MES_FIM_COLHEITA_PROV',
        'QTD_PROV_COLHEITA',
        'MES_INI_COLHEITA_REAL',
        'MES_FIM_COLHEITA_REAL',
        'QTD_REAL_COLHIDA'
    ];
    public $timestamps = false;

    public function propriedade()
    {
        return $this->belongsTo(Propriedade::class, 'COD_PROPRIED', 'COD_PROPRIEDADE');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'COD_PROD', 'COD_PRODUTO');
    }

}
