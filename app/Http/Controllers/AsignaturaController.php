<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use Illuminate\Http\Request;
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

    public function getAsignatira(int $id)
    {
        $asignatura = Asignatura::find($id);

        return response([
            "status" => true,
            "message" => "Asignatura encontrada correctamente.",
            "data" => $asignatura,
        ], 200);
    }

    public function list(Request $request)
    {
        $asignaturas = Asignatura::paginate($request->per_page);

        return response([
            "status" => true,
            "message" => "Asignaturas encontradas correctamente.",
            "data" => $asignaturas,
        ], 200);
    }
}
