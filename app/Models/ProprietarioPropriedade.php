<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProprietarioPropriedade extends Model
{
    use HasFactory;
    protected $table = 'public.PROPRIETARIO_PROPRIEDADE';
    protected $primaryKey = 'COD_PROPRIETARIO_PROPRIEDADE';
    public $fillable = ['COD_PROPRIED', 'COD_PROPRIET', 'DT_AQUISICAO'];
    public $timestamps = false;
}
