<?php

namespace Database\Seeders;

use App\Models\Producto;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Cliente::factory(50)->create();
        Producto::factory(50)->create();
        
        //LLenado de la tabla tabla_compra
       for($i=1; $i<=50; $i++){
        $producto = Producto::find($i);
        $producto->clientes()->attach(random_int(1,50));
       }
    }
}
