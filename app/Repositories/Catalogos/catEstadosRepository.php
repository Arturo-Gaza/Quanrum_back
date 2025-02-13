<?php

namespace App\Repositories\Catalogos;

use App\Interface\Catalogos\catEstadosRepositoryInterface;
use App\Models\tabEstado;

class catEstadosRepository implements catEstadosRepositoryInterface
{
    public function getAll()
    {
        return tabEstado::all();
    }

    public function getByID($id): ?tabEstado
    {
        return tabEstado::where('id_estado', $id)->first();
    }

    public function getAllHabilitados()
    {
        return tabEstado::where('habilitado',1)->get();
    }


    public function store(array $data)
    {
        return tabEstado::create($data);
    }

    public function update(array $data, $id)
    {
        return tabEstado::where('id_capitulo',$id)->update($data);
    }

}
