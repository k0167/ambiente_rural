<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;
    protected $table = 'public.MUNICIPIO';
    protected $primaryKey = 'COD_MUN';
    public $fillable = [
        'NOME_MUN',
        'UF_MUN'
    ];
    public $timestamps = false;

    public function propriedades()
    {
        return $this->hasMany(Propriedade::class, 'COD_MUN', 'COD_MUN');
    }
}
