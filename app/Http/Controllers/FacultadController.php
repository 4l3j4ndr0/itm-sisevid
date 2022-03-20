<?php

namespace App\Http\Controllers;

use App\Models\Facultades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FacultadController extends Controller
{
    function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'decano_id_fk' => 'required',
            'facultad' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $facultad = Facultades::create([
            'decano_id_fk' => $request->decano_id_fk,
            'facultad' => $request->facultad,
        ]);

        return response([
            "status" => true,
            "message" => "Facultad creada correctamente.",
            "data" => $facultad,
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'decano_id_fk' => 'required',
            'facultad' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $facultad = Facultades::find($request->id);
        $facultad->decano_id_fk = $request->decano_id_fk;
        $facultad->facultad = $request->facultad;
        $facultad->save();

        return response([
            "status" => true,
            "message" => "Facultad actualizada correctamente.",
            "data" => $facultad,
        ], 200);
    }

    public function delete(int $id)
    {
        $facultad = Facultades::find($id);
        $facultad->delete();

        return response([
            "status" => true,
            "message" => "Facultad eliminada correctamente.",
            "data" => $facultad,
        ], 200);
    }

    public function getFacultad(int $id)
    {
        $facultad = Facultades::find($id);

        return response([
            "status" => true,
            "message" => "Facultad encontrada correctamente.",
            "data" => $facultad,
        ], 200);
    }

    public function list(Request $request)
    {
        $facultades = Facultades::paginate($request->per_page);

        return response([
            "status" => true,
            "message" => "Facultades encontradas correctamente.",
            "data" => $facultades,
        ], 200);
    }
}
