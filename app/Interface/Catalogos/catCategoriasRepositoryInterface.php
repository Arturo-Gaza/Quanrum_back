<?php

namespace App\Interface\Catalogos;

interface catCategoriasRepositoryInterface
{
    
    public function getAll();
    public function getByID($id);
    public function getAllHabilitados();
    public function store(array $data);
    public function update(array $data, $id);
}
