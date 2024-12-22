<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CatRol extends Model
{
    use HasFactory;
    protected $table = 'cat_rols';
    protected $fillable = ['nombre','habilitado'];
}
