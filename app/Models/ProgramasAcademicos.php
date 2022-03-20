<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramasAcademicos extends Model
{
    use HasFactory;

    protected $table = 'programas_academicos';

    protected $primaryKey = 'id';

    protected $fillable = [
        'facultad_id_fk',
        'programa',
        'descripcion',
    ];
}
