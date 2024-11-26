<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->unique();

            $table->timestamps();
        });

        Schema::create('categoria_receta', function (Blueprint $table) {
            $table->unsignedBigInteger('receta_id');
            $table->unsignedBigInteger('categoria_id');
            
            $table->timestamps();

            $table->foreign('receta_id')
                ->references('id')->on('recetas')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('categoria_id')
                ->references('id')->on('categorias')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['receta_id', 'categoria_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categoria_receta', function (Blueprint $table) {
            $table->dropForeign('categoria_receta_categoria_id_foreign');
            $table->dropForeign('categoria_receta_receta_id_foreign');
        });

        Schema::dropIfExists('categorias');
        Schema::dropIfExists('categoria_receta');
    }
}
