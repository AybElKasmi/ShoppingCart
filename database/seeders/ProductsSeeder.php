<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => "Tee",
                'price' => 8.50,
                'qte_stock' => 10,
            ],

            [
                'name' => "Sandwich",
                'price' => 15.00,
                'qte_stock' => 10,
            ],
            
            [
                'name' => "Taco",
                'price' => 19.00,
                'qte_stock' => 10,
            ],

            [
                'name' => "Coca Cola",
                'price' => 1.90,
                'qte_stock' => 100,
            ],

            [
                'name' => "Coffee",
                'price' => 10.00,
                'qte_stock' => 100,
            ],

            
        ]);
    }
}
