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
        Product::create([
            'name' => 'Logo',
        ]);

        Product::create([
            'name' => 'Lanyard',
        ]);

        Product::create([
            'name' => 'Kartu Nama',
        ]);

        Product::create([
            'name' => 'Brosur',
        ]);

        Product::create([
            'name' => 'Poster/Banner',
        ]);

        Product::create([
            'name' => 'Stiker Produk',
        ]);
        
        Product::create([
            'name' => 'Feeds IG',
        ]);

        Product::create([
            'name' => 'Story IG',
        ]);
    }
}