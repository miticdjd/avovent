<?php

use App\Models\Products;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Create default users
     */
    public function run()
    {
        /**
         * Generate 10 products fro testing purposes
         */
        factory(Products::class, 10)->create();
    }
}
