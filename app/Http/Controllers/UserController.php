<?php

namespace App\Http\Controllers;

use App\Models\PermisosUsuario;
use App\Models\TipoPersona;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo_personas_id_fk' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'nombre' => 'required|max:255',
            'apellidos' => 'required|max:255',
            'cedula' => 'required|max:255',
            'celular' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $user = User::create([
            'tipo_personas_id_fk' => $request->tipo_personas_id_fk,
            'email' => $request->email,
            'password' => $request->celular,
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'cedula' => $request->cedula,
            'celular' => $request->celular,
        ]);

        $permisos = $request->permisos;

        foreach ($permisos as $permiso) {
            DB::table('permisos_usuarios')->insert([
                'usuario_id_fk' => $user->id,
                'titulo' => $permiso['label'],
                'path' => $permiso['value'],
            ]);
        }

        // Util::sendSms('57' . $request->celular, 'Hola ' . $request->nombre . ', te has registrado en el sistema de gestión de evidencias de la empresa SISEVID, usuario ' . $request->email . " la contraseña es tu celular. " . env('APP_FRONT_URL'));

        return response([
            "status" => true,
            "message" => "Usuario creado correctamente.",
            "data" => $user,
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo_personas_id_fk' => 'required',
            'email' => 'required|email|max:255',
            'nombre' => 'required|max:255',
            'apellidos' => 'required|max:255',
            'cedula' => 'required|max:255',
            'celular' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $user = User::find($request->id);

        $user->tipo_personas_id_fk = $request->tipo_personas_id_fk;
        $user->email = $request->email;
        if ($request->password && $request->password != '') {
            $user->password = $request->password;
        }
        $user->nombre = $request->nombre;
        $user->apellidos = $request->apellidos;
        $user->cedula = $request->cedula;
        $user->celular = $request->celular;

        $user->save();

        $permisos = $request->permisos;

        PermisosUsuario::where('usuario_id_fk', $user->id)->delete();

        foreach ($permisos as $permiso) {
            DB::table('permisos_usuarios')->insert([
                'usuario_id_fk' => $user->id,
                'titulo' => $permiso['label'],
                'path' => $permiso['value'],
            ]);
        }

        return response([
            "status" => true,
            "message" => "Usuario actualizado correctamente.",
            "data" => $user,
        ], 200);
    }

    public function delete(int $id)
    {
        $user = User::find($id);

        $user->delete();

        return response([
            "status" => true,
            "message" => "Usuario eliminado correctamente.",
            "data" => $user,

        ], 200);
    }

    public function getUser(int $id)
    {
        $user = User::find($id);

        $typePerson = TipoPersona::find($user->tipo_personas_id_fk);

        $user->tipo_personas_id_fk = [
            "label" => $typePerson->tipo,
            "value" => $typePerson->id,
        ];

        $permisos = [];

        foreach ($user->permisos as $permiso) {
            $permisos[] = [
                "label" => $permiso->titulo,
                "value" => $permiso->path,
            ];
        }

        return response([
            "status" => true,
            "message" => "Usuario encontrado correctamente.",
            "data" => $user,
            "permisos" => $permisos,
        ], 200);
    }

    public function list(Request $request)
    {
        $query = DB::table('users as u')->select('u.id', 'tp.tipo', 'u.nombre', 'u.apellidos', 'u.cedula', 'u.celular', 'u.email')
            ->join('tipo_personas as tp', 'tp.id', '=', 'u.tipo_personas_id_fk')
            ->orderBy('u.id', 'desc');

        if ((isset($request->filter) && $request->filter != null) && $request->filter != '' && $request->filter != 'null') {
            $query->where('u.nombre', 'like', '%' . $request->filter . '%');
            $query->orWhere('u.apellidos', 'like', '%' . $request->filter . '%');
            $query->orWhere('u.cedula', 'like', '%' . $request->filter . '%');
            $query->orWhere('u.celular', 'like', '%' . $request->filter . '%');
            $query->orWhere('u.email', 'like', '%' . $request->filter . '%');
        }

        if (isset($request->onlyStudentTeacher) && $request->onlyStudentTeacher == "true") {
            $query->whereIn('tp.id', [1, 2]);
        }

        $users = $query->paginate($request->rows, ['*'], 'page', $request->page);

        return response([
            "status" => true,
            "message" => "Usuarios obtenidos correctamente.",
            "data" => $users,
        ], 200);
    }

    public function getTiposUsuario()
    {
        $tipoPersonas = TipoPersona::all();

        return response([
            "status" => true,
            "message" => "Tipos de usuario obtenidos correctamente.",
            "data" => $tipoPersonas,
        ]);
    }
}
