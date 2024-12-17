<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
        //creamos objetos para asi ingresar informacion a la db
        $products = new Product();
        $products->name = 'producto uno';
        $products->description = "es el primer productos";
        $products->price=425;

        $products->save();

        $products2 = new Product();
        $products2->name = 'producto dos';
        $products2->description = "es el segundo producto";
        $products2->price=475;
        $products2->save();

        $products3 = new Product();
        $products3->name = 'producto tres';
        $products3->description = "es el tercer productos";
        $products3->price=495;
        $products3->save();
        
    }
}
