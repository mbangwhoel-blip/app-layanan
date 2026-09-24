<?php

namespace Database\Seeders;

use App\Models\ComplaintCategory;
use Illuminate\Database\Seeder;

class ComplaintCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeds categories for public complaints and social reports.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'PPKS Terlantar di Ruang Publik / Jalanan',
                'description' => 'Laporan terkait gelandangan, pengemis, anak jalanan, atau lansia terlantar di area publik yang butuh penjangkauan.',
                'is_active' => true,
            ],
            [
                'name' => 'Ketidaktepatan Sasaran Bantuan Sosial / Indikasi Pungli',
                'description' => 'Laporan warga mampu yang menerima bantuan, pemotongan bansos, atau warga miskin yang belum tersentuh bantuan.',
                'is_active' => true,
            ],
            [
                'name' => 'ODGJ / Disabilitas Terlantar Butuh Evakuasi Darurat',
                'description' => 'Laporan orang dengan gangguan jiwa mengamuk, dipasung, atau terlantar yang memerlukan evakuasi medis terpadu TRC.',
                'is_active' => true,
            ],
            [
                'name' => 'Dugaan Kekerasan / Penelantaran Anak & Lansia',
                'description' => 'Laporan perlakuan salah, kekerasan fisik/psikis, penelantaran anak, atau lansia sebatang kara yang tidak terawat.',
                'is_active' => true,
            ],
            [
                'name' => 'Pelayanan Petugas & Maladministrasi Layanan Sosial',
                'description' => 'Aduan terhadap kendala prosedur, ketidakramahan petugas, keterlambatan pemrosesan tiket, atau pungutan tidak resmi.',
                'is_active' => true,
            ],
            [
                'name' => 'Kedaruratan & Permasalahan Sosial Lingkungan',
                'description' => 'Laporan permasalahan kesejahteraan sosial lainnya di tingkat desa/kelurahan yang membutuhkan respon cepat.',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            ComplaintCategory::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
