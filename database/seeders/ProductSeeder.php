<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $list_product = ["Logo", "Lanyard", "Kartu Nama", "Brosur", "Poster", "Stiker", "Feeds IG", "Story IG"];

        foreach ($list_product as $product) {
            Product::create([
                "name" => $product
            ]);
        }
    }
}