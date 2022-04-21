<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\Ciclo;
use App\Models\ProgramasAcademicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AsignaturaController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'programa_id_fk' => 'required',
            'ciclo_id_fk' => 'required',
            'asignatura' => 'required',
            'creditos' => 'required',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $asignatura = Asignatura::create([
            'programa_id_fk' => $request->programa_id_fk,
            'ciclo_id_fk' => $request->ciclo_id_fk,
            'asignatura' => $request->asignatura,
            'creditos' => $request->creditos,
        ]);

        return response([
            "status" => true,
            "message" => "Asignatura creada correctamente.",
            "data" => $asignatura,
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'programa_id_fk' => 'required',
            'ciclo_id_fk' => 'required',
            'asignatura' => 'required',
            'creditos' => 'required',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $asignatura = Asignatura::find($request->id);
        $asignatura->programa_id_fk = $request->programa_id_fk;
        $asignatura->ciclo_id_fk = $request->ciclo_id_fk;
        $asignatura->asignatura = $request->asignatura;
        $asignatura->creditos = $request->creditos;
        $asignatura->save();

        return response([
            "status" => true,
            "message" => "Asignatura actualizada correctamente.",
            "data" => $asignatura,
        ], 200);
    }

    public function delete(int $id)
    {
        $asignatura = Asignatura::find($id);
        $asignatura->delete();

        return response([
            "status" => true,
            "message" => "Asignatura eliminada correctamente.",
            "data" => $asignatura,
        ], 200);
    }

    public function getAsignatura(int $id)
    {
        $asignatura = Asignatura::find($id);

        $programa = ProgramasAcademicos::find($asignatura->programa_id_fk);

        $ciclo = Ciclo::find($asignatura->ciclo_id_fk);

        $asignatura->programa_id_fk = [
            'value' => $programa->id,
            'label' => $programa->programa,
        ];

        $asignatura->ciclo_id_fk = [
            'value' => $ciclo->id,
            'label' => $ciclo->ciclo,
        ];

        return response([
            "status" => true,
            "message" => "Asignatura encontrada correctamente.",
            "data" => $asignatura,
        ], 200);
    }

    public function list(Request $request)
    {
        $query = DB::table('asignaturas as a')->select('a.id', 'pa.programa', 'c.ciclo', 'a.asignatura', 'a.creditos')
            ->join('programas_academicos as pa', 'pa.id', '=', 'a.programa_id_fk')
            ->join('ciclos as c', 'c.id', '=', 'a.ciclo_id_fk')
            ->orderBy('a.id', 'desc');

        if ((isset($request->filter) && $request->filter != null) && $request->filter != '' && $request->filter != 'null') {
            $query->where('pa.programa', 'like', '%' . $request->filter . '%');
            $query->orWhere('c.ciclo', 'like', '%' . $request->filter . '%');
            $query->orWhere('a.asignatura', 'like', '%' . $request->filter . '%');
            $query->orWhere('a.creditos', 'like', '%' . $request->filter . '%');
        }

        $asignaturas = $query->paginate($request->rows, ['*'], 'page', $request->page);

        return response([
            "status" => true,
            "message" => "Asignaturas encontradas correctamente.",
            "data" => $asignaturas,
        ], 200);
    }
}
