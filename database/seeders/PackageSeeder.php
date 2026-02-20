<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $packages = [];

        for ($i = 1; $i <= 50; $i++) {
            $packages[] = [
                'name' => "Paket " . $faker->unique()->word(),
                'product_id' => rand(1, 2),
                'detail_package' => $faker->sentence(10),
                'price' => rand(1, 11000),
                'working_time' => rand(1, 10),
                'unit' => $faker->randomElement(['days', 'hours']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Package::insert($packages);
    }
}