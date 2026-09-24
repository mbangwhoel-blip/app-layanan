<?php

namespace Database\Seeders;

use App\Models\ClientCategory;
use Illuminate\Database\Seeder;

class ClientCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeds client categories for rehabilitation cases based on PRD Section 2 (Layanan 3).
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Lanjut Usia Terlantar',
                'description' => 'Lansia berusia 60 tahun ke atas yang tidak memiliki keluarga atau terlantar secara ekonomi dan fisik.',
                'is_active' => true,
            ],
            [
                'name' => 'Penyandang Disabilitas',
                'description' => 'Penyandang disabilitas fisik, sensorik, intelektual, maupun mental yang membutuhkan alat bantu dan pembinaan.',
                'is_active' => true,
            ],
            [
                'name' => 'Orang Dengan Gangguan Jiwa (ODGJ) Terlantar',
                'description' => 'Orang dengan gangguan jiwa yang berkeliaran, terlantar di ruang publik, atau butuh evakuasi medis dan rujukan panti.',
                'is_active' => true,
            ],
            [
                'name' => 'Anak Terlantar & Anak Berhadapan dengan Hukum (ABH)',
                'description' => 'Anak yang mengalami penelantaran, tidak memiliki pengasuh layak, atau sedang dalam proses diversi dan perlindungan khusus.',
                'is_active' => true,
            ],
            [
                'name' => 'Korban Tindak Kekerasan & Pekerja Migran Terlantar',
                'description' => 'Korban kekerasan dalam rumah tangga (KDRT), tindak pidana perdagangan orang (TPPO), atau pekerja migran bermasalah.',
                'is_active' => true,
            ],
            [
                'name' => 'Gelandangan, Pengemis (Gepeng) & Tuna Sosial',
                'description' => 'Individu atau kelompok tuna sosial tanpa tempat tinggal tetap yang membutuhkan bimbingan dan pembinaan sosial.',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            ClientCategory::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
