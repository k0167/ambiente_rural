<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produto extends Model
{
    use HasFactory;
    protected $table = 'public.PRODUTO';
    protected $primaryKey = 'COD_PRODUTO';
    public $fillable = ['DESC_PRODUTO'];
    public $timestamps = false;

    public function producoes(): HasMany
    {
        return $this->hasMany(Producao::class, 'COD_PROD', 'COD_PRODUTO');
    }
}
