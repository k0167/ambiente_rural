<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proprietario extends Model
{
    use HasFactory;

    protected $table = 'public.PROPRIETARIO';
    protected $primaryKey = 'COD_PROPRIETARIO';
    public $fillable = ['NOME_PROPRIETARIO', 'FONE1', 'FONE2', 'FONE3','TIPO'];
    public $timestamps = false;

    public function pessoaF()
    {
        return $this->hasOne(PessoaF::class, 'COD_PROP_PF', 'COD_PROPRIETARIO');
    }

    public function pessoaJ()
    {
        return $this->hasOne(PessoaJ::class, 'COD_PROP_PJ', 'COD_PROPRIETARIO');
    }
}
