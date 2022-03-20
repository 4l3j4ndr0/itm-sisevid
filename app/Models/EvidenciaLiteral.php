<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenciaLiteral extends Model
{
    use HasFactory;

    protected $table = 'evidencia_literales';

    protected $fillable = [
        'evidencia_id_fk',
        'literal_id_fk'
    ];

    public $timestamps = false;
}
