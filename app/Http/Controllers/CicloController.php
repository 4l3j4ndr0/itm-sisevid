<?php

namespace App\Http\Controllers;

use App\Models\Ciclo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CicloController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ciclo' => 'required|max:255',
            'desde' => 'required|max:255',
            'hasta' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $ciclo = Ciclo::create([
            'ciclo' => $request->ciclo,
            'desde' => $request->desde,
            'hasta' => $request->hasta,
        ]);

        return response([
            "status" => true,
            "message" => "Ciclo creado correctamente.",
            "data" => $ciclo,
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ciclo' => 'required|max:255',
            'desde' => 'required|max:255',
            'hasta' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $ciclo = Ciclo::find($request->id);
        $ciclo->ciclo = $request->ciclo;
        $ciclo->desde = $request->desde;
        $ciclo->hasta = $request->hasta;
        $ciclo->save();

        return response([
            "status" => true,
            "message" => "Ciclo actualizado correctamente.",
            "data" => $ciclo,
        ], 200);
    }

    public function delete(int $id)
    {
        $ciclo = Ciclo::find($id);
        $ciclo->delete();

        return response([
            "status" => true,
            "message" => "Ciclo eliminado correctamente.",
            "data" => $ciclo,
        ], 200);
    }

    public function getCiclo(int $id)
    {
        $ciclo = Ciclo::find($id);

        return response([
            "status" => true,
            "message" => "Ciclo encontrado correctamente.",
            "data" => $ciclo,
        ], 200);
    }

    public function list(Request $request)
    {
        $query = DB::table('ciclos as c')->select('c.id',  'c.ciclo', 'c.desde', 'c.hasta')->orderBy('c.id', 'desc');

        if ((isset($request->filter) && $request->filter != null) && $request->filter != '' && $request->filter != 'null') {
            $query->where('c.ciclo', 'like', '%' . $request->filter . '%');
        }

        $ciclos = $query->paginate($request->rows, ['*'], 'page', $request->page);

        return response([
            "status" => true,
            "message" => "Ciclos encontrados correctamente.",
            "data" => $ciclos,
        ], 200);
    }
}
