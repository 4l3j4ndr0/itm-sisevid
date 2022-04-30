<?php

namespace App\Http\Controllers;

use App\Models\Condicion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CondicionController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'programa_academico_id_fk' => 'required',
            'capitulo_id_fk' => 'required',
            'condicion' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $condicion = Condicion::create([
            'programa_academico_id_fk' => $request->programa_academico_id_fk,
            'capitulo_id_fk' => $request->capitulo_id_fk,
            'condicion' => $request->condicion,
            'descripcion' => isset($request->descripcion) ? $request->descripcion : null,
        ]);

        return response([
            "status" => true,
            "message" => "Condicion creada correctamente.",
            "data" => $condicion,
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'programa_academico_id_fk' => 'required',
            'capitulo_id_fk' => 'required',
            'condicion' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $condicion = Condicion::find($request->id);
        $condicion->programa_academico_id_fk = $request->programa_academico_id_fk;
        $condicion->capitulo_id_fk = $request->capitulo_id_fk;
        $condicion->condicion = $request->condicion;
        $condicion->descripcion = isset($request->descripcion) ? $request->descripcion : null;
        $condicion->save();

        return response([
            "status" => true,
            "message" => "Condicion actualizada correctamente.",
            "data" => $condicion,
        ], 200);
    }

    public function delete(int $id)
    {
        $condicion = Condicion::find($id);
        $condicion->delete();

        return response([
            "status" => true,
            "message" => "Condicion eliminada correctamente.",
            "data" => $condicion,
        ], 200);
    }

    public function getCondicion(int $id)
    {
        $condicion = Condicion::find($id);

        return response([
            "status" => true,
            "message" => "Condicion encontrada correctamente.",
            "data" => $condicion,
        ], 200);
    }

    public function list(Request $request)
    {
        $query = DB::table('condiciones as c')->select('c.id',  'pa.programa', 'ca.codigo as capitulo', 'c.condicion', 'c.descripcion')
            ->join('capitulos as ca', 'ca.id', '=', 'c.capitulo_id_fk')
            ->join('programa_academicos as pa', 'pa.id', '=', 'c.programa_academico_id_fk')
            ->orderBy('c.id', 'desc');

        if ((isset($request->filter) && $request->filter != null) && $request->filter != '' && $request->filter != 'null') {
            $query->where('pa.programa', 'like', '%' . $request->filter . '%');
            $query->orWhere('ca.codigo', 'like', '%' . $request->filter . '%');
            $query->orWhere('c.condicion', 'like', '%' . $request->filter . '%');
        }

        $condiciones = $query->paginate($request->rows, ['*'], 'page', $request->page);

        return response([
            "status" => true,
            "message" => "Condiciones encontradas correctamente.",
            "data" => $condiciones,
        ], 200);
    }
}
