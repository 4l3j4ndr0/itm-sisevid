<?php

namespace App\Http\Controllers;

use App\Models\Facultades;
use App\Models\ProgramasAcademicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
        $programaAcademico = ProgramasAcademicos::find($id);

        $facultad = Facultades::find($programaAcademico->facultad_id_fk);

        $programaAcademico->facultad_id_fk = [
            'value' => $facultad->id,
            'label' => $facultad->facultad,
        ];

        return response([
            "status" => true,
            "message" => "Programa academico encontrado correctamente.",
            "data" => $programaAcademico,
        ], 200);
    }

    public function list(Request $request)
    {
        $query = DB::table('programas_academicos as p')->select('p.id', 'f.facultad', 'p.programa', 'p.descripcion')
            ->join('facultades as f', 'f.id', '=', 'p.facultad_id_fk')
            ->orderBy('p.id', 'desc');

        if ((isset($request->filter) && $request->filter != null) && $request->filter != '' && $request->filter != 'null') {
            $query->where('f.facultad', 'like', '%' . $request->filter . '%');
            $query->orWhere('p.programa', 'like', '%' . $request->filter . '%');
        }

        $programasAcademicos = $query->paginate($request->rows, ['*'], 'page', $request->page);

        return response([
            "status" => true,
            "message" => "Programas academicos obtenidos correctamente.",
            "data" => $programasAcademicos,
        ], 200);
    }
}
