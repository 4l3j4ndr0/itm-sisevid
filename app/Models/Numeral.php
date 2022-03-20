<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Numeral extends Model
{
    use HasFactory;

    protected $table = 'numerales';

    protected $primaryKey = 'id';

    protected $fillable = [
        'codigo',
        'descripcion'
    ];
}
