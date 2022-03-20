<?php

namespace App\Http\Controllers;

use App\Models\Ciclo;
use Illuminate\Http\Request;
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
            'desde' => $request->fecha_inicio,
            'hasta' => $request->fecha_fin,
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
        $ciclo->desde = $request->fecha_inicio;
        $ciclo->hasta = $request->fecha_fin;
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

    public function getCiclos(Request $request)
    {
        $ciclos = Ciclo::paginatere($request->per_page);

        return response([
            "status" => true,
            "message" => "Ciclos encontrados correctamente.",
            "data" => $ciclos,
        ], 200);
    }
}
