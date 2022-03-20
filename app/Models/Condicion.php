<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condicion extends Model
{
    use HasFactory;

    protected $table = 'condiciones';

    protected $primaryKey = 'id';

    protected $fillable = [
        'programa_academico_id_fk',
        'capitulo_id_fk',
        'condicion',
        'descripcion'
    ];
}
