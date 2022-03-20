<?php

namespace App\Http\Controllers;

use App\Models\Capitulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CapituloController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $capitulo = Capitulo::create([
            'codigo' => $request->codigo,
            'descripcion' => isset($request->descripcion) ? $request->descripcion : null,
        ]);

        return response([
            "status" => true,
            "message" => "Capitulo creado correctamente.",
            "data" => $capitulo,
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $capitulo = Capitulo::find($request->id);
        $capitulo->codigo = $request->codigo;
        $capitulo->descripcion = isset($request->descripcion) ? $request->descripcion : null;
        $capitulo->save();

        return response([
            "status" => true,
            "message" => "Capitulo actualizado correctamente.",
            "data" => $capitulo,
        ], 200);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $capitulo = Capitulo::find($request->id);
        $capitulo->delete();

        return response([
            "status" => true,
            "message" => "Capitulo eliminado correctamente.",
            "data" => $capitulo,
        ], 200);
    }

    public function getcapitulo(int $id)
    {
        $capitulo = Capitulo::find($id);

        return response([
            "status" => true,
            "message" => "Capitulo encontrado correctamente.",
            "data" => $capitulo,
        ], 200);
    }

    public function list(Request $request)
    {
        $capitulos = Capitulo::paginate($request->per_page);

        return response([
            "status" => true,
            "message" => "Capitulos encontrados correctamente.",
            "data" => $capitulos,
        ], 200);
    }
}
