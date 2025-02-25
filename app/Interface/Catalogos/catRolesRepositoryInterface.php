<?php

namespace App\Interface\Catalogos;

interface catRolesRepositoryInterface
{
    public function getAll();

    public function getById($id);

    public function getAllHabilitados();

    public function store(array $data);

    public function update(array $data, $id);
}
