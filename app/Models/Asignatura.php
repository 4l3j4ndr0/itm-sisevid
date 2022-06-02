<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;

    protected $table = 'asignaturas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'programa_id_fk',
        'ciclo_id_fk',
        'asignatura',
        'creditos'
    ];

    public function programa()
    {
        return $this->belongsTo(Programa::class, 'programa_id_fk');
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'ciclo_id_fk');
    }

    public function asignatura_evidencias()
    {
        return $this->hasMany(AsignaturaEvidencia::class, 'asignatura_id_fk');
    }
}
