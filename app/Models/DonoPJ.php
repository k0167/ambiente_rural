<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonoPJ extends Model
{
    use HasFactory;
    protected $table = 'public.DONO_PJ';
    protected $primaryKey ='COD_DONO_PJ';

    public $fillable = [
        'COD_PROP_PF',
        'COD_PROP_PJ',
    ];
    public $timestamps = false;
}
