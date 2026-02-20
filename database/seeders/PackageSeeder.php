<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            // Logo
            ['name' => 'Logo Starter', 'product_id' => 1, 'detail_package' => 'Desain logo simpel, modern, dan minimalis untuk identitas bisnis awal.', 'price' => 30000, 'working_time' => 7, 'unit' => 'days'],
            ['name' => 'Logo Advanced', 'product_id' => 1, 'detail_package' => 'Logo kreatif dengan variasi warna dasar dan tampilan lebih profesional.', 'price' => 50000, 'working_time' => 5, 'unit' => 'days'],
            ['name' => 'Logo Premium', 'product_id' => 1, 'detail_package' => 'Logo eksklusif dengan desain kompleks, warna premium, dan revisi tambahan.', 'price' => 65000, 'working_time' => 5, 'unit' => 'days'],

            // Lanyard
            ['name' => 'Lanyard Starter', 'product_id' => 2, 'detail_package' => 'Desain lanyard sederhana dengan satu warna untuk acara dan identitas.', 'price' => 12000, 'working_time' => 7, 'unit' => 'days'],
            ['name' => 'Lanyard Advanced', 'product_id' => 2, 'detail_package' => 'Lanyard dengan kombinasi warna dan elemen desain yang lebih menarik.', 'price' => 20000, 'working_time' => 5, 'unit' => 'days'],
            ['name' => 'Lanyard Premium', 'product_id' => 2, 'detail_package' => 'Lanyard full color dengan desain kustom yang sesuai branding bisnis Anda.', 'price' => 25000, 'working_time' => 3, 'unit' => 'days'],

            // Kartu Nama
            ['name' => 'Kartu Nama Starter', 'product_id' => 3, 'detail_package' => 'Kartu nama simpel satu sisi, desain minimalis dengan sentuhan profesional.', 'price' => 12000, 'working_time' => 7, 'unit' => 'days'],
            ['name' => 'Kartu Nama Advanced', 'product_id' => 3, 'detail_package' => 'Kartu nama elegan dua sisi dengan tata letak dan warna lebih menarik.', 'price' => 18000, 'working_time' => 5, 'unit' => 'days'],
            ['name' => 'Kartu Nama Premium', 'product_id' => 3, 'detail_package' => 'Desain kartu nama eksklusif, full color, format cetak siap produksi.', 'price' => 25000, 'working_time' => 5, 'unit' => 'days'],

            // Brosur
            ['name' => 'Brosur Starter', 'product_id' => 4, 'detail_package' => 'Brosur lipat dua dengan desain simpel dan profesional untuk promosi.', 'price' => 40000, 'working_time' => 7, 'unit' => 'days'],
            ['name' => 'Brosur Advanced', 'product_id' => 4, 'detail_package' => 'Brosur berkualitas tinggi dengan tampilan profesional dan revisi gratis.', 'price' => 50000, 'working_time' => 5, 'unit' => 'days'],
            ['name' => 'Brosur Premium', 'product_id' => 4, 'detail_package' => 'Brosur lipat tiga eksklusif dengan desain kreatif dan elemen premium.', 'price' => 60000, 'working_time' => 3, 'unit' => 'days'],

            // Poster
            ['name' => 'Poster Starter', 'product_id' => 5, 'detail_package' => 'Poster promosi ukuran A3 dengan desain bersih dan konsep minimalis.', 'price' => 40000, 'working_time' => 7, 'unit' => 'days'],
            ['name' => 'Poster Advanced', 'product_id' => 5, 'detail_package' => 'Poster detail dengan desain menarik dan pilihan warna yang lebih variatif.', 'price' => 50000, 'working_time' => 5, 'unit' => 'days'],
            ['name' => 'Poster Premium', 'product_id' => 5, 'detail_package' => 'Poster profesional dengan ilustrasi custom, kualitas tinggi, dan revisi tambahan.', 'price' => 65000, 'working_time' => 3, 'unit' => 'days'],

            // Stiker
            ['name' => 'Stiker Starter', 'product_id' => 6, 'detail_package' => 'Stiker produk simpel ukuran 5x5 cm, cocok untuk branding awal.', 'price' => 10000, 'working_time' => 7, 'unit' => 'days'],
            ['name' => 'Stiker Advanced', 'product_id' => 6, 'detail_package' => 'Stiker berkualitas dengan desain lebih kreatif dan elemen warna menarik.', 'price' => 18000, 'working_time' => 5, 'unit' => 'days'],
            ['name' => 'Stiker Premium', 'product_id' => 6, 'detail_package' => 'Stiker premium full color dengan desain custom untuk branding bisnis.', 'price' => 25000, 'working_time' => 5, 'unit' => 'days'],

            // Feeds IG
            ['name' => 'Feeds IG Starter', 'product_id' => 7, 'detail_package' => 'Satu feeds Instagram menarik, ideal untuk promosi konten bisnis.', 'price' => 15000, 'working_time' => 7, 'unit' => 'days'],
            ['name' => 'Feeds IG Advanced', 'product_id' => 7, 'detail_package' => 'Tiga feeds Instagram dengan desain kreatif dan tampilan profesional.', 'price' => 30000, 'working_time' => 5, 'unit' => 'days'],
            ['name' => 'Feeds IG Premium', 'product_id' => 7, 'detail_package' => 'Enam feeds Instagram eksklusif dengan desain inovatif dan strategis.', 'price' => 50000, 'working_time' => 5, 'unit' => 'days'],

            // Story IG
            ['name' => 'Story IG Starter', 'product_id' => 8, 'detail_package' => 'Tiga story Instagram dengan desain simpel dan efektif untuk promosi.', 'price' => 30000, 'working_time' => 7, 'unit' => 'days'],
            ['name' => 'Story IG Advanced', 'product_id' => 8, 'detail_package' => 'Lima story Instagram dengan desain lebih profesional dan interaktif.', 'price' => 45000, 'working_time' => 5, 'unit' => 'days'],
            ['name' => 'Story IG Premium', 'product_id' => 8, 'detail_package' => 'Enam story Instagram premium dengan desain unik dan animasi kreatif.', 'price' => 55000, 'working_time' => 5, 'unit' => 'days'],
        ];

        DB::table('packages')->insert($packages);
    }
}