<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    use HasFactory;

    protected $table = 'evidencias';

    protected $primaryKey = 'id';

    protected $fillable = [
        'tipo_evidencia_id_fk',
        'autor',
        'codigo',
        'titulo',
        'fecha_creacion',
        'fecha_modificacion',
        'url_evidencia',
        'descripcion'
    ];
}
