<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facultades extends Model
{
    use HasFactory;

    protected $table = 'facultades';

    protected $primaryKey = 'id';

    protected $fillable = [
        'facultad_id_fk',
        'facultad'
    ];
}
