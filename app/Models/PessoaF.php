<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PessoaF extends Model
{
    use HasFactory;
    protected $table = 'public.PESSOA_F';
    protected $primaryKey = 'COD_PROP_PF';
    public $fillable = [
        'CPF_PROP',
        'NOME_PF',
        'DT_NASC_PF',
        'RG_PF',
        'COD_PROP_CONJUGE',
    ];
    public $timestamps = false;

    public function proprietario()
    {
        return $this->belongsTo(Proprietario::class, 'COD_PROPRIETARIO', 'COD_PROP_PF');
    }
}
