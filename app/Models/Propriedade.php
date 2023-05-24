<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Propriedade extends Model
{
    use HasFactory;
    protected $table = 'public.PROPRIEDADE';
    protected $primaryKey = 'COD_PROPRIEDADE';
    public $fillable = ['NOME_PROPRIEDADE', 'AREA', 'DISTANCIA_DO_MUNIC', 'VALOR_AQUISICAO','COD_MUN'];
    public $timestamps = false;

    public function producoes(): HasMany
    {
        return $this->hasMany(Producao::class, 'COD_PROPRIED', 'COD_PROPRIEDADE');
    }

    public function municipios(): HasOne
    {
        return $this->hasOne(Municipio::class, 'COD_MUN', 'COD_MUN');
    }

}
