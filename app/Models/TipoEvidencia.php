<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEvidencia extends Model
{
    use HasFactory;

    protected $table = 'tipo_evidencias';

    protected $primaryKey = 'id';

    protected $fillable = [
        'tipo',
    ];
}
