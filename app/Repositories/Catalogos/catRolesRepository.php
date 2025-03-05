<?php

namespace App\Repositories\Catalogos;

use App\Interface\Catalogos\catRolesRepositoryInterface;
use App\Models\Catalogos\catRoles;


class catRolesRepository implements catRolesRepositoryInterface
{
    public function getAll()
    {
        return catRoles::all();
    }

    public function getById($id): ?catRoles
    {
        return catRoles::where('idRol', $id)->first();
    }

    public function getAllHabilitados()
    {
        return catRoles::where('habilitado', 1)->get();
    }

    public function store(array $data)
    {
        return catRoles::create($data);
    }

    public function update(array $data, $id)
    {
        return catRoles::where('idRol',$id)->update($data);
    }
}
