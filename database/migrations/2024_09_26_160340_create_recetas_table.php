<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->smallInteger('duracion')->default(0);
            $table->json('ingredientes')->nullable();
            $table->json('pasos')->nullable();
            $table->string('imagen')->nullable();
            $table->integer('visitas')->default(0);

            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('published_at')->nullable();

            $table->boolean('rejected')->default(false);
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recetas');
    }
}
