<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenciaNumeral extends Model
{
    use HasFactory;

    protected $table = 'evidencia_numerales';

    protected $fillable = [
        'evidencia_id_fk',
        'numeral_id_fk'
    ];

    public $timestamps = false;
}
