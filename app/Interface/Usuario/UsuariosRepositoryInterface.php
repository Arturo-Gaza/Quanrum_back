<?php

namespace App\Interface\Usuario;
use App\Models\User;

interface UsuariosRepositoryInterface
{
    public function getAll();
    public function getByID($id);
    public function getAllHabilitados();
    public function findByEmailOrUser(string $email): ?User;
    public function responseUser(string $email);
    public function aumentarIntento(int $intentos, $id);
    public function store(array $data);
    public function update(array $data, $id);
    public function generateToken(User $user): string;
    public function loginActive(int $id);
    public function loginInactive(int $id);
}
