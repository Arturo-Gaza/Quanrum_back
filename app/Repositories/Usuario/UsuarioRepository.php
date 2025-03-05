<?php

namespace App\Repositories\Usuario;

use App\Interface\Usuario\UsuariosRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioRepository implements UsuariosRepositoryInterface
{
    public function getAll()
    {
        $usuario = User::select('users.id', 'users.user', 'users.name', 'users.apellidoP', 'users.apellidoM', 'users.email', 'users.idRol', 'users.habilitado', 'cat_roles.nombre')
            ->join('cat_roles', 'cat_roles.id', '=', 'users.idRol')->get();
        return $usuario;
    }

    public function getAllUserAlmacen($idCarga)
    {
        $usuario = User::select(
            'id',
            'user',
            'name',
            'apellidoP',
            'apellidoM',
            'email',
            'idRol',
            'habilitado',
        )
            ->where('idRol', 2)->get();

        $data1 = array();
        foreach ($usuario as $val) {
            $data1[] = $val;
        }

        $usuarioAsigndo = User::select(
            'users.id',
            'users.user',
            'users.name',
            'users.apellidoP',
            'users.apellidoM',
            'users.email',
            'users.idRol',
            'users.habilitado',
            'tab_asignacions.habilitado AS asigHabilitado',
        )
            ->join('tab_asignacions', 'tab_asignacions.id_usuario', '=', 'users.id')
            ->orWhere('tab_asignacions.id_carga', '=', $idCarga)
            ->groupBy('users.id')
            ->groupBy('tab_asignacions.habilitado')
            ->get()->filter(function ($user) {
                return $user->asigHabilitado == 1 && $user->idRol == 2;
            });

        $data2 = array();
        foreach ($usuarioAsigndo as $val) {
            $data2[] = $val;
        }

        $idsData2 = array_column($data2, 'id');
        $resultadoArr = array_diff($data1, array_filter($data1, function ($item) use ($idsData2) {
            return in_array($item['id'], $idsData2);
        }));

        $results = array();
        foreach ($resultadoArr as $val) {
            $results[] = $val;
        }
        return $results;

    }

    
    public function getByID($id): ?User
    {
        return User::where('id', $id)->first();
    }

    public function getAllHabilitados()
    {
        return User::where('habilitado', 1)->get();
    }

    public function findByEmailOrUser(string $email): ?User
    {
        return User::where('email', $email)->orWhere('user', $email)->first();
    }

    public function responseUser(string $email)
    {
        $usuario = User::select('users.id', 'users.user', 'users.name', 'users.idRol', 'users.email', 'users.apellidoP', 'users.apellidoM', 'cat_roles.nombre_rol')
            ->join('cat_roles', 'cat_roles.idRol', '=', 'users.idRol')->where('users.email', $email)->orWhere('users.user', $email)->first();
        return $usuario;
    }

    public function store(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function update(array $data, $id)
    {
        $data['password'] = Hash::make($data['password']);
        return User::whereId($id)->update($data);
    }

    public function aumentarIntento(int $intentos, $id)
    {
        User::where('id', $id)->update(array('intentos' => $intentos + 1));
    }

    public function generateToken(User $user): string
    {
        return $user->createToken('API Token')->plainTextToken;
    }

    public function loginActive(int $id)
    {
        User::where('id', $id)->update(array('login_activo' => true));
    }

    public function loginInactive(int $id)
    {
        User::where('id', $id)->update(array('login_activo' => false));
    }
}
