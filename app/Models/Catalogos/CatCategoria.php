<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatCategoria extends Model
{
    use HasFactory;

    protected $table = 'cat_categorias';

    protected $primaryKey = 'id_categoria'; // Cambia a tu clave primaria personalizada

    public $incrementing = true; // Si es autoincremental

    protected $keyType = 'int'; // Si la clave primaria es un entero

    protected $fillable = ['nombre_categoria', 'habilitado'];

    public $timestamps = true; // Si tienes columnas `created_at` y `updated_at`
}
