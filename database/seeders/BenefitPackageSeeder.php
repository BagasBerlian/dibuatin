<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BenefitPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packageIds = DB::table('packages')->pluck('id')->toArray();

        $packageBenefits = [
            'Logo Starter' => ['Desain logo sederhana', 'Minimalis', 'Format PNG & JPG', '2 kali revisi'],
            'Logo Advanced' => ['Variasi warna dasar', 'Detail lebih tinggi', 'Format PNG & JPG', '2 kali revisi'],
            'Logo Premium' => ['Profesional', 'Variasi warna kompleks', 'Format PNG & JPG', '3 kali revisi'],

            'Lanyard Starter' => ['Desain polos', 'Satu warna', 'Format PNG & PDF', '1 kali revisi'],
            'Lanyard Advanced' => ['Kombinasi warna', 'Elemen dasar', 'Format PNG & PDF', '2 kali revisi'],
            'Lanyard Premium' => ['Full color', 'Desain custom', 'Format PNG & PDF', '3 kali revisi'],

            'Kartu Nama Starter' => ['Minimalis', 'Satu sisi', 'Format PNG & PDF', '1 kali revisi'],
            'Kartu Nama Advanced' => ['Dua warna', 'Desain lebih menarik', 'Format PNG & PDF', '2 kali revisi'],
            'Kartu Nama Premium' => ['Full color', 'Dua sisi', 'Format PNG & PDF', '2 kali revisi'],

            'Brosur Starter' => ['Lipat dua', 'Desain simpel', 'Format PNG & PDF', '1 kali revisi'],
            'Brosur Advanced' => ['Lipat dua', 'Profesional', 'Format PNG & PDF', '2 kali revisi'],
            'Brosur Premium' => ['Lipat tiga', 'Profesional', 'Format PNG & PDF', '2 kali revisi'],

            'Poster Starter' => ['Konsep sederhana', 'Ukuran A3', 'Format PNG & PDF', '1 kali revisi'],
            'Poster Advanced' => ['Desain lebih detail', 'Ukuran A3', 'Format PNG & PDF', '2 kali revisi'],
            'Poster Premium' => ['Full color', 'Ilustrasi custom', 'Format PNG & PDF', '2 kali revisi'],

            'Stiker Starter' => ['Minimalis', 'Ukuran 5x5 cm', 'Format PNG & PDF', '1 kali revisi'],
            'Stiker Advanced' => ['Lebih detail', 'Pilihan warna', 'Format PNG & PDF', '2 kali revisi'],
            'Stiker Premium' => ['Full color', 'Desain kreatif', 'Format PNG & PDF', '2 kali revisi'],

            'Feeds IG Starter' => ['Desain template', 'Ukuran 1350x1350 px', 'Format PNG & JPG', '1 kali revisi'],
            'Feeds IG Advanced' => ['Desain lebih variatif', 'Ukuran 1350x1350 px', 'Format PNG & JPG', '2 kali revisi'],
            'Feeds IG Premium' => ['Desain unik', 'Tampilan profesional', 'Format PNG & JPG', '2 kali revisi'],

            'Story IG Starter' => ['3 story sederhana', 'Ukuran 1080x1920 px', 'Format PNG & JPG', '1 kali revisi'],
            'Story IG Advanced' => ['5 story menarik', 'Ukuran 1080x1920 px', 'Format PNG & JPG', '2 kali revisi'],
            'Story IG Premium' => ['6 story kreatif', 'Ukuran 1080x1920 px', 'Format PNG & JPG', '2 kali revisi'],
        ];

        foreach ($packageIds as $index => $packageId) {
            $packageName = DB::table('packages')->where('id', $packageId)->value('name');

            if (isset($packageBenefits[$packageName])) {
                foreach ($packageBenefits[$packageName] as $benefit) {
                    DB::table('benefit_packages')->insert([
                        'packages_id' => $packageId,
                        'benefit' => $benefit,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}