<?php

namespace App\Repositories\Catalogos;

use App\Interface\Catalogos\catCategoriasRepositoryInterface;
use App\Models\Catalogos\CatCategoria;

class catCategoriaRepository implements catCategoriasRepositoryInterface
{
    public function getAll()
    {
        return CatCategoria::all();
    }

    public function getByID($id): ?CatCategoria
    {
        return CatCategoria::
        where('id_categoria', $id)->first();
    }

    public function getAllHabilitados()
    {
        return CatCategoria::
        where('habilitado',1)->get();
    }

    public function store(array $data)
    {
        return CatCategoria::create($data);
    }

    public function update(array $data, $id)
    {
        return CatCategoria::
        where('id_categoria',$id);
    }
}
