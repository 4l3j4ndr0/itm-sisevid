<?php

namespace App\Http\Controllers;

use App\Models\ProgramasAcademicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgramaAcademicoController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'facultad_id_fk' => 'required',
            'programa' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $programa_academico = ProgramasAcademicos::create([
            'programa' => $request->programa,
            'facultad_id_fk' => $request->facultad_id_fk,
            'descripcion' => isset($request->descripcion) ? $request->descripcion : null,
        ]);

        return response([
            "status" => true,
            "message" => "Programa academico creado correctamente.",
            "data" => $programa_academico,
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'facultad_id_fk' => 'required',
            'programa' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $programa_academico = ProgramasAcademicos::find($request->id);
        $programa_academico->programa = $request->programa;
        $programa_academico->facultad_id_fk = $request->facultad_id_fk;
        $programa_academico->descripcion = isset($request->descripcion) ? $request->descripcion : null;
        $programa_academico->save();

        return response([
            "status" => true,
            "message" => "Programa academico actualizado correctamente.",
            "data" => $programa_academico,
        ], 200);
    }

    public function delete(int $id)
    {
        $programa_academico = ProgramasAcademicos::find($id);
        $programa_academico->delete();

        return response([
            "status" => true,
            "message" => "Programa academico eliminado correctamente.",
            "data" => $programa_academico,
        ], 200);
    }

    public function getPrograma($id)
    {
        $programa_academico = ProgramasAcademicos::find($id);

        return response([
            "status" => true,
            "message" => "Programa academico encontrado correctamente.",
            "data" => $programa_academico,
        ], 200);
    }

    public function list(Request $request)
    {
        $programas_academicos = ProgramasAcademicos::paginate($request->per_page);

        return response([
            "status" => true,
            "message" => "Programas academicos obtenidos correctamente.",
            "data" => $programas_academicos,
        ], 200);
    }
}
