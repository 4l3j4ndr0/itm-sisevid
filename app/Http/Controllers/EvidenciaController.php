<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\TipoEvidencia;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EvidenciaController extends Controller
{

    public function uploadFile(Request $request)
    {
        $fileName = $request->fileName;
        $file = $request->file($fileName);
        $fecha = new DateTime();

        $path = $file->storeAs('public/evidencias', $fecha->getTimestamp() . $file->getClientOriginalName());

        return response([
            "status" => true,
            "message" => "Archivo cargado exitosamente.",
            "path" => str_replace('public/', 'storage/', $path),
        ], 200);
    }

    public function getTipoEvidencia()
    {
        $consult = DB::table('tipo_evidencias')->get();

        $tipoEvidencias = [];

        foreach ($consult as $value) {
            $tipoEvidencias[] = [
                'value' => $value->id,
                'label' => $value->tipo,
            ];
        }

        return response([
            "status" => true,
            "message" => "Tipos de evidencias consultados correctamente.",
            "data" => $tipoEvidencias,
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo_evidencia_id_fk' => 'required',
            'autor' => 'required',
            'codigo' => 'required|max:255',
            'titulo' => 'required|max:255',
            'url_evidencia' => 'required'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $evidencia = Evidencia::create([
            'tipo_evidencia_id_fk' => $request->tipo_evidencia_id_fk,
            'autor' => $request->autor,
            'codigo' => $request->codigo,
            'titulo' => $request->titulo,
            'descripcion' => isset($request->descripcion) ? $request->descripcion : null,
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'fecha_modificacion' => date('Y-m-d H:i:s'),
            'url_evidencia' => $request->url_evidencia,
        ]);

        return response([
            "status" => true,
            "message" => "Evidencia creada correctamente.",
            "data" => $evidencia,
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo_evidencia_id_fk' => 'required',
            'autor' => 'required|email|max:255|unique:users',
            'codigo' => 'required|max:255',
            'titulo' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $evidencia = Evidencia::find($request->id);

        $evidencia->tipo_evidencia_id_fk = $request->tipo_evidencia_id_fk;
        $evidencia->autor = $request->autor;
        $evidencia->codigo = $request->codigo;
        $evidencia->titulo = $request->titulo;
        $evidencia->descripcion = isset($request->descripcion) ? $request->descripcion : null;
        $evidencia->fecha_modificacion = date('Y-m-d H:i:s');
        $evidencia->url_evidencia = $request->url_evidencia;

        $evidencia->save();

        return response([
            "status" => true,
            "message" => "Evidencia actualizada correctamente.",
            "data" => $evidencia,
        ], 200);
    }

    public function getEvidencia(int $id)
    {
        $evidencia = Evidencia::find($id);

        $typeEvidencia = TipoEvidencia::find($evidencia->tipo_evidencia_id_fk);

        $evidencia->tipo_personas_id_fk = [
            "label" => $typeEvidencia->tipo,
            "value" => $typeEvidencia->id,
        ];

        return response([
            "status" => true,
            "message" => "Evidencia encontrada correctamente.",
            "data" => $evidencia,
        ], 200);
    }

    public function delete(int $id)
    {
        $evidencia = Evidencia::find($id);

        $evidencia->delete();

        return response([
            "status" => true,
            "message" => "Evidencia eliminada correctamente.",
            "data" => $evidencia,

        ], 200);
    }

    public function list(Request $request)
    {
        $query = DB::table('evidencias as e')->select('e.id', 'te.tipo', 'e.autor', 'e.codigo', 'e.titulo', 'e.url_evidencia')
            ->join('tipo_evidencias as te', 'te.id', '=', 'e.tipo_evidencia_id_fk')
            ->orderBy('e.id', 'desc');

        if ((isset($request->filter) && $request->filter != null) && $request->filter != '' && $request->filter != 'null') {
            $query->where('e.autor', 'like', '%' . $request->filter . '%');
            $query->orWhere('e.codigo', 'like', '%' . $request->filter . '%');
            $query->orWhere('e.titulo', 'like', '%' . $request->filter . '%');
            $query->orWhere('te.tipo', 'like', '%' . $request->filter . '%');
        }

        $evidencias = $query->paginate($request->rows, ['*'], 'page', $request->page);

        return response([
            "status" => true,
            "message" => "Evidencias obtenidas correctamente.",
            "data" => $evidencias,
        ], 200);
    }
}
