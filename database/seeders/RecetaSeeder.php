<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Receta;
use App\Models\User;
use App\Models\Valoracion;
use Illuminate\Database\Seeder;

class RecetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Receta::factory(20)
            ->create()
            ->each(function ($receta) {
                
                $categorias = Categoria::all()->random(random_int(1,5));

                foreach ($categorias as $categoria) {
                    $receta->categorias()->attach($categoria->id);
                }

                $numValoraciones = random_int(5, 10);

                Valoracion::factory($numValoraciones)
                    ->average()
                    ->for($receta)
                    ->create();
            });
    }
}
