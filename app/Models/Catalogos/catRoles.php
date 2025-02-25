<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catRoles extends Model
{
    use HasFactory;
    
    protected $table = 'cat_roles';
    protected $fillable = ['nombre_rol', 'habilitado'];
}
