<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticuloLiteral extends Model
{
    use HasFactory;

    protected $table = 'articulo_literales';

    protected $fillable = [
        'articulo_id_fk',
        'literal_id_fk'
    ];

    public $timestamps = false;
}
