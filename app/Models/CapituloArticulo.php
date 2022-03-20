<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapituloArticulo extends Model
{
    use HasFactory;

    protected $table = 'capitulo_articulos';

    protected $fillable = [
        'capitulo_id_fk',
        'articulo_id_fk'
    ];

    public $timestamps = false;
}
