<?php

namespace App\Http\Controllers;

use App\Models\Facultades;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FacultadController extends Controller
{

    function getDecanos()
    {
        $decanos = User::where('tipo_personas_id_fk', '=', 3)->get();

        $newDecanos = [];

        foreach ($decanos as $d) {
            array_push($newDecanos, [
                'value' => $d->id,
                'label' => $d->nombre . ' ' . $d->apellidos
            ]);
        }

        return response([
            "status" => true,
            "message" => "Lista de decanos.",
            "data" => $newDecanos,
        ], 200);
    }

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

        $decano = User::find($facultad->decano_id_fk);

        $facultad->decano_id_fk = [
            'value' => $decano->id,
            'label' => $decano->nombre . ' ' . $decano->apellidos
        ];

        return response([
            "status" => true,
            "message" => "Facultad encontrada correctamente.",
            "data" => $facultad,
        ], 200);
    }

    public function list(Request $request)
    {
        $query = DB::table('facultades as f')->select('f.id',  'f.facultad')->selectRaw("CONCAT(d.nombre, ' ', d.apellidos) as decano")
            ->join('users as d', 'd.id', '=', 'f.decano_id_fk')
            ->orderBy('f.facultad', 'asc');

        if ((isset($request->filter) && $request->filter != null) && $request->filter != '' && $request->filter != 'null') {
            $query->where('f.facultad', 'like', '%' . $request->filter . '%');
        }

        $facultades = $query->paginate($request->rows, ['*'], 'page', $request->page);

        return response([
            "status" => true,
            "message" => "Facultades encontradas correctamente.",
            "data" => $facultades,
        ], 200);
    }
}
