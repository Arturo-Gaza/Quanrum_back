<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cat_categorias', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->string('nombre_categoria',50);
            $table->timestamps();
            $table->boolean('habilitado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_categorias');
    }
};
