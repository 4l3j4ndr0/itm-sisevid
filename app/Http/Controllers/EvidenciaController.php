<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\EvidenciaAsignatura;
use App\Models\EvidenciaUsuario;
use App\Models\TipoEvidencia;
use App\Models\TipoPersona;
use Aws\S3\S3Client;
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

        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-1',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $result = $s3Client->putObject([
            'Bucket' => env('AWS_BUCKET'),
            'Key' => $fecha->getTimestamp() . '_' . $file->getClientOriginalName(),
            'SourceFile' => $file,
            'ACL' => 'public-read',
        ]);

        $path = $result->get('ObjectURL');

        return response([
            "status" => true,
            "message" => "Archivo cargado exitosamente.",
            "path" => $path,
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
            'autor' => 'required',
            'codigo' => 'required',
            'titulo' => 'required'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $users = $request->usuarios;
        $asignaturas = $request->asignaturas;

        $evidencia = Evidencia::find($request->id);

        $evidencia->tipo_evidencia_id_fk = $request->tipo_evidencia_id_fk;
        $evidencia->autor = $request->autor;
        $evidencia->codigo = $request->codigo;
        $evidencia->titulo = $request->titulo;
        $evidencia->descripcion = isset($request->descripcion) ? $request->descripcion : null;
        $evidencia->fecha_modificacion = date('Y-m-d H:i:s');
        $evidencia->url_evidencia = $request->url_evidencia;

        $evidencia->save();

        EvidenciaUsuario::where('evidencia_id_fk', $evidencia->id)->delete();
        EvidenciaAsignatura::where('evidencia_id_fk', $evidencia->id)->delete();

        foreach ($users as $user) {
            EvidenciaUsuario::create([
                'evidencia_id_fk' => $evidencia->id,
                'usuario_id_fk' => $user['value'],
            ]);
        }

        foreach ($asignaturas as $asignatura) {
            EvidenciaAsignatura::create([
                'evidencia_id_fk' => $evidencia->id,
                'asignatura_id_fk' => $asignatura['value'],
            ]);
        }


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

        $evidencia->tipo_evidencia_id_fk = [
            "label" => $typeEvidencia->tipo,
            "value" => $typeEvidencia->id,
        ];

        $usuarios = [];
        $asignaturas = [];

        foreach ($evidencia->usuarios as $usuario) {
            $usuarios[] = [
                'value' => $usuario->usuario_id_fk,
                'label' => $usuario->usuario->nombre . ' ' . $usuario->usuario->apellido . ' (' . $usuario->usuario->tipoPersona->tipo . ')',
            ];
        }

        foreach ($evidencia->asignaturas as $asignatura) {
            $asignaturas[] = [
                'value' => $asignatura->asignatura_id_fk,
                'label' => $asignatura->asignatura->asignatura,
            ];
        }

        $evidencia->usuariosSelect = $usuarios;
        $evidencia->asignaturasSelect = $asignaturas;


        return response([
            "status" => true,
            "message" => "Evidencia encontrada correctamente.",
            "evidencia" => $evidencia,
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
