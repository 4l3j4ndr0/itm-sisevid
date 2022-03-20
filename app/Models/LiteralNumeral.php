<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiteralNumeral extends Model
{
    use HasFactory;

    protected $table = 'literal_numerales';

    protected $fillable = [
        'literal_id_fk',
        'numeral_id_fk'
    ];

    public $timestamps = false;
}
