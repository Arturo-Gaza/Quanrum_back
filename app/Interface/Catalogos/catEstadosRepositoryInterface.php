<?php

namespace App\Interface\Catalogos;

interface catEstadosRepositoryInterface
{
    public function getAll();
    public function getByID($id);
    public function getAllHabilitados();
    public function store(array $data);
    public function update(array $data, $id);
}
