<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PessoaJ extends Model
{
    use HasFactory;
    protected $table = 'public.PESSOA_J';
    protected $primaryKey = 'COD_PROP_PJ';
    public $fillable = [
        'CNPJ',
        'RAZAO_SOCIAL_PJ',
        'DT_CRIA_PJ',
    ];
    public $timestamps = false;
}
